<?php
// app/Http/Controllers/Dokter/RekamMedisController.php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of rekam medis yang dibuat dokter
     */
    public function index(Request $request)
    {
        $query = RekamMedis::with(['pasien', 'reservasi'])
            ->where('dokter_id', auth()->id())
            ->orderBy('tanggal_pemeriksaan', 'desc');

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange($request->start_date, $request->end_date);
        }

        // Filter berdasarkan pasien
        if ($request->filled('pasien_id')) {
            $query->where('user_id', $request->pasien_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rekamMedis = $query->paginate(10);

        // Ambil daftar pasien untuk filter
        $pasiens = RekamMedis::with('pasien')
            ->where('dokter_id', auth()->id())
            ->get()
            ->pluck('pasien')
            ->unique('id')
            ->values();

        return view('dokter.rekam-medis.index', compact('rekamMedis', 'pasiens'));
    }

    /**
     * Show form untuk membuat rekam medis baru
     */
    public function create()
    {
        // Ambil reservasi yang sudah dikonfirmasi dan belum memiliki rekam medis
        $reservasis = Reservasi::with('pasien')
            ->where('dokter_id', auth()->id())
            ->where('status', 'dikonfirmasi')
            ->whereDoesntHave('rekamMedis')
            ->orderBy('tanggal_reservasi', 'desc')
            ->get();

        return view('dokter.rekam-medis.create', compact('reservasis'));
    }

    /**
     * Store rekam medis baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reservasi_id' => 'required|exists:reservasis,id',
            'tanggal_pemeriksaan' => 'required|date',
            'keluhan' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
            'tindakan' => 'nullable|string|max:1000',
            'resep_obat' => 'nullable|string|max:1000',
            'catatan_dokter' => 'nullable|string|max:1000',
            'tinggi_badan' => 'nullable|numeric|min:0|max:300',
            'berat_badan' => 'nullable|numeric|min:0|max:500',
            'tekanan_darah' => 'nullable|string|max:20',
            'suhu_tubuh' => 'nullable|numeric|min:30|max:50',
            'nadi' => 'nullable|integer|min:30|max:200',
            'status' => 'required|in:aktif,selesai'
        ], [
            'reservasi_id.required' => 'Reservasi harus dipilih.',
            'reservasi_id.exists' => 'Reservasi tidak valid.',
            'tanggal_pemeriksaan.required' => 'Tanggal pemeriksaan harus diisi.',
            'tanggal_pemeriksaan.date' => 'Format tanggal pemeriksaan tidak valid.',
            'keluhan.required' => 'Keluhan pasien harus diisi.',
            'keluhan.max' => 'Keluhan maksimal 1000 karakter.',
            'diagnosa.required' => 'Diagnosa harus diisi.',
            'diagnosa.max' => 'Diagnosa maksimal 1000 karakter.',
            'tindakan.max' => 'Tindakan maksimal 1000 karakter.',
            'resep_obat.max' => 'Resep obat maksimal 1000 karakter.',
            'catatan_dokter.max' => 'Catatan dokter maksimal 1000 karakter.',
            'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka.',
            'tinggi_badan.min' => 'Tinggi badan tidak valid.',
            'tinggi_badan.max' => 'Tinggi badan maksimal 300 cm.',
            'berat_badan.numeric' => 'Berat badan harus berupa angka.',
            'berat_badan.min' => 'Berat badan tidak valid.',
            'berat_badan.max' => 'Berat badan maksimal 500 kg.',
            'tekanan_darah.max' => 'Tekanan darah maksimal 20 karakter.',
            'suhu_tubuh.numeric' => 'Suhu tubuh harus berupa angka.',
            'suhu_tubuh.min' => 'Suhu tubuh minimal 30°C.',
            'suhu_tubuh.max' => 'Suhu tubuh maksimal 50°C.',
            'nadi.integer' => 'Nadi harus berupa angka bulat.',
            'nadi.min' => 'Nadi minimal 30 bpm.',
            'nadi.max' => 'Nadi maksimal 200 bpm.',
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Ambil data reservasi
            $reservasi = Reservasi::findOrFail($request->reservasi_id);

            // Pastikan reservasi milik dokter yang sedang login
            if ($reservasi->dokter_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke reservasi ini.');
            }

            // Pastikan reservasi belum memiliki rekam medis
            if ($reservasi->rekamMedis()->exists()) {
                return redirect()->back()->with('error', 'Rekam medis untuk reservasi ini sudah dibuat.');
            }

            // Buat rekam medis
            $rekamMedis = RekamMedis::create([
                'user_id' => $reservasi->user_id,
                'dokter_id' => auth()->id(),
                'reservasi_id' => $request->reservasi_id,
                'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
                'keluhan' => $request->keluhan,
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'resep_obat' => $request->resep_obat,
                'catatan_dokter' => $request->catatan_dokter,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'tekanan_darah' => $request->tekanan_darah,
                'suhu_tubuh' => $request->suhu_tubuh,
                'nadi' => $request->nadi,
                'status' => $request->status
            ]);

            // Update status reservasi jika rekam medis selesai
            if ($request->status === 'selesai') {
                $reservasi->update(['status' => 'selesai']);
            }

            DB::commit();

            return redirect()->route('dokter.rekam-medis.show', $rekamMedis)
                ->with('success', 'Rekam medis berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan rekam medis.')
                ->withInput();
        }
    }

    /**
     * Display rekam medis
     */
    public function show(RekamMedis $rekamMedis)
    {
        // Pastikan rekam medis dibuat oleh dokter yang sedang login
        if ($rekamMedis->dokter_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        $rekamMedis->load(['pasien', 'reservasi']);

        return view('dokter.rekam-medis.show', compact('rekamMedis'));
    }

    /**
     * Show form untuk edit rekam medis
     */
    public function edit(RekamMedis $rekamMedis)
    {
        // Pastikan rekam medis dibuat oleh dokter yang sedang login
        if ($rekamMedis->dokter_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        $rekamMedis->load(['pasien', 'reservasi']);

        return view('dokter.rekam-medis.edit', compact('rekamMedis'));
    }

    /**
     * Update rekam medis
     */
    public function update(Request $request, RekamMedis $rekamMedis)
    {
        // Pastikan rekam medis dibuat oleh dokter yang sedang login
        if ($rekamMedis->dokter_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        $validator = Validator::make($request->all(), [
            'tanggal_pemeriksaan' => 'required|date',
            'keluhan' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
            'tindakan' => 'nullable|string|max:1000',
            'resep_obat' => 'nullable|string|max:1000',
            'catatan_dokter' => 'nullable|string|max:1000',
            'tinggi_badan' => 'nullable|numeric|min:0|max:300',
            'berat_badan' => 'nullable|numeric|min:0|max:500',
            'tekanan_darah' => 'nullable|string|max:20',
            'suhu_tubuh' => 'nullable|numeric|min:30|max:50',
            'nadi' => 'nullable|integer|min:30|max:200',
            'status' => 'required|in:aktif,selesai'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $rekamMedis->update($request->only([
                'tanggal_pemeriksaan',
                'keluhan',
                'diagnosa',
                'tindakan',
                'resep_obat',
                'catatan_dokter',
                'tinggi_badan',
                'berat_badan',
                'tekanan_darah',
                'suhu_tubuh',
                'nadi',
                'status'
            ]));

            // Update status reservasi jika rekam medis selesai
            if ($request->status === 'selesai' && $rekamMedis->reservasi) {
                $rekamMedis->reservasi->update(['status' => 'selesai']);
            }

            DB::commit();

            return redirect()->route('dokter.rekam-medis.show', $rekamMedis)
                ->with('success', 'Rekam medis berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui rekam medis.')
                ->withInput();
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $dokterId = auth()->id();
        
        // Total rekam medis yang dibuat
        $totalRekamMedis = RekamMedis::where('dokter_id', $dokterId)->count();
        
        // Rekam medis bulan ini
        $rekamMedisBulanIni = RekamMedis::where('dokter_id', $dokterId)
            ->whereMonth('tanggal_pemeriksaan', Carbon::now()->month)
            ->whereYear('tanggal_pemeriksaan', Carbon::now()->year)
            ->count();
        
        // Rekam medis hari ini
        $rekamMedisHariIni = RekamMedis::where('dokter_id', $dokterId)
            ->whereDate('tanggal_pemeriksaan', Carbon::today())
            ->count();
        
        // Reservasi menunggu pembuatan rekam medis
        $reservasiMenunggu = Reservasi::where('dokter_id', $dokterId)
            ->where('status', 'dikonfirmasi')
            ->whereDoesntHave('rekamMedis')
            ->count();
        
        return [
            'total' => $totalRekamMedis,
            'bulan_ini' => $rekamMedisBulanIni,
            'hari_ini' => $rekamMedisHariIni,
            'menunggu' => $reservasiMenunggu
        ];
    }
}
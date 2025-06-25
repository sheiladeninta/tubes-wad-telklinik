<?php
namespace App\Http\Controllers\Dokter;
use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class RekamMedisController extends Controller
{
    /**
     * Display a listing of rekam medis untuk dokter
     */
    public function index(Request $request)
    {
        $query = RekamMedis::with(['pasien', 'reservasi'])
            ->where('dokter_id', auth()->id())
            ->orderBy('tanggal_pemeriksaan', 'desc');

        // Filter berdasarkan search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keluhan', 'like', "%{$search}%")
                  ->orWhere('diagnosa', 'like', "%{$search}%")
                  ->orWhereHas('pasien', function($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan tanggal (menggunakan nama yang konsisten dengan form)
        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $request->tanggal_dari)
                  ->whereDate('tanggal_pemeriksaan', '<=', $request->tanggal_sampai);
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

        // Hitung statistik
        $statistics = $this->getStatisticsForIndex();
        
        // Ambil daftar pasien untuk filter
        $pasiens = RekamMedis::with('pasien')
            ->where('dokter_id', auth()->id())
            ->get()
            ->pluck('pasien')
            ->unique('id')
            ->values();
        
        return view('dokter.rekam-medis.index', compact('rekamMedis', 'pasiens', 'statistics'));
    }
    
    /**
     * Show form untuk membuat rekam medis baru
     */
    public function create(Request $request)
    {
        $reservasiId = $request->get('reservasi_id');
        $reservasi = null;
        
        if ($reservasiId) {
            $reservasi = Reservasi::with('user')
                ->where('id', $reservasiId)
                ->where('dokter_id', auth()->id())
                ->where('status', 'confirmed')
                ->first();
                
            if (!$reservasi) {
                return redirect()->route('dokter.reservasi.index')
                    ->with('error', 'Reservasi tidak valid atau tidak ditemukan.');
            }
        }
        // Ambil daftar pasien yang pernah reservasi dengan dokter ini
        // Perbaikan: menggunakan relasi yang benar
        $pasiens = User::whereHas('reservasi', function($query) {
                $query->where('dokter_id', auth()->id());
            })
            ->where('role', 'pasien')
            ->orderBy('name')
            ->get();
        // Jika tidak ada pasien dari reservasi, ambil semua pasien
        if ($pasiens->isEmpty()) {
            $pasiens = User::where('role', 'pasien')
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }
        return view('dokter.rekam-medis.create', compact('reservasi', 'pasiens'));
    }
    
    /**
     * Store rekam medis baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reservasi_id' => 'nullable|exists:reservasis,id',
            'tanggal_pemeriksaan' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'tinggi_badan' => 'nullable|numeric|min:50|max:250',
            'berat_badan' => 'nullable|numeric|min:10|max:300',
            'tekanan_darah' => 'nullable|string',
            'suhu_tubuh' => 'nullable|numeric|min:30|max:45',
            'nadi' => 'nullable|integer|min:40|max:200',
            'status' => 'required|in:draft,final'
        ], [
            'user_id.required' => 'Pasien harus dipilih',
            'user_id.exists' => 'Pasien tidak valid',
            'tanggal_pemeriksaan.required' => 'Tanggal pemeriksaan harus diisi',
            'keluhan.required' => 'Keluhan pasien harus diisi',
            'diagnosa.required' => 'Diagnosa harus diisi',
            'tindakan.required' => 'Tindakan harus diisi',
            'tinggi_badan.min' => 'Tinggi badan minimal 50 cm',
            'tinggi_badan.max' => 'Tinggi badan maksimal 250 cm',
            'berat_badan.min' => 'Berat badan minimal 10 kg',
            'berat_badan.max' => 'Berat badan maksimal 300 kg',
            'suhu_tubuh.min' => 'Suhu tubuh minimal 30°C',
            'suhu_tubuh.max' => 'Suhu tubuh maksimal 45°C',
            'nadi.min' => 'Nadi minimal 40 bpm',
            'nadi.max' => 'Nadi maksimal 200 bpm'
        ]);
        // Validasi tambahan untuk memastikan pasien valid
        $pasien = User::where('id', $request->user_id)
            ->where('role', 'pasien')
            ->first();
        if (!$pasien) {
            return back()->withInput()
                ->with('error', 'Pasien yang dipilih tidak valid.');
        }
        // Validasi reservasi jika ada
        if ($request->reservasi_id) {
            $reservasi = Reservasi::where('id', $request->reservasi_id)
                ->where('dokter_id', auth()->id())
                ->where('user_id', $request->user_id)
                ->first();
            if (!$reservasi) {
                return back()->withInput()
                    ->with('error', 'Reservasi tidak valid atau tidak sesuai dengan pasien.');
            }
        }
        try {
            DB::beginTransaction();
            $rekamMedis = RekamMedis::create([
                'user_id' => $request->user_id,
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
            // Update status reservasi jika ada
            if ($request->reservasi_id) {
                Reservasi::where('id', $request->reservasi_id)
                    ->update(['status' => 'final']);
            }
            DB::commit();
            return redirect()->route('dokter.rekam-medis.show', $rekamMedis)
                ->with('success', 'Rekam medis berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error creating rekam medis: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan rekam medis.');
        }
    }
    
    /**
     * Display rekam medis detail
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
     * Show form edit rekam medis
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
        $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'resep_obat' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'tinggi_badan' => 'nullable|numeric|min:50|max:250',
            'berat_badan' => 'nullable|numeric|min:10|max:300',
            'tekanan_darah' => 'nullable|string',
            'suhu_tubuh' => 'nullable|numeric|min:30|max:45',
            'nadi' => 'nullable|integer|min:40|max:200',
            'status' => 'required|in:draft,final'
        ]);
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
        return redirect()->route('dokter.rekam-medis.show', $rekamMedis)
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Delete rekam medis
     */
    public function destroy(RekamMedis $rekamMedis)
    {
        // Pastikan rekam medis dibuat oleh dokter yang sedang login
        if ($rekamMedis->dokter_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        // Hanya bisa menghapus jika status masih draft
        if ($rekamMedis->status !== 'draft') {
            return redirect()->route('dokter.rekam-medis.index')
                ->with('error', 'Hanya rekam medis dengan status draft yang dapat dihapus.');
        }

        try {
            DB::beginTransaction();
            
            // Jika ada reservasi yang terkait, kembalikan statusnya
            if ($rekamMedis->reservasi_id) {
                Reservasi::where('id', $rekamMedis->reservasi_id)
                    ->update(['status' => 'confirmed']);
            }
            
            $rekamMedis->delete();
            
            DB::commit();
            
            return redirect()->route('dokter.rekam-medis.index')
                ->with('success', 'Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error deleting rekam medis: ' . $e->getMessage());
            
            return redirect()->route('dokter.rekam-medis.index')
                ->with('error', 'Terjadi kesalahan saat menghapus rekam medis.');
        }
    }
    
    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $dokterId = auth()->id();
        
        // Total rekam medis
        $totalRekamMedis = RekamMedis::where('dokter_id', $dokterId)->count();
        
        // Rekam medis hari ini
        $rekamMedisHariIni = RekamMedis::where('dokter_id', $dokterId)
            ->whereDate('tanggal_pemeriksaan', Carbon::today())
            ->count();
        
        // Rekam medis bulan ini
        $rekamMedisBulanIni = RekamMedis::where('dokter_id', $dokterId)
            ->whereMonth('tanggal_pemeriksaan', Carbon::now()->month)
            ->whereYear('tanggal_pemeriksaan', Carbon::now()->year)
            ->count();
        
        // Pasien unik yang ditangani
        $totalPasien = RekamMedis::where('dokter_id', $dokterId)
            ->distinct('user_id')
            ->count();
        
        return [
            'total' => $totalRekamMedis,
            'hari_ini' => $rekamMedisHariIni,
            'bulan_ini' => $rekamMedisBulanIni,
            'total_pasien' => $totalPasien
        ];
    }

    /**
     * Get statistics for index page
     */
    private function getStatisticsForIndex()
    {
        $dokterId = auth()->id();
        
        // Total rekam medis
        $total = RekamMedis::where('dokter_id', $dokterId)->count();
        
        // Draft
        $draft = RekamMedis::where('dokter_id', $dokterId)
            ->where('status', 'draft')
            ->count();
        
        // Final/Selesai
        $final = RekamMedis::where('dokter_id', $dokterId)
            ->where('status', 'final')
            ->count();
        
        // Hari ini
        $today = RekamMedis::where('dokter_id', $dokterId)
            ->whereDate('tanggal_pemeriksaan', Carbon::today())
            ->count();
        
        // Minggu ini
        $thisWeek = RekamMedis::where('dokter_id', $dokterId)
            ->whereBetween('tanggal_pemeriksaan', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->count();
        
        return [
            'total' => $total,
            'draft' => $draft,
            'final' => $final,
            'today' => $today,
            'thisWeek' => $thisWeek
        ];
    }
}
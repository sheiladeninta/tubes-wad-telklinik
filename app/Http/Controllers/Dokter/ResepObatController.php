<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\ResepObat;
use App\Models\DetailResepObat;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResepObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ResepObat::with(['pasien', 'reservasi', 'detailResep'])
            ->where('dokter_id', Auth::id())
            ->orderBy('tanggal_resep', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_resep', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_resep', '<=', $request->tanggal_sampai);
        }

        // Search by patient name or prescription number
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nomor_resep', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pasien', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $resepObat = $query->paginate(10)->withQueryString();
        $statistics = $this->getStatistics();

        return view('dokter.resep-obat.index', compact('resepObat', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $reservasiId = $request->get('reservasi_id');
        $reservasi = null;
        
        if ($reservasiId) {
            $reservasi = Reservasi::with('user')
                ->where('id', $reservasiId)
                ->where('dokter_id', Auth::id())
                ->where('status', Reservasi::STATUS_COMPLETED)
                ->first();
                
            if (!$reservasi) {
                return redirect()->route('dokter.resep-obat.index')
                    ->with('error', 'Reservasi tidak ditemukan atau belum selesai.');
            }
        }

        // Get patients who have completed reservations with this doctor
        $pasienList = User::pasien()
            ->whereHas('reservasi', function($query) {
                $query->where('dokter_id', Auth::id())
                      ->where('status', Reservasi::STATUS_COMPLETED);
            })
            ->orderBy('name')
            ->get();

        return view('dokter.resep-obat.create', compact('reservasi', 'pasienList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:users,id',
            'reservasi_id' => 'nullable|exists:reservasis,id',
            'diagnosa' => 'required|string|max:1000',
            'catatan_dokter' => 'nullable|string|max:1000',
            'obat' => 'required|array|min:1',
            'obat.*.nama' => 'required|string|max:255',
            'obat.*.dosis' => 'required|string|max:100',
            'obat.*.jumlah' => 'required|integer|min:1',
            'obat.*.satuan' => 'required|string|max:50',
            'obat.*.aturan_pakai' => 'required|string|max:255',
            'obat.*.keterangan' => 'nullable|string|max:500',
        ]);

        // Validasi tambahan: pastikan pasien_id adalah user dengan role pasien
        $pasien = User::where('id', $request->pasien_id)
                    ->where('role', 'pasien')
                    ->first();
        
        if (!$pasien) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pasien tidak ditemukan atau tidak valid.');
        }

        // PERBAIKAN: Bersihkan reservasi_id jika kosong
        $reservasiId = null;
        if ($request->filled('reservasi_id') && !empty(trim($request->reservasi_id))) {
            $reservasiId = $request->reservasi_id;
            
            // Validasi reservasi jika ada
            $reservasi = Reservasi::where('id', $reservasiId)
                                ->where('dokter_id', Auth::id())
                                ->where('status', Reservasi::STATUS_COMPLETED)
                                ->first();
            
            if (!$reservasi) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Reservasi tidak valid atau belum selesai.');
            }
        }

        DB::beginTransaction();
        
        try {
            // Generate nomor resep
            $nomorResep = $this->generateNomorResep();
            
            // Create prescription
            $resepObat = ResepObat::create([
                'pasien_id' => $request->pasien_id,
                'dokter_id' => Auth::id(),
                'reservasi_id' => $reservasiId, // PERBAIKAN: Gunakan variabel yang sudah dibersihkan
                'nomor_resep' => $nomorResep,
                'diagnosa' => $request->diagnosa,
                'catatan_dokter' => $request->catatan_dokter,
                'status' => ResepObat::STATUS_PENDING,
                'tanggal_resep' => now(),
            ]);

            // Create prescription details
            foreach ($request->obat as $index => $obat) {
                $detailResep = DetailResepObat::create([
                    'resep_obat_id' => $resepObat->id,
                    'nama_obat' => $obat['nama'],
                    'dosis' => $obat['dosis'],
                    'jumlah' => (int)$obat['jumlah'],
                    'satuan' => $obat['satuan'],
                    'aturan_pakai' => $obat['aturan_pakai'],
                    'keterangan' => $obat['keterangan'] ?? null,
                ]);
            }

            DB::commit();
            
            return redirect()->route('dokter.resep-obat.show', $resepObat)
                ->with('success', 'Resep obat berhasil dibuat.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat resep obat: ' . $e->getMessage());
        }
    }
    /**
     * Generate nomor resep yang unik
     */
    private function generateNomorResep()
    {
        $date = now()->format('Ymd');
        $time = now()->format('His'); // jam-menit-detik
        $mikroDetik = substr(microtime(), 2, 3); // 3 digit mikrodetik
        
        return 'RSP-' . $date . '-' . $time . $mikroDetik;
    }
    /**
     * Display the specified resource.
     */
    public function show(ResepObat $resepObat)
    {
        // Ensure the prescription belongs to the authenticated doctor
        if ($resepObat->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        $resepObat->load(['pasien', 'detailResep', 'reservasi', 'farmasi']);

        return view('dokter.resep-obat.show', compact('resepObat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResepObat $resepObat)
    {
        // Ensure the prescription belongs to the authenticated doctor
        if ($resepObat->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        // Only allow editing if status is pending
        if ($resepObat->status !== ResepObat::STATUS_PENDING) {
            return redirect()->route('dokter.resep-obat.show', $resepObat)
                ->with('error', 'Resep yang sudah diproses tidak dapat diubah.');
        }

        $resepObat->load(['pasien', 'detailResep', 'reservasi']);

        return view('dokter.resep-obat.edit', compact('resepObat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResepObat $resepObat)
    {
        // Ensure the prescription belongs to the authenticated doctor
        if ($resepObat->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        // Only allow editing if status is pending
        if ($resepObat->status !== ResepObat::STATUS_PENDING) {
            return redirect()->route('dokter.resep-obat.show', $resepObat)
                ->with('error', 'Resep yang sudah diproses tidak dapat diubah.');
        }

        $request->validate([
            'diagnosa' => 'required|string',
            'catatan_dokter' => 'nullable|string',
            'obat' => 'required|array|min:1',
            'obat.*.nama' => 'required|string',
            'obat.*.dosis' => 'required|string',
            'obat.*.jumlah' => 'required|integer|min:1',
            'obat.*.satuan' => 'required|string',
            'obat.*.aturan_pakai' => 'required|string',
            'obat.*.keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Update prescription
            $resepObat->update([
                'diagnosa' => $request->diagnosa,
                'catatan_dokter' => $request->catatan_dokter,
            ]);

            // Delete existing details and create new ones
            $resepObat->detailResep()->delete();

            foreach ($request->obat as $obat) {
                DetailResepObat::create([
                    'resep_obat_id' => $resepObat->id,
                    'nama_obat' => $obat['nama'],
                    'dosis' => $obat['dosis'],
                    'jumlah' => $obat['jumlah'],
                    'satuan' => $obat['satuan'],
                    'aturan_pakai' => $obat['aturan_pakai'],
                    'keterangan' => $obat['keterangan'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('dokter.resep-obat.show', $resepObat)
                ->with('success', 'Resep obat berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui resep obat. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResepObat $resepObat)
    {
        // Ensure the prescription belongs to the authenticated doctor
        if ($resepObat->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        // Only allow deletion if status is pending
        if ($resepObat->status !== ResepObat::STATUS_PENDING) {
            return redirect()->route('dokter.resep-obat.index')
                ->with('error', 'Resep yang sudah diproses tidak dapat dihapus.');
        }

        DB::beginTransaction();
        try {
            $resepObat->detailResep()->delete();
            $resepObat->delete();

            DB::commit();

            return redirect()->route('dokter.resep-obat.index')
                ->with('success', 'Resep obat berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menghapus resep obat. Silakan coba lagi.');
        }
    }

    /**
     * Get statistics for dashboard
     */
    private function getStatistics()
    {
        $dokterId = Auth::id();
        
        return [
            'total' => ResepObat::where('dokter_id', $dokterId)->count(),
            'pending' => ResepObat::where('dokter_id', $dokterId)->byStatus(ResepObat::STATUS_PENDING)->count(),
            'diproses' => ResepObat::where('dokter_id', $dokterId)->byStatus(ResepObat::STATUS_DIPROSES)->count(),
            'siap' => ResepObat::where('dokter_id', $dokterId)->byStatus(ResepObat::STATUS_SIAP)->count(),
            'diambil' => ResepObat::where('dokter_id', $dokterId)->byStatus(ResepObat::STATUS_DIAMBIL)->count(),
        ];
    }

    /**
     * Get patients for AJAX
     */
    public function getPasien(Request $request)
    {
        $search = $request->get('search', '');
        
        $pasien = User::pasien()
            ->whereHas('reservasi', function($query) {
                $query->where('dokter_id', Auth::id())
                      ->where('status', Reservasi::STATUS_COMPLETED);
            })
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'user_type']);

        return response()->json($pasien);
    }
}
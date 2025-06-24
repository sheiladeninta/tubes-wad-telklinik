<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\ResepObat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    /**
     * Display a listing of reservations with prescriptions
     */
    public function index(Request $request)
    {
        $query = Reservasi::with([
            'user', 
            'dokter', 
            'resepObat' => function($q) {
                $q->with('detailResep');
            }
        ])->orderBy('tanggal_reservasi', 'desc')
          ->orderBy('jam_reservasi', 'desc');

        // Filter by status reservasi
        if ($request->filled('status_reservasi')) {
            $query->where('status', $request->status_reservasi);
        }

        // Filter by status resep
        if ($request->filled('status_resep')) {
            $query->whereHas('resepObat', function($q) use ($request) {
                $q->where('status', $request->status_resep);
            });
        }

        // Filter by dokter
        if ($request->filled('dokter_id')) {
            $query->where('dokter_id', $request->dokter_id);
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_reservasi', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_reservasi', '<=', $request->tanggal_sampai);
        }

        // Search by patient name
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $reservasis = $query->paginate(15)->withQueryString();

        // Get doctors for filter
        $dokters = User::where('role', 'dokter')->orderBy('name')->get();

        // Get statistics
        $statistics = $this->getStatistics();

        return view('admin.reservasi.index', compact('reservasis', 'dokters', 'statistics'));
    }

    /**
     * Show detailed reservation with prescription
     */
    public function show(Reservasi $reservasi)
    {
        $reservasi->load([
            'user', 
            'dokter', 
            'resepObat' => function($q) {
                $q->with(['detailResep', 'farmasi']);
            }
        ]);

        return view('admin.reservasi.show', compact('reservasi'));
    }

    /**
     * Update prescription status
     */
    public function updateResepStatus(Request $request, ResepObat $resepObat)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(ResepObat::getStatusOptions())),
            'farmasi_id' => 'nullable|exists:users,id',
            'catatan' => 'nullable|string|max:500'
        ]);

        $updateData = [
            'status' => $request->status
        ];

        // Set farmasi_id if status is diproses or siap
        if (in_array($request->status, [ResepObat::STATUS_DIPROSES, ResepObat::STATUS_SIAP])) {
            if ($request->filled('farmasi_id')) {
                $updateData['farmasi_id'] = $request->farmasi_id;
            }
        }

        // Set tanggal_ambil if status is diambil
        if ($request->status === ResepObat::STATUS_DIAMBIL) {
            $updateData['tanggal_ambil'] = now();
        }

        // Update catatan dokter if provided
        if ($request->filled('catatan')) {
            $updateData['catatan_dokter'] = $request->catatan;
        }

        $resepObat->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Status resep obat berhasil diperbarui.',
            'status_label' => $resepObat->fresh()->status_label,
            'status_color' => $resepObat->fresh()->status_color
        ]);
    }

    /**
     * Get statistics for dashboard
     */
    private function getStatistics()
    {
        return [
            'total_reservasi' => Reservasi::count(),
            'reservasi_hari_ini' => Reservasi::whereDate('tanggal_reservasi', today())->count(),
            'total_resep' => ResepObat::count(),
            'resep_pending' => ResepObat::where('status', ResepObat::STATUS_PENDING)->count(),
            'resep_diproses' => ResepObat::where('status', ResepObat::STATUS_DIPROSES)->count(),
            'resep_siap' => ResepObat::where('status', ResepObat::STATUS_SIAP)->count(),
            'resep_diambil' => ResepObat::where('status', ResepObat::STATUS_DIAMBIL)->count(),
        ];
    }

    /**
     * Get prescription management page
     */
    public function resepObat(Request $request)
    {
        $query = ResepObat::with(['pasien', 'dokter', 'detailResep', 'reservasi', 'farmasi'])
            ->orderBy('tanggal_resep', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by dokter
        if ($request->filled('dokter_id')) {
            $query->where('dokter_id', $request->dokter_id);
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
                  ->orWhereHas('pasien', function($subQ) use ($request) {
                      $subQ->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $resepObat = $query->paginate(15)->withQueryString();

        // Get doctors and pharmacists for filters
        $dokters = User::where('role', 'dokter')->orderBy('name')->get();
        $farmasis = User::where('role', 'farmasi')->orderBy('name')->get();

        return view('admin.resep-obat.index', compact('resepObat', 'dokters', 'farmasis'));
    }
}
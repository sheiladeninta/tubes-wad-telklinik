<?php
// ini untuk pasien melihat resep obat
namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\ResepObat;
use App\Models\DetailResepObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Import DomPDF

class ResepObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ResepObat::with(['dokter', 'detailResep', 'reservasi'])
            ->byPasien(Auth::id())
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

        $resepObat = $query->paginate(10)->withQueryString();

        // Get statistics
        $statistics = $this->getStatistics();

        return view('pasien.resep-obat.index', compact('resepObat', 'statistics'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ResepObat $resepObat)
    {
        // Ensure the prescription belongs to the authenticated patient
        if ($resepObat->pasien_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        $resepObat->load(['dokter', 'detailResep', 'reservasi', 'farmasi']);

        return view('pasien.resep-obat.show', compact('resepObat'));
    }

    /**
     * Get active prescriptions that are ready to be picked up
     */
    public function siapDiambil()
    {
        $resepObat = ResepObat::with(['dokter', 'detailResep'])
            ->byPasien(Auth::id())
            ->byStatus(ResepObat::STATUS_SIAP)
            ->orderBy('tanggal_resep', 'desc')
            ->paginate(10);

        return view('pasien.resep-obat.siap-diambil', compact('resepObat'));
    }

    /**
     * Get prescription history
     */
    public function riwayat()
    {
        $resepObat = ResepObat::with(['dokter', 'detailResep'])
            ->byPasien(Auth::id())
            ->byStatus(ResepObat::STATUS_DIAMBIL)
            ->orderBy('tanggal_ambil', 'desc')
            ->paginate(10);

        return view('pasien.resep-obat.riwayat', compact('resepObat'));
    }

    /**
     * Download prescription as PDF
     */
    public function download(ResepObat $resepObat)
    {
        // Ensure the prescription belongs to the authenticated patient
        if ($resepObat->pasien_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        $resepObat->load(['dokter', 'detailResep', 'pasien']);

        // Generate PDF
        $pdf = Pdf::loadView('pasien.resep-obat.pdf', compact('resepObat'));
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'Resep-Obat-' . $resepObat->nomor_resep . '-' . date('Y-m-d') . '.pdf';
        
        // Download PDF directly
        return $pdf->download($filename);
    }

    /**
     * Stream PDF (untuk preview di browser)
     */
    public function preview(ResepObat $resepObat)
    {
        // Ensure the prescription belongs to the authenticated patient
        if ($resepObat->pasien_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        $resepObat->load(['dokter', 'detailResep', 'pasien']);

        // Generate PDF
        $pdf = Pdf::loadView('pasien.resep-obat.pdf', compact('resepObat'));
        $pdf->setPaper('A4', 'portrait');
        
        // Stream PDF (tampil di browser)
        return $pdf->stream('Resep-Obat-' . $resepObat->nomor_resep . '.pdf');
    }

    /**
     * Get statistics for dashboard
     */
    private function getStatistics()
    {
        $pasienId = Auth::id();

        return [
            'total' => ResepObat::byPasien($pasienId)->count(),
            'pending' => ResepObat::byPasien($pasienId)->byStatus(ResepObat::STATUS_PENDING)->count(),
            'diproses' => ResepObat::byPasien($pasienId)->byStatus(ResepObat::STATUS_DIPROSES)->count(),
            'siap' => ResepObat::byPasien($pasienId)->byStatus(ResepObat::STATUS_SIAP)->count(),
            'diambil' => ResepObat::byPasien($pasienId)->byStatus(ResepObat::STATUS_DIAMBIL)->count(),
        ];
    }

    /**
     * Mark prescription as picked up (for demo purposes)
     * In real implementation, this would be done by pharmacy staff
     */
    public function konfirmasiAmbil(ResepObat $resepObat)
    {
        // Ensure the prescription belongs to the authenticated patient
        if ($resepObat->pasien_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        if ($resepObat->status !== ResepObat::STATUS_SIAP) {
            return redirect()->back()->with('error', 'Resep obat belum siap diambil.');
        }

        $resepObat->update([
            'status' => ResepObat::STATUS_DIAMBIL,
            'tanggal_ambil' => now()
        ]);

        return redirect()->route('pasien.resep-obat.show', $resepObat)
            ->with('success', 'Resep obat berhasil dikonfirmasi sebagai sudah diambil.');
    }
}
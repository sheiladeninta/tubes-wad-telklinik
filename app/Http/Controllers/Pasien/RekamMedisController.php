<?php
// ini untuk pasien melakukan cek rekam medis
namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RekamMedis::with(['dokter', 'reservasi'])
            ->forPasien(auth()->id())
            ->orderBy('tanggal_pemeriksaan', 'desc');

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange($request->start_date, $request->end_date);
        }

        // Filter berdasarkan dokter
        if ($request->filled('dokter_id')) {
            $query->where('dokter_id', $request->dokter_id);
        }

        $rekamMedis = $query->paginate(10);

        // Ambil daftar dokter untuk filter
        $dokters = RekamMedis::with('dokter')
            ->forPasien(auth()->id())
            ->get()
            ->pluck('dokter')
            ->unique('id')
            ->values();

        return view('pasien.rekam-medis.index', compact('rekamMedis', 'dokters'));
    }

    /**
     * Display the specified resource.
     */
    public function show(RekamMedis $rekamMedis)
    {
        // Pastikan rekam medis milik pasien yang sedang login
        if ($rekamMedis->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        $rekamMedis->load(['dokter', 'reservasi']);

        return view('pasien.rekam-medis.show', compact('rekamMedis'));
    }

    /**
     * Download rekam medis as PDF
     */
    public function download(RekamMedis $rekamMedis)
    {
        // Pastikan rekam medis milik pasien yang sedang login
        if ($rekamMedis->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        $rekamMedis->load(['dokter', 'reservasi', 'pasien']);

        // Generate PDF menggunakan view
        $pdf = \PDF::loadView('pasien.rekam-medis.pdf', compact('rekamMedis'));
        
        $filename = 'rekam-medis-' . $rekamMedis->id . '-' . Carbon::now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $userId = auth()->id();
        
        // Total rekam medis
        $totalRekamMedis = RekamMedis::forPasien($userId)->count();
        
        // Rekam medis bulan ini
        $rekamMedisBulanIni = RekamMedis::forPasien($userId)
            ->whereMonth('tanggal_pemeriksaan', Carbon::now()->month)
            ->whereYear('tanggal_pemeriksaan', Carbon::now()->year)
            ->count();
        
        // Rekam medis terakhir
        $rekamMedisTerakhir = RekamMedis::with('dokter')
            ->forPasien($userId)
            ->latest('tanggal_pemeriksaan')
            ->first();
        
        // BMI terakhir
        $bmiTerakhir = RekamMedis::forPasien($userId)
            ->whereNotNull('tinggi_badan')
            ->whereNotNull('berat_badan')
            ->latest('tanggal_pemeriksaan')
            ->first();
        
        return [
            'total' => $totalRekamMedis,
            'bulan_ini' => $rekamMedisBulanIni,
            'terakhir' => $rekamMedisTerakhir,
            'bmi_terakhir' => $bmiTerakhir
        ];
    }
}
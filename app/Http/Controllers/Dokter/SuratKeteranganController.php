<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RequestSuratKeterangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratKeteranganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RequestSuratKeterangan::with(['pasien'])
            ->byDokter(Auth::id())
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Filter berdasarkan jenis surat
        if ($request->filled('jenis_surat') && $request->jenis_surat !== 'all') {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        // Search berdasarkan nama pasien
        if ($request->filled('search')) {
            $query->whereHas('pasien', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $requests = $query->paginate(10)->withQueryString();

        // Count berdasarkan status untuk card statistik
        $statusCounts = RequestSuratKeterangan::byDokter(Auth::id())
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('dokter.surat-keterangan.index', compact('requests', 'statusCounts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestSuratKeterangan $suratKeterangan)
    {
        // Pastikan dokter hanya bisa melihat request yang ditujukan kepadanya
        if ($suratKeterangan->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $suratKeterangan->load(['pasien']);
        
        return view('dokter.surat-keterangan.show', compact('suratKeterangan'));
    }

    /**
     * Approve request dan generate surat
     */
    public function approve(Request $request, RequestSuratKeterangan $suratKeterangan)
    {
        // Pastikan dokter hanya bisa approve request yang ditujukan kepadanya
        if ($suratKeterangan->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Pastikan status masih pending
        if ($suratKeterangan->status !== RequestSuratKeterangan::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Request sudah diproses sebelumnya.');
        }

        // Validasi input tambahan dari dokter
        $validated = $request->validate([
            'diagnosa' => 'required|string|max:500',
            'keterangan_dokter' => 'nullable|string|max:1000',
        ], [
            'diagnosa.required' => 'Diagnosa harus diisi.',
            'diagnosa.max' => 'Diagnosa maksimal 500 karakter.',
            'keterangan_dokter.max' => 'Keterangan dokter maksimal 1000 karakter.',
        ]);

        try {
            // Update status ke diproses
            $suratKeterangan->update([
                'status' => RequestSuratKeterangan::STATUS_DIPROSES,
                'tanggal_diproses' => now(),
            ]);

            // Generate PDF surat keterangan
            $pdfContent = $this->generateSuratPDF($suratKeterangan, $validated);
            
            // Simpan file PDF
            $fileName = 'surat_keterangan_' . $suratKeterangan->id . '_' . time() . '.pdf';
            $filePath = 'surat-keterangan/' . $fileName;
            
            Storage::disk('public')->put($filePath, $pdfContent);

            // Update status ke selesai dan simpan path file
            $suratKeterangan->update([
                'status' => RequestSuratKeterangan::STATUS_SELESAI,
                'file_surat' => $filePath,
                'diagnosa' => $validated['diagnosa'],
                'keterangan_dokter' => $validated['keterangan_dokter'] ?? null,
            ]);

            return redirect()->route('dokter.surat-keterangan.index')
                ->with('success', 'Surat keterangan berhasil dibuat dan dikirim ke pasien.');

        } catch (\Exception $e) {
            // Rollback status jika terjadi error
            $suratKeterangan->update([
                'status' => RequestSuratKeterangan::STATUS_PENDING
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat surat keterangan: ' . $e->getMessage());
        }
    }

    /**
     * Reject request
     */
    public function reject(Request $request, RequestSuratKeterangan $suratKeterangan)
    {
        // Pastikan dokter hanya bisa reject request yang ditujukan kepadanya
        if ($suratKeterangan->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Pastikan status masih pending
        if ($suratKeterangan->status !== RequestSuratKeterangan::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Request sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'alasan_ditolak' => 'required|string|max:500'
        ], [
            'alasan_ditolak.required' => 'Alasan penolakan harus diisi.',
            'alasan_ditolak.max' => 'Alasan penolakan maksimal 500 karakter.'
        ]);

        $suratKeterangan->update([
            'status' => RequestSuratKeterangan::STATUS_DITOLAK,
            'alasan_ditolak' => $validated['alasan_ditolak'],
            'tanggal_diproses' => now(),
        ]);

        return redirect()->route('dokter.surat-keterangan.index')
            ->with('success', 'Request surat keterangan berhasil ditolak.');
    }

    /**
     * Generate PDF surat keterangan
     */
    private function generateSuratPDF(RequestSuratKeterangan $suratKeterangan, array $dataFromDokter)
    {
        $data = [
            'surat' => $suratKeterangan,
            'pasien' => $suratKeterangan->pasien,
            'dokter' => $suratKeterangan->dokter,
            'diagnosa' => $dataFromDokter['diagnosa'],
            'keterangan_dokter' => $dataFromDokter['keterangan_dokter'] ?? null,
            'tanggal_dibuat' => now(),
        ];

        $pdf = Pdf::loadView('dokter.surat-keterangan.pdf-template', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->output();
    }

    /**
     * Download surat keterangan yang sudah dibuat
     */
    public function download(RequestSuratKeterangan $suratKeterangan)
    {
        // Pastikan dokter hanya bisa download yang dibuatnya
        if ($suratKeterangan->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        // Pastikan surat sudah selesai dan ada filenya
        if ($suratKeterangan->status !== RequestSuratKeterangan::STATUS_SELESAI || !$suratKeterangan->file_surat) {
            return redirect()->back()->with('error', 'Surat keterangan belum tersedia untuk diunduh.');
        }

        // Cek apakah file ada
        if (!Storage::disk('public')->exists($suratKeterangan->file_surat)) {
            return redirect()->back()->with('error', 'File surat keterangan tidak ditemukan.');
        }

        $fileName = 'Surat_Keterangan_' . $suratKeterangan->jenis_surat_label . '_' . 
                   $suratKeterangan->pasien->name . '_' . $suratKeterangan->created_at->format('Y-m-d') . '.pdf';
        
        return Storage::disk('public')->download($suratKeterangan->file_surat, $fileName);
    }
}
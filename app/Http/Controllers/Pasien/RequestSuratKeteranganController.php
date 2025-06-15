<?php
// ini untuk pasien melakukan request surat keterangan ke dokter
namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\RequestSuratKeterangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequestSuratKeteranganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = RequestSuratKeterangan::with(['dokter'])
            ->byPasien(Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pasien.surat-keterangan.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dokters = User::where('role', 'dokter')
            ->where('is_active', true)
            ->select('id', 'name', 'specialist')
            ->orderBy('name')
            ->get();

        return view('pasien.surat-keterangan.create', compact('dokters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'jenis_surat' => 'required|in:sakit,sehat,rujukan,keterangan_medis',
            'keperluan' => 'required|string|max:255',
            'tanggal_mulai_sakit' => 'nullable|date|required_if:jenis_surat,sakit',
            'tanggal_selesai_sakit' => 'nullable|date|after_or_equal:tanggal_mulai_sakit|required_if:jenis_surat,sakit',
            'keluhan' => 'nullable|string|max:1000',
            'keterangan_tambahan' => 'nullable|string|max:500'
        ], [
            'dokter_id.required' => 'Pilih dokter yang akan memproses surat keterangan.',
            'dokter_id.exists' => 'Dokter yang dipilih tidak valid.',
            'jenis_surat.required' => 'Pilih jenis surat keterangan.',
            'jenis_surat.in' => 'Jenis surat keterangan tidak valid.',
            'keperluan.required' => 'Keperluan surat keterangan harus diisi.',
            'keperluan.max' => 'Keperluan maksimal 255 karakter.',
            'tanggal_mulai_sakit.required_if' => 'Tanggal mulai sakit harus diisi untuk surat keterangan sakit.',
            'tanggal_selesai_sakit.required_if' => 'Tanggal selesai sakit harus diisi untuk surat keterangan sakit.',
            'tanggal_selesai_sakit.after_or_equal' => 'Tanggal selesai sakit harus sama atau setelah tanggal mulai sakit.',
            'keluhan.max' => 'Keluhan maksimal 1000 karakter.',
            'keterangan_tambahan.max' => 'Keterangan tambahan maksimal 500 karakter.'
        ]);

        $validated['pasien_id'] = Auth::id();
        $validated['tanggal_request'] = now();

        RequestSuratKeterangan::create($validated);

        return redirect()->route('pasien.surat-keterangan.index')
            ->with('success', 'Request surat keterangan berhasil dikirim. Silakan tunggu konfirmasi dari dokter.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestSuratKeterangan $suratKeterangan)
    {
        // Pastikan pasien hanya bisa melihat request miliknya sendiri
        if ($suratKeterangan->pasien_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $suratKeterangan->load(['dokter']);

        return view('pasien.surat-keterangan.show', compact('suratKeterangan'));
    }

    /**
     * Download surat keterangan yang sudah selesai
     */
    public function download(RequestSuratKeterangan $suratKeterangan)
    {
        // Pastikan pasien hanya bisa download miliknya sendiri
        if ($suratKeterangan->pasien_id !== Auth::id()) {
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
                   Auth::user()->name . '_' . $suratKeterangan->created_at->format('Y-m-d') . '.pdf';

        return Storage::disk('public')->download($suratKeterangan->file_surat, $fileName);
    }

    /**
     * Cancel request surat keterangan (hanya bisa jika status pending)
     */
    public function cancel(RequestSuratKeterangan $suratKeterangan)
    {
        // Pastikan pasien hanya bisa cancel miliknya sendiri
        if ($suratKeterangan->pasien_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Hanya bisa cancel jika status pending
        if ($suratKeterangan->status !== RequestSuratKeterangan::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Request tidak dapat dibatalkan karena sudah diproses.');
        }

        $suratKeterangan->delete();

        return redirect()->route('pasien.surat-keterangan.index')
            ->with('success', 'Request surat keterangan berhasil dibatalkan.');
    }

    /**
     * Get available doctors via AJAX
     */
    public function getDokters(Request $request)
    {
        $dokters = User::where('role', 'dokter')
            ->where('is_active', true)
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                           ->orWhere('specialist', 'like', '%' . $search . '%');
            })
            ->select('id', 'name', 'specialist')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($dokters);
    }
}
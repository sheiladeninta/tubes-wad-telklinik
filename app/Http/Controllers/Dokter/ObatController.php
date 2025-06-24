<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource for doctors.
     */
    public function index(Request $request)
    {
        $query = Obat::aktif(); // Hanya tampilkan obat yang aktif
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_obat', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis_obat', 'like', '%' . $request->search . '%')
                  ->orWhere('pabrik', 'like', '%' . $request->search . '%')
                  ->orWhere('komposisi', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by jenis obat
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis_obat', $request->jenis);
        }
        
        // Filter by status stok
        if ($request->has('stok_status')) {
            switch ($request->stok_status) {
                case 'habis':
                    $query->where('stok', 0);
                    break;
                case 'menipis':
                    $query->where('stok', '>', 0)->where('stok', '<', 10);
                    break;
                case 'aman':
                    $query->where('stok', '>=', 50);
                    break;
                case 'sedang':
                    $query->where('stok', '>=', 10)->where('stok', '<', 50);
                    break;
            }
        }
        
        // Filter by expiry status
        if ($request->has('expiry_status')) {
            switch ($request->expiry_status) {
                case 'hampir_kadaluarsa':
                    $query->where('tanggal_kadaluarsa', '<=', now()->addMonths(6))
                          ->where('tanggal_kadaluarsa', '>', now());
                    break;
                case 'kadaluarsa':
                    $query->where('tanggal_kadaluarsa', '<', now());
                    break;
                case 'aman':
                    $query->where('tanggal_kadaluarsa', '>', now()->addMonths(6));
                    break;
            }
        }
        
        $obat = $query->orderBy('nama_obat')->paginate(12);
        
        // Get filter options
        $jenisObat = Obat::aktif()->select('jenis_obat')->distinct()->pluck('jenis_obat');
        
        // Get statistics
        $statistics = [
            'total_obat' => Obat::aktif()->count(),
            'stok_menipis' => Obat::aktif()->stokMenupis()->count(),
            'hampir_kadaluarsa' => Obat::aktif()->hampirKadaluarsa()->count(),
            'stok_habis' => Obat::aktif()->where('stok', 0)->count(),
        ];
        
        return view('dokter.obat.index', compact('obat', 'jenisObat', 'statistics'));
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $obat = Obat::aktif()->findOrFail($id);
        return view('dokter.obat.show', compact('obat'));
    }
    
    /**
     * Get medicine information for AJAX requests
     */
    public function getInfo($id)
    {
        $obat = Obat::aktif()->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $obat->id,
                'nama_obat' => $obat->nama_obat,
                'jenis_obat' => $obat->jenis_obat,
                'deskripsi' => $obat->deskripsi,
                'komposisi' => $obat->komposisi,
                'dosis' => $obat->dosis,
                'cara_pakai' => $obat->cara_pakai,
                'efek_samping' => $obat->efek_samping,
                'kontraindikasi' => $obat->kontraindikasi,
                'stok' => $obat->stok,
                'status_stok' => $obat->status_stok,
                'harga_format' => $obat->harga_format,
                'tanggal_kadaluarsa' => $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->format('d/m/Y') : '-',
                'pabrik' => $obat->pabrik,
                'nomor_batch' => $obat->nomor_batch,
                'gambar' => $obat->gambar ? asset('storage/' . $obat->gambar) : null,
                'is_hampir_kadaluarsa' => $obat->isHampirKadaluarsa(),
                'is_kadaluarsa' => $obat->isKadaluarsa(),
            ]
        ]);
    }
}
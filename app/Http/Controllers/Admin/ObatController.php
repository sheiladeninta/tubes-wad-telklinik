<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Obat::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_obat', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis_obat', 'like', '%' . $request->search . '%')
                  ->orWhere('pabrik', 'like', '%' . $request->search . '%');
        }

        // Filter by jenis obat
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis_obat', $request->jenis);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by stok status
        if ($request->has('stok_status')) {
            switch ($request->stok_status) {
                case 'habis':
                    $query->where('stok', 0);
                    break;
                case 'menipis':
                    $query->where('stok', '>', 0)->where('stok', '<', 10);
                    break;
                case 'hampir_kadaluarsa':
                    $query->where('tanggal_kadaluarsa', '<=', now()->addMonths(6))
                          ->where('tanggal_kadaluarsa', '>', now());
                    break;
            }
        }

        $obat = $query->orderBy('nama_obat')->paginate(10);

        // Get filter options
        $jenisObat = Obat::select('jenis_obat')->distinct()->pluck('jenis_obat');
        
        return view('admin.obat.index', compact('obat', 'jenisObat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|in:tablet,kapsul,sirup,injeksi,salep,tetes,spray,suppositoria,lainnya',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'tanggal_kadaluarsa' => 'nullable|date|after:today',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('obat', $imageName, 'public');
            $data['gambar'] = $imagePath;
        }

        Obat::create($data);

        return redirect()->route('admin.obat.index')
                        ->with('success', 'Obat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.show', compact('obat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|in:tablet,kapsul,sirup,injeksi,salep,tetes,spray,suppositoria,lainnya',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'tanggal_kadaluarsa' => 'nullable|date|after:today',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($obat->gambar) {
                Storage::disk('public')->delete($obat->gambar);
            }

            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('obat', $imageName, 'public');
            $data['gambar'] = $imagePath;
        }

        $obat->update($data);

        return redirect()->route('admin.obat.index')
                        ->with('success', 'Obat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        
        // Delete image if exists
        if ($obat->gambar) {
            Storage::disk('public')->delete($obat->gambar);
        }
        
        $obat->delete();

        return redirect()->route('admin.obat.index')
                        ->with('success', 'Obat berhasil dihapus!');
    }

    /**
     * Update stock of medicine
     */
    public function updateStock(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'stok' => 'required|integer|min:0',
            'aksi' => 'required|in:tambah,kurang,set'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $stokBaru = $obat->stok;
        
        switch ($request->aksi) {
            case 'tambah':
                $stokBaru += $request->stok;
                break;
            case 'kurang':
                $stokBaru = max(0, $stokBaru - $request->stok);
                break;
            case 'set':
                $stokBaru = $request->stok;
                break;
        }

        $obat->update(['stok' => $stokBaru]);

        return response()->json([
            'success' => true, 
            'message' => 'Stok berhasil diperbarui!',
            'stok_baru' => $stokBaru
        ]);
    }

    /**
     * Get dashboard data for medicines
     */
    public function getDashboardData()
    {
        $totalObat = Obat::count();
        $stokMenupis = Obat::stokMenupis()->count();
        $hampirKadaluarsa = Obat::hampirKadaluarsa()->count();
        $totalNilaiStok = Obat::sum(\DB::raw('stok * harga'));

        return response()->json([
            'total_obat' => $totalObat,
            'stok_menipis' => $stokMenupis,
            'hampir_kadaluarsa' => $hampirKadaluarsa,
            'total_nilai_stok' => $totalNilaiStok
        ]);
    }
}
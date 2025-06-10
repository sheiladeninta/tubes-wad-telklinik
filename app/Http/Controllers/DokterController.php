<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DokterController extends Controller
{
    public function dashboard()
    {
        $dokter = Auth::user();
        
        // Pastikan user adalah dokter
        if (!$dokter->isDokter()) {
            abort(403, 'Unauthorized access');
        }
        
        // Statistics untuk dashboard
        $stats = [
            'jadwal_hari_ini' => 0, // Akan diimplementasi nanti
            'total_pasien' => User::pasien()->count(),
            'konsultasi_pending' => 0, // Akan diimplementasi nanti
            'total_dokter' => User::dokter()->where('is_active', true)->count(),
        ];
        
        // Data dokter yang sedang login
        $dokterInfo = [
            'name' => $dokter->name,
            'email' => $dokter->email,
            'specialist' => $dokter->specialist,
            'license_number' => $dokter->license_number,
            'phone' => $dokter->phone,
            'address' => $dokter->address,
            'birth_date' => $dokter->birth_date ? $dokter->birth_date->format('d F Y') : '-',
            'gender' => $dokter->gender === 'L' ? 'Laki-laki' : 'Perempuan',
            'blood_type' => $dokter->blood_type,
            'is_active' => $dokter->is_active,
        ];
        
        return view('dokter.dashboard', compact('dokter', 'stats', 'dokterInfo'));
    }
    
    public function profile()
    {
        $dokter = Auth::user();
        
        if (!$dokter->isDokter()) {
            abort(403, 'Unauthorized access');
        }
        
        return view('dokter.profile', compact('dokter'));
    }
    
    public function updateProfile(Request $request)
    {
        $dokter = Auth::user();
        
        if (!$dokter->isDokter()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'specialist' => 'required|string|max:100',
        ]);

        $dokter->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'specialist' => $request->specialist,
        ]);

        return redirect()->back()->with('success', 'Profile berhasil diperbarui!');
    }
}
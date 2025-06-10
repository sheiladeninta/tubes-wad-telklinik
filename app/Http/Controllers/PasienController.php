<?php

// app/Http/Controllers/PasienController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    public function dashboard()
    {
        $pasien = Auth::user();
        
        $stats = [
            'total_kunjungan' => 0,
            'reservasi_aktif' => 0,
            'resep_aktif' => 0,
        ];
        
        return view('pasien.dashboard', compact('pasien', 'stats'));
    }
}
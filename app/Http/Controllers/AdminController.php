<?php
// ini untuk mengantur dashboard admin
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_pasien' => User::pasien()->count(),
            'total_dokter' => User::dokter()->count(),
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}

<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    /**
     * Menampilkan daftar reservasi pasien untuk dokter yang sedang login
     */
    public function index(Request $request)
    {
        $query = Reservasi::where('dokter_id', Auth::id())
            ->with(['user', 'dokter'])
            ->orderBy('tanggal_reservasi', 'desc')
            ->orderBy('jam_reservasi', 'desc');

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_reservasi', $request->tanggal);
        }

        // Search berdasarkan nama pasien
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $reservasis = $query->paginate(10);

        // Statistik reservasi
        $stats = [
            'total' => Reservasi::where('dokter_id', Auth::id())->count(),
            'pending' => Reservasi::where('dokter_id', Auth::id())->where('status', Reservasi::STATUS_PENDING)->count(),
            'confirmed' => Reservasi::where('dokter_id', Auth::id())->where('status', Reservasi::STATUS_CONFIRMED)->count(),
            'completed' => Reservasi::where('dokter_id', Auth::id())->where('status', Reservasi::STATUS_COMPLETED)->count(),
            'cancelled' => Reservasi::where('dokter_id', Auth::id())->where('status', Reservasi::STATUS_CANCELLED)->count(),
        ];

        return view('dokter.reservasi.index', compact('reservasis', 'stats'));
    }

    /**
     * Menampilkan detail reservasi
     */
    public function show(Reservasi $reservasi)
    {
        // Pastikan reservasi milik dokter yang sedang login
        if ($reservasi->dokter_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('dokter.reservasi.show', compact('reservasi'));
    }

    /**
     * Konfirmasi reservasi
     */
    public function confirm(Reservasi $reservasi)
    {
        // Pastikan reservasi milik dokter yang sedang login
        if ($reservasi->dokter_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa konfirmasi jika status pending
        if ($reservasi->status !== Reservasi::STATUS_PENDING) {
            return back()->with('error', 'Reservasi tidak dapat dikonfirmasi.');
        }

        $reservasi->update(['status' => Reservasi::STATUS_CONFIRMED]);

        return back()->with('success', 'Reservasi berhasil dikonfirmasi.');
    }

    /**
     * Menyelesaikan reservasi
     */
    public function complete(Request $request, Reservasi $reservasi)
    {
        // Pastikan reservasi milik dokter yang sedang login
        if ($reservasi->dokter_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa menyelesaikan jika status confirmed
        if ($reservasi->status !== Reservasi::STATUS_CONFIRMED) {
            return back()->with('error', 'Reservasi tidak dapat diselesaikan.');
        }

        $request->validate([
            'catatan_dokter' => 'nullable|string|max:1000'
        ]);

        $reservasi->update([
            'status' => Reservasi::STATUS_COMPLETED,
            'catatan_dokter' => $request->catatan_dokter
        ]);

        return back()->with('success', 'Reservasi berhasil diselesaikan.');
    }

    /**
     * Membatalkan reservasi
     */
    public function cancel(Request $request, Reservasi $reservasi)
    {
        // Pastikan reservasi milik dokter yang sedang login
        if ($reservasi->dokter_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa cancel jika status pending atau confirmed
        if (!in_array($reservasi->status, [Reservasi::STATUS_PENDING, Reservasi::STATUS_CONFIRMED])) {
            return back()->with('error', 'Reservasi tidak dapat dibatalkan.');
        }

        $request->validate([
            'catatan_dokter' => 'nullable|string|max:1000'
        ]);

        $reservasi->update([
            'status' => Reservasi::STATUS_CANCELLED,
            'catatan_dokter' => $request->catatan_dokter
        ]);

        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }

    /**
     * Menampilkan reservasi hari ini
     */
    public function today()
    {
        $reservasis = Reservasi::where('dokter_id', Auth::id())
            ->whereDate('tanggal_reservasi', now()->toDateString())
            ->with(['user', 'dokter'])
            ->orderBy('jam_reservasi', 'asc')
            ->get();

        return view('dokter.reservasi.today', compact('reservasis'));
    }

    /**
     * Menampilkan reservasi yang akan datang
     */
    public function upcoming()
    {
        $reservasis = Reservasi::where('dokter_id', Auth::id())
            ->where('tanggal_reservasi', '>=', now()->toDateString())
            ->whereIn('status', [Reservasi::STATUS_PENDING, Reservasi::STATUS_CONFIRMED])
            ->with(['user', 'dokter'])
            ->orderBy('tanggal_reservasi', 'asc')
            ->orderBy('jam_reservasi', 'asc')
            ->get();

        return view('dokter.reservasi.upcoming', compact('reservasis'));
    }
}
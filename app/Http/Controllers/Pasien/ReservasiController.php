<?php
// ini untuk pasien melakukan reservasi dokter
namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::byUser(Auth::id())
            ->with('dokter')
            ->orderBy('tanggal_reservasi', 'desc')
            ->orderBy('jam_reservasi', 'desc')
            ->paginate(10);

        return view('pasien.reservasi.index', compact('reservasis'));
    }

    public function create()
    {
        // Ambil daftar dokter (asumsi role dokter ada)
        $dokters = User::where('role', 'dokter')
            ->orderBy('name')
            ->get();

        // Generate slot waktu (08:00 - 17:00, interval 30 menit)
        $timeSlots = $this->generateTimeSlots();

        return view('pasien.reservasi.create', compact('dokters', 'timeSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi' => 'required',
            'keluhan' => 'required|string|min:10|max:1000',
        ], [
            'dokter_id.required' => 'Pilih dokter yang diinginkan.',
            'dokter_id.exists' => 'Dokter yang dipilih tidak valid.',
            'tanggal_reservasi.required' => 'Tanggal reservasi harus diisi.',
            'tanggal_reservasi.date' => 'Format tanggal tidak valid.',
            'tanggal_reservasi.after_or_equal' => 'Tanggal reservasi tidak boleh kurang dari hari ini.',
            'jam_reservasi.required' => 'Jam reservasi harus dipilih.',
            'keluhan.required' => 'Keluhan harus diisi.',
            'keluhan.min' => 'Keluhan minimal 10 karakter.',
            'keluhan.max' => 'Keluhan maksimal 1000 karakter.',
        ]);

        // Cek apakah slot waktu sudah terisi
        $existingReservasi = Reservasi::where('dokter_id', $request->dokter_id)
            ->where('tanggal_reservasi', $request->tanggal_reservasi)
            ->where('jam_reservasi', $request->jam_reservasi)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($existingReservasi) {
            return back()->withErrors(['jam_reservasi' => 'Slot waktu tersebut sudah terisi. Silakan pilih waktu lain.'])->withInput();
        }

        Reservasi::create([
            'user_id' => Auth::id(),
            'dokter_id' => $request->dokter_id,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'jam_reservasi' => $request->jam_reservasi,
            'keluhan' => $request->keluhan,
            'status' => Reservasi::STATUS_PENDING,
        ]);

        return redirect()->route('pasien.reservasi.index')
            ->with('success', 'Reservasi berhasil dibuat. Silakan tunggu konfirmasi dari dokter.');
    }

    public function show(Reservasi $reservasi)
    {
        // Pastikan reservasi milik user yang login
        if ($reservasi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('pasien.reservasi.show', compact('reservasi'));
    }

    public function cancel(Reservasi $reservasi)
    {
        // Pastikan reservasi milik user yang login
        if ($reservasi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa cancel jika status pending atau confirmed
        if (!in_array($reservasi->status, [Reservasi::STATUS_PENDING, Reservasi::STATUS_CONFIRMED])) {
            return back()->with('error', 'Reservasi tidak dapat dibatalkan.');
        }

        // Perbaiki parsing datetime - gabungkan tanggal dan jam dengan benar
        $tanggalReservasi = Carbon::parse($reservasi->tanggal_reservasi);
        $jamReservasi = Carbon::parse($reservasi->jam_reservasi);
        
        // Buat datetime yang benar dengan menggabungkan tanggal dan jam
        $reservasiDateTime = $tanggalReservasi->setTime($jamReservasi->hour, $jamReservasi->minute);
        
        // Cek apakah kurang dari 2 jam sebelum jadwal
        if ($reservasiDateTime->diffInHours(now()) < 2) {
            return back()->with('error', 'Reservasi tidak dapat dibatalkan kurang dari 2 jam sebelum jadwal.');
        }

        $reservasi->update(['status' => Reservasi::STATUS_CANCELLED]);

        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function upcoming()
    {
        $reservasis = Reservasi::byUser(Auth::id())
            ->upcoming()
            ->with('dokter')
            ->orderBy('tanggal_reservasi', 'asc')
            ->orderBy('jam_reservasi', 'asc')
            ->get();

        return view('pasien.reservasi.upcoming', compact('reservasis'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'tanggal_reservasi' => 'required|date',
        ]);

        $bookedSlots = Reservasi::where('dokter_id', $request->dokter_id)
            ->where('tanggal_reservasi', $request->tanggal_reservasi)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('jam_reservasi')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        $timeSlots = $this->generateTimeSlots();
        $availableSlots = array_filter($timeSlots, function ($slot) use ($bookedSlots) {
            return !in_array($slot, $bookedSlots);
        });

        return response()->json([
            'available_slots' => array_values($availableSlots)
        ]);
    }

    private function generateTimeSlots()
    {
        $slots = [];
        $start = Carbon::createFromTime(8, 0); // 08:00
        $end = Carbon::createFromTime(17, 0);  // 17:00

        while ($start <= $end) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(30);
        }

        return $slots;
    }
}
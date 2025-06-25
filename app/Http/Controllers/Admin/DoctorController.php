<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized access');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of doctors
     */
    public function index(Request $request)
    {
        $query = User::dokter();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('specialist', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $doctors = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new doctor
     */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /**
     * Store a newly created doctor
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:L,P',
            'address' => 'nullable|string|max:500',
            'specialist' => 'required|string|max:255',
            'license_number' => 'required|string|max:100|unique:users',
            'blood_type' => 'nullable|in:A,B,AB,O',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'specialist.required' => 'Spesialisasi wajib diisi.',
            'license_number.required' => 'Nomor lisensi wajib diisi.',
            'license_number.unique' => 'Nomor lisensi sudah terdaftar.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'blood_type.in' => 'Golongan darah tidak valid.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dokter',
            'user_type' => 'dokter',
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'specialist' => $request->specialist,
            'license_number' => $request->license_number,
            'blood_type' => $request->blood_type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.doctors.index')
                        ->with('success', 'Data dokter berhasil ditambahkan.');
    }

    /**
     * Display the specified doctor
     */
    public function show(User $doctor)
    {
        if (!$doctor->isDokter()) {
            abort(404);
        }
        
        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified doctor
     */
    public function edit(User $doctor)
    {
        if (!$doctor->isDokter()) {
            abort(404);
        }
        
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified doctor
     */
    public function update(Request $request, User $doctor)
    {
        if (!$doctor->isDokter()) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($doctor->id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:L,P',
            'address' => 'nullable|string|max:500',
            'specialist' => 'required|string|max:255',
            'license_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users')->ignore($doctor->id),
            ],
            'blood_type' => 'nullable|in:A,B,AB,O',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'specialist.required' => 'Spesialisasi wajib diisi.',
            'license_number.required' => 'Nomor lisensi wajib diisi.',
            'license_number.unique' => 'Nomor lisensi sudah terdaftar.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'blood_type.in' => 'Golongan darah tidak valid.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'specialist' => $request->specialist,
            'license_number' => $request->license_number,
            'blood_type' => $request->blood_type,
            'is_active' => $request->has('is_active'),
        ];

        // Only update password if provided
        if (!empty($request->password)) {
            $updateData['password'] = Hash::make($request->password);
        }

        $doctor->update($updateData);

        return redirect()->route('admin.doctors.index')
                        ->with('success', 'Data dokter berhasil diperbarui.');
    }

    /**
     * Remove the specified doctor
     */
    public function destroy(User $doctor)
    {
        if (!$doctor->isDokter()) {
            abort(404);
        }

        // Check if doctor has any reservations or medical records
        if ($doctor->reservasiDokter()->count() > 0 || $doctor->rekamMedisDokter()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus dokter yang memiliki riwayat reservasi atau rekam medis.');
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')
                        ->with('success', 'Data dokter berhasil dihapus.');
    }

    /**
     * Toggle doctor status (active/inactive)
     */
    public function toggleStatus(User $doctor)
    {
        if (!$doctor->isDokter()) {
            abort(404);
        }

        $doctor->update([
            'is_active' => !$doctor->is_active
        ]);

        $status = $doctor->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Status dokter berhasil {$status}.");
    }
}
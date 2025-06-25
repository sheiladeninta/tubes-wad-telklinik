@extends('layouts.admin')

@section('title', 'Edit Dokter')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Dokter</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Dokter</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Edit Dokter</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-lg-6">
                                <h6 class="fw-semibold text-primary mb-3">Informasi Pribadi</h6>
                                
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $doctor->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $doctor->email) }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password Confirmation -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation">
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">No. Telepon</label>
                                    <input type="text" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $doctor->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Birth Date -->
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <input type="date" 
                                           class="form-control @error('birth_date') is-invalid @enderror" 
                                           id="birth_date" 
                                           name="birth_date" 
                                           value="{{ old('birth_date', $doctor->birth_date) }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" 
                                            id="gender" 
                                            name="gender">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('gender', $doctor->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender', $doctor->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Blood Type -->
                                <div class="mb-3">
                                    <label for="blood_type" class="form-label">Golongan Darah</label>
                                    <select class="form-select @error('blood_type') is-invalid @enderror" 
                                            id="blood_type" 
                                            name="blood_type">
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A" {{ old('blood_type', $doctor->blood_type) == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('blood_type', $doctor->blood_type) == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="AB" {{ old('blood_type', $doctor->blood_type) == 'AB' ? 'selected' : '' }}>AB</option>
                                        <option value="O" {{ old('blood_type', $doctor->blood_type) == 'O' ? 'selected' : '' }}>O</option>
                                    </select>
                                    @error('blood_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="col-lg-6">
                                <h6 class="fw-semibold text-primary mb-3">Informasi Profesional</h6>
                                
                                <!-- Specialist -->
                                <div class="mb-3">
                                    <label for="specialist" class="form-label">
                                        Spesialisasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('specialist') is-invalid @enderror" 
                                           id="specialist" 
                                           name="specialist" 
                                           value="{{ old('specialist', $doctor->specialist) }}" 
                                           required>
                                    @error('specialist')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- License Number -->
                                <div class="mb-3">
                                    <label for="license_number" class="form-label">
                                        Nomor Lisensi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('license_number') is-invalid @enderror" 
                                           id="license_number" 
                                           name="license_number" 
                                           value="{{ old('license_number', $doctor->license_number) }}" 
                                           required>
                                    @error('license_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" 
                                              name="address" 
                                              rows="4" 
                                              placeholder="Masukkan alamat lengkap">{{ old('address', $doctor->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               {{ old('is_active', $doctor->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Status Aktif
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Dokter yang tidak aktif tidak dapat melakukan aktivitas sistem
                                    </small>
                                </div>

                                <!-- Statistics Info -->
                                <div class="card bg-light mt-4">
                                    <div class="card-body">
                                        <h6 class="card-title">Informasi Statistik</h6>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="mb-2">
                                                    <span class="fw-bold text-primary">{{ $doctor->reservasiDokter()->count() }}</span>
                                                </div>
                                                <small class="text-muted">Total Reservasi</small>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-2">
                                                    <span class="fw-bold text-success">{{ $doctor->rekamMedisDokter()->count() }}</span>
                                                </div>
                                                <small class="text-muted">Rekam Medis</small>
                                            </div>
                                        </div>
                                        @if($doctor->reservasiDokter()->count() > 0 || $doctor->rekamMedisDokter()->count() > 0)
                                            <div class="alert alert-warning mt-3 mb-0">
                                                <small>
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Dokter ini memiliki riwayat reservasi/rekam medis dan tidak dapat dihapus
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-secondary">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-light">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate license number format if needed
    const licenseInput = document.getElementById('license_number');
    const specialistInput = document.getElementById('specialist');
    
    // Add any additional form validation or interactions here
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        
        if (password && password !== passwordConfirm) {
            e.preventDefault();
            alert('Konfirmasi password tidak cocok!');
            return false;
        }
    });
});
</script>
@endpush
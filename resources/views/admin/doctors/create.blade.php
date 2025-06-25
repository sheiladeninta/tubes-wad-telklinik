@extends('layouts.admin')
@section('title', 'Tambah Dokter Baru')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-user-plus me-2"></i>
                            Tambah Dokter Baru
                        </h4>
                        <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('admin.doctors.store') }}" method="POST">
                        @csrf
                        
                        <!-- Personal Information Section -->
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-user me-2"></i>
                                Informasi Pribadi
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <input type="date" 
                                           class="form-control @error('birth_date') is-invalid @enderror" 
                                           id="birth_date" 
                                           name="birth_date" 
                                           value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" 
                                            id="gender" 
                                            name="gender">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="blood_type" class="form-label">Golongan Darah</label>
                                    <select class="form-select @error('blood_type') is-invalid @enderror" 
                                            id="blood_type" 
                                            name="blood_type">
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                                        <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                                    </select>
                                    @error('blood_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" 
                                              name="address" 
                                              rows="3">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Professional Information Section -->
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-stethoscope me-2"></i>
                                Informasi Profesional
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="specialist" class="form-label">
                                        Spesialisasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('specialist') is-invalid @enderror" 
                                           id="specialist" 
                                           name="specialist" 
                                           value="{{ old('specialist') }}" 
                                           placeholder="Contoh: Dokter Umum, Kardiologi, dll"
                                           required>
                                    @error('specialist')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="license_number" class="form-label">
                                        Nomor Lisensi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('license_number') is-invalid @enderror" 
                                           id="license_number" 
                                           name="license_number" 
                                           value="{{ old('license_number') }}" 
                                           required>
                                    @error('license_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Account Information Section -->
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-key me-2"></i>
                                Informasi Akun
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Password minimal 6 karakter</small>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">
                                        Konfirmasi Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Aktifkan akun dokter
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Jika dicentang, dokter dapat langsung melakukan login dan menerima jadwal praktik
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-format phone number
    $('#phone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 0) {
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+62' + value.substring(1);
            } else if (!value.startsWith('+')) {
                value = '+62' + value;
            }
        }
        $(this).val(value);
    });
    
    // Password confirmation validation
    $('#password_confirmation').on('keyup', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();
        
        if (confirmPassword.length > 0) {
            if (password === confirmPassword) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
        }
    });
    
    // Form validation before submit
    $('form').on('submit', function(e) {
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();
        
        if (password !== confirmPassword) {
            e.preventDefault();
            $('#password_confirmation').addClass('is-invalid');
            
            // Show error message if not exists
            if (!$('#password_confirmation').siblings('.invalid-feedback').length) {
                $('#password_confirmation').after('<div class="invalid-feedback">Konfirmasi password tidak cocok</div>');
            }
            
            // Focus on confirmation password field
            $('#password_confirmation').focus();
            
            // Show alert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Konfirmasi password tidak cocok!'
            });
        }
    });
});
</script>
@endpush
@endsection
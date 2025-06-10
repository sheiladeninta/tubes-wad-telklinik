@extends('layouts.app')

@section('title', 'Daftar - Tel-Klinik')

@section('content')
<div class="auth-container d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="auth-card">
                    <div class="auth-header">
                        <h2 class="mb-0">
                            <i class="fas fa-heartbeat me-2"></i>
                            Tel-Klinik
                        </h2>
                        <p class="mb-0 mt-2">Daftar Akun Baru</p>
                    </div>
                    
                    <div class="auth-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf
                            
                            <div class="row">
                                <!-- Nama Lengkap -->
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autocomplete="name" 
                                           autofocus
                                           placeholder="Masukkan nama lengkap Anda">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Email -->
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required 
                                           autocomplete="email"
                                           placeholder="Masukkan email Anda">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Jenis Pengguna -->
                                <div class="col-md-12 mb-3">
                                    <label for="user_type" class="form-label">
                                        <i class="fas fa-users me-1"></i>
                                        Jenis Pengguna <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('user_type') is-invalid @enderror" 
                                            id="user_type" 
                                            name="user_type" 
                                            required>
                                        <option value="">Pilih jenis pengguna</option>
                                        <option value="mahasiswa" {{ old('user_type') == 'mahasiswa' ? 'selected' : '' }}>
                                            Mahasiswa
                                        </option>
                                        <option value="dosen" {{ old('user_type') == 'dosen' ? 'selected' : '' }}>
                                            Dosen
                                        </option>
                                        <option value="pegawai" {{ old('user_type') == 'pegawai' ? 'selected' : '' }}>
                                            Pegawai
                                        </option>
                                    </select>
                                    @error('user_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Password -->
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Minimal 6 karakter">
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Konfirmasi Password -->
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-lock me-1"></i>
                                        Konfirmasi Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Ulangi password">
                                        <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirmation">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Nomor Telepon -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-1"></i>
                                        Nomor Telepon
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           autocomplete="tel"
                                           placeholder="Contoh: 08123456789">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Tanggal Lahir -->
                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">
                                        <i class="fas fa-calendar me-1"></i>
                                        Tanggal Lahir
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('birth_date') is-invalid @enderror" 
                                           id="birth_date" 
                                           name="birth_date" 
                                           value="{{ old('birth_date') }}" 
                                           max="{{ date('Y-m-d', strtotime('-1 day')) }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Jenis Kelamin -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-venus-mars me-1"></i>
                                        Jenis Kelamin
                                    </label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input @error('gender') is-invalid @enderror" 
                                                   type="radio" 
                                                   name="gender" 
                                                   id="gender_l" 
                                                   value="L" 
                                                   {{ old('gender') == 'L' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gender_l">
                                                Laki-laki
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('gender') is-invalid @enderror" 
                                                   type="radio" 
                                                   name="gender" 
                                                   id="gender_p" 
                                                   value="P" 
                                                   {{ old('gender') == 'P' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gender_p">
                                                Perempuan
                                            </label>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Alamat -->
                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Alamat
                                    </label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" 
                                              name="address" 
                                              rows="3" 
                                              placeholder="Masukkan alamat lengkap Anda">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Terms and Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Saya menyetujui <a href="#" class="text-decoration-none">Syarat dan Ketentuan</a> 
                                        serta <a href="#" class="text-decoration-none">Kebijakan Privasi</a> Tel-Klinik
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Daftar Sekarang
                                </button>
                            </div>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <p class="mb-0">
                                Sudah memiliki akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePasswordField(passwordFieldId, toggleButtonId) {
        document.getElementById(toggleButtonId).addEventListener('click', function() {
            const password = document.getElementById(passwordFieldId);
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }
    
    // Initialize password toggle for both fields
    togglePasswordField('password', 'togglePassword');
    togglePasswordField('password_confirmation', 'togglePasswordConfirmation');
    
    // Password confirmation validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        
        if (confirmPassword && password !== confirmPassword) {
            this.setCustomValidity('Password tidak cocok');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
    
    // Form validation before submit
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const terms = document.getElementById('terms').checked;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            return false;
        }
        
        if (!terms) {
            e.preventDefault();
            alert('Anda harus menyetujui syarat dan ketentuan!');
            return false;
        }
    });
    
    // Auto-format phone number
    document.getElementById('phone').addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.startsWith('0')) {
            value = value;
        } else if (value.startsWith('62')) {
            value = '0' + value.substring(2);
        }
        this.value = value;
    });
</script>
@endsection
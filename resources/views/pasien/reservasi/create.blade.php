@extends('layouts.pasien')

@section('title', 'Buat Reservasi - Tel-Klinik')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">
                <i class="fas fa-calendar-plus me-2" style="color: #dc3545;"></i>
                Buat Reservasi Baru
            </h1>
            <p class="text-muted mb-0">Jadwalkan konsultasi dengan dokter pilihan Anda</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pasien.dashboard') }}" style="color: #dc3545; text-decoration: none;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pasien.reservasi.index') }}" style="color: #dc3545; text-decoration: none;">Reservasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buat Reservasi</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Form Reservasi -->
            <div class="card shadow-sm" style="border: none; border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #dc3545, #b02a37); color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-form me-2"></i>Form Reservasi</h5>
                </div>
                <div class="card-body" style="padding: 2rem;">
                    <form action="{{ route('pasien.reservasi.store') }}" method="POST" id="reservasiForm">
                        @csrf
                        
                        <!-- Pilih Dokter -->
                        <div class="mb-4">
                            <label for="dokter_id" class="form-label fw-bold" style="color: #2c3e50;">
                                <i class="fas fa-user-md me-2" style="color: #dc3545;"></i>Pilih Dokter
                            </label>
                            <select name="dokter_id" id="dokter_id" class="form-select @error('dokter_id') is-invalid @enderror" style="border-radius: 8px; border: 2px solid #e9ecef; padding: 12px;" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                        {{ $dokter->name }} - {{ $dokter->specialist }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dokter_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Reservasi -->
                        <div class="mb-4">
                            <label for="tanggal_reservasi" class="form-label fw-bold" style="color: #2c3e50;">
                                <i class="fas fa-calendar me-2" style="color: #dc3545;"></i>Tanggal Reservasi
                            </label>
                            <input type="date" name="tanggal_reservasi" id="tanggal_reservasi" class="form-control @error('tanggal_reservasi') is-invalid @enderror" value="{{ old('tanggal_reservasi') }}" min="{{ date('Y-m-d') }}" style="border-radius: 8px; border: 2px solid #e9ecef; padding: 12px;" required>
                            @error('tanggal_reservasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jam Reservasi -->
                        <div class="mb-4">
                            <label for="jam_reservasi" class="form-label fw-bold" style="color: #2c3e50;">
                                <i class="fas fa-clock me-2" style="color: #dc3545;"></i>Jam Reservasi
                            </label>
                            <select name="jam_reservasi" id="jam_reservasi" class="form-select @error('jam_reservasi') is-invalid @enderror" style="border-radius: 8px; border: 2px solid #e9ecef; padding: 12px;" required disabled>
                                <option value="">-- Pilih dokter dan tanggal terlebih dahulu --</option>
                            </select>
                            @error('jam_reservasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1" style="color: #17a2b8;"></i>
                                Jam operasional: 08:00 - 17:00 WIB
                            </div>
                        </div>

                        <!-- Keluhan -->
                        <div class="mb-4">
                            <label for="keluhan" class="form-label fw-bold" style="color: #2c3e50;">
                                <i class="fas fa-file-medical-alt me-2" style="color: #dc3545;"></i>Keluhan / Gejala
                            </label>
                            <textarea name="keluhan" id="keluhan" rows="4" class="form-control @error('keluhan') is-invalid @enderror" placeholder="Jelaskan keluhan atau gejala yang Anda alami..." style="border-radius: 8px; border: 2px solid #e9ecef; padding: 12px;" required>{{ old('keluhan') }}</textarea>
                            @error('keluhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1" style="color: #17a2b8;"></i>
                                Minimal 10 karakter, maksimal 1000 karakter
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pasien.reservasi.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; padding: 12px 24px;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-danger" style="background: linear-gradient(135deg, #dc3545, #b02a37); border: none; border-radius: 8px; padding: 12px 24px;">
                                <i class="fas fa-save me-2"></i>Buat Reservasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Info Panel -->
            <div class="card shadow-sm mb-4" style="border: none; border-radius: 12px;">
                <div class="card-header" style="background: #f8f9fa; border-radius: 12px 12px 0 0; border-bottom: 2px solid #e9ecef;">
                    <h6 class="mb-0" style="color: #2c3e50; font-weight: 600;">
                        <i class="fas fa-info-circle me-2" style="color: #17a2b8;"></i>Informasi Penting
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" style="border-radius: 8px; border: none; background: #e7f3ff;">
                        <h6 style="color: #0c5460; font-weight: 600;">Jam Operasional</h6>
                        <p class="mb-0" style="color: #0c5460;">Senin - Jumat: 08:00 - 17:00 WIB<br>Sabtu: 08:00 - 12:00 WIB</p>
                    </div>
                    
                    <div class="alert alert-warning" style="border-radius: 8px; border: none; background: #fff3cd;">
                        <h6 style="color: #856404; font-weight: 600;">Ketentuan Reservasi</h6>
                        <ul style="color: #856404; margin-bottom: 0; padding-left: 1.2rem;">
                            <li>Reservasi dapat dibuat maksimal 30 hari ke depan</li>
                            <li>Pembatalan minimal 2 jam sebelum jadwal</li>
                            <li>Konfirmasi akan diberikan dalam 24 jam</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kontak Darurat -->
            <div class="card shadow-sm" style="border: none; border-radius: 12px;">
                <div class="card-header" style="background: #f8f9fa; border-radius: 12px 12px 0 0; border-bottom: 2px solid #e9ecef;">
                    <h6 class="mb-0" style="color: #2c3e50; font-weight: 600;">
                        <i class="fas fa-phone me-2" style="color: #dc3545;"></i>Kontak Darurat
                    </h6>
                </div>
                <div class="card-body">
                    <p style="color: #2c3e50; margin-bottom: 1rem;">Untuk kondisi darurat, hubungi:</p>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone-alt me-2" style="color: #dc3545;"></i>
                        <strong style="color: #2c3e50;">0811-2345-6789</strong>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope me-2" style="color: #dc3545;"></i>
                        <span style="color: #2c3e50;">emergency@tel-klinik.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dokterSelect = document.getElementById('dokter_id');
    const tanggalInput = document.getElementById('tanggal_reservasi');
    const jamSelect = document.getElementById('jam_reservasi');
    
    // Function to load available time slots
    function loadAvailableSlots() {
        const dokterId = dokterSelect.value;
        const tanggal = tanggalInput.value;
        
        if (!dokterId || !tanggal) {
            jamSelect.innerHTML = '<option value="">-- Pilih dokter dan tanggal terlebih dahulu --</option>';
            jamSelect.disabled = true;
            return;
        }
        
        // Show loading
        jamSelect.innerHTML = '<option value="">Loading...</option>';
        jamSelect.disabled = true;
        
        // Make AJAX request
        fetch('{{ route("pasien.reservasi.check-availability") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                dokter_id: dokterId,
                tanggal_reservasi: tanggal
            })
        })
        .then(response => response.json())
        .then(data => {
            jamSelect.innerHTML = '<option value="">-- Pilih Jam --</option>';
            
            if (data.available_slots && data.available_slots.length > 0) {
                data.available_slots.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot;
                    option.textContent = slot + ' WIB';
                    jamSelect.appendChild(option);
                });
                jamSelect.disabled = false;
            } else {
                jamSelect.innerHTML = '<option value="">-- Tidak ada slot tersedia --</option>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            jamSelect.innerHTML = '<option value="">-- Error loading slots --</option>';
        });
    }
    
    // Event listeners
    dokterSelect.addEventListener('change', loadAvailableSlots);
    tanggalInput.addEventListener('change', loadAvailableSlots);
    
    // Character counter for keluhan
    const keluhanTextarea = document.getElementById('keluhan');
    const counterElement = document.createElement('div');
    counterElement.className = 'form-text text-end';
    counterElement.style.marginTop = '5px';
    keluhanTextarea.parentNode.appendChild(counterElement);
    
    function updateCounter() {
        const length = keluhanTextarea.value.length;
        counterElement.textContent = `${length}/1000 karakter`;
        counterElement.style.color = length > 1000 ? '#dc3545' : '#6c757d';
    }
    
    keluhanTextarea.addEventListener('input', updateCounter);
    updateCounter();
});
</script>
@endsection
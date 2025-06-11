@extends('layouts.pasien')
@section('title', 'Konsultasi Baru - Tel-Klinik')
@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('pasien.consultation.index') }}" class="btn btn-link text-danger p-0 me-3">
                    <i class="fas fa-arrow-left fa-lg"></i>
                </a>
                <div>
                    <h2 class="mb-1" style="color: #dc3545; font-weight: 600;">
                        <i class="fas fa-plus-circle me-2"></i>Konsultasi Baru
                    </h2>
                    <p class="text-muted mb-0">Mulai konsultasi dengan dokter untuk mendapatkan bantuan medis</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Consultation Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2 text-danger"></i>Form Konsultasi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pasien.consultation.store') }}" method="POST">
                        @csrf
                        
                        <!-- Subject -->
                        <div class="mb-4">
                            <label for="subject" class="form-label fw-medium">
                                <i class="fas fa-tag me-2 text-danger"></i>Subjek Konsultasi
                            </label>
                            <input type="text" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}"
                                   placeholder="Contoh: Demam dan batuk berkelanjutan"
                                   maxlength="255"
                                   required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Masukkan topik utama keluhan Anda (maksimal 255 karakter)</div>
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-medium">
                                <i class="fas fa-file-medical me-2 text-danger"></i>Deskripsi Keluhan
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="6"
                                      maxlength="1000"
                                      placeholder="Jelaskan gejala, keluhan, atau pertanyaan medis Anda secara detail..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <div class="d-flex justify-content-between">
                                    <span>Jelaskan kondisi kesehatan Anda dengan detail (maksimal 1000 karakter)</span>
                                    <span id="charCount">0/1000</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Priority -->
                        <div class="mb-4">
                            <label for="priority" class="form-label fw-medium">
                                <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Tingkat Prioritas
                            </label>
                            <select class="form-select @error('priority') is-invalid @enderror" 
                                    id="priority" 
                                    name="priority"
                                    required>
                                <option value="">Pilih tingkat prioritas</option>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                    <i class="fas fa-circle text-success"></i> Rendah - Konsultasi umum, tidak mendesak
                                </option>
                                <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>
                                    <i class="fas fa-circle text-primary"></i> Normal - Keluhan biasa yang perlu konsultasi
                                </option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                    <i class="fas fa-circle text-warning"></i> Tinggi - Gejala yang mengkhawatirkan
                                </option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                                    <i class="fas fa-circle text-danger"></i> Mendesak - Kondisi yang membutuhkan perhatian segera
                                </option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Pilih sesuai dengan tingkat kegawatan keluhan Anda</div>
                        </div>
                        
                        <!-- Doctor Selection (Optional) -->
                        <div class="mb-4">
                            <label for="dokter_id" class="form-label fw-medium">
                                <i class="fas fa-user-md me-2 text-danger"></i>Pilih Dokter (Opsional)
                            </label>
                            <select class="form-select @error('dokter_id') is-invalid @enderror" 
                                    id="dokter_id" 
                                    name="dokter_id">
                                <option value="">Biarkan sistem memilih dokter yang tersedia</option>
                                @foreach($availableDoctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('dokter_id') == $doctor->id ? 'selected' : '' }}>
                                        Dr. {{ $doctor->name }}
                                        @if($doctor->specialization)
                                            - {{ $doctor->specialization }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('dokter_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Jika tidak dipilih, sistem akan secara otomatis mencarikan dokter yang tersedia</div>
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="fas fa-paper-plane me-2"></i>Buat Konsultasi
                            </button>
                            <a href="{{ route('pasien.consultation.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Information Sidebar -->
        <div class="col-lg-4">
            <!-- Priority Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Panduan Prioritas
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="priority-guide">
                        <div class="priority-item mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-success me-2">Rendah</span>
                                <small class="fw-medium">Konsultasi Umum</small>
                            </div>
                            <small class="text-muted">Pertanyaan kesehatan umum, check-up rutin, atau konsultasi pencegahan.</small>
                        </div>
                        <div class="priority-item mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-primary me-2">Normal</span>
                                <small class="fw-medium">Keluhan Biasa</small>
                            </div>
                            <small class="text-muted">Gejala ringan seperti flu, sakit kepala, atau masalah pencernaan ringan.</small>
                        </div>
                        <div class="priority-item mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-warning me-2">Tinggi</span>
                                <small class="fw-medium">Gejala Mengkhawatirkan</small>
                            </div>
                            <small class="text-muted">Demam tinggi, nyeri hebat, atau gejala yang berlangsung lama.</small>
                        </div>
                        <div class="priority-item">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge bg-danger me-2">Mendesak</span>
                                <small class="fw-medium">Kondisi Darurat</small>
                            </div>
                            <small class="text-muted">Nyeri dada, sesak napas berat, atau kondisi yang mengancam jiwa.</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tips -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>Tips Konsultasi
                    </h6>
                </div>
                <div class="card-body p-3">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <small><i class="fas fa-check-circle text-success me-2"></i>Jelaskan gejala dengan detail dan kronologis</small>
                        </li>
                        <li class="mb-2">
                            <small><i class="fas fa-check-circle text-success me-2"></i>Sebutkan obat yang sedang dikonsumsi</small>
                        </li>
                        <li class="mb-2">
                            <small><i class="fas fa-check-circle text-success me-2"></i>Siapkan foto atau dokumen medis jika ada</small>
                        </li>
                        <li class="mb-2">
                            <small><i class="fas fa-check-circle text-success me-2"></i>Pilih prioritas dengan tepat</small>
                        </li>
                        <li>
                            <small><i class="fas fa-check-circle text-success me-2"></i>Bersikap jujur dan terbuka dengan dokter</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for character counter -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const descriptionTextarea = document.getElementById('description');
    const charCountSpan = document.getElementById('charCount');
    
    // Update character count
    function updateCharCount() {
        const currentLength = descriptionTextarea.value.length;
        charCountSpan.textContent = currentLength + '/1000';
        
        // Change color based on length
        if (currentLength > 800) {
            charCountSpan.className = 'text-danger';
        } else if (currentLength > 600) {
            charCountSpan.className = 'text-warning';
        } else {
            charCountSpan.className = 'text-muted';
        }
    }
    
    // Initial count
    updateCharCount();
    
    // Update on input
    descriptionTextarea.addEventListener('input', updateCharCount);
    
    // Form validation enhancement
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const subject = document.getElementById('subject').value.trim();
        const description = document.getElementById('description').value.trim();
        const priority = document.getElementById('priority').value;
        
        if (!subject || !description || !priority) {
            e.preventDefault();
            alert('Harap lengkapi semua field yang wajib diisi.');
            return false;
        }
        
        if (description.length < 20) {
            e.preventDefault();
            alert('Deskripsi keluhan minimal 20 karakter untuk membantu dokter memahami kondisi Anda.');
            return false;
        }
    });
});
</script>

<style>
.priority-guide .priority-item {
    border-left: 3px solid #e9ecef;
    padding-left: 10px;
}

.priority-guide .priority-item:hover {
    background-color: #f8f9fa;
    border-radius: 5px;
    padding: 8px 10px;
    border-left-color: #dc3545;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.card {
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}
</style>
@endsection
@extends('layouts.dokter')
@section('title', 'Buat Resep Obat')

@push('styles')
<style>
.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
.btn-add-obat {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    color: white;
    transition: all 0.3s ease;
}
.btn-add-obat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    color: white;
}
.btn-remove-obat {
    background: linear-gradient(45deg, #dc3545, #c82333);
    border: none;
    color: white;
    transition: all 0.3s ease;
}
.btn-remove-obat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    color: white;
}
.obat-item {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    background: #f8f9fa;
    transition: all 0.3s ease;
    position: relative;
}
.obat-item:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
}
.patient-info {
    background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
}
.required {
    color: #dc3545;
}
.form-floating > label {
    font-weight: 500;
}
.btn-primary {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border: none;
    padding: 12px 30px;
    transition: all 0.3s ease;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(102, 126, 234, 0.4);
}
.btn-secondary {
    background: linear-gradient(45deg, #6c757d, #495057);
    border: none;
    padding: 12px 30px;
    transition: all 0.3s ease;
}
.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(108, 117, 125, 0.4);
}
.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    border: 1px solid #b6d4da;
    color: #0c5460;
}
.is-invalid {
    border-color: #dc3545;
}
.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-prescription-bottle-alt me-2"></i>
                        Buat Resep Obat Baru
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan dalam form:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('dokter.resep-obat.store') }}" method="POST" id="resepForm">
        @csrf
        
        <!-- Patient Information -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-user-injured me-2 text-primary"></i>
                            Informasi Pasien
                        </h5>
                        @if($reservasi)
                            <!-- Reservasi dari parameter URL -->
                            <input type="hidden" name="reservasi_id" value="{{ $reservasi->id }}">
                            <div class="patient-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Nama Pasien:</strong><br>
                                        <span class="text-dark">{{ $reservasi->user->name }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Tipe:</strong><br>
                                        <span class="badge bg-info">{{ $reservasi->user->user_type_display }}</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <strong>Tanggal Reservasi:</strong><br>
                                        <span class="text-dark">{{ $reservasi->tanggal_reservasi->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Waktu:</strong><br>
                                        <span class="text-dark">{{ $reservasi->waktu_reservasi }}</span>
                                    </div>
                                </div>
                                @if($reservasi->user->user_type === 'lansia')
                                    <div class="alert alert-info mt-3 mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Perhatian:</strong> Pasien lansia memerlukan perhatian khusus dalam pemberian dosis obat.
                                    </div>
                                @endif
                            </div>
                            <input type="hidden" name="pasien_id" value="{{ $reservasi->user_id }}">
                        @else
                            <!-- Pilih pasien manual -->
                            <div class="form-floating mb-3">
                                <select class="form-select @error('pasien_id') is-invalid @enderror" 
                                        name="pasien_id" id="pasien_id" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach($pasienList as $pasien)
                                        <option value="{{ $pasien->id }}" 
                                                data-type="{{ $pasien->user_type }}"
                                                {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>
                                            {{ $pasien->name }} - {{ $pasien->user_type_display }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="pasien_id">Pasien <span class="required">*</span></label>
                                @error('pasien_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="pasienAlert" class="alert alert-info" style="display: none;">
                                <i class="fas fa-info-circle me-2"></i>
                                <span id="pasienAlertText"></span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Information -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-stethoscope me-2 text-success"></i>
                            Informasi Medis
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control @error('keluhan') is-invalid @enderror" 
                                              name="keluhan" id="keluhan" style="height: 120px" 
                                              placeholder="Keluhan pasien" required>{{ old('keluhan') }}</textarea>
                                    <label for="keluhan">Keluhan <span class="required">*</span></label>
                                    @error('keluhan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control @error('diagnosa') is-invalid @enderror" 
                                              name="diagnosa" id="diagnosa" style="height: 120px" 
                                              placeholder="Diagnosa dokter" required>{{ old('diagnosa') }}</textarea>
                                    <label for="diagnosa">Diagnosa <span class="required">*</span></label>
                                    @error('diagnosa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control @error('catatan_dokter') is-invalid @enderror" 
                                      name="catatan_dokter" id="catatan_dokter" style="height: 80px" 
                                      placeholder="Catatan tambahan">{{ old('catatan_dokter') }}</textarea>
                            <label for="catatan_dokter">Catatan Tambahan</label>
                            @error('catatan_dokter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medication List -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-pills me-2 text-warning"></i>
                                Daftar Obat
                            </h5>
                            <button type="button" class="btn btn-add-obat" id="addObat">
                                <i class="fas fa-plus me-2"></i>Tambah Obat
                            </button>
                        </div>
                        <div id="obatContainer">
                            <!-- Obat items will be added here dynamically -->
                        </div>
                        <div class="text-muted mt-2">
                            <small><i class="fas fa-info-circle me-1"></i>Minimal harus ada satu obat dalam resep</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary me-3" id="submitBtn">
                            <i class="fas fa-save me-2"></i>Simpan Resep
                        </button>
                        <a href="{{ route('dokter.resep-obat.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Obat Item Template -->
<template id="obatTemplate">
    <div class="obat-item">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0 text-primary">
                <i class="fas fa-pill me-2"></i>Obat #<span class="obat-number"></span>
            </h6>
            <button type="button" class="btn btn-remove-obat btn-sm remove-obat" title="Hapus obat">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="obat[][nama]" 
                           placeholder="Nama obat" required>
                    <label>Nama Obat <span class="required">*</span></label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="obat[][dosis]" 
                           placeholder="Contoh: 500mg" required>
                    <label>Dosis <span class="required">*</span></label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="obat[][jumlah]" 
                           placeholder="Jumlah" min="1" required>
                    <label>Jumlah <span class="required">*</span></label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-3">
                    <select class="form-select" name="obat[][satuan]" required>
                        <option value="">Pilih Satuan</option>
                        <option value="tablet">Tablet</option>
                        <option value="kapsul">Kapsul</option>
                        <option value="ml">ml</option>
                        <option value="botol">Botol</option>
                        <option value="tube">Tube</option>
                        <option value="sachet">Sachet</option>
                        <option value="strip">Strip</option>
                        <option value="ampul">Ampul</option>
                        <option value="vial">Vial</option>
                    </select>
                    <label>Satuan <span class="required">*</span></label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="obat[][aturan_pakai]" 
                           placeholder="Contoh: 2x1 sehari sesudah makan" required>
                    <label>Cara Pakai <span class="required">*</span></label>
                </div>
            </div>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" name="obat[][keterangan]" 
                      style="height: 80px" placeholder="Keterangan tambahan (opsional)"></textarea>
            <label>Keterangan</label>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let obatCounter = 0;
    
    // Add initial obat item
    addObatItem();
    
    // Patient selection change handler (only for manual selection)
    $('#pasien_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        const patientType = selectedOption.data('type');
        const alertDiv = $('#pasienAlert');
        const alertText = $('#pasienAlertText');
        
        if (patientType === 'lansia') {
            alertText.text('Perhatian: Pasien lansia memerlukan perhatian khusus dalam pemberian dosis obat.');
            alertDiv.removeClass('alert-warning').addClass('alert-info').show();
        } else if (patientType === 'balita') {
            alertText.text('Perhatian: Pasien balita memerlukan dosis khusus sesuai berat badan dan usia.');
            alertDiv.removeClass('alert-info').addClass('alert-warning').show();
        } else {
            alertDiv.hide();
        }
    });
    
    // Add obat item
    $('#addObat').click(function() {
        addObatItem();
    });
    
    // Remove obat item
    $(document).on('click', '.remove-obat', function() {
        if ($('.obat-item').length > 1) {
            $(this).closest('.obat-item').remove();
            updateObatNumbers();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Minimal harus ada satu obat dalam resep.',
                confirmButtonColor: '#667eea'
            });
        }
    });
    
    function addObatItem() {
        obatCounter++;
        const template = document.getElementById('obatTemplate');
        const clone = template.content.cloneNode(true);
        
        // Update obat number
        clone.querySelector('.obat-number').textContent = obatCounter;
        
        // Update input names with proper array indices
        const inputs = clone.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace('[]', '[' + (obatCounter - 1) + ']');
            }
        });
        
        document.getElementById('obatContainer').appendChild(clone);
        updateObatNumbers();
        
        // Add animation
        $('.obat-item:last').hide().fadeIn(300);
    }
    
    function updateObatNumbers() {
        $('.obat-item').each(function(index) {
            $(this).find('.obat-number').text(index + 1);
        });
    }
    
    // Form validation
    $('#resepForm').submit(function(e) {
        let isValid = true;
        const submitBtn = $('#submitBtn');
        const spinner = submitBtn.find('.loading-spinner');
        
        // Check if at least one obat is added
        if ($('.obat-item').length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Minimal harus ada satu obat dalam resep.',
                confirmButtonColor: '#667eea'
            });
            e.preventDefault();
            return false;
        }
        
        // Validate each obat item
        $('.obat-item').each(function() {
            const requiredFields = $(this).find('input[required], select[required], textarea[required]');
            requiredFields.each(function() {
                if (!$(this).val().trim()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
        });
        
        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Form Tidak Lengkap',
                text: 'Mohon lengkapi semua field yang wajib diisi.',
                confirmButtonColor: '#667eea'
            });
            e.preventDefault();
            return false;
        }
        
        return true;
    });
    
    // Real-time validation
    $(document).on('input change', 'input[required], select[required], textarea[required]', function() {
        if ($(this).val().trim()) {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Auto-expand textarea
    $(document).on('input', 'textarea', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Confirmation before leaving page with unsaved changes
    let formChanged = false;
    
    $(document).on('input change', '#resepForm input, #resepForm select, #resepForm textarea', function() {
        formChanged = true;
    });
    
    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
        }
    });
    
    // Remove beforeunload when form is submitted
    $('#resepForm').on('submit', function() {
        formChanged = false;
    });
    
    // Common medications suggestions (optional enhancement)
    const commonMedications = [
        'Paracetamol', 'Ibuprofen', 'Amoxicillin', 'Omeprazole', 'Metformin',
        'Amlodipine', 'Simvastatin', 'Aspirin', 'Captopril', 'Furosemide'
    ];
    
    // Add autocomplete to medication name fields
    $(document).on('input', 'input[name*="[nama]"]', function() {
        const input = $(this);
        const value = input.val().toLowerCase();
        
        if (value.length >= 2) {
            const suggestions = commonMedications.filter(med => 
                med.toLowerCase().includes(value)
            );
            
            // You can implement dropdown suggestions here if needed
            // For now, we'll just store the suggestions for future use
            input.data('suggestions', suggestions);
        }
    });
});
</script>

<!-- SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
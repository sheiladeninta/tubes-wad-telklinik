@extends('layouts.dokter')
@section('title', 'Edit Resep Obat')
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
    padding: 20px;
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
.info-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 1px solid #dee2e6;
    border-radius: 10px;
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Edit Resep Obat
                        </h4>
                        <a href="{{ route('dokter.resep-obat.show', $resepObat) }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
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

    <form action="{{ route('dokter.resep-obat.update', $resepObat) }}" method="POST" id="resepForm">
        @csrf
        @method('PUT')
        
        <!-- Prescription & Patient Information -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm info-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-prescription-bottle-alt me-2 text-primary"></i>
                            Informasi Resep
                        </h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor Resep</label>
                            <div class="form-control-plaintext bg-light rounded p-2">
                                {{ $resepObat->nomor_resep }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Resep</label>
                            <div class="form-control-plaintext bg-light rounded p-2">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $resepObat->tanggal_resep->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Status</label>
                            <div>
                                <span class="badge bg-{{ $resepObat->status_color }}">
                                    {{ ucfirst($resepObat->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm info-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-user-injured me-2 text-info"></i>
                            Informasi Pasien
                        </h5>
                        <div class="patient-info">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <strong>Nama Pasien:</strong><br>
                                    <span class="text-dark">{{ $resepObat->pasien->name }}</span>
                                </div>
                                <div class="col-12 mb-2">
                                    <strong>Email:</strong><br>
                                    <span class="text-dark">{{ $resepObat->pasien->email }}</span>
                                </div>
                                @if($resepObat->reservasi)
                                <div class="col-12 mb-2">
                                    <strong>Tanggal Reservasi:</strong><br>
                                    <span class="badge bg-success">{{ $resepObat->reservasi->tanggal_reservasi }}</span>
                                </div>
                                <div class="col-12 mb-2">
                                    <strong>Jam Reservasi:</strong><br>
                                    <span class="badge bg-success">{{ $resepObat->reservasi->jam_reservasi }}</span>
                                </div>
                                @endif
                                <div class="col-12">
                                    <strong>Tipe Pasien:</strong><br>
                                    <span class="badge bg-info">{{ $resepObat->pasien->user_type_display ?? 'Umum' }}</span>
                                </div>
                            </div>
                            @if($resepObat->pasien->user_type === 'lansia')
                                <div class="alert alert-info mt-3 mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Perhatian:</strong> Pasien lansia memerlukan perhatian khusus dalam pemberian dosis obat.
                                </div>
                            @elseif($resepObat->pasien->user_type === 'balita')
                                <div class="alert alert-warning mt-3 mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Perhatian:</strong> Pasien balita memerlukan dosis khusus sesuai berat badan dan usia.
                                </div>
                            @endif
                        </div>
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
                                    <textarea class="form-control @error('diagnosa') is-invalid @enderror" 
                                              name="diagnosa" id="diagnosa" style="height: 120px" 
                                              placeholder="Diagnosa dokter" required>{{ old('diagnosa', $resepObat->diagnosa) }}</textarea>
                                    <label for="diagnosa">Diagnosa <span class="required">*</span></label>
                                    @error('diagnosa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control @error('catatan_dokter') is-invalid @enderror" 
                                              name="catatan_dokter" id="catatan_dokter" style="height: 120px" 
                                              placeholder="Catatan tambahan">{{ old('catatan_dokter', $resepObat->catatan_dokter) }}</textarea>
                                    <label for="catatan_dokter">Catatan Tambahan</label>
                                    @error('catatan_dokter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
                            @foreach($resepObat->detailResep as $index => $detail)
                            <div class="obat-item">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-pill me-2"></i>Obat #<span class="obat-number">{{ $index + 1 }}</span>
                                    </h6>
                                    <button type="button" class="btn btn-remove-obat btn-sm remove-obat" title="Hapus obat">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('obat.'.$index.'.nama') is-invalid @enderror" 
                                                   name="obat[{{ $index }}][nama]" 
                                                   value="{{ old('obat.'.$index.'.nama', $detail->nama_obat) }}" 
                                                   placeholder="Nama obat" required>
                                            <label>Nama Obat <span class="required">*</span></label>
                                            @error('obat.'.$index.'.nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('obat.'.$index.'.dosis') is-invalid @enderror" 
                                                   name="obat[{{ $index }}][dosis]" 
                                                   value="{{ old('obat.'.$index.'.dosis', $detail->dosis) }}" 
                                                   placeholder="Contoh: 500mg" required>
                                            <label>Dosis <span class="required">*</span></label>
                                            @error('obat.'.$index.'.dosis')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control @error('obat.'.$index.'.jumlah') is-invalid @enderror" 
                                                   name="obat[{{ $index }}][jumlah]" 
                                                   value="{{ old('obat.'.$index.'.jumlah', $detail->jumlah) }}" 
                                                   placeholder="Jumlah" min="1" required>
                                            <label>Jumlah <span class="required">*</span></label>
                                            @error('obat.'.$index.'.jumlah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('obat.'.$index.'.satuan') is-invalid @enderror" 
                                                    name="obat[{{ $index }}][satuan]" required>
                                                <option value="">Pilih Satuan</option>
                                                <option value="tablet" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                                <option value="kapsul" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                                                <option value="ml" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'ml' ? 'selected' : '' }}>ml</option>
                                                <option value="botol" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'botol' ? 'selected' : '' }}>Botol</option>
                                                <option value="tube" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'tube' ? 'selected' : '' }}>Tube</option>
                                                <option value="sachet" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'sachet' ? 'selected' : '' }}>Sachet</option>
                                                <option value="strip" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'strip' ? 'selected' : '' }}>Strip</option>
                                                <option value="ampul" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'ampul' ? 'selected' : '' }}>Ampul</option>
                                                <option value="vial" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'vial' ? 'selected' : '' }}>Vial</option>
                                            </select>
                                            <label>Satuan <span class="required">*</span></label>
                                            @error('obat.'.$index.'.satuan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('obat.'.$index.'.aturan_pakai') is-invalid @enderror" 
                                                   name="obat[{{ $index }}][aturan_pakai]" 
                                                   value="{{ old('obat.'.$index.'.aturan_pakai', $detail->aturan_pakai) }}" 
                                                   placeholder="Contoh: 2x1 sehari sesudah makan" required>
                                            <label>Cara Pakai <span class="required">*</span></label>
                                            @error('obat.'.$index.'.aturan_pakai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control @error('obat.'.$index.'.keterangan') is-invalid @enderror" 
                                              name="obat[{{ $index }}][keterangan]" 
                                              style="height: 80px" placeholder="Keterangan tambahan (opsional)">{{ old('obat.'.$index.'.keterangan', $detail->keterangan) }}</textarea>
                                    <label>Keterangan</label>
                                    @error('obat.'.$index.'.keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endforeach
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
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('dokter.resep-obat.show', $resepObat) }}" class="btn btn-secondary">
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
    let obatCounter = {{ count($resepObat->detailResep) }};
    
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
        const template = document.getElementById('obatTemplate');
        const clone = template.content.cloneNode(true);
        
        // Update obat number
        clone.querySelector('.obat-number').textContent = obatCounter + 1;
        
        // Update input names with proper array indices
        const inputs = clone.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace('[]', '[' + obatCounter + ']');
            }
        });
        
        document.getElementById('obatContainer').appendChild(clone);
        obatCounter++;
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
});
</script>
<!-- SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
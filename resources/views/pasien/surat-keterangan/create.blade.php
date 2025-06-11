@extends('layouts.pasien')
@section('title', 'Request Surat Keterangan - Tel-Klinik')
@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('pasien.surat-keterangan.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="text-dark mb-1" style="font-weight: 600;">
                        <i class="fas fa-file-plus me-2 text-danger"></i>
                        Request Surat Keterangan
                    </h2>
                    <p class="text-muted mb-0">Isi formulir berikut untuk mengajukan surat keterangan medis</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-form me-2"></i>
                        Formulir Request Surat Keterangan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pasien.surat-keterangan.store') }}" method="POST" id="requestForm">
                        @csrf
                        
                        <!-- Pilih Dokter -->
                        <div class="mb-4">
                            <label for="dokter_id" class="form-label fw-medium">
                                <i class="fas fa-user-md me-2 text-danger"></i>
                                Pilih Dokter <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('dokter_id') is-invalid @enderror" id="dokter_id" name="dokter_id" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                        {{ $dokter->name }}
                                        @if($dokter->specialist)
                                            - {{ $dokter->specialist }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('dokter_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Pilih dokter yang akan memproses surat keterangan</small>
                        </div>

                        <!-- Jenis Surat -->
                        <div class="mb-4">
                            <label for="jenis_surat" class="form-label fw-medium">
                                <i class="fas fa-file-alt me-2 text-danger"></i>
                                Jenis Surat Keterangan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('jenis_surat') is-invalid @enderror" id="jenis_surat" name="jenis_surat" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                <option value="sakit" {{ old('jenis_surat') == 'sakit' ? 'selected' : '' }}>Surat Keterangan Sakit</option>
                                <option value="sehat" {{ old('jenis_surat') == 'sehat' ? 'selected' : '' }}>Surat Keterangan Sehat</option>
                                <option value="rujukan" {{ old('jenis_surat') == 'rujukan' ? 'selected' : '' }}>Surat Rujukan</option>
                                <option value="keterangan_medis" {{ old('jenis_surat') == 'keterangan_medis' ? 'selected' : '' }}>Surat Keterangan Medis</option>
                            </select>
                            @error('jenis_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Pilih jenis surat keterangan yang dibutuhkan</small>
                        </div>

                        <!-- Keperluan -->
                        <div class="mb-4">
                            <label for="keperluan" class="form-label fw-medium">
                                <i class="fas fa-info-circle me-2 text-danger"></i>
                                Keperluan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('keperluan') is-invalid @enderror" 
                                   id="keperluan" name="keperluan" value="{{ old('keperluan') }}" 
                                   placeholder="Contoh: Untuk keperluan cuti, izin tidak masuk kerja, dll." required>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Sebutkan untuk keperluan apa surat keterangan ini dibutuhkan</small>
                        </div>

                        <!-- Tanggal Sakit (Conditional) -->
                        <div class="mb-4" id="tanggal_sakit_section" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tanggal_mulai_sakit" class="form-label fw-medium">
                                        <i class="fas fa-calendar-alt me-2 text-danger"></i>
                                        Tanggal Mulai Sakit <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_mulai_sakit') is-invalid @enderror" 
                                           id="tanggal_mulai_sakit" name="tanggal_mulai_sakit" value="{{ old('tanggal_mulai_sakit') }}">
                                    @error('tanggal_mulai_sakit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tanggal_selesai_sakit" class="form-label fw-medium">
                                        <i class="fas fa-calendar-check me-2 text-danger"></i>
                                        Tanggal Selesai Sakit <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_selesai_sakit') is-invalid @enderror" 
                                           id="tanggal_selesai_sakit" name="tanggal_selesai_sakit" value="{{ old('tanggal_selesai_sakit') }}">
                                    @error('tanggal_selesai_sakit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <small class="form-text text-muted">Isi tanggal periode sakit untuk surat keterangan sakit</small>
                        </div>

                        <!-- Keluhan -->
                        <div class="mb-4">
                            <label for="keluhan" class="form-label fw-medium">
                                <i class="fas fa-stethoscope me-2 text-danger"></i>
                                Keluhan / Gejala
                            </label>
                            <textarea class="form-control @error('keluhan') is-invalid @enderror" 
                                      id="keluhan" name="keluhan" rows="4" 
                                      placeholder="Jelaskan keluhan atau gejala yang dialami...">{{ old('keluhan') }}</textarea>
                            @error('keluhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Opsional: Jelaskan keluhan atau gejala yang dialami (maksimal 1000 karakter)</small>
                        </div>

                        <!-- Keterangan Tambahan -->
                        <div class="mb-4">
                            <label for="keterangan_tambahan" class="form-label fw-medium">
                                <i class="fas fa-comment-alt me-2 text-danger"></i>
                                Keterangan Tambahan
                            </label>
                            <textarea class="form-control @error('keterangan_tambahan') is-invalid @enderror" 
                                      id="keterangan_tambahan" name="keterangan_tambahan" rows="3" 
                                      placeholder="Informasi tambahan yang perlu diketahui dokter...">{{ old('keterangan_tambahan') }}</textarea>
                            @error('keterangan_tambahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Opsional: Informasi tambahan untuk dokter (maksimal 500 karakter)</small>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info border-0 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Informasi Penting:</strong>
                                    <ul class="mb-0 mt-1">
                                        <li>Request akan diproses oleh dokter yang dipilih</li>
                                        <li>Anda akan mendapat notifikasi setelah surat keterangan selesai</li>
                                        <li>Surat keterangan dapat diunduh setelah disetujui dokter</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pasien.surat-keterangan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-danger" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>
                                Kirim Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 10px;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .btn-danger {
        background: linear-gradient(45deg, #dc3545, #c82333);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
    }
    
    .btn-danger:hover {
        background: linear-gradient(45deg, #c82333, #bd2130);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
    
    .alert-info {
        background: linear-gradient(45deg, #d1ecf1, #bee5eb);
        border-left: 4px solid #17a2b8;
    }
    
    .form-label {
        color: #495057;
        margin-bottom: 8px;
    }
    
    .form-text {
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle tanggal sakit section berdasarkan jenis surat
        $('#jenis_surat').on('change', function() {
            const jenisSurat = $(this).val();
            const tanggalSakitSection = $('#tanggal_sakit_section');
            const tanggalMulaiSakit = $('#tanggal_mulai_sakit');
            const tanggalSelesaiSakit = $('#tanggal_selesai_sakit');
            
            if (jenisSurat === 'sakit') {
                tanggalSakitSection.show();
                tanggalMulaiSakit.attr('required', true);
                tanggalSelesaiSakit.attr('required', true);
            } else {
                tanggalSakitSection.hide();
                tanggalMulaiSakit.attr('required', false).val('');
                tanggalSelesaiSakit.attr('required', false).val('');
            }
        });
        
        // Trigger change event on page load untuk maintain state
        $('#jenis_surat').trigger('change');
        
        // Validasi tanggal selesai sakit tidak boleh kurang dari tanggal mulai sakit
        $('#tanggal_selesai_sakit').on('change', function() {
            const tanggalMulai = $('#tanggal_mulai_sakit').val();
            const tanggalSelesai = $(this).val();
            
            if (tanggalMulai && tanggalSelesai && tanggalSelesai < tanggalMulai) {
                alert('Tanggal selesai sakit tidak boleh lebih awal dari tanggal mulai sakit');
                $(this).val('');
            }
        });
        
        // Character counter untuk textarea
        function addCharacterCounter(selector, maxLength) {
            $(selector).on('input', function() {
                const currentLength = $(this).val().length;
                const remaining = maxLength - currentLength;
                let counterText = `${currentLength}/${maxLength} karakter`;
                
                if (remaining < 0) {
                    counterText += ' (melebihi batas)';
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
                
                // Update atau create counter element
                let counter = $(this).siblings('.character-counter');
                if (counter.length === 0) {
                    counter = $('<small class="form-text text-muted character-counter"></small>');
                    $(this).after(counter);
                }
                counter.text(counterText);
            });
        }
        
        // Add character counters
        addCharacterCounter('#keluhan', 1000);
        addCharacterCounter('#keterangan_tambahan', 500);
        
        // Form submission dengan loading state
        $('#requestForm').on('submit', function() {
            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true)
                     .html('<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...');
            
            // Re-enable after 5 seconds to prevent permanent disable jika ada error
            setTimeout(function() {
                submitBtn.prop('disabled', false)
                         .html('<i class="fas fa-paper-plane me-2"></i>Kirim Request');
            }, 5000);
        });
        
        // Auto-resize textarea
        $('textarea').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Konfirmasi sebelum meninggalkan halaman jika form sudah diisi
        let formChanged = false;
        $('input, select, textarea').on('change input', function() {
            formChanged = true;
        });
        
        $(window).on('beforeunload', function() {
            if (formChanged) {
                return 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });
        
        // Remove beforeunload saat form submit
        $('#requestForm').on('submit', function() {
            formChanged = false;
        });
    });
</script>
@endpush
@endsection
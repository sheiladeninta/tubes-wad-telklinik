@extends('layouts.dokter')

@section('title', 'Edit Rekam Medis')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Edit Rekam Medis</h3>
                        <div>
                            <a href="{{ route('dokter.rekam-medis.show', $rekamMedis) }}" class="btn btn-info me-2">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                            <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <form action="{{ route('dokter.rekam-medis.update', $rekamMedis) }}" method="POST" id="rekamMedisForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        <!-- Informasi Pasien dan Reservasi -->
                        <div class="alert alert-info">
                            <h5><i class="fas fa-user"></i> Informasi Pasien</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Pasien:</strong> {{ $rekamMedis->pasien->name }}<br>
                                    <strong>Email:</strong> {{ $rekamMedis->pasien->email }}
                                </div>
                                <div class="col-md-6">
                                    @if($rekamMedis->reservasi)
                                        <strong>Reservasi:</strong> {{ $rekamMedis->reservasi->tanggal_reservasi->format('d/m/Y') }}<br>
                                        <strong>Waktu:</strong> {{ $rekamMedis->reservasi->waktu_reservasi }}
                                    @else
                                        <strong>Status:</strong> Tanpa Reservasi<br>
                                        <strong>Dibuat:</strong> {{ $rekamMedis->created_at->format('d/m/Y H:i') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Informasi Dasar -->
                            <div class="col-12">
                                <h5 class="mb-3">Informasi Dasar</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                                    <input type="datetime-local" 
                                           class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror" 
                                           id="tanggal_pemeriksaan" 
                                           name="tanggal_pemeriksaan" 
                                           value="{{ old('tanggal_pemeriksaan', $rekamMedis->tanggal_pemeriksaan->format('Y-m-d\TH:i')) }}" 
                                           required>
                                    @error('tanggal_pemeriksaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="draft" {{ old('status', $rekamMedis->status) == 'draft' ? 'selected' : '' }}>
                                            Draft
                                        </option>
                                        <option value="final" {{ old('status', $rekamMedis->status) == 'final' ? 'selected' : '' }}>
                                            Final
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Status final akan membuat rekam medis dapat dilihat oleh pasien</div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Tanda Vital -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Tanda Vital</h5>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                    <input type="number" 
                                           class="form-control @error('tinggi_badan') is-invalid @enderror" 
                                           id="tinggi_badan" 
                                           name="tinggi_badan" 
                                           value="{{ old('tinggi_badan', $rekamMedis->tinggi_badan) }}" 
                                           step="0.1" 
                                           min="50" 
                                           max="250"
                                           placeholder="170">
                                    @error('tinggi_badan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                    <input type="number" 
                                           class="form-control @error('berat_badan') is-invalid @enderror" 
                                           id="berat_badan" 
                                           name="berat_badan" 
                                           value="{{ old('berat_badan', $rekamMedis->berat_badan) }}" 
                                           step="0.1" 
                                           min="10" 
                                           max="300"
                                           placeholder="65">
                                    @error('berat_badan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="tekanan_darah" class="form-label">Tekanan Darah</label>
                                    <input type="text" 
                                           class="form-control @error('tekanan_darah') is-invalid @enderror" 
                                           id="tekanan_darah" 
                                           name="tekanan_darah" 
                                           value="{{ old('tekanan_darah', $rekamMedis->tekanan_darah) }}" 
                                           placeholder="120/80"
                                           pattern="^\d{2,3}\/\d{2,3}$">
                                    @error('tekanan_darah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format: 120/80</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="suhu_tubuh" class="form-label">Suhu Tubuh (°C)</label>
                                    <input type="number" 
                                           class="form-control @error('suhu_tubuh') is-invalid @enderror" 
                                           id="suhu_tubuh" 
                                           name="suhu_tubuh" 
                                           value="{{ old('suhu_tubuh', $rekamMedis->suhu_tubuh) }}" 
                                           step="0.1" 
                                           min="30" 
                                           max="45"
                                           placeholder="36.5">
                                    @error('suhu_tubuh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="nadi" class="form-label">Nadi (bpm)</label>
                                    <input type="number" 
                                           class="form-control @error('nadi') is-invalid @enderror" 
                                           id="nadi" 
                                           name="nadi" 
                                           value="{{ old('nadi', $rekamMedis->nadi) }}" 
                                           min="40" 
                                           max="200"
                                           placeholder="80">
                                    @error('nadi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">BMI</label>
                                    <input type="text" class="form-control" id="bmi_display" readonly placeholder="Akan dihitung otomatis">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Kategori BMI</label>
                                    <input type="text" class="form-control" id="kategori_bmi_display" readonly placeholder="Kategori BMI">
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Anamnesis dan Pemeriksaan -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Anamnesis dan Pemeriksaan</h5>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="keluhan" class="form-label">Keluhan Utama <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('keluhan') is-invalid @enderror" 
                                              id="keluhan" 
                                              name="keluhan" 
                                              rows="3" 
                                              placeholder="Jelaskan keluhan utama pasien..."
                                              required>{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                                    @error('keluhan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Diagnosa dan Tindakan -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Diagnosa dan Tindakan</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="diagnosa" class="form-label">Diagnosa <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('diagnosa') is-invalid @enderror" 
                                              id="diagnosa" 
                                              name="diagnosa" 
                                              rows="4" 
                                              placeholder="Masukkan diagnosa medis..."
                                              required>{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                                    @error('diagnosa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tindakan" class="form-label">Tindakan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('tindakan') is-invalid @enderror" 
                                              id="tindakan" 
                                              name="tindakan" 
                                              rows="4" 
                                              placeholder="Masukkan tindakan yang dilakukan..."
                                              required>{{ old('tindakan', $rekamMedis->tindakan) }}</textarea>
                                    @error('tindakan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Resep dan Catatan -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Resep dan Catatan</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="resep_obat" class="form-label">Resep Obat</label>
                                    <textarea class="form-control @error('resep_obat') is-invalid @enderror" 
                                              id="resep_obat" 
                                              name="resep_obat" 
                                              rows="4" 
                                              placeholder="Masukkan resep obat (opsional)...">{{ old('resep_obat', $rekamMedis->resep_obat) }}</textarea>
                                    @error('resep_obat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format: Nama obat, dosis, cara pakai, durasi</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="catatan_dokter" class="form-label">Catatan Dokter</label>
                                    <textarea class="form-control @error('catatan_dokter') is-invalid @enderror" 
                                              id="catatan_dokter" 
                                              name="catatan_dokter" 
                                              rows="4" 
                                              placeholder="Catatan tambahan dari dokter (opsional)...">{{ old('catatan_dokter', $rekamMedis->catatan_dokter) }}</textarea>
                                    @error('catatan_dokter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Informasi Terakhir Diperbarui</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Dibuat Pada</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $rekamMedis->created_at->format('d/m/Y H:i:s') }}" 
                                           readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Terakhir Diperbarui</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $rekamMedis->updated_at->format('d/m/Y H:i:s') }}" 
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('dokter.rekam-medis.show', $rekamMedis) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                            <div>
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

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage">Apakah Anda yakin ingin menyimpan perubahan rekam medis ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmSubmit">Ya, Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    
    .text-danger {
        color: #dc3545 !important;
    }
    
    .alert-info {
        background-color: #e7f3ff;
        border-color: #b8daff;
        color: #004085;
    }
    
    hr {
        border-top: 2px solid #dee2e6;
        margin: 1.5rem 0;
    }
    
    .form-text {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
    }
    
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #dc3545;
    }
    
    #bmi_display, #kategori_bmi_display {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .kategori-bmi-kurus { color: #007bff !important; }
    .kategori-bmi-normal { color: #28a745 !important; }
    .kategori-bmi-gemuk { color: #ffc107 !important; }
    .kategori-bmi-obesitas { color: #dc3545 !important; }

    input[readonly] {
        background-color: #f8f9fa;
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Status asli rekam medis
    const originalStatus = '{{ $rekamMedis->status }}';
    
    // Fungsi untuk menghitung BMI
    function calculateBMI() {
        const tinggi = parseFloat($('#tinggi_badan').val());
        const berat = parseFloat($('#berat_badan').val());
        
        if (tinggi && berat && tinggi > 0 && berat > 0) {
            const tinggiMeter = tinggi / 100;
            const bmi = berat / (tinggiMeter * tinggiMeter);
            
            $('#bmi_display').val(bmi.toFixed(2));
            
            // Tentukan kategori BMI sesuai dengan model
            let kategori = '';
            let colorClass = '';
            if (bmi < 18.5) {
                kategori = 'Kurus';
                colorClass = 'kategori-bmi-kurus';
            } else if (bmi < 25) {
                kategori = 'Normal';
                colorClass = 'kategori-bmi-normal';
            } else if (bmi < 30) {
                kategori = 'Gemuk';
                colorClass = 'kategori-bmi-gemuk';
            } else {
                kategori = 'Obesitas';
                colorClass = 'kategori-bmi-obesitas';
            }
            
            $('#kategori_bmi_display')
                .val(kategori)
                .removeClass('kategori-bmi-kurus kategori-bmi-normal kategori-bmi-gemuk kategori-bmi-obesitas')
                .addClass(colorClass);
        } else {
            $('#bmi_display').val('');
            $('#kategori_bmi_display').val('').removeClass('kategori-bmi-kurus kategori-bmi-normal kategori-bmi-gemuk kategori-bmi-obesitas');
        }
    }
    
    // Event listener untuk perubahan tinggi dan berat badan
    $('#tinggi_badan, #berat_badan').on('input', calculateBMI);
    
    // Hitung BMI saat halaman dimuat
    calculateBMI();
    
    // Format input tekanan darah
    $('#tekanan_darah').on('input', function() {
        let value = $(this).val().replace(/[^\d\/]/g, '');
        // Hanya izinkan satu '/' 
        const slashCount = (value.match(/\//g) || []).length;
        if (slashCount > 1) {
            const parts = value.split('/');
            value = parts[0] + '/' + parts[1];
        }
        $(this).val(value);
    });
    
    // Validasi tekanan darah pattern
    $('#tekanan_darah').on('blur', function() {
        const value = $(this).val();
        if (value && !value.match(/^\d{2,3}\/\d{2,3}$/)) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">Format harus seperti: 120/80</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });
    
    // Validasi form sebelum submit
    $('#rekamMedisForm').on('submit', function(e) {
        let isValid = true;
        let errorMessage = '';
        
        // Validasi field wajib berdasarkan controller
        const requiredFields = [
            { field: 'tanggal_pemeriksaan', name: 'Tanggal Pemeriksaan' },
            { field: 'keluhan', name: 'Keluhan Utama' },
            { field: 'diagnosa', name: 'Diagnosa' },
            { field: 'tindakan', name: 'Tindakan' },
            { field: 'status', name: 'Status' }
        ];
        
        requiredFields.forEach(function(item) {
            const element = $(`[name="${item.field}"]`);
            const value = element.val();
            if (!value || value.trim() === '') {
                isValid = false;
                errorMessage += `${item.name} harus diisi\n`;
                element.addClass('is-invalid');
            } else {
                element.removeClass('is-invalid');
            }
        });
        
        // Validasi range untuk tanda vital sesuai controller
        const validationRules = [
            { field: 'tinggi_badan', min: 50, max: 250, name: 'Tinggi Badan' },
            { field: 'berat_badan', min: 10, max: 300, name: 'Berat Badan' },
            { field: 'suhu_tubuh', min: 30, max: 45, name: 'Suhu Tubuh' },
            { field: 'nadi', min: 40, max: 200, name: 'Nadi' }
        ];
        
        validationRules.forEach(function(rule) {
            const element = $(`[name="${rule.field}"]`);
            const value = parseFloat(element.val());
            if (value && (value < rule.min || value > rule.max)) {
                isValid = false;
                errorMessage += `${rule.name} harus antara ${rule.min} - ${rule.max}\n`;
                element.addClass('is-invalid');
            } else if (element.hasClass('is-invalid') && element.val()) {
                element.removeClass('is-invalid');
            }
        });
        
        // Validasi tekanan darah format
        const tekananDarah = $('#tekanan_darah').val();
        if (tekananDarah && !tekananDarah.match(/^\d{2,3}\/\d{2,3}$/)) {
            isValid = false;
            errorMessage += 'Format tekanan darah harus seperti: 120/80\n';
            $('#tekanan_darah').addClass('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon perbaiki kesalahan berikut:\n\n' + errorMessage);
            // Scroll ke error pertama
            const firstError = $('.is-invalid:first');
            if (firstError.length) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
            return false;
        }
        
        // Tampilkan konfirmasi jika status berubah dari draft ke final
        const currentStatus = $('#status').val();
        if (originalStatus === 'draft' && currentStatus === 'final') {
            e.preventDefault();
            $('#confirmMessage').text('Apakah Anda yakin ingin mengubah status rekam medis menjadi final? Setelah final, rekam medis akan dapat dilihat oleh pasien.');
            $('#confirmModal').modal('show');
            
            $('#confirmSubmit').off('click').on('click', function() {
                $('#confirmModal').modal('hide');
                $('#rekamMedisForm')[0].submit();
            });
        } else {
            // Konfirmasi biasa untuk perubahan lainnya
            e.preventDefault();
            $('#confirmMessage').text('Apakah Anda yakin ingin menyimpan perubahan rekam medis ini?');
            $('#confirmModal').modal('show');
            
            $('#confirmSubmit').off('click').on('click', function() {
                $('#confirmModal').modal('hide');
                $('#rekamMedisForm')[0].submit();
            });
        }
    });
    
    // Auto-resize textarea sesuai konten
    $('textarea').each(function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    }).on('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
    
    // Remove invalid class saat user mulai mengetik
    $('.form-control, .form-select').on('input change', function() {
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Tooltip initialization
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Highlight perubahan form
    let formChanged = false;
    $('.form-control, .form-select, textarea').on('input change', function() {
        formChanged = true;
    });
    
    // Warning jika user mencoba keluar tanpa menyimpan
    $(window).on('beforeunload', function(e) {
        if (formChanged) {
            const message = 'Anda memiliki perubahan yang belum disimpan. Apakah Anda yakin ingin keluar?';
            e.returnValue = message;
            return message;
        }
    });
    
    // Remove warning saat form disubmit
    $('#rekamMedisForm').on('submit', function() {
        $(window).off('beforeunload');
    });
});
</script>
@endpush
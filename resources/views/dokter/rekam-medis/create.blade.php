{{-- resources/views/dokter/rekam-medis/create.blade.php --}}

@extends('layouts.dokter')

@section('title', 'Buat Rekam Medis')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-medical"></i>
                        Buat Rekam Medis Baru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('dokter.rekam-medis.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($reservasis->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Tidak ada reservasi yang perlu dibuatkan rekam medis.
                            </div>
                        @else
                            <div class="row">
                                <!-- Informasi Reservasi -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reservasi_id">Pilih Reservasi <span class="text-danger">*</span></label>
                                        <select name="reservasi_id" id="reservasi_id" class="form-control @error('reservasi_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Reservasi --</option>
                                            @foreach($reservasis as $reservasi)
                                                <option value="{{ $reservasi->id }}" 
                                                    data-pasien="{{ $reservasi->pasien->name }}"
                                                    data-email="{{ $reservasi->pasien->email }}"
                                                    data-tanggal="{{ $reservasi->tanggal_reservasi->format('d/m/Y H:i') }}"
                                                    data-keluhan="{{ $reservasi->keluhan }}"
                                                    {{ old('reservasi_id') == $reservasi->id ? 'selected' : '' }}>
                                                    {{ $reservasi->pasien->name }} - {{ $reservasi->tanggal_reservasi->format('d/m/Y H:i') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('reservasi_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Info Pasien (akan muncul setelah memilih reservasi) -->
                                    <div id="info-pasien" class="card card-outline card-info" style="display: none;">
                                        <div class="card-header">
                                            <h5 class="card-title">Informasi Pasien</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td width="30%"><strong>Nama</strong></td>
                                                    <td>: <span id="pasien-nama"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email</strong></td>
                                                    <td>: <span id="pasien-email"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tanggal Reservasi</strong></td>
                                                    <td>: <span id="reservasi-tanggal"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Keluhan Awal</strong></td>
                                                    <td>: <span id="reservasi-keluhan"></span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_pemeriksaan">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                                        <input type="datetime-local" 
                                               name="tanggal_pemeriksaan" 
                                               id="tanggal_pemeriksaan" 
                                               class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror"
                                               value="{{ old('tanggal_pemeriksaan', now()->format('Y-m-d\TH:i')) }}" 
                                               required>
                                        @error('tanggal_pemeriksaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Keluhan dan Diagnosa -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keluhan">Keluhan Pasien <span class="text-danger">*</span></label>
                                        <textarea name="keluhan" 
                                                  id="keluhan" 
                                                  class="form-control @error('keluhan') is-invalid @enderror" 
                                                  rows="4" 
                                                  maxlength="1000" 
                                                  required>{{ old('keluhan') }}</textarea>
                                        <small class="text-muted">Maksimal 1000 karakter</small>
                                        @error('keluhan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="diagnosa">Diagnosa <span class="text-danger">*</span></label>
                                        <textarea name="diagnosa" 
                                                  id="diagnosa" 
                                                  class="form-control @error('diagnosa') is-invalid @enderror" 
                                                  rows="4" 
                                                  maxlength="1000" 
                                                  required>{{ old('diagnosa') }}</textarea>
                                        <small class="text-muted">Maksimal 1000 karakter</small>
                                        @error('diagnosa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Tindakan dan Resep -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tindakan">Tindakan Medis</label>
                                        <textarea name="tindakan" 
                                                  id="tindakan" 
                                                  class="form-control @error('tindakan') is-invalid @enderror" 
                                                  rows="3" 
                                                  maxlength="1000">{{ old('tindakan') }}</textarea>
                                        <small class="text-muted">Maksimal 1000 karakter</small>
                                        @error('tindakan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="resep_obat">Resep Obat</label>
                                        <textarea name="resep_obat" 
                                                  id="resep_obat" 
                                                  class="form-control @error('resep_obat') is-invalid @enderror" 
                                                  rows="3" 
                                                  maxlength="1000">{{ old('resep_obat') }}</textarea>
                                        <small class="text-muted">Maksimal 1000 karakter</small>
                                        @error('resep_obat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Vital Signs -->
                            <div class="card card-outline card-success">
                                <div class="card-header">
                                    <h5 class="card-title">Tanda Vital</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                                <input type="number" 
                                                       name="tinggi_badan" 
                                                       id="tinggi_badan" 
                                                       class="form-control @error('tinggi_badan') is-invalid @enderror" 
                                                       value="{{ old('tinggi_badan') }}" 
                                                       min="0" 
                                                       max="300" 
                                                       step="0.01">
                                                @error('tinggi_badan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_badan">Berat Badan (kg)</label>
                                                <input type="number" 
                                                       name="berat_badan" 
                                                       id="berat_badan" 
                                                       class="form-control @error('berat_badan') is-invalid @enderror" 
                                                       value="{{ old('berat_badan') }}" 
                                                       min="0" 
                                                       max="500" 
                                                       step="0.01">
                                                @error('berat_badan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tekanan_darah">Tekanan Darah</label>
                                                <input type="text" 
                                                       name="tekanan_darah" 
                                                       id="tekanan_darah" 
                                                       class="form-control @error('tekanan_darah') is-invalid @enderror" 
                                                       value="{{ old('tekanan_darah') }}" 
                                                       placeholder="120/80" 
                                                       maxlength="20">
                                                @error('tekanan_darah')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="suhu_tubuh">Suhu Tubuh (°C)</label>
                                                <input type="number" 
                                                       name="suhu_tubuh" 
                                                       id="suhu_tubuh" 
                                                       class="form-control @error('suhu_tubuh') is-invalid @enderror" 
                                                       value="{{ old('suhu_tubuh') }}" 
                                                       min="30" 
                                                       max="50" 
                                                       step="0.1">
                                                @error('suhu_tubuh')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nadi">Nadi (bpm)</label>
                                                <input type="number" 
                                                       name="nadi" 
                                                       id="nadi" 
                                                       class="form-control @error('nadi') is-invalid @enderror" 
                                                       value="{{ old('nadi') }}" 
                                                       min="30" 
                                                       max="200">
                                                @error('nadi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>BMI</label>
                                                <input type="text" 
                                                       id="bmi_display" 
                                                       class="form-control" 
                                                       readonly 
                                                       placeholder="Otomatis terhitung">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="catatan_dokter">Catatan Dokter</label>
                                                <textarea name="catatan_dokter" 
                                                          id="catatan_dokter" 
                                                          class="form-control @error('catatan_dokter') is-invalid @enderror" 
                                                          rows="3" 
                                                          maxlength="1000">{{ old('catatan_dokter') }}</textarea>
                                                <small class="text-muted">Maksimal 1000 karakter</small>
                                                @error('catatan_dokter')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if(!$reservasis->isEmpty())
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <span class="text-danger">*</span> Wajib diisi
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Simpan Rekam Medis
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Event listener untuk perubahan pada dropdown reservasi
    $('#reservasi_id').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        
        if (selectedOption.val()) {
            // Ambil data dari atribut option
            var pasienNama = selectedOption.data('pasien');
            var pasienEmail = selectedOption.data('email');
            var reservasiTanggal = selectedOption.data('tanggal');
            var reservasiKeluhan = selectedOption.data('keluhan');
            
            // Tampilkan informasi pasien
            $('#pasien-nama').text(pasienNama);
            $('#pasien-email').text(pasienEmail);
            $('#reservasi-tanggal').text(reservasiTanggal);
            $('#reservasi-keluhan').text(reservasiKeluhan);
            
            // Tampilkan card info pasien
            $('#info-pasien').show();
            
            // Auto-fill keluhan dari reservasi
            if (reservasiKeluhan && $('#keluhan').val() === '') {
                $('#keluhan').val(reservasiKeluhan);
            }
        } else {
            // Sembunyikan card info pasien
            $('#info-pasien').hide();
        }
    });
    
    // Hitung BMI otomatis
    function calculateBMI() {
        var tinggi = parseFloat($('#tinggi_badan').val());
        var berat = parseFloat($('#berat_badan').val());
        
        if (tinggi > 0 && berat > 0) {
            // Konversi tinggi dari cm ke meter
            var tinggiMeter = tinggi / 100;
            var bmi = berat / (tinggiMeter * tinggiMeter);
            
            // Tampilkan BMI dengan 2 desimal
            var kategori = '';
            if (bmi < 18.5) {
                kategori = 'Kurus';
            } else if (bmi < 25) {
                kategori = 'Normal';
            } else if (bmi < 30) {
                kategori = 'Gemuk';
            } else {
                kategori = 'Obesitas';
            }
            
            $('#bmi_display').val(bmi.toFixed(2) + ' (' + kategori + ')');
        } else {
            $('#bmi_display').val('');
        }
    }
    
    // Event listener untuk perubahan tinggi dan berat badan
    $('#tinggi_badan, #berat_badan').on('input', calculateBMI);
    
    // Validasi form sebelum submit
    $('form').on('submit', function(e) {
        var isValid = true;
        var errorMessage = '';
        
        // Validasi reservasi
        if (!$('#reservasi_id').val()) {
            isValid = false;
            errorMessage += '- Reservasi harus dipilih\n';
        }
        
        // Validasi tanggal pemeriksaan
        if (!$('#tanggal_pemeriksaan').val()) {
            isValid = false;
            errorMessage += '- Tanggal pemeriksaan harus diisi\n';
        }
        
        // Validasi keluhan
        if (!$('#keluhan').val().trim()) {
            isValid = false;
            errorMessage += '- Keluhan pasien harus diisi\n';
        }
        
        // Validasi diagnosa
        if (!$('#diagnosa').val().trim()) {
            isValid = false;
            errorMessage += '- Diagnosa harus diisi\n';
        }
        
        // Validasi status
        if (!$('#status').val()) {
            isValid = false;
            errorMessage += '- Status harus dipilih\n';
        }
        
        // Validasi tekanan darah format
        var tekananDarah = $('#tekanan_darah').val();
        if (tekananDarah && !tekananDarah.match(/^\d+\/\d+$/)) {
            isValid = false;
            errorMessage += '- Format tekanan darah harus seperti: 120/80\n';
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Harap perbaiki kesalahan berikut:\n\n' + errorMessage);
            return false;
        }
        
        // Konfirmasi sebelum submit
        if (!confirm('Apakah Anda yakin ingin menyimpan rekam medis ini?')) {
            e.preventDefault();
            return false;
        }
    });
    
    // Format input tekanan darah
    $('#tekanan_darah').on('input', function() {
        var value = $(this).val();
        // Hapus karakter non-digit dan /
        value = value.replace(/[^\d\/]/g, '');
        // Pastikan hanya ada satu /
        var parts = value.split('/');
        if (parts.length > 2) {
            value = parts[0] + '/' + parts.slice(1).join('');
        }
        $(this).val(value);
    });
    
    // Validasi input numerik
    $('input[type="number"]').on('input', function() {
        var value = $(this).val();
        var min = parseFloat($(this).attr('min'));
        var max = parseFloat($(this).attr('max'));
        
        if (value !== '' && !isNaN(value)) {
            if (min !== undefined && parseFloat(value) < min) {
                $(this).addClass('is-invalid');
            } else if (max !== undefined && parseFloat(value) > max) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Hitung karakter yang tersisa untuk textarea
    $('textarea[maxlength]').each(function() {
        var maxLength = $(this).attr('maxlength');
        var textarea = $(this);
        var counter = $('<small class="text-muted float-right">0/' + maxLength + ' karakter</small>');
        
        textarea.parent().append(counter);
        
        textarea.on('input', function() {
            var currentLength = $(this).val().length;
            counter.text(currentLength + '/' + maxLength + ' karakter');
            
            if (currentLength > maxLength * 0.9) {
                counter.removeClass('text-muted').addClass('text-warning');
            } else {
                counter.removeClass('text-warning').addClass('text-muted');
            }
        });
        
        // Trigger initial count
        textarea.trigger('input');
    });
    
    // Auto-resize textarea
    $('textarea').each(function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    }).on('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
    
    // Shortcut keyboard
    $(document).on('keydown', function(e) {
        // Ctrl+S untuk simpan
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            $('form').submit();
        }
        
        // Ctrl+R untuk reset
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            resetForm();
        }
    });
});

// Fungsi untuk reset form
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
        // Reset semua input
        $('form')[0].reset();
        
        // Sembunyikan info pasien
        $('#info-pasien').hide();
        
        // Reset BMI display
        $('#bmi_display').val('');
        
        // Reset validation classes
        $('.is-invalid').removeClass('is-invalid');
        
        // Focus ke dropdown reservasi
        $('#reservasi_id').focus();
        
        // Show success message
        toastr.info('Form telah direset');
    }
}

// Fungsi untuk validasi real-time
function validateField(fieldId, rules) {
    var field = $('#' + fieldId);
    var value = field.val();
    var isValid = true;
    var errorMessage = '';
    
    // Implementasi validasi berdasarkan rules
    if (rules.required && !value.trim()) {
        isValid = false;
        errorMessage = 'Field ini wajib diisi';
    }
    
    if (rules.maxLength && value.length > rules.maxLength) {
        isValid = false;
        errorMessage = 'Maksimal ' + rules.maxLength + ' karakter';
    }
    
    if (rules.minValue && parseFloat(value) < rules.minValue) {
        isValid = false;
        errorMessage = 'Nilai minimal ' + rules.minValue;
    }
    
    if (rules.maxValue && parseFloat(value) > rules.maxValue) {
        isValid = false;
        errorMessage = 'Nilai maksimal ' + rules.maxValue;
    }
    
    // Update UI berdasarkan validasi
    if (isValid) {
        field.removeClass('is-invalid').addClass('is-valid');
        field.siblings('.invalid-feedback').hide();
    } else {
        field.removeClass('is-valid').addClass('is-invalid');
        field.siblings('.invalid-feedback').text(errorMessage).show();
    }
    
    return isValid;
}
</script>
@endpush

@push('styles')
<style>
.card-outline {
    border-top: 3px solid;
}

.card-outline.card-info {
    border-top-color: #17a2b8;
}

.card-outline.card-success {
    border-top-color: #28a745;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    border-radius: 0.375rem;
}

.btn-group-sm > .btn, .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.alert {
    border: 0;
    border-radius: 0.375rem;
}

.card {
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
    border: 0;
    border-radius: 0.375rem;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    background-color: rgba(0, 0, 0, 0.03);
}

.table-borderless td,
.table-borderless th {
    border: 0;
}

.text-danger {
    color: #dc3545 !important;
}

.text-muted {
    color: #6c757d !important;
}

.text-warning {
    color: #ffc107 !important;
}

.is-invalid {
    border-color: #dc3545;
}

.is-valid {
    border-color: #28a745;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-tools {
        margin-bottom: 1rem;
    }
    
    .text-right {
        text-align: left !important;
    }
    
    .btn-group-vertical > .btn {
        margin-bottom: 0.5rem;
    }
}

/* Print styles */
@media print {
    .card-tools,
    .card-footer,
    .btn {
        display: none !important;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
}
</style>
@endpush
@endsection
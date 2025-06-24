@extends('layouts.dokter')

@section('title', 'Edit Resep Obat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Resep Obat</h3>
                    <a href="{{ route('dokter.resep-obat.show', $resepObat) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dokter.resep-obat.update', $resepObat) }}" method="POST" id="formResep">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Informasi Resep -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Informasi Resep</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nomor Resep</label>
                                            <input type="text" class="form-control" value="{{ $resepObat->nomor_resep }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Resep</label>
                                            <input type="text" class="form-control" value="{{ $resepObat->tanggal_resep->format('d/m/Y H:i') }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input type="text" class="form-control" value="{{ ucfirst($resepObat->status) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Pasien -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Informasi Pasien</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama Pasien</label>
                                            <input type="text" class="form-control" value="{{ $resepObat->pasien->name }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" value="{{ $resepObat->pasien->email }}" readonly>
                                        </div>
                                        @if($resepObat->reservasi)
                                        <div class="form-group">
                                            <label>Nomor Reservasi</label>
                                            <input type="text" class="form-control" value="{{ $resepObat->reservasi->nomor_reservasi }}" readonly>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Diagnosa -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Diagnosa <span class="text-danger">*</span></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea name="diagnosa" class="form-control @error('diagnosa') is-invalid @enderror" 
                                                      rows="4" placeholder="Masukkan diagnosa..." required>{{ old('diagnosa', $resepObat->diagnosa) }}</textarea>
                                            @error('diagnosa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Dokter -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Catatan Dokter</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea name="catatan_dokter" class="form-control @error('catatan_dokter') is-invalid @enderror" 
                                                      rows="3" placeholder="Catatan tambahan (opsional)">{{ old('catatan_dokter', $resepObat->catatan_dokter) }}</textarea>
                                            @error('catatan_dokter')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Obat -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">Daftar Obat <span class="text-danger">*</span></h5>
                                        <button type="button" class="btn btn-success btn-sm" id="tambahObat">
                                            <i class="fas fa-plus"></i> Tambah Obat
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="daftarObat">
                                            @foreach($resepObat->detailResep as $index => $detail)
                                            <div class="obat-item border p-3 mb-3 rounded">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0">Obat {{ $index + 1 }}</h6>
                                                    <button type="button" class="btn btn-danger btn-sm hapus-obat">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama Obat <span class="text-danger">*</span></label>
                                                            <input type="text" name="obat[{{ $index }}][nama]" 
                                                                   class="form-control @error('obat.'.$index.'.nama') is-invalid @enderror" 
                                                                   value="{{ old('obat.'.$index.'.nama', $detail->nama_obat) }}" 
                                                                   placeholder="Masukkan nama obat" required>
                                                            @error('obat.'.$index.'.nama')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Dosis <span class="text-danger">*</span></label>
                                                            <input type="text" name="obat[{{ $index }}][dosis]" 
                                                                   class="form-control @error('obat.'.$index.'.dosis') is-invalid @enderror" 
                                                                   value="{{ old('obat.'.$index.'.dosis', $detail->dosis) }}" 
                                                                   placeholder="Contoh: 500mg" required>
                                                            @error('obat.'.$index.'.dosis')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Jumlah <span class="text-danger">*</span></label>
                                                            <input type="number" name="obat[{{ $index }}][jumlah]" 
                                                                   class="form-control @error('obat.'.$index.'.jumlah') is-invalid @enderror" 
                                                                   value="{{ old('obat.'.$index.'.jumlah', $detail->jumlah) }}" 
                                                                   min="1" required>
                                                            @error('obat.'.$index.'.jumlah')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Satuan <span class="text-danger">*</span></label>
                                                            <select name="obat[{{ $index }}][satuan]" 
                                                                    class="form-control @error('obat.'.$index.'.satuan') is-invalid @enderror" required>
                                                                <option value="">Pilih Satuan</option>
                                                                <option value="tablet" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                                                <option value="kapsul" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                                                                <option value="ml" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'ml' ? 'selected' : '' }}>ML</option>
                                                                <option value="botol" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'botol' ? 'selected' : '' }}>Botol</option>
                                                                <option value="tube" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'tube' ? 'selected' : '' }}>Tube</option>
                                                                <option value="sachet" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'sachet' ? 'selected' : '' }}>Sachet</option>
                                                                <option value="strip" {{ old('obat.'.$index.'.satuan', $detail->satuan) == 'strip' ? 'selected' : '' }}>Strip</option>
                                                            </select>
                                                            @error('obat.'.$index.'.satuan')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Aturan Pakai <span class="text-danger">*</span></label>
                                                            <input type="text" name="obat[{{ $index }}][aturan_pakai]" 
                                                                   class="form-control @error('obat.'.$index.'.aturan_pakai') is-invalid @enderror" 
                                                                   value="{{ old('obat.'.$index.'.aturan_pakai', $detail->aturan_pakai) }}" 
                                                                   placeholder="Contoh: 3x1 sehari sesudah makan" required>
                                                            @error('obat.'.$index.'.aturan_pakai')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <input type="text" name="obat[{{ $index }}][keterangan]" 
                                                                   class="form-control @error('obat.'.$index.'.keterangan') is-invalid @enderror" 
                                                                   value="{{ old('obat.'.$index.'.keterangan', $detail->keterangan) }}" 
                                                                   placeholder="Keterangan tambahan (opsional)">
                                                            @error('obat.'.$index.'.keterangan')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @error('obat')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save"></i> Simpan Perubahan
                                        </button>
                                        <a href="{{ route('dokter.resep-obat.show', $resepObat) }}" class="btn btn-secondary btn-lg ml-2">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                </div>
                            </div>
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
    let obatIndex = {{ count($resepObat->detailResep) }};
    
    // Template untuk obat baru
    function getObatTemplate(index) {
        return `
        <div class="obat-item border p-3 mb-3 rounded">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Obat ${index + 1}</h6>
                <button type="button" class="btn btn-danger btn-sm hapus-obat">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Obat <span class="text-danger">*</span></label>
                        <input type="text" name="obat[${index}][nama]" class="form-control" placeholder="Masukkan nama obat" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dosis <span class="text-danger">*</span></label>
                        <input type="text" name="obat[${index}][dosis]" class="form-control" placeholder="Contoh: 500mg" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jumlah <span class="text-danger">*</span></label>
                        <input type="number" name="obat[${index}][jumlah]" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Satuan <span class="text-danger">*</span></label>
                        <select name="obat[${index}][satuan]" class="form-control" required>
                            <option value="">Pilih Satuan</option>
                            <option value="tablet">Tablet</option>
                            <option value="kapsul">Kapsul</option>
                            <option value="ml">ML</option>
                            <option value="botol">Botol</option>
                            <option value="tube">Tube</option>
                            <option value="sachet">Sachet</option>
                            <option value="strip">Strip</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Aturan Pakai <span class="text-danger">*</span></label>
                        <input type="text" name="obat[${index}][aturan_pakai]" class="form-control" placeholder="Contoh: 3x1 sehari sesudah makan" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="obat[${index}][keterangan]" class="form-control" placeholder="Keterangan tambahan (opsional)">
                    </div>
                </div>
            </div>
        </div>`;
    }

    // Tambah obat baru
    $('#tambahObat').click(function() {
        $('#daftarObat').append(getObatTemplate(obatIndex));
        updateObatNumbers();
        obatIndex++;
    });

    // Hapus obat
    $(document).on('click', '.hapus-obat', function() {
        if ($('.obat-item').length > 1) {
            $(this).closest('.obat-item').remove();
            updateObatNumbers();
        } else {
            alert('Minimal harus ada 1 obat dalam resep!');
        }
    });

    // Update nomor obat
    function updateObatNumbers() {
        $('.obat-item').each(function(index) {
            $(this).find('h6').text('Obat ' + (index + 1));
        });
    }

    // Validasi form sebelum submit
    $('#formResep').submit(function(e) {
        let valid = true;
        let errorMsg = '';

        // Validasi diagnosa
        if (!$('textarea[name="diagnosa"]').val().trim()) {
            valid = false;
            errorMsg += 'Diagnosa wajib diisi!\n';
        }

        // Validasi minimal 1 obat
        if ($('.obat-item').length === 0) {
            valid = false;
            errorMsg += 'Minimal harus ada 1 obat dalam resep!\n';
        }

        // Validasi setiap obat
        $('.obat-item').each(function(index) {
            let obatValid = true;
            let obatNum = index + 1;

            $(this).find('input[required], select[required]').each(function() {
                if (!$(this).val().trim()) {
                    obatValid = false;
                }
            });

            if (!obatValid) {
                valid = false;
                errorMsg += `Obat ${obatNum}: Semua field wajib harus diisi!\n`;
            }
        });

        if (!valid) {
            e.preventDefault();
            alert(errorMsg);
        }
    });
});
</script>
@endpush
@endsection
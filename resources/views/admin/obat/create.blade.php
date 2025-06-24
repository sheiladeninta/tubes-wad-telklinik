@extends('layouts.admin')

@section('title', 'Tambah Obat')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Obat Baru</h1>
        <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Obat</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.obat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Nama Obat -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_obat" class="form-label">Nama Obat <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nama_obat') is-invalid @enderror" 
                                   id="nama_obat" 
                                   name="nama_obat" 
                                   value="{{ old('nama_obat') }}"
                                   placeholder="Masukkan nama obat"
                                   required>
                            @error('nama_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jenis Obat -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_obat" class="form-label">Jenis Obat <span class="text-danger">*</span></label>
                            <select class="form-control @error('jenis_obat') is-invalid @enderror" 
                                    id="jenis_obat" 
                                    name="jenis_obat" 
                                    required>
                                <option value="">Pilih Jenis Obat</option>
                                <option value="tablet" {{ old('jenis_obat') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="kapsul" {{ old('jenis_obat') == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                                <option value="sirup" {{ old('jenis_obat') == 'sirup' ? 'selected' : '' }}>Sirup</option>
                                <option value="injeksi" {{ old('jenis_obat') == 'injeksi' ? 'selected' : '' }}>Injeksi</option>
                                <option value="salep" {{ old('jenis_obat') == 'salep' ? 'selected' : '' }}>Salep</option>
                                <option value="tetes" {{ old('jenis_obat') == 'tetes' ? 'selected' : '' }}>Tetes</option>
                                <option value="spray" {{ old('jenis_obat') == 'spray' ? 'selected' : '' }}>Spray</option>
                                <option value="suppositoria" {{ old('jenis_obat') == 'suppositoria' ? 'selected' : '' }}>Suppositoria</option>
                                <option value="lainnya" {{ old('jenis_obat') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Stok -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('stok') is-invalid @enderror" 
                                   id="stok" 
                                   name="stok" 
                                   value="{{ old('stok') }}"
                                   min="0"
                                   placeholder="Masukkan jumlah stok"
                                   required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Harga -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('harga') is-invalid @enderror" 
                                   id="harga" 
                                   name="harga" 
                                   value="{{ old('harga') }}"
                                   min="0"
                                   step="0.01"
                                   placeholder="Masukkan harga obat"
                                   required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Tanggal Kadaluarsa -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                            <input type="date" 
                                   class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror" 
                                   id="tanggal_kadaluarsa" 
                                   name="tanggal_kadaluarsa" 
                                   value="{{ old('tanggal_kadaluarsa') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            @error('tanggal_kadaluarsa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Kosongkan jika tidak ada tanggal kadaluarsa</small>
                        </div>
                    </div>

                    <!-- Pabrik -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pabrik" class="form-label">Pabrik</label>
                            <input type="text" 
                                   class="form-control @error('pabrik') is-invalid @enderror" 
                                   id="pabrik" 
                                   name="pabrik" 
                                   value="{{ old('pabrik') }}"
                                   placeholder="Masukkan nama pabrik">
                            @error('pabrik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Gambar -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gambar" class="form-label">Gambar Obat</label>
                            <input type="file" 
                                   class="form-control-file @error('gambar') is-invalid @enderror" 
                                   id="gambar" 
                                   name="gambar"
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.
                            </small>
                        </div>
                    </div>

                    <!-- Preview Gambar -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Preview Gambar</label>
                            <div id="image-preview" class="border rounded p-3 text-center" style="height: 150px; display: none;">
                                <img id="preview-img" src="#" alt="Preview" style="max-height: 120px; max-width: 100%;">
                            </div>
                            <div id="no-image-preview" class="border rounded p-3 text-center text-muted" style="height: 150px; display: flex; align-items: center; justify-content: center;">
                                Tidak ada gambar dipilih
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4"
                                      placeholder="Masukkan deskripsi obat (opsional)">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status">
                                <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row">
                    <div class="col-12">
                        <hr>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Obat
                            </button>
                            <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview gambar
    const imageInput = document.getElementById('gambar');
    const imagePreview = document.getElementById('image-preview');
    const noImagePreview = document.getElementById('no-image-preview');
    const previewImg = document.getElementById('preview-img');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
                noImagePreview.style.display = 'none';
            };
            
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
            noImagePreview.style.display = 'flex';
        }
    });

    // Format harga dengan separator ribuan
    const hargaInput = document.getElementById('harga');
    hargaInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        if (value) {
            // Format dengan separator ribuan
            value = parseInt(value).toLocaleString('id-ID');
            e.target.value = value;
        }
    });

    // Validasi tanggal kadaluarsa
    const tanggalInput = document.getElementById('tanggal_kadaluarsa');
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const minDate = tomorrow.toISOString().split('T')[0];
    tanggalInput.setAttribute('min', minDate);
});
</script>
@endpush
@endsection
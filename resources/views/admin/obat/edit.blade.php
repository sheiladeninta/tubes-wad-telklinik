@extends('layouts.admin')

@section('title', 'Edit Obat')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Obat</h1>
        <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Obat</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_obat">Nama Obat</label>
                            <input type="text" name="nama_obat" id="nama_obat" class="form-control @error('nama_obat') is-invalid @enderror" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                            @error('nama_obat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_obat">Jenis Obat</label>
                            <select name="jenis_obat" id="jenis_obat" class="form-control @error('jenis_obat') is-invalid @enderror" required>
                                @foreach(['tablet','kapsul','sirup','injeksi','salep','tetes','spray','suppositoria','lainnya'] as $jenis)
                                    <option value="{{ $jenis }}" {{ old('jenis_obat', $obat->jenis_obat) == $jenis ? 'selected' : '' }}>{{ ucfirst($jenis) }}</option>
                                @endforeach
                            </select>
                            @error('jenis_obat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $obat->stok) }}" min="0" required>
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="harga">Harga (Rp)</label>
                            <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $obat->harga) }}" min="0" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
                            <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror" value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->format('Y-m-d') : '') }}">
                            @error('tanggal_kadaluarsa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pabrik">Pabrik</label>
                            <input type="text" name="pabrik" id="pabrik" class="form-control @error('pabrik') is-invalid @enderror" value="{{ old('pabrik', $obat->pabrik) }}">
                            @error('pabrik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gambar">Gambar Obat</label>
                            <input type="file" name="gambar" id="gambar" class="form-control-file @error('gambar') is-invalid @enderror">
                            @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if($obat->gambar)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $obat->gambar) }}" alt="Preview" class="img-thumbnail" style="max-height: 120px;">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="aktif" {{ old('status', $obat->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $obat->status) == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Obat
                    </button>
                    <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

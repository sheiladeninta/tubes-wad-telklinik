@extends('layouts.dokter')

@section('title', 'Rekam Medis Pasien')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Rekam Medis Pasien</h3>
                    <a href="{{ route('dokter.rekam-medis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Rekam Medis
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <form method="GET" action="{{ route('dokter.rekam-medis.index') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Dari Tanggal</label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="pasien_id" class="form-label">Pasien</label>
                                    <select class="form-select" id="pasien_id" name="pasien_id">
                                        <option value="">Semua Pasien</option>
                                        @foreach($pasiens as $pasien)
                                            <option value="{{ $pasien->id }}" 
                                                    {{ request('pasien_id') == $pasien->id ? 'selected' : '' }}>
                                                {{ $pasien->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="final" {{ request('status') == 'final' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="submit" class="btn btn-secondary me-2">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pasien</th>
                                    <th>Keluhan</th>
                                    <th>Diagnosa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekamMedis as $index => $rm)
                                    <tr>
                                        <td>{{ $rekamMedis->firstItem() + $index }}</td>
                                        <td>{{ $rm->tanggal_pemeriksaan->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ strtoupper(substr($rm->pasien->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $rm->pasien->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $rm->pasien->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $rm->keluhan }}">
                                                {{ $rm->keluhan }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $rm->diagnosa }}">
                                                {{ $rm->diagnosa }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($rm->status == 'final')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('dokter.rekam-medis.show', $rm) }}" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('dokter.rekam-medis.edit', $rm) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-file-medical fa-3x mb-3"></i>
                                                <p>Belum ada rekam medis yang dibuat</p>
                                                <a href="{{ route('dokter.rekam-medis.create') }}" class="btn btn-primary">
                                                    Buat Rekam Medis Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($rekamMedis->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $rekamMedis->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 16px;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
@endsection
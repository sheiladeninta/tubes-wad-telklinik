@extends('layouts.admin')

@section('title', 'Detail Dokter')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Dokter</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Dokter</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Details Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informasi Dokter</h5>
                    <div>
                        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-primary mb-3">Informasi Pribadi</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Nama Lengkap</label>
                                <p class="mb-0">{{ $doctor->name }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Email</label>
                                <p class="mb-0">{{ $doctor->email }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">No. Telepon</label>
                                <p class="mb-0">{{ $doctor->phone ?? '-' }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Tanggal Lahir</label>
                                <p class="mb-0">
                                    @if($doctor->birth_date)
                                        {{ \Carbon\Carbon::parse($doctor->birth_date)->format('d F Y') }}
                                        <small class="text-muted">({{ \Carbon\Carbon::parse($doctor->birth_date)->age }} tahun)</small>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Jenis Kelamin</label>
                                <p class="mb-0">
                                    @if($doctor->gender == 'L')
                                        <span class="badge bg-info">Laki-laki</span>
                                    @elseif($doctor->gender == 'P')
                                        <span class="badge bg-warning">Perempuan</span>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Golongan Darah</label>
                                <p class="mb-0">
                                    @if($doctor->blood_type)
                                        <span class="badge bg-danger">{{ $doctor->blood_type }}</span>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-primary mb-3">Informasi Profesional</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Spesialisasi</label>
                                <p class="mb-0">
                                    <span class="badge bg-success fs-6">{{ $doctor->specialist }}</span>
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Nomor Lisensi</label>
                                <p class="mb-0">
                                    <code>{{ $doctor->license_number }}</code>
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Status</label>
                                <p class="mb-0">
                                    @if($doctor->is_active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Tanggal Bergabung</label>
                                <p class="mb-0">{{ $doctor->created_at->format('d F Y H:i') }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted">Terakhir Diperbarui</label>
                                <p class="mb-0">{{ $doctor->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    @if($doctor->address)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="fw-semibold text-primary mb-3">Alamat</h6>
                            <div class="border rounded p-3 bg-light">
                                <p class="mb-0">{{ $doctor->address }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-primary mb-1">{{ $doctor->reservasiDokter()->count() }}</h4>
                                <p class="text-muted mb-0 small">Total Reservasi</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="text-success mb-1">{{ $doctor->rekamMedisDokter()->count() }}</h4>
                                <p class="text-muted mb-0 small">Rekam Medis</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="mt-4">
                        <h6 class="fw-semibold mb-3">Aksi Cepat</h6>
                        <div class="d-grid gap-2">
                            <form action="{{ route('admin.doctors.toggle-status', $doctor) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                @if($doctor->is_active)
                                    <button type="submit" class="btn btn-warning btn-sm w-100" 
                                            onclick="return confirm('Yakin ingin menonaktifkan dokter ini?')">
                                        <i class="fas fa-pause"></i> Nonaktifkan
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-success btn-sm w-100"
                                            onclick="return confirm('Yakin ingin mengaktifkan dokter ini?')">
                                        <i class="fas fa-play"></i> Aktifkan
                                    </button>
                                @endif
                            </form>
                            
                            <button type="button" class="btn btn-danger btn-sm w-100" 
                                    onclick="confirmDelete()" 
                                    {{ ($doctor->reservasiDokter()->count() > 0 || $doctor->rekamMedisDokter()->count() > 0) ? 'disabled title="Tidak dapat menghapus dokter yang memiliki riwayat"' : '' }}>
                                <i class="fas fa-trash"></i> Hapus Dokter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<form id="deleteForm" action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Yakin ingin menghapus dokter ini? Tindakan ini tidak dapat dibatalkan!')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endpush
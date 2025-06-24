@extends('layouts.dokter')

@section('title', 'Kelola Surat Keterangan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Kelola Surat Keterangan</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Surat Keterangan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-clock-outline widget-icon bg-warning-lighten text-warning"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Menunggu Persetujuan">Pending</h5>
                    <h3 class="mt-3 mb-3">{{ $statusCounts['pending'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-cog-outline widget-icon bg-info-lighten text-info"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Sedang Diproses">Diproses</h5>
                    <h3 class="mt-3 mb-3">{{ $statusCounts['diproses'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-check-circle-outline widget-icon bg-success-lighten text-success"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Selesai">Selesai</h5>
                    <h3 class="mt-3 mb-3">{{ $statusCounts['selesai'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-close-circle-outline widget-icon bg-danger-lighten text-danger"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Ditolak">Ditolak</h5>
                    <h3 class="mt-3 mb-3">{{ $statusCounts['ditolak'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Cari nama pasien..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="jenis_surat" class="form-select">
                                    <option value="all" {{ request('jenis_surat') == 'all' ? 'selected' : '' }}>Semua Jenis</option>
                                    <option value="sakit" {{ request('jenis_surat') == 'sakit' ? 'selected' : '' }}>Surat Sakit</option>
                                    <option value="sehat" {{ request('jenis_surat') == 'sehat' ? 'selected' : '' }}>Surat Sehat</option>
                                    <option value="rujukan" {{ request('jenis_surat') == 'rujukan' ? 'selected' : '' }}>Surat Rujukan</option>
                                    <option value="keterangan_medis" {{ request('jenis_surat') == 'keterangan_medis' ? 'selected' : '' }}>Keterangan Medis</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-magnify"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="{{ route('dokter.surat-keterangan.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Alert Messages -->
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

                    <!-- Table -->
                    @if($requests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Request</th>
                                        <th>Pasien</th>
                                        <th>Jenis Surat</th>
                                        <th>Keperluan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $index => $request)
                                        <tr>
                                            <td>{{ $requests->firstItem() + $index }}</td>
                                            <td>{{ $request->tanggal_request->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="fw-bold">{{ $request->pasien->name }}</div>
                                                <small class="text-muted">{{ $request->pasien->email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $request->jenis_surat_label }}</span>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;" title="{{ $request->keperluan }}">
                                                    {{ $request->keperluan }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $request->status_badge_color }}">
                                                    {{ $request->status_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('dokter.surat-keterangan.show', $request) }}" 
                                                       class="btn btn-sm btn-info" title="Lihat Detail">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    
                                                    @if($request->status === 'selesai' && $request->file_surat)
                                                        <a href="{{ route('dokter.surat-keterangan.download', $request) }}" 
                                                           class="btn btn-sm btn-success" title="Download Surat">
                                                            <i class="mdi mdi-download"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $requests->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-file-document-outline text-muted" style="font-size: 48px;"></i>
                            <h5 class="mt-3 text-muted">Tidak ada request surat keterangan</h5>
                            <p class="text-muted">Request surat keterangan dari pasien akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-submit form when filter changes
    document.querySelectorAll('select[name="status"], select[name="jenis_surat"]').forEach(function(select) {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush
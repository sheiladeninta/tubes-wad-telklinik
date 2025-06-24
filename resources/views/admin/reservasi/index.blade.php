@extends('layouts.admin')

@section('title', 'Manajemen Reservasi & Resep Obat')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Reservasi & Resep Obat</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Reservasi</li>
            </ol>
        </nav>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Reservasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['total_reservasi'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Reservasi Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['reservasi_hari_ini'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Resep Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['resep_pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-prescription-bottle-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Resep Siap Diambil
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['resep_siap'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pills fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reservasi.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Cari Pasien</label>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" 
                               placeholder="Nama atau email pasien...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Status Reservasi</label>
                        <select class="form-control" name="status_reservasi">
                            <option value="">Semua Status</option>
                            @foreach(\App\Models\Reservasi::getStatusOptions() as $key => $value)
                                <option value="{{ $key }}" {{ request('status_reservasi') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Status Resep</label>
                        <select class="form-control" name="status_resep">
                            <option value="">Semua Status</option>
                            @foreach(\App\Models\ResepObat::getStatusOptions() as $key => $value)
                                <option value="{{ $key }}" {{ request('status_resep') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Dokter</label>
                        <select class="form-control" name="dokter_id">
                            <option value="">Semua Dokter</option>
                            @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ request('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">Dari</label>
                        <input type="date" class="form-control" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">Sampai</label>
                        <input type="date" class="form-control" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                    </div>
                    <div class="col-md-1 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Reservasi & Resep Obat</h6>
            <div>
                <a href="{{ route('admin.resep-obat.index') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-pills"></i> Kelola Resep Obat
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Tanggal & Jam</th>
                            <th>Status Reservasi</th>
                            <th>Resep Obat</th>
                            <th>Status Resep</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservasis as $reservasi)
                            <tr>
                                <td>{{ $loop->iteration + ($reservasis->currentPage() - 1) * $reservasis->perPage() }}</td>
                                <td>
                                    <strong>{{ $reservasi->user->name }}</strong><br>
                                    <small class="text-muted">{{ $reservasi->user->email }}</small>
                                </td>
                                <td>
                                    <strong>{{ $reservasi->dokter->name }}</strong>
                                </td>
                                <td>
                                    {{ $reservasi->tanggal_reservasi->format('d/m/Y') }}<br>
                                    <small>{{ $reservasi->jam_reservasi }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $reservasi->status_badge_class }}">
                                        {{ $reservasi->status_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($reservasi->resepObat)
                                        <strong>{{ $reservasi->resepObat->nomor_resep }}</strong><br>
                                        <small class="text-muted">
                                            {{ $reservasi->resepObat->tanggal_resep->format('d/m/Y') }}
                                        </small><br>
                                        <small>
                                            {{ $reservasi->resepObat->detailResep->count() }} obat
                                        </small>
                                    @else
                                        <span class="text-muted">Belum ada resep</span>
                                    @endif
                                </td>
                                <td>
                                    @if($reservasi->resepObat)
                                        <span class="badge badge-{{ $reservasi->resepObat->status_color }}" 
                                              id="status-badge-{{ $reservasi->resepObat->id }}">
                                            {{ $reservasi->resepObat->status_label }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.reservasi.show', $reservasi) }}" 
                                           class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($reservasi->resepObat)
                                            <button type="button" class="btn btn-warning btn-sm" 
                                                    onclick="showUpdateStatusModal({{ $reservasi->resepObat->id }})"
                                                    title="Update Status Resep">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <em>Tidak ada data reservasi</em>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reservasis->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $reservasis->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Update Status Resep -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Resep Obat</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="updateStatusForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Status Resep</label>
                        <select class="form-control" name="status" id="status" required>
                            @foreach(\App\Models\ResepObat::getStatusOptions() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="farmasiGroup" style="display: none;">
                        <label>Farmasi</label>
                        <select class="form-control" name="farmasi_id" id="farmasi_id">
                            <option value="">Pilih Farmasi</option>
                            @foreach(\App\Models\User::where('role', 'farmasi')->get() as $farmasi)
                                <option value="{{ $farmasi->id }}">{{ $farmasi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan (Opsional)</label>
                        <textarea class="form-control" name="catatan" rows="3" 
                                  placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentResepId = null;

function showUpdateStatusModal(resepId) {
    currentResepId = resepId;
    $('#updateStatusModal').modal('show');
}

// Show/hide farmasi field based on status
$('#status').change(function() {
    const status = $(this).val();
    if (status === 'diproses' || status === 'siap') {
        $('#farmasiGroup').show();
        $('#farmasi_id').prop('required', true);
    } else {
        $('#farmasiGroup').hide();
        $('#farmasi_id').prop('required', false);
    }
});

// Handle form submission
$('#updateStatusForm').submit(function(e) {
    e.preventDefault();
    
    if (!currentResepId) return;
    
    const formData = new FormData(this);
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: `/admin/resep-obat/${currentResepId}/update-status`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                // Update badge in table
                $(`#status-badge-${currentResepId}`)
                    .removeClass()
                    .addClass(`badge badge-${response.status_color}`)
                    .text(response.status_label);
                
                $('#updateStatusModal').modal('hide');
                
                // Show success message
                alert('Status resep obat berhasil diperbarui!');
                
                // Reset form
                $('#updateStatusForm')[0].reset();
                $('#farmasiGroup').hide();
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan saat memperbarui status.');
            console.error(xhr.responseText);
        }
    });
});

// Reset modal when closed
$('#updateStatusModal').on('hidden.bs.modal', function() {
    $('#updateStatusForm')[0].reset();
    $('#farmasiGroup').hide();
    currentResepId = null;
});
</script>
@endpush
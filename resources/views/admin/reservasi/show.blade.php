@extends('layouts.admin')
@section('title', 'Detail Reservasi & Resep Obat')
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Reservasi & Resep Obat</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.reservasi.index') }}">Reservasi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Reservasi Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Reservasi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%"><strong>Nama Pasien</strong></td>
                            <td>{{ $reservasi->user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email Pasien</strong></td>
                            <td>{{ $reservasi->user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dokter</strong></td>
                            <td>{{ $reservasi->dokter->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $reservasi->tanggal_reservasi->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam</strong></td>
                            <td>{{ $reservasi->jam_reservasi }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <span class="badge badge-{{ $reservasi->status_badge_class }}">
                                    {{ $reservasi->status_label }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat Pada</strong></td>
                            <td>{{ $reservasi->created_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Patient Complaint -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Keluhan Pasien</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $reservasi->keluhan }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($reservasi->resepObat)
        <div class="row">
            <!-- Prescription Information -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Resep Obat</h6>
                        <button type="button" class="btn btn-sm btn-warning" 
                                onclick="showUpdateStatusModal({{ $reservasi->resepObat->id }})">
                            <i class="fas fa-edit"></i> Update Status
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Nomor Resep</strong></td>
                                        <td>{{ $reservasi->resepObat->nomor_resep }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Resep</strong></td>
                                        <td>{{ $reservasi->resepObat->tanggal_resep->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $reservasi->resepObat->status_color }}"
                                                  id="status-badge-{{ $reservasi->resepObat->id }}">
                                                {{ $reservasi->resepObat->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    @if($reservasi->resepObat->farmasi)
                                        <tr>
                                            <td width="40%"><strong>Farmasi</strong></td>
                                            <td>{{ $reservasi->resepObat->farmasi->name }}</td>
                                        </tr>
                                    @endif
                                    @if($reservasi->resepObat->tanggal_ambil)
                                        <tr>
                                            <td><strong>Tanggal Ambil</strong></td>
                                            <td>{{ $reservasi->resepObat->tanggal_ambil->format('d F Y H:i') }}</td>
                                        </tr>
                                    @endif
                                    @if($reservasi->resepObat->catatan_dokter)
                                        <tr>
                                            <td><strong>Catatan</strong></td>
                                            <td>{{ $reservasi->resepObat->catatan_dokter }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-success btn-sm" 
                                    onclick="updateStatus('{{ $reservasi->resepObat->id }}', 'diproses')">
                                <i class="fas fa-play"></i> Proses Resep
                            </button>
                            <button type="button" class="btn btn-info btn-sm" 
                                    onclick="updateStatus('{{ $reservasi->resepObat->id }}', 'siap')">
                                <i class="fas fa-check"></i> Siap Diambil
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" 
                                    onclick="updateStatus('{{ $reservasi->resepObat->id }}', 'diambil')">
                                <i class="fas fa-hand-paper"></i> Sudah Diambil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prescription Details -->
        @if($reservasi->resepObat->detailResep && $reservasi->resepObat->detailResep->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Detail Obat</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Obat</th>
                                            <th>Jumlah</th>
                                            <th>Dosis</th>
                                            <th>Aturan Pakai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reservasi->resepObat->detailResep as $index => $detail)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $detail->nama_obat }}</td>
                                                <td>{{ $detail->jumlah }}</td>
                                                <td>{{ $detail->dosis }}</td>
                                                <td>{{ $detail->aturan_pakai }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-prescription-bottle fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Resep Obat</h5>
                        <p class="text-muted">Resep obat belum dibuat untuk reservasi ini.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('admin.reservasi.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Reservasi
            </a>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
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
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="siap">Siap Diambil</option>
                            <option value="diambil">Sudah Diambil</option>
                        </select>
                    </div>
                    <div class="form-group" id="farmasiGroup" style="display: none;">
                        <label for="farmasi_id">Farmasi</label>
                        <select class="form-control" id="farmasi_id" name="farmasi_id">
                            <option value="">Pilih Farmasi</option>
                            <!-- Options will be populated via JavaScript -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                                  placeholder="Masukkan catatan tambahan..."></textarea>
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

function updateStatus(resepId, status) {
    if (confirm('Apakah Anda yakin ingin mengubah status resep?')) {
        $.ajax({
            url: `/admin/resep-obat/${resepId}/update-status`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                status: status
            },
            success: function(response) {
                if (response.success) {
                    // Update status badge
                    $(`#status-badge-${resepId}`)
                        .removeClass()
                        .addClass(`badge badge-${response.status_color}`)
                        .text(response.status_label);
                    
                    // Show success message
                    showAlert('success', response.message);
                    
                    // Reload page after 2 seconds
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showAlert('error', 'Terjadi kesalahan saat memperbarui status.');
                }
            },
            error: function() {
                showAlert('error', 'Terjadi kesalahan saat memperbarui status.');
            }
        });
    }
}

$('#updateStatusForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    $.ajax({
        url: `/admin/resep-obat/${currentResepId}/update-status`,
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            status: formData.get('status'),
            farmasi_id: formData.get('farmasi_id'),
            catatan: formData.get('catatan')
        },
        success: function(response) {
            if (response.success) {
                $('#updateStatusModal').modal('hide');
                
                // Update status badge
                $(`#status-badge-${currentResepId}`)
                    .removeClass()
                    .addClass(`badge badge-${response.status_color}`)
                    .text(response.status_label);
                
                // Show success message
                showAlert('success', response.message);
                
                // Reload page after 2 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showAlert('error', 'Terjadi kesalahan saat memperbarui status.');
            }
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan saat memperbarui status.';
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat();
                errorMessage = errors.join('<br>');
            }
            
            showAlert('error', errorMessage);
        }
    });
});

// Show/hide farmasi dropdown based on status
$('#status').on('change', function() {
    const status = $(this).val();
    const farmasiGroup = $('#farmasiGroup');
    
    if (status === 'diproses' || status === 'siap') {
        farmasiGroup.show();
        $('#farmasi_id').prop('required', true);
        loadFarmasisOptions();
    } else {
        farmasiGroup.hide();
        $('#farmasi_id').prop('required', false);
    }
});

function loadFarmasisOptions() {
    // This would typically load from your API
    // For now, you can populate this manually or via AJAX
    const farmasisSelect = $('#farmasi_id');
    farmasisSelect.empty().append('<option value="">Pilih Farmasi</option>');
    
    // You can populate this with actual farmasi data
    // Example: farmasisSelect.append('<option value="1">Farmasi Name</option>');
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertIcon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="${alertIcon}"></i> ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    // Insert alert at the top of the container
    $('.container-fluid').prepend(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        $('.alert').alert('close');
    }, 5000);
}

// Reset modal form when closed
$('#updateStatusModal').on('hidden.bs.modal', function() {
    $('#updateStatusForm')[0].reset();
    $('#farmasiGroup').hide();
    currentResepId = null;
});
</script>
@endpush
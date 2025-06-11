@extends('layouts.pasien')

@section('title', 'Konsultasi Online - Tel-Klinik')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="color: #dc3545; font-weight: 600;">
                        <i class="fas fa-comments me-2"></i>Konsultasi Online
                    </h2>
                    <p class="text-muted mb-0">Kelola konsultasi kesehatan Anda dengan dokter</p>
                </div>
                <a href="{{ route('pasien.consultation.create') }}" class="btn btn-danger">
                    <i class="fas fa-plus me-2"></i>Konsultasi Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-warning mb-2">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h5 class="card-title mb-1">{{ $consultations->where('status', 'waiting')->count() }}</h5>
                    <p class="card-text text-muted mb-0">Menunggu</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-success mb-2">
                        <i class="fas fa-comment-dots fa-2x"></i>
                    </div>
                    <h5 class="card-title mb-1">{{ $consultations->where('status', 'active')->count() }}</h5>
                    <p class="card-text text-muted mb-0">Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-primary mb-2">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <h5 class="card-title mb-1">{{ $consultations->where('status', 'completed')->count() }}</h5>
                    <p class="card-text text-muted mb-0">Selesai</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-info mb-2">
                        <i class="fas fa-list fa-2x"></i>
                    </div>
                    <h5 class="card-title mb-1">{{ $consultations->total() }}</h5>
                    <p class="card-text text-muted mb-0">Total</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Consultations List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-list me-2 text-danger"></i>Daftar Konsultasi
            </h5>
        </div>
        <div class="card-body p-0">
            @if($consultations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 py-3">Subjek</th>
                                <th class="border-0 py-3">Dokter</th>
                                <th class="border-0 py-3">Status</th>
                                <th class="border-0 py-3">Prioritas</th>
                                <th class="border-0 py-3">Pesan Terakhir</th>
                                <th class="border-0 py-3">Tanggal</th>
                                <th class="border-0 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultations as $consultation)
                                <tr>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $consultation->subject }}</h6>
                                                <small class="text-muted">{{ Str::limit($consultation->description, 50) }}</small>
                                                @if($consultation->unread_messages_count > 0)
                                                    <span class="badge bg-danger ms-2">{{ $consultation->unread_messages_count }} baru</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        @if($consultation->dokter)
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($consultation->dokter->name) }}&background=dc3545&color=fff" 
                                                     class="rounded-circle me-2" width="32" height="32" alt="Dokter">
                                                <div>
                                                    <div class="fw-medium">{{ $consultation->dokter->name }}</div>
                                                    <small class="text-muted">{{ $consultation->dokter->specialization ?? 'Dokter Umum' }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Belum ditentukan</span>
                                        @endif
                                    </td>
                                    <td class="py-3">{!! $consultation->statusBadge !!}</td>
                                    <td class="py-3">{!! $consultation->priorityBadge !!}</td>
                                    <td class="py-3">
                                        @if($consultation->latestMessage->first())
                                            <small class="text-muted">
                                                {{ Str::limit($consultation->latestMessage->first()->message, 30) }}
                                            </small>
                                        @else
                                            <small class="text-muted">Belum ada pesan</small>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <small class="text-muted">{{ $consultation->created_at->format('d M Y H:i') }}</small>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pasien.consultation.show', $consultation->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(in_array($consultation->status, ['waiting', 'active']))
                                                <form action="{{ route('pasien.consultation.cancel', $consultation->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan konsultasi ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($consultations->hasPages())
                    <div class="card-footer bg-white">
                        {{ $consultations->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-comments fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">Belum Ada Konsultasi</h5>
                    <p class="text-muted mb-4">Anda belum memiliki riwayat konsultasi online.</p>
                    <a href="{{ route('pasien.consultation.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus me-2"></i>Mulai Konsultasi Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.table-hover tbody tr:hover {
    background-color: rgba(220, 53, 69, 0.05);
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endsection
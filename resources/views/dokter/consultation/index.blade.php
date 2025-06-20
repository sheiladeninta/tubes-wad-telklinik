@extends('layouts.dokter')

@section('title', 'Konsultasi Online')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-comments mr-2"></i>
                        Konsultasi Online
                    </h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($consultations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Pasien</th>
                                        <th>Subjek</th>
                                        <th>Status</th>
                                        <th>Prioritas</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Pesan Belum Dibaca</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($consultations as $consultation)
                                        <tr>
                                            <td>
                                                <strong>{{ $consultation->pasien->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $consultation->pasien->email }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $consultation->subject }}</strong>
                                                @if($consultation->latestMessage->isNotEmpty())
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ Str::limit($consultation->latestMessage->first()->message, 50) }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>{!! $consultation->status_badge !!}</td>
                                            <td>{!! $consultation->priority_badge !!}</td>
                                            <td>{{ $consultation->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($consultation->unread_messages_count > 0)
                                                    <span class="badge badge-danger">{{ $consultation->unread_messages_count }}</span>
                                                @else
                                                    <span class="badge badge-secondary">0</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('dokter.consultation.show', $consultation->id) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $consultations->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada konsultasi</h5>
                            <p class="text-muted">Konsultasi pasien akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto refresh setiap 30 detik untuk cek konsultasi baru
    setInterval(function() {
        location.reload();
    }, 30000);
</script>
@endsection
@extends('layouts.dokter')
@section('title', 'Konsultasi dengan ' . $consultation->pasien->name)
@section('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out;
    border-radius: 0.75rem;
}

.message-item img {
    cursor: pointer;
    transition: transform 0.2s;
}

.message-item img:hover {
    transform: scale(1.02);
}

#messages-container {
    scroll-behavior: smooth;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.message-text {
    word-wrap: break-word;
    white-space: pre-wrap;
    line-height: 1.5;
}

.input-group .form-control {
    border-radius: 0.5rem 0 0 0.5rem;
}

.input-group .btn {
    border-radius: 0;
}

.input-group .btn:last-child {
    border-radius: 0 0.5rem 0.5rem 0;
}

.alert {
    border-radius: 0.75rem;
    border: none;
}

.modal-content {
    border-radius: 0.75rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
}

.badge {
    font-weight: 500;
}

/* Custom scrollbar */
#messages-container::-webkit-scrollbar {
    width: 6px;
}

#messages-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#messages-container::-webkit-scrollbar-thumb {
    background: #dc3545;
    border-radius: 3px;
}

#messages-container::-webkit-scrollbar-thumb:hover {
    background: #c82333;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="color: #dc3545; font-weight: 600;">
                        <i class="fas fa-comments me-2"></i>Konsultasi Dokter
                    </h2>
                    <p class="text-muted mb-0">{{ $consultation->subject }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('dokter.consultation.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
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

    <div class="row">
        <!-- Chat Interface -->
        <div class="col-md-8">
            <!-- Consultation Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-danger"></i>Informasi Konsultasi
                        </h5>
                        <div class="d-flex gap-2">
                            {!! $consultation->status_badge !!}
                            {!! $consultation->priority_badge !!}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted d-block">ID Konsultasi</small>
                                <strong>#{{ $consultation->id }}</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Pasien</small>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($consultation->pasien->name) }}&background=dc3545&color=fff" 
                                         class="rounded-circle me-2" width="32" height="32" alt="Pasien">
                                    <div>
                                        <div class="fw-medium">{{ $consultation->pasien->name }}</div>
                                        <small class="text-muted">{{ $consultation->pasien->email }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted d-block">Tanggal Dibuat</small>
                                <strong>{{ $consultation->created_at->format('d M Y, H:i') }}</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Status Konsultasi</small>
                                @switch($consultation->status)
                                    @case('waiting')
                                        <span class="text-warning">
                                            <i class="fas fa-clock me-1"></i>Menunggu tindakan dokter
                                        </span>
                                        @break
                                    @case('active')
                                        <span class="text-success">
                                            <i class="fas fa-comment-dots me-1"></i>Konsultasi aktif
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="text-primary">
                                            <i class="fas fa-check-circle me-1"></i>Konsultasi selesai
                                        </span>
                                        @break
                                    @case('cancelled')
                                        <span class="text-danger">
                                            <i class="fas fa-times-circle me-1"></i>Konsultasi dibatalkan
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                    @if($consultation->description)
                        <div class="mt-3 pt-3 border-top">
                            <small class="text-muted d-block mb-2">Deskripsi Keluhan</small>
                            <p class="mb-0">{{ $consultation->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Chat Interface Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-comments me-2 text-danger"></i>Percakapan
                        </h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                onclick="refreshMessages()" title="Refresh Pesan">
                            <i class="fas fa-sync-alt me-1"></i>Refresh
                        </button>
                    </div>
                </div>
                
                <!-- Messages Container -->
                <div class="card-body p-0">
                    <div id="messages-container" style="height: 500px; overflow-y: auto;" class="p-4">
                        @forelse($messages as $message)
                            <div class="message-item mb-4 {{ $message->sender_id === auth()->id() ? 'text-end' : 'text-start' }}">
                                <div class="d-inline-block p-3 rounded-3 {{ $message->sender_id === auth()->id() ? 'bg-danger text-white' : 'bg-light' }}" 
                                     style="max-width: 70%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    
                                    <!-- Sender Info -->
                                    <div class="small mb-2 {{ $message->sender_id === auth()->id() ? 'opacity-75' : 'text-muted' }}">
                                        <div class="d-flex align-items-center {{ $message->sender_id === auth()->id() ? 'justify-content-end' : '' }}">
                                            @if($message->sender_id !== auth()->id())
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($message->sender->name) }}&background=dc3545&color=fff" 
                                                     class="rounded-circle me-2" width="20" height="20" alt="Sender">
                                            @endif
                                            <strong>{{ $message->sender->name }}</strong>
                                        </div>
                                    </div>
                                    
                                    <!-- Message Content -->
                                    @if($message->message_type === 'image' && $message->attachment)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($message->attachment) }}" 
                                                 alt="Attachment" 
                                                 class="img-fluid rounded-3" 
                                                 style="max-height: 200px; cursor: pointer;"
                                                 onclick="showImageModal('{{ Storage::url($message->attachment) }}')">
                                        </div>
                                    @elseif($message->message_type === 'file' && $message->attachment)
                                        <div class="mb-2">
                                            <a href="{{ Storage::url($message->attachment) }}" 
                                               target="_blank" 
                                               class="{{ $message->sender_id === auth()->id() ? 'text-white' : 'text-danger' }} text-decoration-none">
                                                <i class="fas fa-file me-2"></i>
                                                <span class="text-decoration-underline">{{ basename($message->attachment) }}</span>
                                            </a>
                                        </div>
                                    @endif
                                    
                                    @if($message->message)
                                        <div class="message-text">{{ $message->message }}</div>
                                    @endif
                                    
                                    <!-- Timestamp -->
                                    <div class="small mt-2 {{ $message->sender_id === auth()->id() ? 'opacity-75' : 'text-muted' }}">
                                        {{ $message->created_at->format('d M Y, H:i') }}
                                        @if($message->is_read && $message->sender_id === auth()->id())
                                            <i class="fas fa-check-double ms-1"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                <div class="mb-3">
                                    <i class="fas fa-comments fa-3x text-muted"></i>
                                </div>
                                <h5 class="text-muted mb-3">Belum ada pesan</h5>
                                <p class="mb-0">Belum ada pesan dalam konsultasi ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Message Input Form -->
                @if(in_array($consultation->status, ['waiting', 'active']))
                    <div class="card-footer bg-white border-top">
                        <form id="message-form" action="{{ route('dokter.consultation.send-message', $consultation->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="text" 
                                       name="message" 
                                       id="message-input"
                                       class="form-control border-0" 
                                       placeholder="Ketik pesan Anda..."
                                       maxlength="1000"
                                       style="box-shadow: none;">
                                
                                <input type="file" 
                                       name="attachment" 
                                       id="attachment-input" 
                                       class="d-none"
                                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                
                                <button type="button" 
                                        class="btn btn-outline-secondary border-0" 
                                        onclick="document.getElementById('attachment-input').click()"
                                        title="Lampirkan File">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                                
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-paper-plane me-1"></i>Kirim
                                </button>
                            </div>
                            
                            <!-- File Preview -->
                            <div id="file-preview" class="mt-2 d-none">
                                <small class="text-muted">
                                    <i class="fas fa-file me-1"></i>File dipilih: <span id="file-name"></span>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" onclick="clearFile()">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </small>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="card-footer bg-light border-top text-center text-muted py-4">
                        <i class="fas fa-lock me-2"></i>
                        <strong>Konsultasi telah berakhir.</strong> 
                        <span>Anda tidak dapat mengirim pesan lagi.</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Patient Info -->
            <div class="card border-0 shadow-sm mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-user me-2"></i>Informasi Pasien
                    </h5>
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($consultation->pasien->name) }}&background=ffffff&color=667eea" 
                             class="rounded-circle me-3" width="48" height="48" alt="Pasien">
                        <div>
                            <div class="fw-medium">{{ $consultation->pasien->name }}</div>
                            <small class="opacity-75">{{ $consultation->pasien->email }}</small>
                        </div>
                    </div>
                    @if($consultation->pasien->phone)
                        <p class="mb-1 opacity-90">
                            <i class="fas fa-phone me-2"></i>{{ $consultation->pasien->phone }}
                        </p>
                    @endif
                </div>
            </div>
            
            <!-- Consultation Details -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle me-2 text-danger"></i>Detail Konsultasi
                    </h5>
                    <div class="mb-3">
                        <small class="text-muted d-block">Keluhan Utama</small>
                        <p class="mb-0">{{ $consultation->description ?: 'Tidak ada deskripsi' }}</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-2">
                                <small class="text-muted d-block">Prioritas</small>
                                {!! $consultation->priority_badge !!}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <small class="text-muted d-block">Status</small>
                                {!! $consultation->status_badge !!}
                            </div>
                        </div>
                    </div>
                    
                    @if($consultation->started_at)
                        <div class="mb-2">
                            <small class="text-muted d-block">Dimulai</small>
                            <span>{{ $consultation->started_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                    
                    @if($consultation->completed_at)
                        <div class="mb-2">
                            <small class="text-muted d-block">Selesai</small>
                            <span>{{ $consultation->completed_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-cogs me-2 text-danger"></i>Aksi Dokter
                    </h5>
                    
                    @if($consultation->status == 'waiting')
                        <form action="{{ route('dokter.consultation.accept', $consultation->id) }}" 
                              method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check me-2"></i>Terima Konsultasi
                            </button>
                        </form>
                    @endif
                    
                    @if($consultation->status == 'active')
                        <button type="button" class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#completeModal">
                            <i class="fas fa-check-circle me-2"></i>Selesaikan Konsultasi
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modal-image" src="" alt="Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Complete Consultation Modal -->
<div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="completeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0">
            <form action="{{ route('dokter.consultation.complete', $consultation->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="completeModalLabel">
                        <i class="fas fa-check-circle me-2 text-success"></i>Selesaikan Konsultasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" id="diagnosis" class="form-control" rows="4" 
                                  placeholder="Masukkan diagnosis atau kesimpulan konsultasi..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="prescription" class="form-label">Resep/Rekomendasi</label>
                        <textarea name="prescription" id="prescription" class="form-control" rows="4" 
                                  placeholder="Masukkan resep obat atau rekomendasi pengobatan..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="consultation_fee" class="form-label">Biaya Konsultasi (Rp)</label>
                        <input type="number" name="consultation_fee" id="consultation_fee" 
                               class="form-control" min="0" step="1000" 
                               placeholder="Masukkan biaya konsultasi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-1"></i>Selesaikan Konsultasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto scroll to bottom
    scrollToBottom();
    
    // Handle file input change
    document.getElementById('attachment-input')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-preview').classList.remove('d-none');
        }
    });
    
    // Handle Enter key for sending message
    document.getElementById('message-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('message-form').submit();
        }
    });
    
});

function scrollToBottom() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
}

function clearFile() {
    document.getElementById('attachment-input').value = '';
    document.getElementById('file-preview').classList.add('d-none');
}

function showImageModal(src) {
    document.getElementById('modal-image').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function refreshMessages() {
    fetch(`{{ route('dokter.consultation.messages', $consultation->id) }}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('messages-container').innerHTML = data.html;
                scrollToBottom();
            }
        })
        .catch(error => {
            console.error('Error refreshing messages:', error);
        });
}

function showAlert(message, type) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = document.querySelector('.container-fluid');
    const existingAlert = container.querySelector('.alert');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}
</script>
@endsection
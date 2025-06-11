@extends('layouts.pasien')
@section('title', 'Detail Konsultasi - Tel-Klinik')
@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="color: #dc3545; font-weight: 600;">
                        <i class="fas fa-comments me-2"></i>Detail Konsultasi
                    </h2>
                    <p class="text-muted mb-0">{{ $consultation->subject }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('pasien.consultation.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    @if(in_array($consultation->status, ['waiting', 'active']))
                        <button type="button" class="btn btn-outline-danger" 
                                onclick="endConsultation()" title="Akhiri Konsultasi">
                            <i class="fas fa-stop me-2"></i>Akhiri
                        </button>
                        <button type="button" class="btn btn-outline-secondary" 
                                onclick="cancelConsultation()" title="Batalkan Konsultasi">
                            <i class="fas fa-times me-2"></i>Batalkan
                        </button>
                    @endif
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

    <!-- Consultation Info Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2 text-danger"></i>Informasi Konsultasi
                </h5>
                <div class="d-flex gap-2">
                    {!! $consultation->statusBadge !!}
                    {!! $consultation->priorityBadge !!}
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
                        <small class="text-muted d-block">Dokter</small>
                        @if($consultation->dokter)
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($consultation->dokter->name) }}&background=dc3545&color=fff" 
                                     class="rounded-circle me-2" width="32" height="32" alt="Dokter">
                                <div>
                                    <div class="fw-medium">{{ $consultation->dokter->name }}</div>
                                    @if($consultation->dokter->specialist)
                                        <small class="text-muted">{{ $consultation->dokter->specialist }}</small>
                                    @else
                                        <small class="text-muted">Dokter Umum</small>
                                    @endif
                                </div>
                            </div>
                        @else
                            <span class="text-warning">
                                <i class="fas fa-clock me-1"></i>Menunggu penugasan dokter
                            </span>
                        @endif
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
                                    <i class="fas fa-clock me-1"></i>Menunggu respon dokter
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
                                    @if($message->sender->isDokter() && $message->sender->specialist)
                                        <small class="ms-1">({{ $message->sender->specialist }})</small>
                                    @endif
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
                <form id="message-form" enctype="multipart/form-data">
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

<!-- Confirmation Modals -->
<div class="modal fade" id="endConsultationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-stop-circle me-2 text-danger"></i>Akhiri Konsultasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Apakah Anda yakin ingin mengakhiri konsultasi ini?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <small>Setelah diakhiri, Anda tidak dapat mengirim pesan lagi.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('pasien.consultation.end', $consultation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-stop me-1"></i>Ya, Akhiri
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelConsultationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2 text-danger"></i>Batalkan Konsultasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Apakah Anda yakin ingin membatalkan konsultasi ini?</p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <small>Konsultasi yang dibatalkan tidak dapat dikembalikan.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('pasien.consultation.cancel', $consultation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>Ya, Batalkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto scroll to bottom
    scrollToBottom();
    
    // Handle form submission
    document.getElementById('message-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        sendMessage();
    });
    
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
            sendMessage();
        }
    });
    
    // Auto refresh messages every 15 seconds
    setInterval(refreshMessages, 15000);
});

function sendMessage() {
    const form = document.getElementById('message-form');
    const formData = new FormData(form);
    const messageInput = document.getElementById('message-input');
    const attachmentInput = document.getElementById('attachment-input');
    
    // Validate input
    if (!formData.get('message').trim() && !formData.get('attachment')) {
        showAlert('Silakan masukkan pesan atau lampirkan file.', 'warning');
        return;
    }
    
    // Disable form
    form.style.pointerEvents = 'none';
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Mengirim...';
    
    fetch(`{{ route('pasien.consultation.sendMessage', $consultation->id) }}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear form
            messageInput.value = '';
            attachmentInput.value = '';
            clearFile();
            
            // Refresh messages
            refreshMessages();
            showAlert('Pesan berhasil dikirim!', 'success');
        } else {
            showAlert('Gagal mengirim pesan. Silakan coba lagi.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Terjadi kesalahan. Silakan coba lagi.', 'danger');
    })
    .finally(() => {
        // Re-enable form
        form.style.pointerEvents = 'auto';
        submitBtn.innerHTML = originalText;
    });
}

function refreshMessages() {
    fetch(`{{ route('pasien.consultation.getMessages', $consultation->id) }}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        updateMessagesDisplay(data.messages);
        // Update consultation status if needed
        if (data.consultation_status) {
            updateConsultationStatus(data.consultation_status);
        }
    })
    .catch(error => console.error('Error refreshing messages:', error));
}

function updateMessagesDisplay(messages) {
    const container = document.getElementById('messages-container');
    let html = '';
    
    if (messages.length === 0) {
        html = `
            <div class="text-center text-muted py-5">
                <div class="mb-3">
                    <i class="fas fa-comments fa-3x text-muted"></i>
                </div>
                <h5 class="text-muted mb-3">Belum ada pesan</h5>
                <p class="mb-0">Belum ada pesan dalam konsultasi ini.</p>
            </div>
        `;
    } else {
        messages.forEach(message => {
            const isOwn = message.sender_id === {{ auth()->id() }};
            const alignClass = isOwn ? 'text-end' : 'text-start';
            const bgClass = isOwn ? 'bg-danger text-white' : 'bg-light';
            
            let contentHtml = '';
            
            // Handle attachments
            if (message.message_type === 'image' && message.attachment) {
                contentHtml += `
                    <div class="mb-2">
                        <img src="/storage/${message.attachment}" 
                             alt="Attachment" 
                             class="img-fluid rounded-3" 
                             style="max-height: 200px; cursor: pointer;"
                             onclick="showImageModal('/storage/${message.attachment}')">
                    </div>
                `;
            } else if (message.message_type === 'file' && message.attachment) {
                const linkClass = isOwn ? 'text-white' : 'text-danger';
                contentHtml += `
                    <div class="mb-2">
                        <a href="/storage/${message.attachment}" 
                           target="_blank" 
                           class="${linkClass} text-decoration-none">
                            <i class="fas fa-file me-2"></i>
                            <span class="text-decoration-underline">${message.attachment.split('/').pop()}</span>
                        </a>
                    </div>
                `;
            }
            
            if (message.message) {
                contentHtml += `<div class="message-text">${message.message}</div>`;
            }
            
            const readIcon = message.is_read && isOwn ? '<i class="fas fa-check-double ms-1"></i>' : '';
            const createdAt = new Date(message.created_at).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const senderInfo = !isOwn ? `
                <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(message.sender.name)}&background=dc3545&color=fff" 
                     class="rounded-circle me-2" width="20" height="20" alt="Sender">
            ` : '';
            
            html += `
                <div class="message-item mb-4 ${alignClass}">
                    <div class="d-inline-block p-3 rounded-3 ${bgClass}" 
                         style="max-width: 70%; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <div class="small mb-2 ${isOwn ? 'opacity-75' : 'text-muted'}">
                            <div class="d-flex align-items-center ${isOwn ? 'justify-content-end' : ''}">
                                ${senderInfo}
                                <strong>${message.sender.name}</strong>
                            </div>
                        </div>
                        ${contentHtml}
                        <div class="small mt-2 ${isOwn ? 'opacity-75' : 'text-muted'}">
                            ${createdAt}
                            ${readIcon}
                        </div>
                    </div>
                </div>
            `;
        });
    }
    
    container.innerHTML = html;
    scrollToBottom();
}

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

function endConsultation() {
    new bootstrap.Modal(document.getElementById('endConsultationModal')).show();
}

function cancelConsultation() {
    new bootstrap.Modal(document.getElementById('cancelConsultationModal')).show();
}

function updateConsultationStatus(status) {
    if (!['waiting', 'active'].includes(status)) {
        const messageForm = document.getElementById('message-form');
        if (messageForm) {
            messageForm.parentElement.innerHTML = `
                <div class="card-footer bg-light border-top text-center text-muted py-4">
                    <i class="fas fa-lock me-2"></i>
                    <strong>Konsultasi telah berakhir.</strong> 
                    <span>Anda tidak dapat mengirim pesan lagi.</span>
                </div>
            `;
        }
    }
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
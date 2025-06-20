@extends('layouts.dokter')

@section('title', 'Konsultasi dengan ' . $consultation->pasien->name)

@section('styles')
<style>
    .chat-container {
        height: 500px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 15px;
        background-color: #f8f9fa;
    }
    
    .message {
        margin-bottom: 15px;
        display: flex;
    }
    
    .message.sent {
        justify-content: flex-end;
    }
    
    .message.received {
        justify-content: flex-start;
    }
    
    .message-bubble {
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 18px;
        position: relative;
        word-wrap: break-word;
    }
    
    .message.sent .message-bubble {
        background-color: #007bff;
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    .message.received .message-bubble {
        background-color: white;
        color: #333;
        border: 1px solid #dee2e6;
        border-bottom-left-radius: 4px;
    }
    
    .message-time {
        font-size: 0.75rem;
        opacity: 0.7;
        margin-top: 5px;
    }
    
    .message-sender {
        font-size: 0.8rem;
        font-weight: bold;
        margin-bottom: 3px;
    }
    
    .attachment-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        margin-top: 5px;
    }
    
    .file-attachment {
        display: inline-block;
        padding: 8px 12px;
        background-color: #e9ecef;
        border-radius: 6px;
        text-decoration: none;
        color: #495057;
        margin-top: 5px;
    }
    
    .file-attachment:hover {
        background-color: #dee2e6;
        text-decoration: none;
        color: #495057;
    }
    
    .patient-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
    }
    
    .consultation-header {
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 20px;
        padding-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header consultation-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">{{ $consultation->subject }}</h4>
                            <small class="text-muted">
                                Konsultasi dengan {{ $consultation->pasien->name }} • 
                                Dibuat {{ $consultation->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <div>
                            {!! $consultation->status_badge !!}
                            {!! $consultation->priority_badge !!}
                        </div>
                    </div>
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

                    <!-- Chat Messages -->
                    <div class="chat-container" id="chatContainer">
                        @foreach($messages as $message)
                            <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                                <div class="message-bubble">
                                    @if($message->sender_id != Auth::id())
                                        <div class="message-sender">{{ $message->sender->name }}</div>
                                    @endif
                                    
                                    <div class="message-content">
                                        {{ $message->message }}
                                        
                                        @if($message->attachment)
                                            @if($message->message_type == 'image')
                                                <br>
                                                <img src="{{ Storage::url($message->attachment) }}" 
                                                     alt="Attachment" class="attachment-preview">
                                            @else
                                                <br>
                                                <a href="{{ Storage::url($message->attachment) }}" 
                                                   target="_blank" class="file-attachment">
                                                    <i class="fas fa-file"></i> 
                                                    {{ basename($message->attachment) }}
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    <div class="message-time">
                                        {{ $message->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Message Form -->
                    @if(in_array($consultation->status, ['waiting', 'active']))
                        <form action="{{ route('dokter.consultation.send-message', $consultation->id) }}" 
                              method="POST" enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <div class="input-group">
                                <textarea name="message" class="form-control" 
                                         placeholder="Ketik pesan Anda..." rows="3" 
                                         style="resize: none;"></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    <input type="file" name="attachment" id="attachment" 
                                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" 
                                           class="form-control-file" style="display: none;">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" 
                                            onclick="document.getElementById('attachment').click();">
                                        <i class="fas fa-paperclip"></i> Lampiran
                                    </button>
                                    <span id="attachmentName" class="ml-2 text-muted"></span>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Kirim
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i> 
                            Konsultasi ini sudah {{ $consultation->status == 'completed' ? 'selesai' : 'dibatalkan' }}.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Patient Info -->
            <div class="card patient-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user"></i> Informasi Pasien
                    </h5>
                    <p class="mb-1"><strong>Nama:</strong> {{ $consultation->pasien->name }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $consultation->pasien->email }}</p>
                    @if($consultation->pasien->phone)
                        <p class="mb-1"><strong>Telepon:</strong> {{ $consultation->pasien->phone }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Consultation Info -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle"></i> Detail Konsultasi
                    </h5>
                    <p class="mb-1"><strong>Keluhan:</strong></p>
                    <p class="text-muted">{{ $consultation->description }}</p>
                    <p class="mb-1"><strong>Prioritas:</strong> {!! $consultation->priority_badge !!}</p>
                    <p class="mb-1"><strong>Status:</strong> {!! $consultation->status_badge !!}</p>
                    
                    @if($consultation->started_at)
                        <p class="mb-1"><strong>Dimulai:</strong> {{ $consultation->started_at->format('d/m/Y H:i') }}</p>
                    @endif
                    
                    @if($consultation->completed_at)
                        <p class="mb-1"><strong>Selesai:</strong> {{ $consultation->completed_at->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-cogs"></i> Aksi
                    </h5>
                    
                    @if($consultation->status == 'waiting')
                        <form action="{{ route('dokter.consultation.accept', $consultation->id) }}" 
                              method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Terima Konsultasi
                            </button>
                        </form>
                    @endif
                    
                    @if($consultation->status == 'active')
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#completeModal">
                            <i class="fas fa-check-circle"></i> Selesaikan Konsultasi
                        </button>
                    @endif
                    
                    <a href="{{ route('dokter.consultation.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Complete Consultation Modal -->
<div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="completeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('dokter.consultation.complete', $consultation->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="completeModalLabel">Selesaikan Konsultasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="diagnosis">Diagnosis</label>
                        <textarea name="diagnosis" id="diagnosis" class="form-control" rows="4" 
                                  placeholder="Masukkan diagnosis atau kesimpulan konsultasi..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="prescription">Resep/Rekomendasi</label>
                        <textarea name="prescription" id="prescription" class="form-control" rows="4" 
                                  placeholder="Masukkan resep obat atau rekomendasi pengobatan..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="consultation_fee">Biaya Konsultasi (Rp)</label>
                        <input type="number" name="consultation_fee" id="consultation_fee" 
                               class="form-control" min="0" step="1000" 
                               placeholder="Masukkan biaya konsultasi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Selesaikan Konsultasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Scroll to bottom of chat
    function scrollToBottom() {
        const chatContainer = document.getElementById('chatContainer');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
    
    // Scroll to bottom on page load
    $(document).ready(function() {
        scrollToBottom();
    });
    
    // Show attachment name when file is selected
    document.getElementById('attachment').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '';
        document.getElementById('attachmentName').textContent = fileName;
    });
    
    // Auto refresh messages every 5 seconds if consultation is active
    @if(in_array($consultation->status, ['waiting', 'active']))
        setInterval(function() {
            location.reload();
        }, 5000);
    @endif
</script>
@endsection
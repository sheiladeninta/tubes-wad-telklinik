@php
    use Illuminate\Support\Str;
@endphp
{{-- File: resources/views/pasien/reservasi/partials/upcoming-card.blade.php --}}
<div class="border-bottom" style="border-color: #eee !important;">
    <div class="row g-0 p-4">
        <div class="col-md-2">
            <div class="text-center">
                <div class="avatar mb-2" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <i class="fas fa-user-md text-white fa-lg"></i>
                </div>
                @if($urgent ?? false)
                    <span class="badge bg-danger" style="border-radius: 20px; font-size: 10px;">
                        <i class="fas fa-exclamation me-1"></i>URGENT
                    </span>
                @endif
            </div>
        </div>
        
        <div class="col-md-4">
            <h6 class="mb-1" style="color: #2c3e50; font-weight: 600;">
                {{ $reservasi->dokter->name ?? 'Dokter tidak ditemukan' }}
            </h6>
            <p class="text-muted mb-1" style="font-size: 14px;">
                <i class="fas fa-envelope me-1"></i>{{ $reservasi->dokter->email ?? '' }}
            </p>
            
            @php
                $statusConfig = [
                    'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Menunggu'],
                    'confirmed' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Terkonfirmasi'],
                    'completed' => ['class' => 'primary', 'icon' => 'user-md', 'text' => 'Selesai'],
                    'cancelled' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Dibatalkan'],
                ];
                $config = $statusConfig[$reservasi->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => 'Unknown'];
            @endphp
            
            <span class="badge bg-{{ $config['class'] }}" style="padding: 6px 10px; border-radius: 15px; font-size: 11px;">
                <i class="fas fa-{{ $config['icon'] }} me-1"></i>{{ $config['text'] }}
            </span>
        </div>
        
        <div class="col-md-3">
            <div class="mb-2">
                <strong style="color: #2c3e50; font-size: 16px;">
                    <i class="fas fa-calendar me-1" style="color: #dc3545;"></i>
                    {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->translatedFormat('d F Y') }}
                </strong>
            </div>
            <div class="mb-2">
                <strong style="color: #2c3e50; font-size: 16px;">
                    <i class="fas fa-clock me-1" style="color: #fdcb6e;"></i>
                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi)->format('H:i') }} WIB
                </strong>
            </div>
            
            @if($urgent ?? false)
                @php
                    $tanggalReservasi = \Carbon\Carbon::parse($reservasi->tanggal_reservasi);
                    $jamReservasi = \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi);
                    $reservasiDateTime = $tanggalReservasi->setTime($jamReservasi->hour, $jamReservasi->minute);
                @endphp
                <div class="text-danger" style="font-size: 12px; font-weight: 500;">
                    <i class="fas fa-hourglass-half me-1"></i>
                    <span data-countdown="{{ $reservasiDateTime->toISOString() }}">
                        Menghitung...
                    </span>
                </div>
            @endif
        </div>
        
        <div class="col-md-3">
            <div class="mb-3">
                <h6 style="color: #2c3e50; font-size: 14px; margin-bottom: 8px;">Keluhan:</h6>
                <div style="max-height: 60px; overflow-y: auto; font-size: 13px; color: #636e72; line-height: 1.4;">
                    {{ Str::limit($reservasi->keluhan, 100) }}
                    @if(strlen($reservasi->keluhan) > 100)
                        <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#keluhanModal{{ $reservasi->id }}" style="font-size: 12px;">
                            Selengkapnya...
                        </a>
                    @endif
                </div>
            </div>
            
            <div class="d-flex gap-1">
                <a href="{{ route('pasien.reservasi.show', $reservasi) }}" 
                   class="btn btn-sm btn-outline-primary flex-fill" 
                   style="border-radius: 6px; font-size: 12px;" 
                   title="Lihat Detail">
                    <i class="fas fa-eye me-1"></i>Detail
                </a>
                
                @if(in_array($reservasi->status, ['pending', 'confirmed']))
                    @php
                        $tanggalReservasi = \Carbon\Carbon::parse($reservasi->tanggal_reservasi);
                        $jamReservasi = \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi);
                        $reservasiDateTime = $tanggalReservasi->setTime($jamReservasi->hour, $jamReservasi->minute);
                        $canCancel = $reservasiDateTime->diffInHours(now()) >= 2;
                    @endphp
                    
                    @if($canCancel)
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger flex-fill" 
                                style="border-radius: 6px; font-size: 12px;" 
                                title="Batalkan Reservasi"
                                onclick="confirmCancel({{ $reservasi->id }})">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                    @else
                        <button type="button" 
                                class="btn btn-sm btn-outline-secondary flex-fill" 
                                style="border-radius: 6px; font-size: 12px; opacity: 0.5;" 
                                title="Tidak dapat dibatalkan (< 2 jam)"
                                disabled>
                            <i class="fas fa-ban me-1"></i>Terkunci
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Keluhan --}}
@if(strlen($reservasi->keluhan) > 100)
    <div class="modal fade" id="keluhanModal{{ $reservasi->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title">
                        <i class="fas fa-file-medical-alt me-2"></i>Detail Keluhan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong style="color: #2c3e50;">Reservasi dengan:</strong><br>
                        <span class="text-muted">{{ $reservasi->dokter->name ?? 'Dokter tidak ditemukan' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong style="color: #2c3e50;">Jadwal:</strong><br>
                        <span class="text-muted">
                            {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->translatedFormat('d F Y') }} 
                            pukul {{ \Carbon\Carbon::createFromFormat('H:i:s', $reservasi->jam_reservasi)->format('H:i') }} WIB
                        </span>
                    </div>
                    <div>
                        <strong style="color: #2c3e50;">Keluhan Lengkap:</strong><br>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 10px; line-height: 1.6;">
                            {{ $reservasi->keluhan }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endif
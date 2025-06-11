@extends('layouts.pasien')

@section('title', 'Jadwal Mendatang - Tel-Klinik')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">
                <i class="fas fa-calendar-alt me-2" style="color: #dc3545;"></i>
                Jadwal Mendatang
            </h1>
            <p class="text-muted mb-0">Reservasi yang akan datang dan perlu perhatian Anda</p>
        </div>
        <div>
            <a href="{{ route('pasien.reservasi.index') }}" class="btn btn-outline-secondary me-2" style="border-radius: 8px; padding: 12px 24px;">
                <i class="fas fa-history me-2"></i>Riwayat Reservasi
            </a>
            <a href="{{ route('pasien.reservasi.create') }}" class="btn btn-danger" style="background: linear-gradient(135deg, #dc3545, #b02a37); border: none; border-radius: 8px; padding: 12px 24px;">
                <i class="fas fa-plus me-2"></i>Buat Reservasi Baru
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="border-radius: 8px; border: none; background: #d1edff;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 8px; border: none;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Quick Info Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #a8e6cf, #74b9ff);">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x mb-2" style="color: #00b894;"></i>
                    <h5 class="card-title" style="color: #2d3436;">{{ $reservasis->where('status', 'confirmed')->count() }}</h5>
                    <p class="card-text" style="color: #636e72;">Terkonfirmasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #ffeaa7, #fdcb6e);">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x mb-2" style="color: #e17055;"></i>
                    <h5 class="card-title" style="color: #2d3436;">{{ $reservasis->where('status', 'pending')->count() }}</h5>
                    <p class="card-text" style="color: #636e72;">Menunggu Konfirmasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #ff7675, #fd79a8);">
                <div class="card-body">
                    <i class="fas fa-calendar-day fa-2x mb-2" style="color: #d63031;"></i>
                    <h5 class="card-title" style="color: #2d3436;">{{ $reservasis->where('tanggal_reservasi', now()->format('Y-m-d'))->count() }}</h5>
                    <p class="card-text" style="color: #636e72;">Hari Ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Reservations -->
    <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 12px 12px 0 0;">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Jadwal Reservasi Mendatang
            </h5>
        </div>
        <div class="card-body p-0">
            @if($reservasis->count() > 0)
                @php
                    $today = now()->format('Y-m-d');
                    $tomorrow = now()->addDay()->format('Y-m-d');
                    $thisWeek = now()->endOfWeek()->format('Y-m-d');
                @endphp

                <!-- Hari Ini -->
                @php $todayReservations = $reservasis->where('tanggal_reservasi', $today); @endphp
                @if($todayReservations->count() > 0)
                    <div class="px-4 py-3" style="background: linear-gradient(135deg, #ff7675, #fd79a8); color: white;">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar-day me-2"></i>Hari Ini - {{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}
                        </h6>
                    </div>
                    @foreach($todayReservations as $reservasi)
                        @include('pasien.reservasi.partials.upcoming-card', ['reservasi' => $reservasi, 'urgent' => true])
                    @endforeach
                @endif

                <!-- Besok -->
                @php $tomorrowReservations = $reservasis->where('tanggal_reservasi', $tomorrow); @endphp
                @if($tomorrowReservations->count() > 0)
                    <div class="px-4 py-3" style="background: linear-gradient(135deg, #fdcb6e, #e17055); color: white; {{ $todayReservations->count() > 0 ? 'border-top: 1px solid #eee;' : '' }}">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar-plus me-2"></i>Besok - {{ \Carbon\Carbon::tomorrow()->translatedFormat('d F Y') }}
                        </h6>
                    </div>
                    @foreach($tomorrowReservations as $reservasi)
                        @include('pasien.reservasi.partials.upcoming-card', ['reservasi' => $reservasi, 'urgent' => false])
                    @endforeach
                @endif

                <!-- Minggu Ini -->
                @php 
                    $thisWeekReservations = $reservasis->filter(function($reservasi) use ($today, $tomorrow, $thisWeek) {
                        return $reservasi->tanggal_reservasi > $tomorrow && $reservasi->tanggal_reservasi <= $thisWeek;
                    });
                @endphp
                @if($thisWeekReservations->count() > 0)
                    <div class="px-4 py-3" style="background: linear-gradient(135deg, #74b9ff, #0984e3); color: white; {{ ($todayReservations->count() > 0 || $tomorrowReservations->count() > 0) ? 'border-top: 1px solid #eee;' : '' }}">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar-week me-2"></i>Minggu Ini
                        </h6>
                    </div>
                    @foreach($thisWeekReservations as $reservasi)
                        @include('pasien.reservasi.partials.upcoming-card', ['reservasi' => $reservasi, 'urgent' => false])
                    @endforeach
                @endif

                <!-- Selanjutnya -->
                @php 
                    $laterReservations = $reservasis->filter(function($reservasi) use ($thisWeek) {
                        return $reservasi->tanggal_reservasi > $thisWeek;
                    });
                @endphp
                @if($laterReservations->count() > 0)
                    <div class="px-4 py-3" style="background: linear-gradient(135deg, #a29bfe, #6c5ce7); color: white; {{ ($todayReservations->count() > 0 || $tomorrowReservations->count() > 0 || $thisWeekReservations->count() > 0) ? 'border-top: 1px solid #eee;' : '' }}">
                        <h6 class="mb-0">
                            <i class="fas fa-calendar me-2"></i>Selanjutnya
                        </h6>
                    </div>
                    @foreach($laterReservations as $reservasi)
                        @include('pasien.reservasi.partials.upcoming-card', ['reservasi' => $reservasi, 'urgent' => false])
                    @endforeach
                @endif

            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak Ada Jadwal Mendatang</h5>
                    <p class="text-muted">Anda tidak memiliki reservasi yang akan datang. Buat reservasi baru untuk konsultasi dengan dokter.</p>
                    <a href="{{ route('pasien.reservasi.create') }}" class="btn btn-danger" style="border-radius: 8px;">
                        <i class="fas fa-plus me-2"></i>Buat Reservasi Baru
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Tips Section -->
    @if($reservasis->count() > 0)
        <div class="card mt-4" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #e8f4fd, #d1edff);">
            <div class="card-body">
                <h6 style="color: #2c3e50;">
                    <i class="fas fa-lightbulb me-2" style="color: #fdcb6e;"></i>Tips untuk Reservasi Anda
                </h6>
                <ul class="mb-0" style="color: #636e72;">
                    <li>Datang 15 menit sebelum jadwal konsultasi</li>
                    <li>Siapkan keluhan dan pertanyaan yang ingin disampaikan</li>
                    <li>Bawa kartu identitas dan riwayat medis jika ada</li>
                    <li>Reservasi dapat dibatalkan minimal 2 jam sebelum jadwal</li>
                </ul>
            </div>
        </div>
    @endif
</div>

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545, #b02a37); color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Pembatalan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan reservasi ini?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="cancelForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmCancel(reservasiId) {
    const form = document.getElementById('cancelForm');
    form.action = `/pasien/reservasi/${reservasiId}/cancel`;
    
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}

// Auto hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

// Add countdown for urgent appointments
function updateCountdowns() {
    const countdownElements = document.querySelectorAll('[data-countdown]');
    countdownElements.forEach(function(element) {
        const targetTime = new Date(element.getAttribute('data-countdown')).getTime();
        const now = new Date().getTime();
        const distance = targetTime - now;
        
        if (distance > 0) {
            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            
            if (hours > 0) {
                element.textContent = `${hours} jam ${minutes} menit lagi`;
            } else {
                element.textContent = `${minutes} menit lagi`;
            }
            
            // Add urgency styling if less than 2 hours
            if (distance < 2 * 60 * 60 * 1000) {
                element.classList.add('text-danger', 'fw-bold');
            }
        } else {
            element.textContent = 'Sudah berlalu';
            element.classList.add('text-muted');
        }
    });
}

// Update countdowns every minute
setInterval(updateCountdowns, 60000);
updateCountdowns(); // Initial call
</script>

@endsection
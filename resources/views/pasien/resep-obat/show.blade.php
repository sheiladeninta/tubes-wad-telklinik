@extends('layouts.pasien')
@section('title', 'Detail Resep Obat - Tel-Klinik')

@section('styles')
<style>
    .prescription-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        color: white;
    }
    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: transform 0.2s ease-in-out;
    }
    .card-custom:hover {
        transform: translateY(-2px);
    }
    .status-badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-pending {
        background: linear-gradient(45deg, #ffeaa7, #fdcb6e);
        color: #e17055;
    }
    .status-diproses {
        background: linear-gradient(45deg, #74b9ff, #0984e3);
        color: white;
    }
    .status-siap {
        background: linear-gradient(45deg, #55efc4, #00b894);
        color: white;
    }
    .status-diambil {
        background: linear-gradient(45deg, #fd79a8, #e84393);
        color: white;
    }
    .medication-item {
        border-left: 4px solid #667eea;
        background: #f8f9ff;
        transition: all 0.3s ease;
    }
    .medication-item:hover {
        border-left-color: #764ba2;
        background: #f0f3ff;
    }
    .doctor-info {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        border-radius: 12px;
    }
    .prescription-info {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        border-radius: 12px;
    }
    .btn-custom {
        border-radius: 25px;
        padding: 0.7rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-primary-custom {
        background: linear-gradient(45deg, #667eea, #764ba2);
        border: none;
        color: white;
    }
    .btn-primary-custom:hover {
        background: linear-gradient(45deg, #5a6fd8, #6a4190);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .btn-success-custom {
        background: linear-gradient(45deg, #00b894, #00a085);
        border: none;
        color: white;
    }
    .btn-success-custom:hover {
        background: linear-gradient(45deg, #00a085, #009176);
        transform: translateY(-1px);
    }
    .btn-warning-custom {
        background: linear-gradient(45deg, #fdcb6e, #e17055);
        border: none;
        color: white;
    }
    .btn-warning-custom:hover {
        background: linear-gradient(45deg, #e17055, #d63031);
        transform: translateY(-1px);
    }
    .icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.2);
        margin-right: 1rem;
    }
    .timeline-item {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 1.5rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #667eea;
    }
    .timeline-item::after {
        content: '';
        position: absolute;
        left: 5px;
        top: 15px;
        width: 2px;
        height: calc(100% - 10px);
        background: #e0e6ed;
    }
    .timeline-item:last-child::after {
        display: none;
    }
    .medication-dosage {
        background: linear-gradient(45deg, #e17055, #d63031);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .medication-frequency {
        background: linear-gradient(45deg, #00b894, #00a085);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }
    @media (max-width: 768px) {
        .btn-custom {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .prescription-header {
            text-align: center;
        }
        .icon-wrapper {
            width: 40px;
            height: 40px;
            margin-right: 0.5rem;
        }
    }
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Back Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('pasien.resep-obat.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Resep
            </a>
        </div>
    </div>

    <!-- Prescription Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="prescription-header p-4 fade-in">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper">
                                <i class="fas fa-prescription-bottle-alt fa-2x"></i>
                            </div>
                            <div>
                                <h2 class="mb-1">Resep Obat #{{ $resepObat->nomor_resep }}</h2>
                                <p class="mb-0 opacity-75">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    {{ $resepObat->tanggal_resep->format('d F Y, H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <span class="status-badge status-{{ strtolower($resepObat->status) }}">
                            @switch($resepObat->status)
                                @case('pending')
                                    <i class="fas fa-clock me-1"></i>Menunggu
                                    @break
                                @case('diproses')
                                    <i class="fas fa-spinner me-1"></i>Diproses
                                    @break
                                @case('siap')
                                    <i class="fas fa-check-circle me-1"></i>Siap Diambil
                                    @break
                                @case('diambil')
                                    <i class="fas fa-check-double me-1"></i>Sudah Diambil
                                    @break
                                @default
                                    {{ ucfirst($resepObat->status) }}
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Doctor Information -->
            <div class="card card-custom doctor-info mb-4 fade-in">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-user-md text-primary me-2"></i>
                        Informasi Dokter
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-user text-muted me-2"></i>
                                <strong>{{ $resepObat->dokter->nama_lengkap }}</strong>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-stethoscope text-muted me-2"></i>
                                <span>{{ $resepObat->dokter->spesialisasi ?? 'Dokter Umum' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-id-card text-muted me-2"></i>
                                <span>SIP: {{ $resepObat->dokter->nomor_sip ?? '-' }}</span>
                            </div>
                            @if($resepObat->reservasi)
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar-check text-muted me-2"></i>
                                <span>Konsultasi: {{ $resepObat->reservasi->tanggal_reservasi->format('d/m/Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medication List -->
            <div class="card card-custom mb-4 fade-in">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-pills text-primary me-2"></i>
                        Daftar Obat ({{ $resepObat->detailResep->count() }} item)
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($resepObat->detailResep as $index => $detail)
                    <div class="medication-item p-3 rounded mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="mb-1 text-primary">{{ $detail->nama_obat }}</h6>
                                <p class="text-muted mb-2 small">{{ $detail->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                <div class="d-flex flex-wrap align-items-center">
                                    <span class="medication-dosage">{{ $detail->dosis }}</span>
                                    <span class="medication-frequency">{{ $detail->frekuensi }}</span>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mt-2 mt-md-0">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="badge bg-info mb-1">Jumlah</span>
                                    <h5 class="mb-0 text-primary">{{ $detail->jumlah }}</h5>
                                </div>
                            </div>
                            <div class="col-md-3 text-md-end mt-2 mt-md-0">
                                <div class="d-flex flex-column align-items-md-end">
                                    <span class="badge bg-secondary mb-1">Durasi</span>
                                    <span class="text-muted">{{ $detail->durasi_hari }} hari</span>
                                </div>
                            </div>
                        </div>
                        @if($detail->catatan)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info py-2 mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Catatan:</strong> {{ $detail->catatan }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-pills fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada obat dalam resep ini</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Notes -->
            @if($resepObat->catatan)
            <div class="card card-custom mb-4 fade-in">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-sticky-note text-warning me-2"></i>
                        Catatan Dokter
                    </h5>
                    <div class="alert alert-warning border-0">
                        <p class="mb-0">{{ $resepObat->catatan }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Prescription Information -->
            <div class="card card-custom prescription-info mb-4 fade-in">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Informasi Resep
                    </h5>
                    <div class="timeline-item">
                        <strong>Tanggal Resep</strong>
                        <p class="text-muted mb-0">{{ $resepObat->tanggal_resep->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @if($resepObat->tanggal_proses)
                    <div class="timeline-item">
                        <strong>Tanggal Diproses</strong>
                        <p class="text-muted mb-0">{{ $resepObat->tanggal_proses->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @endif
                    @if($resepObat->tanggal_siap)
                    <div class="timeline-item">
                        <strong>Tanggal Siap</strong>
                        <p class="text-muted mb-0">{{ $resepObat->tanggal_siap->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @endif
                    @if($resepObat->tanggal_ambil)
                    <div class="timeline-item">
                        <strong>Tanggal Diambil</strong>
                        <p class="text-muted mb-0">{{ $resepObat->tanggal_ambil->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @endif
                    <div class="timeline-item">
                        <strong>Total Obat</strong>
                        <p class="text-muted mb-0">{{ $resepObat->detailResep->count() }} jenis obat</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card card-custom mb-4 fade-in">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-cogs text-secondary me-2"></i>
                        Aksi
                    </h5>
                    <div class="d-grid gap-2">
                        <!-- Download/Print Button -->
                        <a href="{{ route('pasien.resep-obat.download', $resepObat) }}" 
                           class="btn btn-primary-custom btn-custom" target="_blank">
                            <i class="fas fa-download me-2"></i>Unduh/Cetak Resep
                        </a>

                        @if($resepObat->status === 'siap')
                        <!-- Confirm Pickup Button -->
                        <form action="{{ route('pasien.resep-obat.konfirmasi-ambil', $resepObat) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success-custom btn-custom w-100"
                                    onclick="return confirm('Apakah Anda yakin sudah mengambil obat ini?')">
                                <i class="fas fa-check me-2"></i>Konfirmasi Sudah Diambil
                            </button>
                        </form>
                        @endif

                        @if($resepObat->status === 'pending')
                        <!-- Contact Pharmacy -->
                        <button class="btn btn-warning-custom btn-custom" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="fas fa-phone me-2"></i>Hubungi Farmasi
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pharmacy Information -->
            @if($resepObat->farmasi)
            <div class="card card-custom fade-in">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-store text-success me-2"></i>
                        Informasi Farmasi
                    </h5>
                    <div class="mb-2">
                        <i class="fas fa-building text-muted me-2"></i>
                        <strong>{{ $resepObat->farmasi->nama }}</strong>
                    </div>
                    @if($resepObat->farmasi->alamat)
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt text-muted me-2"></i>
                        <span class="text-muted">{{ $resepObat->farmasi->alamat }}</span>
                    </div>
                    @endif
                    @if($resepObat->farmasi->telepon)
                    <div class="mb-2">
                        <i class="fas fa-phone text-muted me-2"></i>
                        <a href="tel:{{ $resepObat->farmasi->telepon }}" class="text-decoration-none">
                            {{ $resepObat->farmasi->telepon }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">
                    <i class="fas fa-phone text-primary me-2"></i>Hubungi Farmasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Untuk informasi lebih lanjut mengenai resep obat Anda, silakan hubungi:</p>
                <div class="alert alert-info">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <strong>Telp:</strong> 
                        <a href="tel:021-12345678" class="ms-2">(021) 123-456-78</a>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fab fa-whatsapp me-2"></i>
                        <strong>WhatsApp:</strong> 
                        <a href="https://wa.me/6281234567890" class="ms-2" target="_blank">0812-3456-7890</a>
                    </div>
                </div>
                <p class="small text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Jam operasional: Senin - Sabtu (08:00 - 20:00), Minggu (10:00 - 16:00)
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add fade-in animation to elements as they come into view
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });

    // Confirm prescription pickup
    function confirmPickup() {
        return confirm(
            'Apakah Anda yakin sudah mengambil semua obat dalam resep ini?\n\n' +
            'Setelah dikonfirmasi, status resep akan berubah menjadi "Sudah Diambil" ' +
            'dan tidak dapat diubah kembali.'
        );
    }

    // Print prescription
    function printPrescription() {
        window.open("{{ route('pasien.resep-obat.download', $resepObat) }}", '_blank');
    }
</script>
@endsection
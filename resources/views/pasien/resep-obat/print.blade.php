@extends('layouts.pasien')
@section('title', 'Cetak Resep Obat - ' . $resepObat->nomor_resep)
@section('styles')
<style>
    @media print {
        body { margin: 0; padding: 20px; }
        .no-print { display: none !important; }
        .page-break { page-break-before: always; }
        .navbar, .sidebar, .footer { display: none !important; }
        .container-fluid { padding: 0 !important; }
    }
    
    body {
        font-family: 'Arial', sans-serif;
        font-size: 12px;
        line-height: 1.4;
        color: #333;
    }
    
    .print-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .header {
        text-align: center;
        border-bottom: 3px solid #007bff;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    
    .clinic-name {
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 5px;
    }
    
    .clinic-address {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }
    
    .prescription-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-top: 15px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .info-section {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
    }
    
    .info-title {
        font-weight: bold;
        font-size: 14px;
        color: #007bff;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 8px;
    }
    
    .info-label {
        width: 120px;
        font-weight: bold;
        color: #555;
    }
    
    .info-value {
        flex: 1;
        color: #333;
    }
    
    .prescription-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        border: 1px solid #ddd;
    }
    
    .prescription-table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: bold;
        padding: 12px 8px;
        text-align: left;
        border-bottom: 2px solid #dee2e6;
    }
    
    .prescription-table td {
        padding: 10px 8px;
        border-bottom: 1px solid #eee;
        vertical-align: top;
    }
    
    .prescription-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    .medication-name {
        font-weight: bold;
        color: #007bff;
    }
    
    .medication-strength {
        font-size: 11px;
        color: #666;
    }
    
    .dosage {
        font-weight: bold;
        color: #28a745;
    }
    
    .instructions {
        font-style: italic;
        color: #666;
    }
    
    .signature-section {
        margin-top: 40px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
    }
    
    .signature-box {
        text-align: center;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }
    
    .signature-title {
        font-weight: bold;
        margin-bottom: 60px;
    }
    
    .signature-name {
        border-top: 1px solid #333;
        padding-top: 5px;
        font-style: italic;
    }
    
    .footer {
        margin-top: 30px;
        text-align: center;
        font-size: 10px;
        color: #666;
        border-top: 1px solid #eee;
        padding-top: 15px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .status-siap {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-diambil {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-diproses {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 100px;
        color: rgba(0, 123, 255, 0.1);
        z-index: -1;
        pointer-events: none;
    }
    
    .print-info {
        font-size: 10px;
        color: #666;
        text-align: right;
        margin-bottom: 20px;
    }
    
    .print-controls {
        text-align: center;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #dee2e6;
    }
    
    .btn-print {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
        font-size: 14px;
        transition: background-color 0.3s;
    }
    
    .btn-print:hover {
        background: #0056b3;
    }
    
    .btn-close {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }
    
    .btn-close:hover {
        background: #545b62;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="print-container">
        <div class="watermark no-print">TEL-KLINIK</div>
        
        <!-- Print Controls -->
        <div class="print-controls no-print">
            <button onclick="window.print()" class="btn-print">
                <i class="fas fa-print"></i> Cetak Resep
            </button>
            <button onclick="window.history.back()" class="btn-close">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
        </div>
        
        <div class="print-info">
            Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
        </div>

        <!-- Header -->
        <div class="header">
            <div class="clinic-name">TEL-KLINIK</div>
            <div class="clinic-address">
                Jl. Kesehatan No. 123, Jakarta<br>
                Telp: (021) 123-4567 | Email: info@tel-klinik.com
            </div>
            <div class="prescription-title">RESEP OBAT</div>
        </div>

        <!-- Patient and Prescription Info -->
        <div class="info-grid">
            <div class="info-section">
                <div class="info-title">INFORMASI PASIEN</div>
                <div class="info-row">
                    <div class="info-label">Nama:</div>
                    <div class="info-value">{{ $resepObat->pasien->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">No. Telp:</div>
                    <div class="info-value">{{ $resepObat->pasien->phone ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Alamat:</div>
                    <div class="info-value">{{ $resepObat->pasien->address ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Umur:</div>
                    <div class="info-value">{{ $resepObat->pasien->tanggal_lahir ? \Carbon\Carbon::parse($resepObat->pasien->tanggal_lahir)->age . ' tahun' : '-' }}</div>
                </div>
            </div>
            
            <div class="info-section">
                <div class="info-title">INFORMASI RESEP</div>
                <div class="info-row">
                    <div class="info-label">No. Resep:</div>
                    <div class="info-value">{{ $resepObat->nomor_resep }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal:</div>
                    <div class="info-value">{{ $resepObat->tanggal_resep->format('d/m/Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Dokter:</div>
                    <div class="info-value">{{ $resepObat->dokter->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ strtolower($resepObat->status) }}">
                            {{ $resepObat->status_label }}
                        </span>
                    </div>
                </div>
                @if($resepObat->tanggal_ambil)
                <div class="info-row">
                    <div class="info-label">Tgl. Diambil:</div>
                    <div class="info-value">{{ $resepObat->tanggal_ambil->format('d/m/Y') }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Diagnosis -->
        @if($resepObat->diagnosa)
        <div class="info-section" style="margin-bottom: 30px;">
            <div class="info-title">DIAGNOSA</div>
            <p style="margin: 0; color: #333;">{{ $resepObat->diagnosa }}</p>
        </div>
        @endif

        <!-- Prescription Details -->
        <div style="margin-bottom: 20px;">
            <h5 style="color: #007bff; font-weight: bold; margin-bottom: 15px;">
                <i class="fas fa-pills"></i> DETAIL OBAT
            </h5>
        </div>

        <table class="prescription-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Obat</th>
                    <th style="width: 15%;">Dosis</th>
                    <th style="width: 10%;">Jumlah</th>
                    <th style="width: 15%;">Frekuensi</th>
                    <th style="width: 30%;">Aturan Pakai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resepObat->detailResep as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="medication-name">{{ $detail->nama_obat }}</div>
                        @if($detail->kekuatan_obat)
                        <div class="medication-strength">{{ $detail->kekuatan_obat }}</div>
                        @endif
                    </td>
                    <td class="dosage">{{ $detail->dosis }}</td>
                    <td>{{ $detail->jumlah }} {{ $detail->satuan ?? 'pcs' }}</td>
                    <td>{{ $detail->frekuensi }}</td>
                    <td class="instructions">{{ $detail->aturan_pakai }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #666; font-style: italic;">
                        Tidak ada detail obat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Additional Notes -->
        @if($resepObat->catatan)
        <div class="info-section" style="margin-bottom: 30px;">
            <div class="info-title">CATATAN DOKTER</div>
            <p style="margin: 0; color: #333; font-style: italic;">{{ $resepObat->catatan }}</p>
        </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-title">Pasien</div>
                <div class="signature-name">{{ $resepObat->pasien->name }}</div>
            </div>
            <div class="signature-box">
                <div class="signature-title">Dokter yang Merawat</div>
                <div class="signature-name">{{ $resepObat->dokter->name }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Resep ini dicetak secara elektronik dan sah tanpa tanda tangan basah</p>
            <p>TEL-KLINIK &copy; {{ date('Y') }} - Sistem Informasi Klinik</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto print when page loads if requested
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('auto_print') === '1') {
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    }

    // Print functionality
    function printPage() {
        window.print();
    }

    // Prevent accidental navigation away
    window.addEventListener('beforeprint', function() {
        document.title = 'Resep Obat - {{ $resepObat->nomor_resep }}';
    });

    window.addEventListener('afterprint', function() {
        document.title = 'Cetak Resep Obat - {{ $resepObat->nomor_resep }}';
    });
</script>
@endsection
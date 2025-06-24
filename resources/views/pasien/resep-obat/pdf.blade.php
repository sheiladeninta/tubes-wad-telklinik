<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Obat - {{ $resepObat->nomor_resep }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #dc3545;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #dc3545;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        
        .header h2 {
            color: #666;
            font-size: 16px;
            margin: 5px 0 0 0;
            font-weight: normal;
        }
        
        .prescription-info {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 25px;
            border-left: 4px solid #dc3545;
        }
        
        .prescription-info h3 {
            color: #dc3545;
            font-size: 16px;
            margin: 0 0 10px 0;
            font-weight: bold;
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
        
        .prescription-content {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
        }
        
        .prescription-content h3 {
            color: #dc3545;
            font-size: 18px;
            margin: 0 0 15px 0;
            font-weight: bold;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 5px;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section h4 {
            color: #495057;
            font-size: 14px;
            margin: 0 0 8px 0;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .section-content {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        
        .medication-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        .medication-table th, 
        .medication-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .medication-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        
        .medication-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .instructions {
            background-color: #e8f5e8;
            border: 1px solid #28a745;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .instructions h4 {
            color: #28a745;
            margin-top: 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .instructions ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 5px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: white;
        }
        
        .status-pending {
            background-color: #ffc107;
            color: #856404;
        }
        
        .status-diproses {
            background-color: #007bff;
        }
        
        .status-siap {
            background-color: #28a745;
        }
        
        .status-diambil {
            background-color: #6c757d;
        }
        
        .doctor-signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            height: 60px;
            margin-bottom: 5px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>TEL-KLINIK</h1>
        <h2>RESEP OBAT ELEKTRONIK</h2>
    </div>

    <!-- Prescription Information -->
    <div class="prescription-info">
        <h3>INFORMASI RESEP</h3>
        <div class="info-row">
            <div class="info-label">No. Resep</div>
            <div class="info-value">: {{ $resepObat->nomor_resep }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Resep</div>
            <div class="info-value">: {{ \Carbon\Carbon::parse($resepObat->tanggal_resep)->format('d F Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nama Pasien</div>
            <div class="info-value">: {{ $resepObat->pasien->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Umur</div>
            <div class="info-value">: {{ \Carbon\Carbon::parse($resepObat->pasien->birth_date)->age }} tahun</div>
        </div>
        <div class="info-row">
            <div class="info-label">Dokter Pemeriksa</div>
            <div class="info-value">: Dr. {{ $resepObat->dokter->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status</div>
            <div class="info-value">: <span class="status-badge status-{{ strtolower($resepObat->status) }}">{{ ucfirst($resepObat->status) }}</span></div>
        </div>
    </div>

    <!-- Prescription Content -->
    <div class="prescription-content">
        <h3>DAFTAR OBAT</h3>
        
        <!-- Basic Information -->
        <div class="section">
            <table class="medication-table">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 30%">Nama Obat</th>
                        <th style="width: 15%">Jumlah</th>
                        <th style="width: 25%">Aturan Pakai</th>
                        <th style="width: 25%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resepObat->detailResep as $index => $detail)
                    <tr>
                        <td style="text-align: center">{{ $index + 1 }}</td>
                        <td>{{ $detail->nama_obat }}</td>
                        <td style="text-align: center">{{ $detail->jumlah }}</td>
                        <td>{{ $detail->aturan_pakai }}</td>
                        <td>{{ $detail->keterangan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Catatan Dokter -->
        @if($resepObat->catatan)
        <div class="section">
            <h4>Catatan Dokter</h4>
            <div class="section-content">
                {{ $resepObat->catatan }}
            </div>
        </div>
        @endif

        <!-- Peringatan Umum -->
        <div class="instructions">
            <h4>Peringatan Umum</h4>
            <ul>
                <li>Minum obat sesuai dengan aturan pakai yang telah ditentukan</li>
                <li>Jangan menghentikan pengobatan tanpa konsultasi dengan dokter</li>
                <li>Simpan obat di tempat yang sejuk dan kering</li>
                <li>Jauhkan dari jangkauan anak-anak</li>
                <li>Segera hubungi dokter jika terjadi efek samping yang tidak diinginkan</li>
            </ul>
        </div>
    </div>

    <!-- Doctor Signature -->
    <div class="doctor-signature">
        <div class="signature-box">
            <p>Pasien/Keluarga</p>
            <div class="signature-line"></div>
            <p><strong>{{ $resepObat->pasien->name }}</strong></p>
        </div>
        <div class="signature-box">
            <p>{{ \Carbon\Carbon::parse($resepObat->tanggal_resep)->format('d F Y') }}</p>
            <p>Dokter Penanggung Jawab</p>
            <div class="signature-line"></div>
            <p><strong>Dr. {{ $resepObat->dokter->name }}</strong></p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>TEL-KLINIK</strong> - Sistem Resep Obat Elektronik</p>
        <p>Dokumen ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>Dokumen ini bersifat rahasia dan hanya untuk keperluan medis</p>
    </div>
</body>
</html>
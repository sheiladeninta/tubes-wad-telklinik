<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis - {{ $rekamMedis->pasien->name }}</title>
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
        
        .patient-info {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 25px;
            border-left: 4px solid #dc3545;
        }
        
        .patient-info h3 {
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
        
        .medical-record {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
        }
        
        .medical-record h3 {
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
        
        .vital-signs {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }
        
        .vital-item {
            flex: 1;
            min-width: 120px;
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
        
        .vital-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .vital-value {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        
        .vital-unit {
            font-size: 10px;
            color: #666;
        }
        
        .prescription {
            background-color: #e8f5e8;
            border: 1px solid #28a745;
            padding: 15px;
            border-radius: 4px;
        }
        
        .prescription h4 {
            color: #28a745;
            margin-top: 0;
        }
        
        .prescription-item {
            background-color: #fff;
            padding: 8px;
            margin-bottom: 8px;
            border-radius: 4px;
            border-left: 3px solid #28a745;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .doctor-signature {
            margin-top: 30px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            height: 60px;
            margin-bottom: 5px;
        }
        
        .bmi-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }
        
        .bmi-category {
            font-weight: bold;
            color: #856404;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #28a745;
            color: white;
        }
        
        .page-break {
            page-break-after: always;
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
        <h2>REKAM MEDIS ELEKTRONIK</h2>
    </div>

    <!-- Patient Information -->
    <div class="patient-info">
        <h3>INFORMASI PASIEN</h3>
        <div class="info-row">
            <div class="info-label">Nama Pasien</div>
            <div class="info-value">: {{ $rekamMedis->pasien->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value">: {{ $rekamMedis->pasien->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">No. Telepon</div>
            <div class="info-value">: {{ $rekamMedis->pasien->phone ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Lahir</div>
            <div class="info-value">: {{ $rekamMedis->pasien->tanggal_lahir ? \Carbon\Carbon::parse($rekamMedis->pasien->tanggal_lahir)->format('d F Y') : '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jenis Kelamin</div>
            <div class="info-value">: {{ $rekamMedis->pasien->jenis_kelamin ?? '-' }}</div>
        </div>
    </div>

    <!-- Medical Record -->
    <div class="medical-record">
        <h3>REKAM MEDIS PEMERIKSAAN</h3>
        
        <!-- Basic Information -->
        <div class="section">
            <table>
                <tr>
                    <th style="width: 150px;">Tanggal Pemeriksaan</th>
                    <td>{{ $rekamMedis->tanggal_pemeriksaan->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Waktu Pemeriksaan</th>
                    <td>{{ $rekamMedis->tanggal_pemeriksaan->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <th>Dokter Pemeriksa</th>
                    <td>Dr. {{ $rekamMedis->dokter->name }}</td>
                </tr>
                @if($rekamMedis->reservasi)
                <tr>
                    <th>No. Reservasi</th>
                    <td>{{ $rekamMedis->reservasi->id }}</td>
                </tr>
                @endif
                <tr>
                    <th>Status</th>
                    <td><span class="status-badge">{{ ucfirst($rekamMedis->status) }}</span></td>
                </tr>
            </table>
        </div>

        <!-- Keluhan -->
        <div class="section">
            <h4>Keluhan Utama</h4>
            <div class="section-content">
                {{ $rekamMedis->keluhan ?: 'Tidak ada keluhan yang dicatat' }}
            </div>
        </div>

        <!-- Vital Signs -->
        @if($rekamMedis->tinggi_badan || $rekamMedis->berat_badan || $rekamMedis->tekanan_darah || $rekamMedis->suhu_tubuh || $rekamMedis->nadi)
        <div class="section">
            <h4>Tanda-Tanda Vital</h4>
            <div class="vital-signs">
                @if($rekamMedis->tinggi_badan)
                <div class="vital-item">
                    <div class="vital-label">Tinggi Badan</div>
                    <div class="vital-value">{{ $rekamMedis->tinggi_badan }} <span class="vital-unit">cm</span></div>
                </div>
                @endif
                
                @if($rekamMedis->berat_badan)
                <div class="vital-item">
                    <div class="vital-label">Berat Badan</div>
                    <div class="vital-value">{{ $rekamMedis->berat_badan }} <span class="vital-unit">kg</span></div>
                </div>
                @endif
                
                @if($rekamMedis->tinggi_badan && $rekamMedis->berat_badan)
                <div class="vital-item">
                    <div class="vital-label">BMI</div>
                    <div class="vital-value">{{ $rekamMedis->bmi }}</div>
                </div>
                @endif
                
                @if($rekamMedis->tekanan_darah)
                <div class="vital-item">
                    <div class="vital-label">Tekanan Darah</div>
                    <div class="vital-value">{{ $rekamMedis->tekanan_darah }} <span class="vital-unit">mmHg</span></div>
                </div>
                @endif
                
                @if($rekamMedis->suhu_tubuh)
                <div class="vital-item">
                    <div class="vital-label">Suhu Tubuh</div>
                    <div class="vital-value">{{ $rekamMedis->suhu_tubuh }} <span class="vital-unit">°C</span></div>
                </div>
                @endif
                
                @if($rekamMedis->nadi)
                <div class="vital-item">
                    <div class="vital-label">Denyut Nadi</div>
                    <div class="vital-value">{{ $rekamMedis->nadi }} <span class="vital-unit">bpm</span></div>
                </div>
                @endif
            </div>
            
            @if($rekamMedis->tinggi_badan && $rekamMedis->berat_badan)
            <div class="bmi-info">
                <strong>Kategori BMI:</strong> <span class="bmi-category">{{ $rekamMedis->kategori_bmi }}</span>
            </div>
            @endif
        </div>
        @endif

        <!-- Anamnesis -->
        @if($rekamMedis->anamnesis)
        <div class="section">
            <h4>Anamnesis</h4>
            <div class="section-content">
                {{ $rekamMedis->anamnesis }}
            </div>
        </div>
        @endif

        <!-- Pemeriksaan Fisik -->
        @if($rekamMedis->pemeriksaan_fisik)
        <div class="section">
            <h4>Pemeriksaan Fisik</h4>
            <div class="section-content">
                {{ $rekamMedis->pemeriksaan_fisik }}
            </div>
        </div>
        @endif

        <!-- Diagnosa -->
        <div class="section">
            <h4>Diagnosa</h4>
            <div class="section-content">
                {{ $rekamMedis->diagnosa ?: 'Diagnosa belum ditentukan' }}
            </div>
        </div>

        <!-- Terapi/Pengobatan -->
        @if($rekamMedis->terapi)
        <div class="section">
            <h4>Terapi/Pengobatan</h4>
            <div class="prescription">
                {{ $rekamMedis->terapi }}
            </div>
        </div>
        @endif

        <!-- Catatan Tambahan -->
        @if($rekamMedis->catatan)
        <div class="section">
            <h4>Catatan Tambahan</h4>
            <div class="section-content">
                {{ $rekamMedis->catatan }}
            </div>
        </div>
        @endif

        <!-- Tindak Lanjut -->
        @if($rekamMedis->tindak_lanjut)
        <div class="section">
            <h4>Tindak Lanjut</h4>
            <div class="section-content">
                {{ $rekamMedis->tindak_lanjut }}
            </div>
        </div>
        @endif
    </div>

    <!-- Doctor Signature -->
    <div class="doctor-signature">
        <div class="signature-box">
            <p>{{ $rekamMedis->tanggal_pemeriksaan->format('d F Y') }}</p>
            <p>Dokter Pemeriksa,</p>
            <div class="signature-line"></div>
            <p><strong>Dr. {{ $rekamMedis->dokter->name }}</strong></p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>TEL-KLINIK</strong> - Sistem Rekam Medis Elektronik</p>
        <p>Dokumen ini dicetak pada {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB</p>
        <p>Dokumen ini bersifat rahasia dan hanya untuk keperluan medis</p>
    </div>
</body>
</html>
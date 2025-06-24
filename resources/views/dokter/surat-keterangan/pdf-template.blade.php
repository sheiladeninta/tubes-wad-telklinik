<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan {{ $surat->jenis_surat_label }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        
        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .header .clinic-info {
            font-size: 11px;
            margin-top: 10px;
            line-height: 1.3;
        }
        
        .document-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 30px 0;
        }
        
        .nomor-surat {
            text-align: center;
            font-size: 12px;
            margin-bottom: 30px;
        }
        
        .content {
            text-align: justify;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .content p {
            margin: 15px 0;
        }
        
        .patient-info {
            margin: 20px 0;
            padding-left: 20px;
        }
        
        .patient-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .patient-info table td {
            padding: 5px 0;
            vertical-align: top;
        }
        
        .patient-info table td:first-child {
            width: 150px;
            font-weight: bold;
        }
        
        .patient-info table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }
        
        .diagnosis-section {
            margin: 25px 0;
            padding: 15px;
            border: 1px solid #000;
            background-color: #f9f9f9;
        }
        
        .diagnosis-section h4 {
            margin: 0 0 10px 0;
            font-size: 13px;
            text-transform: uppercase;
        }
        
        .signature-section {
            margin-top: 50px;
            display: table;
            width: 100%;
        }
        
        .signature-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .signature-right {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        
        .signature-box {
            border: 1px solid #000;
            height: 80px;
            margin: 10px 0;
            position: relative;
        }
        
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 10px;
        }
        
        .doctor-license {
            font-size: 11px;
            margin-top: 5px;
        }
        
        .date-location {
            text-align: right;
            margin-bottom: 20px;
            font-style: italic;
        }
        
        .footer-note {
            margin-top: 30px;
            font-size: 10px;
            font-style: italic;
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        
        .stamp-area {
            position: relative;
            height: 80px;
            border: 2px dashed #ccc;
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
        }
        
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header Klinik/RS -->
    <div class="header">
        <h1>Tel-Klinik Praktik Dokter</h1>
        <h2>{{ $dokter->name ?? 'Dr. [Nama Dokter]' }}</h2>
        <div class="clinic-info">
            <strong>Alamat:</strong> Jalan Telekomunikasi, Bojongsoang<br>
            <strong>Telepon:</strong> 000777 | <strong>Email:</strong> admin@tel-klinik.com<br>
        </div>
    </div>

    <!-- Judul Surat -->
    <div class="document-title">
        Surat Keterangan {{ $surat->jenis_surat_label }}
    </div>

    <!-- Nomor Surat -->
    <div class="nomor-surat">
        <strong>No. {{ str_pad($surat->id, 4, '0', STR_PAD_LEFT) }}/SK/{{ $tanggal_dibuat->format('m/Y') }}</strong>
    </div>

    <!-- Isi Surat -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, dokter yang bertugas di {{ $dokter->name ?? 'Klinik/RS' }}, dengan ini menerangkan bahwa:</p>
        
        <div class="patient-info">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>{{ $pasien->name }}</strong></td>
                </tr>
                @if($pasien->birth_date)
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($pasien->birth_date)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($pasien->birth_date)->age }} tahun</td>
                </tr>
                @endif
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $pasien->gender }}</td>
                </tr>
                @if($pasien->address)
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $pasien->address }}</td>
                </tr>
                @endif
                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td>{{ $pasien->user_type }}</td>
                </tr>
            </table>
        </div>

        @if($surat->jenis_surat === 'sakit')
            <p>Telah diperiksa pada tanggal <strong>{{ $tanggal_dibuat->format('d F Y') }}</strong> dan berdasarkan hasil pemeriksaan medis, yang bersangkutan dinyatakan:</p>
            
            <div class="diagnosis-section">
                <h4>Diagnosa:</h4>
                <p>{{ $diagnosa }}</p>
                
                @if($keterangan_dokter)
                <h4>Keterangan Medis:</h4>
                <p>{{ $keterangan_dokter }}</p>
                @endif
            </div>
            
            <p>Sehingga yang bersangkutan <strong>TIDAK DAPAT</strong> melakukan aktivitas normal dan <strong>PERLU ISTIRAHAT</strong> untuk pemulihan kesehatan.</p>
            
            @if($surat->keperluan)
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $surat->keperluan }}</strong></p>
            @endif

        @elseif($surat->jenis_surat === 'sehat')
            <p>Telah diperiksa pada tanggal <strong>{{ $tanggal_dibuat->format('d F Y') }}</strong> dan berdasarkan hasil pemeriksaan medis, yang bersangkutan dinyatakan:</p>
            
            <div class="diagnosis-section">
                <h4>Hasil Pemeriksaan:</h4>
                <p>{{ $diagnosa }}</p>
                
                @if($keterangan_dokter)
                <h4>Keterangan Medis:</h4>
                <p>{{ $keterangan_dokter }}</p>
                @endif
            </div>
            
            <p>Berdasarkan pemeriksaan tersebut, yang bersangkutan dinyatakan dalam <strong>KEADAAN SEHAT</strong> dan <strong>MAMPU</strong> melakukan aktivitas normal.</p>
            
            @if($surat->keperluan)
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $surat->keperluan }}</strong></p>
            @endif

        @else
            <p>Telah diperiksa pada tanggal <strong>{{ $tanggal_dibuat->format('d F Y') }}</strong> dan berdasarkan hasil pemeriksaan medis:</p>
            
            <div class="diagnosis-section">
                <h4>Hasil Pemeriksaan:</h4>
                <p>{{ $diagnosa }}</p>
                
                @if($keterangan_dokter)
                <h4>Keterangan Dokter:</h4>
                <p>{{ $keterangan_dokter }}</p>
                @endif
            </div>
            
            @if($surat->keperluan)
            <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{ $surat->keperluan }}</strong></p>
            @endif
        @endif

        <p>Demikian surat keterangan ini dibuat dengan sebenarnya dan dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- Tanggal dan Tempat -->
    <div class="date-location">
        [Kota], {{ $tanggal_dibuat->format('d F Y') }}
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-left">
            <!-- Kosong untuk tanda tangan pasien jika diperlukan -->
        </div>
        <div class="signature-right">
            <p>Dokter yang Memeriksa,</p>
            
            <!-- Area untuk stempel dan tanda tangan -->
            <div class="stamp-area">
                Stempel & Tanda Tangan Dokter
            </div>
            
            <div class="signature-name">
                {{ $dokter->name ?? 'Dr. [Nama Dokter]' }}
            </div>
            <div class="doctor-license">
                SIP: [Nomor SIP]
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-note">
        Surat keterangan ini dicetak secara elektronik pada {{ now()->format('d F Y, H:i') }} WIB<br>
        dan telah ditandatangani secara digital oleh dokter yang bersangkutan.
    </div>
</body>
</html>
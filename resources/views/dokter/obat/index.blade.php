@extends('layouts.dokter')

@section('title', 'Daftar Obat')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-pills text-primary"></i> Daftar Obat
        </h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Obat
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['total_obat'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pills fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Stok Menipis
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['stok_menipis'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Stok Habis
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['stok_habis'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Hampir Kadaluarsa
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['hampir_kadaluarsa'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dokter.obat.index') }}" class="row">
                <div class="col-md-4 mb-3">
                    <label for="search" class="form-label">Cari Obat</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nama obat, jenis, pabrik, komposisi...">
                </div>
                
                <div class="col-md-2 mb-3">
                    <label for="jenis" class="form-label">Jenis Obat</label>
                    <select class="form-control" id="jenis" name="jenis">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisObat as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                {{ ucfirst($jenis) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2 mb-3">
                    <label for="stok_status" class="form-label">Status Stok</label>
                    <select class="form-control" id="stok_status" name="stok_status">
                        <option value="">Semua Status</option>
                        <option value="aman" {{ request('stok_status') == 'aman' ? 'selected' : '' }}>Aman</option>
                        <option value="sedang" {{ request('stok_status') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="menipis" {{ request('stok_status') == 'menipis' ? 'selected' : '' }}>Menipis</option>
                        <option value="habis" {{ request('stok_status') == 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>
                
                <div class="col-md-2 mb-3">
                    <label for="expiry_status" class="form-label">Status Kadaluarsa</label>
                    <select class="form-control" id="expiry_status" name="expiry_status">
                        <option value="">Semua</option>
                        <option value="aman" {{ request('expiry_status') == 'aman' ? 'selected' : '' }}>Aman</option>
                        <option value="hampir_kadaluarsa" {{ request('expiry_status') == 'hampir_kadaluarsa' ? 'selected' : '' }}>Hampir Kadaluarsa</option>
                        <option value="kadaluarsa" {{ request('expiry_status') == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                    </select>
                </div>
                
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <div class="btn-group w-100">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('dokter.obat.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Medicine List Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Obat 
                @if(request()->hasAny(['search', 'jenis', 'stok_status', 'expiry_status']))
                    <small class="text-muted">({{ $obat->total() }} hasil ditemukan)</small>
                @endif
            </h6>
        </div>
        <div class="card-body">
            @if($obat->count() > 0)
                <div class="row">
                    @foreach($obat as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <!-- Medicine Image -->
                                <div class="card-img-top-wrapper" style="height: 200px; overflow: hidden; background: #f8f9fc;">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" 
                                             class="card-img-top h-100 w-100" 
                                             style="object-fit: cover;" 
                                             alt="{{ $item->nama_obat }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-pills fa-3x text-gray-300"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <!-- Medicine Name & Type -->
                                    <h6 class="card-title text-primary font-weight-bold mb-2">
                                        {{ $item->nama_obat }}
                                    </h6>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-tag mr-1"></i>{{ ucfirst($item->jenis_obat) }}
                                    </p>
                                    
                                    <!-- Stock Status -->
                                    <div class="mb-2">
                                        <span class="badge badge-{{ $item->status_stok_badge }} badge-pill">
                                            {{ $item->status_stok }} ({{ $item->stok }})
                                        </span>
                                        @if($item->isHampirKadaluarsa())
                                            <span class="badge badge-warning badge-pill ml-1">
                                                <i class="fas fa-exclamation-triangle"></i> Hampir Kadaluarsa
                                            </span>
                                        @endif
                                        @if($item->isKadaluarsa())
                                            <span class="badge badge-danger badge-pill ml-1">
                                                <i class="fas fa-times"></i> Kadaluarsa
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Price -->
                                    <p class="text-success font-weight-bold mb-2">
                                        <i class="fas fa-money-bill-wave mr-1"></i>{{ $item->harga_format }}
                                    </p>
                                    
                                    <!-- Manufacturer -->
                                    @if($item->pabrik)
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-industry mr-1"></i>{{ $item->pabrik }}
                                        </p>
                                    @endif
                                    
                                    <!-- Expiry Date -->
                                    @if($item->tanggal_kadaluarsa)
                                        <p class="text-muted small mb-3">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Exp: {{ $item->tanggal_kadaluarsa->format('d/m/Y') }}
                                        </p>
                                    @endif
                                    
                                    <!-- Action Buttons -->
                                    <div class="mt-auto">
                                        <div class="btn-group w-100">
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    onclick="showMedicineDetail({{ $item->id }})">
                                                <i class="fas fa-eye"></i> Lihat Detail
                                            </button>
                                            <a href="{{ route('dokter.obat.show', $item->id) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $obat->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-500">Tidak ada obat ditemukan</h5>
                    <p class="text-gray-400">Coba ubah filter pencarian atau kata kunci Anda.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Medicine Detail Modal -->
<div class="modal fade" id="medicineDetailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="medicineDetailModalLabel">Detail Obat</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="medicineDetailContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showMedicineDetail(id) {
    $('#medicineDetailModal').modal('show');
    $('#medicineDetailContent').html(`
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    `);
    
    $.ajax({
        url: `/dokter/obat/${id}/info`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const data = response.data;
                let content = `
                    <div class="row">
                        <div class="col-md-4">
                            ${data.gambar ? 
                                `<img src="${data.gambar}" class="img-fluid rounded mb-3" alt="${data.nama_obat}">` :
                                `<div class="bg-light d-flex align-items-center justify-content-center rounded mb-3" style="height: 200px;">
                                    <i class="fas fa-pills fa-3x text-gray-400"></i>
                                </div>`
                            }
                        </div>
                        <div class="col-md-8">
                            <h4 class="text-primary font-weight-bold">${data.nama_obat}</h4>
                            <p class="text-muted mb-2"><strong>Jenis:</strong> ${data.jenis_obat.charAt(0).toUpperCase() + data.jenis_obat.slice(1)}</p>
                            <p class="text-success font-weight-bold mb-2"><strong>Harga:</strong> ${data.harga_format}</p>
                            <p class="mb-2">
                                <strong>Status Stok:</strong> 
                                <span class="badge badge-${getBadgeClass(data.status_stok)} badge-pill">
                                    ${data.status_stok} (${data.stok})
                                </span>
                            </p>
                            ${data.pabrik ? `<p class="mb-2"><strong>Pabrik:</strong> ${data.pabrik}</p>` : ''}
                            ${data.nomor_batch ? `<p class="mb-2"><strong>Nomor Batch:</strong> ${data.nomor_batch}</p>` : ''}
                            ${data.tanggal_kadaluarsa !== '-' ? `<p class="mb-2"><strong>Tanggal Kadaluarsa:</strong> ${data.tanggal_kadaluarsa}</p>` : ''}
                            
                            ${data.is_hampir_kadaluarsa ? 
                                '<div class="alert alert-warning py-2"><i class="fas fa-exclamation-triangle"></i> Obat hampir kadaluarsa!</div>' : ''
                            }
                            ${data.is_kadaluarsa ? 
                                '<div class="alert alert-danger py-2"><i class="fas fa-times"></i> Obat sudah kadaluarsa!</div>' : ''
                            }
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        ${data.deskripsi ? `
                            <div class="col-12 mb-3">
                                <h6 class="font-weight-bold text-primary">Deskripsi</h6>
                                <p class="text-justify">${data.deskripsi}</p>
                            </div>
                        ` : ''}
                        
                        ${data.komposisi ? `
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold text-primary">Komposisi</h6>
                                <p class="text-justify">${data.komposisi}</p>
                            </div>
                        ` : ''}
                        
                        ${data.dosis ? `
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold text-primary">Dosis</h6>
                                <p class="text-justify">${data.dosis}</p>
                            </div>
                        ` : ''}
                        
                        ${data.cara_pakai ? `
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold text-primary">Cara Pakai</h6>
                                <p class="text-justify">${data.cara_pakai}</p>
                            </div>
                        ` : ''}
                        
                        ${data.efek_samping ? `
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold text-danger">Efek Samping</h6>
                                <p class="text-justify">${data.efek_samping}</p>
                            </div>
                        ` : ''}
                        
                        ${data.kontraindikasi ? `
                            <div class="col-12 mb-3">
                                <h6 class="font-weight-bold text-warning">Kontraindikasi</h6>
                                <p class="text-justify">${data.kontraindikasi}</p>
                            </div>
                        ` : ''}
                    </div>
                `;
                
                $('#medicineDetailContent').html(content);
                $('#medicineDetailModalLabel').text(`Detail Obat - ${data.nama_obat}`);
            }
        },
        error: function() {
            $('#medicineDetailContent').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> 
                    Gagal memuat detail obat. Silakan coba lagi.
                </div>
            `);
        }
    });
}

function getBadgeClass(status) {
    switch(status) {
        case 'Habis': return 'danger';
        case 'Menipis': return 'warning';
        case 'Sedang': return 'info';
        case 'Aman': return 'success';
        default: return 'secondary';
    }
}
</script>
@endpush
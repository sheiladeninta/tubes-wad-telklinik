@extends('layouts.dokter')

@section('title', 'Resep Obat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Resep Obat</h3>
                    <a href="{{ route('dokter.resep-obat.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Resep Baru
                    </a>
                </div>
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['total'] }}</h4>
                                    <small>Total Resep</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['pending'] }}</h4>
                                    <small>Pending</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['diproses'] }}</h4>
                                    <small>Diproses</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['siap'] }}</h4>
                                    <small>Siap</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card bg-secondary text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $statistics['diambil'] }}</h4>
                                    <small>Diambil</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari pasien atau nomor resep..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="siap" {{ request('status') == 'siap' ? 'selected' : '' }}>Siap</option>
                                    <option value="diambil" {{ request('status') == 'diambil' ? 'selected' : '' }}>Diambil</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="tanggal_dari" class="form-control" 
                                       value="{{ request('tanggal_dari') }}" placeholder="Dari Tanggal">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="tanggal_sampai" class="form-control" 
                                       value="{{ request('tanggal_sampai') }}" placeholder="Sampai Tanggal">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('dokter.resep-obat.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Resep</th>
                                    <th>Pasien</th>
                                    <th>Tanggal Resep</th>
                                    <th>Diagnosa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($resepObat as $index => $resep)
                                <tr>
                                    <td>{{ $resepObat->firstItem() + $index }}</td>
                                    <td>{{ $resep->nomor_resep }}</td>
                                    <td>{{ $resep->pasien->name }}</td>
                                    <td>{{ $resep->tanggal_resep->format('d/m/Y H:i') }}</td>
                                    <td>{{ Str::limit($resep->diagnosa, 50) }}</td>
                                    <td>
                                        @switch($resep->status)
                                            @case('pending')
                                                <span class="badge badge-warning">Pending</span>
                                                @break
                                            @case('diproses')
                                                <span class="badge badge-info">Diproses</span>
                                                @break
                                            @case('siap')
                                                <span class="badge badge-success">Siap</span>
                                                @break
                                            @case('diambil')
                                                <span class="badge badge-secondary">Diambil</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('dokter.resep-obat.show', $resep) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        @if($resep->status == 'pending')
                                            <a href="{{ route('dokter.resep-obat.edit', $resep) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" 
                                                  action="{{ route('dokter.resep-obat.destroy', $resep) }}" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data resep obat</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $resepObat->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto submit form when status changes
    $('select[name="status"]').change(function() {
        $(this).closest('form').submit();
    });
</script>
@endpush
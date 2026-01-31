@extends('layout')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard & Monitoring</h1>
    <form action="{{ route('dashboard') }}" method="GET" class="form-inline">
        <label class="mr-2">Filter Tanggal Produksi:</label>
        <input type="date" name="date" class="form-control mr-2" value="{{ $filterDate }}" onchange="this.form.submit()">
    </form>
</div>

<!-- Production Summary Cards -->
<div class="row">
    <!-- Total Target -->
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Target Produksi ({{ date('d M Y', strtotime($filterDate)) }})</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $produksiSummary->total_target ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bullseye fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Hasil -->
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hasil Produksi ({{ date('d M Y', strtotime($filterDate)) }})</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $produksiSummary->total_hasil ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Reject -->
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Reject ({{ date('d M Y', strtotime($filterDate)) }})</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $produksiSummary->total_reject ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Status Stok Terkini</h1>
</div>

<div class="row">
    @forelse($stok as $item)
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-{{ $item->stok_saat_ini > 0 ? 'success' : 'danger' }} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            {{ $item->barang->nama_produk ?? 'Unknown Product' }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                           Stok: {{ $item->stok_saat_ini }}
                        </div>
                        <small class="text-muted">Update: {{ $item->updated_at->diffForHumans() }}</small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">Belum ada data stok.</div>
    </div>
    @endforelse
</div>

<div class="row">
    <div class="col-12">
         <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Detail Stok</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Stok Saat Ini</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stok as $item)
                            <tr>
                                <td>{{ $item->barang->nama_produk ?? '-' }} ({{ $item->barang->kode_produk ?? '-' }})</td>
                                <td class="{{ $item->stok_saat_ini <= 10 ? 'text-danger font-weight-bold' : '' }}">
                                    {{ $item->stok_saat_ini }}
                                </td>
                                <td>{{ $item->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
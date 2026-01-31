@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Preview Laporan Produksi</h6>
    </div>
    <div class="card-body">
        <!-- Anda bisa mendesain tampilan preview laporan di sini -->
        <h3 class="text-center font-weight-bold mb-4">FORMULIR PT.ADITYA TIRTA ABADI UTAMA</h3>
        <h4 class="text-center font-weight-bold mb-4">LAPORAN PRODUKSI</h4>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Tanggal Laporan</strong></td>
                        <td width="5%">:</td>
                        <td>{{ \Carbon\Carbon::parse($produksi->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nomor Batch</strong></td>
                        <td>:</td>
                        <td>{{ $produksi->batch_produksi }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>:</td>
                        <td><span class="badge badge-{{ $produksi->status == 'sukses' ? 'success' : 'info' }}">{{ ucfirst($produksi->status) }}</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <h5 class="font-weight-bold mt-4">Detail Barang</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Produksi</th>
                        <th>Nomor Batch</th>
                        <th>Nama Barang</th>
                        <th>Target</th>
                        <th>Hasil</th>
                        <th>Reject</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produksi->details as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->tanggal_produksi }}</td>
                        <td>{{ $detail->nomor_batch ?? '-' }}</td>
                        <td>{{ $detail->barang->nama_produk ?? 'N/A' }}</td>
                        <td>{{ $detail->target }}</td>
                        <td>{{ $detail->hasil }}</td>
                        <td>{{ $detail->reject }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-5 text-center">
            <!-- Tempat tanda tangan atau catatan kaki bisa dibuat di sini -->
            <br><br><br>
            <p>( ..................................... )</p>
            <p>Admin Produksi</p>
        </div>

        <center class="mt-4 no-print">
            <button onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print"></i> Cetak / PDF</button>
            <a href="{{ route('laporan_produksi.index') }}" class="btn btn-primary">Kembali</a>
        </center>
    </div>
</div>

<style>
    @media print {
        .no-print, .sidebar, .topbar, .sticky-footer, .card-header {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        #content-wrapper {
            background-color: white !important;
        }
    }
</style>
@endsection

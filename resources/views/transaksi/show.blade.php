@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h1 class="m-0 font-weight-bold text-primary text-center">Preview Transaksi Barang Keluar</h1>
    </div>
    <div class="card-body">
        <!-- Header Surat -->
        <h3 class="text-center font-weight-bold mb-4">FORMULIR PT.ADITYA TIRTA ABADI UTAMA</h3>
        <h4 class="text-center font-weight-bold mb-4">BUKTI BARANG KELUAR</h4>
        
        <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td width="35%"><strong>Tanggal Transaksi</strong></td>
                        <td width="5%">:</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nomor BBK</strong></td>
                        <td>:</td>
                        <td>{{ $transaksi->nomor_bbk }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                 <table class="table table-borderless">
                    <tr>
                        <td width="35%"><strong>Nama Supir</strong></td>
                        <td width="5%">:</td>
                        <td>{{ $transaksi->nama_supir }}</td>
                    </tr>
                    <tr>
                        <td><strong>Plat Nomor</strong></td>
                        <td>:</td>
                        <td>{{ $transaksi->plat_kendaraan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tabel Barang -->
        <h5 class="font-weight-bold mt-4">Rincian Barang</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Barang</th>
                        <th>Nomor Batch</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->details as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->barang->nama_produk ?? 'N/A' }}</td>
                        <td>{{ $detail->nomor_batch ?? '-' }}</td>
                        <td>{{ $detail->jumlah }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Keterangan -->
        @if($transaksi->keterangan)
        <div class="mt-3">
            <strong>Keterangan:</strong>
            <p>{{ $transaksi->keterangan }}</p>
        </div>
        @endif

        <!-- Tanda Tangan -->
        <div class="row mt-5 text-center">
            <div class="col-4">
                <p>Penerima,</p>
                <br><br><br>
                <p>( ........................ )</p>
            </div>
            <div class="col-4">
                <p>Supir,</p>
                <br><br><br>
                <p>( {{ $transaksi->nama_supir }} )</p>
            </div>
            <div class="col-4">
                <p>Hormat Kami,</p>
                <br><br><br>
                <p>( Admin Gudang )</p>
            </div>
        </div>

        <!-- Buttons -->
        <center class="mt-5 no-print">
            <button onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print"></i> Cetak / PDF</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-primary">Kembali</a>
        </center>
    </div>
</div>

<style>
    @media print {
        @page { 
            size: auto; 
            margin: 5mm; 
        }
        body { 
            margin: 0;
            font-size: 11px; /* Smaller font for print */
        }
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
        
        /* Compact Layout */
        h3 { font-size: 18px !important; margin-bottom: 5px !important; }
        h4 { font-size: 16px !important; margin-bottom: 10px !important; }
        h5 { font-size: 14px !important; margin-top: 10px !important; }
        
        .table td, .table th {
            padding: 0.3rem !important; /* Reduce padding */
            font-size: 11px !important;
        }
        
        .row.mb-3 { margin-bottom: 15px !important; }
        p { margin-bottom: 5px !important; }
        
        /* Force single page constraint if content isn't too massive */
        html, body {
            height: 100%;
            overflow: visible;
        }
        
        /* Optional: Scale down if needed */
        /* body { transform: scale(0.95); transform-origin: top left; width: 105%; } */
    }
</style>
@endsection

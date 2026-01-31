@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Data Transaksi (Barang Keluar)</h6>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ $message }}',
            });
        </script>
        @endif

        @if(in_array(auth()->user()->role, ['superadmin', 'admin']))
        <a href="{{ route('transaksi.create') }}" class="btn btn-success mb-3">Tambah Transaksi</a>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. BBK</th>
                        <th>Pengirim</th>
                        <th>Detail Barang</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $trx)
                    <tr>
                        <td>{{ $trx->tanggal }}</td>
                        <td>{{ $trx->nomor_bbk }}</td>
                        <td>
                            {{ $trx->nama_supir }}<br>
                            <small>{{ $trx->plat_kendaraan }}</small>
                        </td>
                        <td>
                            <ul class="pl-3 mb-0">
                                @foreach($trx->details as $detail)
                                <li>
                                    {{ $detail->barang->nama_produk ?? 'N/A' }} 
                                    @if($detail->nomor_batch) <small>(Batch: {{ $detail->nomor_batch }})</small> @endif
                                    <br>
                                    <strong>Jumlah: {{ $detail->jumlah }}</strong>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $trx->keterangan }}</td>
                        <td>
                            <div style="white-space: nowrap">
                            @if(in_array(auth()->user()->role, ['superadmin', 'admin']))
                                <a href="{{ route('transaksi.edit', $trx->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                
                                <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>

                                <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-info btn-sm" title="Preview"><i class="fas fa-eye"></i></a>
                            @else
                                <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-info btn-sm" title="Preview"><i class="fas fa-eye"></i></a>
                            @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDelete(button) {
    Swal.fire({
        title: 'Yakin hapus?',
        text: "Stok akan dikembalikan! Data yang dihapus tidak dapat dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    })
}
</script>
@endsection
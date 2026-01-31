@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Riwayat Stok Barang Masuk (Manual)</h6>
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

        <a href="{{ route('stok.create') }}" class="btn btn-success mb-3">Tambah Stok Manual</a>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Detail Barang Masuk</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stok_masuk as $item)
                    <tr>
                        <td>{{ $item->tanggal }}</td>
                        <td>
                            <ul class="pl-3 mb-0">
                                @foreach($item->details as $detail)
                                <li>
                                    <strong>{{ $detail->barang->nama_produk ?? 'N/A' }}</strong> : {{ $detail->jumlah }}
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $item->keterangan }}</td>
                        <td>
                            <div style="white-space: nowrap">
                                <a href="{{ route('stok.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('stok.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
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
        text: "Stok akan berkurang! Data yang dihapus tidak dapat dikembalikan.",
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
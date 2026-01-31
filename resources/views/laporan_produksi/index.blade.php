@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Laporan Produksi</h6>
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
        <a href="{{ route('laporan_produksi.create') }}" class="btn btn-success mb-3">Tambah Laporan</a>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tgl Laporan</th>
                        <th>Batch</th>
                        <th>Detail Items (Tgl Produksi & Hasil)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produksis as $produksi)
                    <tr>
                        <td>{{ $produksi->tanggal }}</td>
                        <td>{{ $produksi->batch_produksi }}</td>
                        <td>
                            <ul class="pl-3 mb-0">
                                @foreach($produksi->details as $detail)
                                <li>
                                    <span class="badge badge-secondary">{{ $detail->tanggal_produksi }}</span>
                                    <strong>{{ $detail->barang->nama_produk ?? 'N/A' }}</strong>
                                    @if($detail->nomor_batch) <span class="badge badge-info">{{ $detail->nomor_batch }}</span> @endif
                                    <br>
                                    <small>Target: {{ $detail->target }} | Hasil: {{ $detail->hasil }} | Reject: {{ $detail->reject }}</small>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td><span class="badge badge-info">{{ $produksi->status }}</span></td>
                        <td>
                            <div style="white-space: nowrap">
                            @if(in_array(auth()->user()->role, ['superadmin', 'admin']))
                                <a href="{{ route('laporan_produksi.edit', $produksi->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                
                                <form action="{{ route('laporan_produksi.destroy', $produksi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                                
                                <a href="{{ route('laporan_produksi.show', $produksi->id) }}" class="btn btn-info btn-sm" title="Preview"><i class="fas fa-eye"></i></a>
                            @else
                                <a href="{{ route('laporan_produksi.show', $produksi->id) }}" class="btn btn-info btn-sm" title="Preview"><i class="fas fa-eye"></i></a>
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
        title: 'Yakin ingin menghapus?',
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
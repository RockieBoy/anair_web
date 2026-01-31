@extends('layout')
@section('content')
<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h1 class="m-0 font-weight-bold text-primary text-center">Tabel Produk</h1>
            </div>
            <div class="card-body">
              <div>
                  @if ($message = Session::get('success'))
                  <script>
                        Swal.fire({
                              icon: 'success',
                              title: 'Berhasil!',
                              text: '{{ $message }}',
                        });
                  </script>
                  @endif
                  <a class="btn btn-success mb-3" href="{{route('produk.create')}}">Tambah Data Produk</a>
                  <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="2">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>Harga</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No.</th>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>Harga</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach ($produk as $prod)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$prod->kode_produk}}</td>
                      <td>{{$prod->nama_produk}}</td>
                      <td>{{$prod->harga}}</td>
                      <td>
                        <form action="{{route('produk.destroy',$prod->id)}}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                            <a class="btn btn-warning" href="{{route('produk.edit',$prod->id)}}">Ubah</a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Hapus</button>
                        </form>
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
        title: 'Apakah Anda Yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
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
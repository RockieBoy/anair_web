@extends('layout')
@section('content')
<div class="row">
<div class="col-lg-12 mb-4">
<div class="card shadow mb-4">
      <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" align="center">TAMBAH DATA PRODUK</h6>
      </div>
      <div class="card-body">
            @if ($errors->any())
                  <script>
                        Swal.fire({
                              icon: 'error',
                              title: 'Gagal Validasi!',
                              html: '@foreach($errors->all() as $error) {{ $error }} <br> @endforeach',
                        });
                  </script>
            @endif
				
            <form class="user" action="{{route('produk.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf

                  <div class="form-group">
                        <Label>Kode Produk :</Label>
                        <input type="text" class="form-control" name="kode_produk" placeholder="Masukkan Kode Produk..">
                  </div>

                  <div class="form-group">
                        <Label>Nama Produk :</Label>
                        <input type="text" class="form-control" name="nama_produk" placeholder="Masukkan Nama Produk..">
                  </div>

                  <div class="form-group">
                        <Label>Harga :</Label>
                        <div class="input-group">
                              <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                              </div>
                              <input type="number" class="form-control" name="harga" placeholder="Masukkan Harga Produk.." min="0">
                        </div>
                  </div>
                        <center>
                              <button type="submit" class="btn btn-success">Simpan Data</button>
                              <a href="{{ route('produk.index') }}" class="btn btn-primary">Kembali</a>
                        </center>
                  </form>
                  
                  </div>
            </div>
</div>
</div>
@endsection
@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Pengguna Baru</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username Login" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-group">
                <label>Role / Jabatan</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="superadmin">Superadmin (Kelola User)</option>
                    <option value="admin">Admin (Gudang/Produksi)</option>
                    <option value="karyawan">Karyawan (View Only)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
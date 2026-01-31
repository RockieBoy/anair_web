@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Pengguna</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
            </div>

            <div class="form-group">
                <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="form-control" placeholder="Password Baru">
            </div>

            <div class="form-group">
                <label>Role / Jabatan</label>
                <select name="role" class="form-control" required>
                    <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin (Kelola User)</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Gudang/Produksi)</option>
                    <option value="karyawan" {{ $user->role == 'karyawan' ? 'selected' : '' }}>Karyawan (View Only)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Pengguna</button>
            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Tambah Stok Masuk (Manual)</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('stok.store') }}" method="POST">
            @csrf
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Keterangan (Opsional)</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Stok tambahan dari gudang pusat">
                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="font-weight-bold">Detail Barang</h6>
                <button type="button" class="btn btn-success btn-sm" id="add-row"><i class="fas fa-plus"></i> Tambah Baris</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="table-details">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th width="20%">Jumlah Masuk</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="item-row">
                            <td>
                                <select name="details[0][barang_id]" class="form-control" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="details[0][jumlah]" class="form-control" min="1" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <center class="mt-4">
                <button type="submit" class="btn btn-success">Simpan Stok</button>
                <a href="{{ route('stok.index') }}" class="btn btn-primary">Kembali</a>
            </center>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rowIndex = 1;

        function bindEvents(row) {
            row.querySelector('.remove-row').addEventListener('click', function() {
                if(document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                } else {
                    alert("Minimal satu baris barang harus ada.");
                }
            });
        }

        document.querySelectorAll('.item-row').forEach(row => bindEvents(row));

        document.getElementById('add-row').addEventListener('click', function () {
            const tableBody = document.querySelector('#table-details tbody');
            const firstRow = tableBody.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input').forEach(input => {
                input.value = '';
                let name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIndex}]`));
                }
            });

            newRow.querySelectorAll('select').forEach(select => {
                select.value = "";
                let name = select.getAttribute('name');
                if (name) {
                    select.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIndex}]`));
                }
            });

            bindEvents(newRow);
            tableBody.appendChild(newRow);
            rowIndex++;
        });
    });
</script>
@endsection
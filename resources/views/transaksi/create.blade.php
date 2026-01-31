@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Transaksi Barang Keluar</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Nomor Bukti Barang Keluar (BBK)</label>
                    <input type="text" name="nomor_bbk" class="form-control" placeholder="Contoh: BBK-001" required>
                </div>
            </div>

            <div class="form-row">
                 <div class="form-group col-md-6">
                    <label>Nama Supir</label>
                    <input type="text" name="nama_supir" class="form-control" placeholder="Nama Supir" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Plat Kendaraan</label>
                    <input type="text" name="plat_kendaraan" class="form-control" placeholder="B 1234 XY" required>
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"></textarea>
            </div>

            <hr>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="font-weight-bold">Detail Barang Keluar</h6>
                 <button type="button" class="btn btn-success btn-sm" id="add-row"><i class="fas fa-plus"></i> Tambah Barang</button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="table-details">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Nomor Batch (Opsional)</th>
                            <th>Jumlah Keluar (Kurangi Stok)</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="item-row">
                            <td>
                                <select name="details[0][barang_id]" class="form-control" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}">{{ $produk->nama_produk }} (Stok: {{ $produk->stok_barang->stok_saat_ini ?? 0 }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="details[0][nomor_batch]" class="form-control" placeholder="Batch">
                            </td>
                            <td>
                                <input type="number" name="details[0][jumlah]" class="form-control" placeholder="Jumlah" min="1" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Transaksi</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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
                    alert("Minimal satu barang harus ada.");
                }
            });
        }

        bindEvents(document.querySelector('.item-row'));

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
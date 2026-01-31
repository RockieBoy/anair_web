@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Transaksi Barang Keluar</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $transaksi->tanggal }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Nomor Bukti Barang Keluar (BBK)</label>
                    <input type="text" name="nomor_bbk" class="form-control" value="{{ $transaksi->nomor_bbk }}">
                </div>
            </div>

            <div class="form-row">
                 <div class="form-group col-md-6">
                    <label>Nama Supir</label>
                    <input type="text" name="nama_supir" class="form-control" value="{{ $transaksi->nama_supir }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Plat Kendaraan</label>
                    <input type="text" name="plat_kendaraan" class="form-control" value="{{ $transaksi->plat_kendaraan }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ $transaksi->keterangan }}</textarea>
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
                            <th>Nomor Batch</th>
                            <th>Jumlah Keluar</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $index => $detail)
                        <tr class="item-row">
                            <td>
                                <select name="details[{{ $index }}][barang_id]" class="form-control" required>
                                    @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}" {{ $detail->barang_id == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="details[{{ $index }}][nomor_batch]" class="form-control" value="{{ $detail->nomor_batch }}">
                            </td>
                            <td>
                                <input type="number" name="details[{{ $index }}][jumlah]" class="form-control" value="{{ $detail->jumlah }}" min="1" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <center>
                <button type="submit" class="btn btn-success">Update Transaksi</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-primary">Kembali</a>
            </center>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rowIndex = {{ count($transaksi->details) }};

        function bindEvents(row) {
            row.querySelector('.remove-row').addEventListener('click', function() {
                if(document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                } else {
                    alert("Minimal satu barang harus ada.");
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
                // select.value = "";
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
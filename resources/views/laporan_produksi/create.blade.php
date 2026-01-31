@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Laporan Produksi</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('laporan_produksi.store') }}" method="POST" id="formProduksi">
            @csrf
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tanggal Membuat Laporan</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Batch Produksi</label>
                    <input type="text" name="batch_produksi" class="form-control" placeholder="Contoh: BATCH-001" required>
                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="font-weight-bold">Detail Barang Produksi</h6>
                <button type="button" class="btn btn-success btn-sm" id="add-row"><i class="fas fa-plus"></i> Tambah Barang</button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="table-details">
                    <thead>
                        <tr>
                            <th width="12%">Tanggal Produksi</th>
                            <th width="15%">Nomor Batch</th>
                            <th width="25%">Barang</th>
                            <th width="12%">Target</th>
                            <th width="12%">Hasil (Stok)</th>
                            <th width="12%">Reject (Auto)</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="item-row">
                             <td>
                                <input type="date" name="details[0][tanggal_produksi]" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </td>
                            <td>
                                <input type="text" name="details[0][nomor_batch]" class="form-control" placeholder="BATCH-Item" required>
                            </td>
                            <td>
                                <select name="details[0][barang_id]" class="form-control" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}">{{ $produk->nama_produk }} ({{ $produk->kode_produk }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="details[0][target]" class="form-control target-input" placeholder="0" min="1" required>
                            </td>
                            <td>
                                <input type="number" name="details[0][hasil]" class="form-control hasil-input" placeholder="0" min="0" required>
                            </td>
                            <td>
                                <input type="number" class="form-control reject-input" placeholder="0" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Laporan</button>
            <a href="{{ route('laporan_produksi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rowIndex = 1;

        // Function to bind calculation events
        function bindEvents(row) {
            const targetInput = row.querySelector('.target-input');
            const hasilInput = row.querySelector('.hasil-input');
            const rejectInput = row.querySelector('.reject-input');

            function calculateReject() {
                const target = parseInt(targetInput.value) || 0;
                const hasil = parseInt(hasilInput.value) || 0;
                const reject = target - hasil;
                rejectInput.value = reject < 0 ? 0 : reject;
            }

            targetInput.addEventListener('input', calculateReject);
            hasilInput.addEventListener('input', calculateReject);

            // Remove row event
            row.querySelector('.remove-row').addEventListener('click', function() {
                if(document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                } else {
                    alert("Minimal satu barang harus ada.");
                }
            });
        }

        // Bind initial row
        bindEvents(document.querySelector('.item-row'));

        // Add Row Logic
        document.getElementById('add-row').addEventListener('click', function () {
            const tableBody = document.querySelector('#table-details tbody');
            const firstRow = tableBody.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);

            // Reset inputs
            newRow.querySelectorAll('input').forEach(input => {
                input.value = input.type === 'date' ? "{{ date('Y-m-d') }}" : '';
                // Update name attributes for array structure
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

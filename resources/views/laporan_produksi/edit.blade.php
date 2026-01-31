@extends('layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Laporan Produksi</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('laporan_produksi.update', $produksi->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Tanggal Laporan</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $produksi->tanggal }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Batch Produksi</label>
                    <input type="text" class="form-control" value="{{ $produksi->batch_produksi }}" readonly>
                </div>
                 <div class="form-group col-md-4">
                    <label>Status</label>
                     <select name="status" class="form-control">
                        <option value="berjalan" {{ $produksi->status == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="sukses" {{ $produksi->status == 'sukses' ? 'selected' : '' }}>Sukses</option>
                     </select>
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
                            <th width="12%">Hasil</th>
                            <th width="12%">Reject (Auto)</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produksi->details as $index => $detail)
                        <tr class="item-row">
                            <td>
                                <input type="date" name="details[{{ $index }}][tanggal_produksi]" class="form-control" value="{{ $detail->tanggal_produksi }}" required>
                            </td>
                            <td>
                                <input type="text" name="details[{{ $index }}][nomor_batch]" class="form-control" value="{{ $detail->nomor_batch }}" required>
                            </td>
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
                                <input type="number" name="details[{{ $index }}][target]" class="form-control target-input" value="{{ $detail->target }}" required>
                            </td>
                            <td>
                                <input type="number" name="details[{{ $index }}][hasil]" class="form-control hasil-input" value="{{ $detail->hasil }}" required>
                            </td>
                             <td>
                                <input type="number" class="form-control reject-input" value="{{ $detail->target - $detail->hasil }}" readonly>
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
                <button type="submit" class="btn btn-success">Update Laporan</button>
                <a href="{{ route('laporan_produksi.index') }}" class="btn btn-primary">Kembali</a>
            </center>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rowIndex = {{ count($produksi->details) }};

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

            row.querySelector('.remove-row').addEventListener('click', function() {
                if(document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                } else {
                    alert("Minimal satu barang harus ada.");
                }
            });
        }

        // Bind existing rows
        document.querySelectorAll('.item-row').forEach(row => bindEvents(row));

        // Add Row Logic
        document.getElementById('add-row').addEventListener('click', function () {
            const tableBody = document.querySelector('#table-details tbody');
            const firstRow = tableBody.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input').forEach(input => {
                if (input.type === 'date') return; // Keep date or reset to today? Let's keep copied or reset.
                if (input.classList.contains('reject-input')) { input.value = ''; return; }
                input.value = '';
                
                let name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIndex}]`));
                }
            });

            newRow.querySelectorAll('select').forEach(select => {
                // select.value = ""; // Keep selected or reset? Reset.
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

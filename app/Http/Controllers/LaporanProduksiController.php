<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\Produk;
use App\Models\ProduksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanProduksiController extends Controller
{
    public function index()
    {
        $produksis = Produksi::with(['details.barang'])->latest()->get();
        return view('laporan_produksi.index', compact('produksis'));
    }

    public function show($id)
    {
        $produksi = Produksi::with('details.barang')->findOrFail($id);
        return view('laporan_produksi.show', compact('produksi'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('laporan_produksi.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'batch_produksi' => 'required|string|unique:laporan_produksi,batch_produksi',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:tbl_produk,id',
            'details.*.nomor_batch' => 'required|string', 
            'details.*.tanggal_produksi' => 'required|date', // Validasi per item
            'details.*.target' => 'required|integer|min:1',
            'details.*.hasil' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $produksi = Produksi::create([
                'tanggal' => $request->tanggal,
                'batch_produksi' => $request->batch_produksi, // Header batch usually for report ID now? Or maybe user meant remove it? User said "1 transaksi si batch nya gpp kalua masih ada sebagai nomor laporan". So keep it.
                'status' => 'berjalan', 
            ]);

            foreach ($request->details as $detail) {
                $target = $detail['target'];
                $hasil = $detail['hasil'];
                $reject = $target - $hasil;
                if ($reject < 0) $reject = 0; 

                ProduksiDetail::create([
                    'laporan_produksi_id' => $produksi->id,
                    'barang_id' => $detail['barang_id'],
                    'nomor_batch' => $detail['nomor_batch'],
                    'tanggal_produksi' => $detail['tanggal_produksi'], 
                    'target' => $target,
                    'hasil' => $hasil,
                    'reject' => $reject,
                ]);
            }
        });

        return redirect()->route('laporan_produksi.index')->with('success', 'Laporan Produksi berhasil dibuat.');
    }

    public function edit($id)
    {
        $produksi = Produksi::with('details')->findOrFail($id);
        $produks = Produk::all();
        return view('laporan_produksi.edit', compact('produksi', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:tbl_produk,id',
            'details.*.nomor_batch' => 'required|string',
            'details.*.tanggal_produksi' => 'required|date',
            'details.*.target' => 'required|integer|min:1',
            'details.*.hasil' => 'required|integer|min:0',
        ]);

        $produksi = Produksi::findOrFail($id);

        DB::transaction(function () use ($request, $produksi) {
            $produksi->update([
                'tanggal' => $request->tanggal,
                'status' => $request->status,
            ]);

            $produksi->details()->delete();

            foreach ($request->details as $detail) {
                 $target = $detail['target'];
                $hasil = $detail['hasil'];
                $reject = $target - $hasil;
                if ($reject < 0) $reject = 0; 

                ProduksiDetail::create([
                    'laporan_produksi_id' => $produksi->id,
                    'barang_id' => $detail['barang_id'],
                    'nomor_batch' => $detail['nomor_batch'],
                    'tanggal_produksi' => $detail['tanggal_produksi'],
                    'target' => $target,
                    'hasil' => $hasil,
                    'reject' => $reject,
                ]);
            }
        });

        return redirect()->route('laporan_produksi.index')->with('success', 'Laporan Produksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produksi->details()->delete(); 
        $produksi->delete();
        return redirect()->route('laporan_produksi.index')->with('success', 'Laporan Produksi dihapus.');
    }
}

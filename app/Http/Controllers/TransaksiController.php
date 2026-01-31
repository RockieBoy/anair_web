<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['details.barang'])->latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('details.barang')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('transaksi.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_bbk' => 'required|string|unique:transaksi,nomor_bbk',
            'nama_supir' => 'required|string',
            'plat_kendaraan' => 'required|string',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:tbl_produk,id',
            'details.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $transaksi = Transaksi::create([
                'tanggal' => $request->tanggal,
                'nomor_bbk' => $request->nomor_bbk,
                'nama_supir' => $request->nama_supir,
                'plat_kendaraan' => $request->plat_kendaraan,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->details as $detail) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $detail['barang_id'],
                    'nomor_batch' => $detail['nomor_batch'] ?? null,
                    'jumlah' => $detail['jumlah'],
                ]);
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi Keluar berhasil dibuat.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id);
        $produks = Produk::all();
        return view('transaksi.edit', compact('transaksi', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_bbk' => 'required|string|unique:transaksi,nomor_bbk,' . $id,
            'nama_supir' => 'required|string',
            'plat_kendaraan' => 'required|string',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:tbl_produk,id',
            'details.*.jumlah' => 'required|integer|min:1',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        DB::transaction(function () use ($request, $transaksi) {
            $transaksi->update([
                'tanggal' => $request->tanggal,
                'nomor_bbk' => $request->nomor_bbk,
                'nama_supir' => $request->nama_supir,
                'plat_kendaraan' => $request->plat_kendaraan,
                'keterangan' => $request->keterangan,
            ]);

            // Sync details: Delete old (reverses stock via Observer), create new (deducts stock via Observer)
            $transaksi->details()->delete();

            foreach ($request->details as $detail) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $detail['barang_id'],
                    'nomor_batch' => $detail['nomor_batch'] ?? null,
                    'jumlah' => $detail['jumlah'],
                ]);
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->details()->delete(); // Reverses stock
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi dihapus.');
    }
}

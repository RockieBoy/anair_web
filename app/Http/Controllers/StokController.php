<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\DetailStokMasuk;
use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display the History of Stok Masuk
     */
    public function index()
    {
        $stok_masuk = StokMasuk::with('details.barang')->latest()->get();
        return view('tambah_stok.index', compact('stok_masuk'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('tambah_stok.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:tbl_produk,id',
            'details.*.jumlah' => 'required|integer|min:1',
        ]);

        $stokMasuk = StokMasuk::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        foreach ($request->details as $detail) {
            DetailStokMasuk::create([
                'stok_masuk_id' => $stokMasuk->id,
                'barang_id' => $detail['barang_id'],
                'jumlah' => $detail['jumlah'],
            ]);
        }

        return redirect()->route('stok.index')->with('success', 'Stok manual berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stok_masuk = StokMasuk::with('details')->findOrFail($id);
        $produks = Produk::all();
        return view('tambah_stok.edit', compact('stok_masuk', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:tbl_produk,id',
            'details.*.jumlah' => 'required|integer|min:1',
        ]);

        $stokMasuk = StokMasuk::findOrFail($id);
        $stokMasuk->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        // Basic Sync Logic: Delete all and recreate (or finer grained if preferred, this is simpler)
        // Note: Check if Observer handles deletion correctly. Yes, 'deleted' event decrements stock.
        // But we want to 'update' effectively.
        // If we delete all details, stock decreases. Then we create new, stock increases. Net effect correct.
        
        foreach ($stokMasuk->details as $detail) {
            $detail->delete();
        }

        foreach ($request->details as $detail) {
            DetailStokMasuk::create([
                'stok_masuk_id' => $stokMasuk->id,
                'barang_id' => $detail['barang_id'],
                'jumlah' => $detail['jumlah'],
            ]);
        }

        return redirect()->route('stok.index')->with('success', 'Data stok manual diperbarui.');
    }

    public function destroy($id)
    {
        $stokMasuk = StokMasuk::findOrFail($id);
        // Deleting header should cascade delete details via DB foreign key, 
        // BUT Eloquent Observers might not fire on cascade delete unless we iterate.
        // Let's iterate to be safe and ensure Observer 'deleted' fires to correct stock.
        
        foreach ($stokMasuk->details as $detail) {
            $detail->delete();
        }
        
        $stokMasuk->delete();
        
        return redirect()->route('stok.index')->with('success', 'Data stok manual dihapus.');
    }
}

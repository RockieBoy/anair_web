<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use Illuminate\Http\Request;


class ProdukController extends Controller
{

    public function index()
    {
        $produk = Produk::get();
        return view('produk.index',compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk'=> 'required',
            'nama_produk'=> 'required',
            'harga'=> 'required',
        ]);

        Produk::create([
            'kode_produk'=> $request->kode_produk,
            'nama_produk'=> $request->nama_produk,
            'harga'=> $request->harga,
        ]);

        return redirect()->route('produk.index')
                        ->with('success','Produk created Successfully.');
    }

    public function edit(Produk $produk)
    {
        
        return view('produk.edit',compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {

            $request->validate([
            'kode_produk' => 'required',
            'nama_produk' => 'required',
            'harga' => 'required',
        ]);

        
        $produk->update([
                'kode_produk' => $request->kode_produk,
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
            ]);

        return redirect()->route('produk.index')->with('success', 'Data Produk Berhasil di Edit.');
    }

    public function destroy(Produk $produk)
    {

        $produk->delete();

        return redirect()->route('produk.index')->with('success','Data berhasil dihapus ');
    }
}

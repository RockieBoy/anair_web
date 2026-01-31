<?php

namespace App\Observers;

use App\Models\BarangMasuk;
use App\Models\Stok;

class BarangMasukObserver
{
    /**
     * Handle the BarangMasuk "created" event.
     */
    public function created(BarangMasuk $barangMasuk): void
    {
        $stok = Stok::firstOrCreate(
            ['barang_id' => $barangMasuk->barang_id],
            ['stok_saat_ini' => 0]
        );

        $stok->stok_saat_ini += $barangMasuk->jumlah;
        $stok->save();
    }

    /**
     * Handle the BarangMasuk "updated" event.
     */
    public function updated(BarangMasuk $barangMasuk): void
    {
        $selisih = $barangMasuk->jumlah - $barangMasuk->getOriginal('jumlah');
        if ($selisih != 0) {
            $stok = Stok::firstOrCreate(
                ['barang_id' => $barangMasuk->barang_id],
                ['stok_saat_ini' => 0]
            );
            $stok->stok_saat_ini += $selisih;
            $stok->save();
        }
    }

    /**
     * Handle the BarangMasuk "deleted" event.
     */
    public function deleted(BarangMasuk $barangMasuk): void
    {
        $stok = Stok::where('barang_id', $barangMasuk->barang_id)->first();
        if ($stok) {
            $stok->stok_saat_ini -= $barangMasuk->jumlah;
            $stok->save();
        }
    }
}

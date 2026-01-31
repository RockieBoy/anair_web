<?php

namespace App\Observers;

use App\Models\DetailStokMasuk;
use App\Models\Stok;

class DetailStokMasukObserver
{
    /**
     * Handle the DetailStokMasuk "created" event.
     */
    public function created(DetailStokMasuk $detail)
    {
        $stok = Stok::firstOrCreate(
            ['barang_id' => $detail->barang_id],
            ['stok_saat_ini' => 0]
        );
        $stok->increment('stok_saat_ini', $detail->jumlah);
    }

    /**
     * Handle the DetailStokMasuk "updated" event.
     */
    public function updated(DetailStokMasuk $detail)
    {
        // Revert old stock
        $stok = Stok::where('barang_id', $detail->getOriginal('barang_id'))->first();
        if ($stok) {
            $stok->decrement('stok_saat_ini', $detail->getOriginal('jumlah'));
        }

        // Apply new stock
        $stok = Stok::firstOrCreate(
            ['barang_id' => $detail->barang_id],
            ['stok_saat_ini' => 0]
        );
        $stok->increment('stok_saat_ini', $detail->jumlah);
    }

    /**
     * Handle the DetailStokMasuk "deleted" event.
     */
    public function deleted(DetailStokMasuk $detail)
    {
        $stok = Stok::where('barang_id', $detail->barang_id)->first();
        if ($stok) {
            $stok->decrement('stok_saat_ini', $detail->jumlah);
        }
    }
}

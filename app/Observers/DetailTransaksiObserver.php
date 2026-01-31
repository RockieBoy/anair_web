<?php

namespace App\Observers;

use App\Models\DetailTransaksi;
use App\Models\Stok;

class DetailTransaksiObserver
{
    /**
     * Handle the DetailTransaksi "created" event.
     */
    public function created(DetailTransaksi $detailTransaksi): void
    {
        $stok = Stok::firstOrCreate(
            ['barang_id' => $detailTransaksi->barang_id],
            ['stok_saat_ini' => 0]
        );

        $stok->stok_saat_ini -= $detailTransaksi->jumlah;
        $stok->save();
    }
}

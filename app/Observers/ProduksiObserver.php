<?php

namespace App\Observers;

use App\Models\Produksi;

class ProduksiObserver
{
    /**
     * Handle the Produksi "updated" event.
     */
    public function updated(Produksi $produksi): void
    {
        // Logic penghitungan stok dipindah ke ProduksiDetailObserver
        // Observer ini hanya memantau perubahan header jika diperlukan di masa depan
    }
}

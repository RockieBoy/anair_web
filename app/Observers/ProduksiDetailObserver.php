<?php

namespace App\Observers;

use App\Models\ProduksiDetail;
use App\Models\Stok;

class ProduksiDetailObserver
{
    /**
     * Handle the ProduksiDetail "created" event.
     */
    public function created(ProduksiDetail $detail): void
    {
        $this->updateStok($detail->barang_id, $detail->hasil);
    }

    /**
     * Handle the ProduksiDetail "updated" event.
     */
    public function updated(ProduksiDetail $detail): void
    {
        // Hitung selisih jika ada perubahan pada hasil produksi
        $selisih = $detail->hasil - $detail->getOriginal('hasil');
        if ($selisih != 0) {
            $this->updateStok($detail->barang_id, $selisih);
        }
    }

    /**
     * Handle the ProduksiDetail "deleted" event.
     */
    public function deleted(ProduksiDetail $detail): void
    {
        // Kembalikan stok jika data dihapus (kurangi stok yang sudah ditambah)
        $this->updateStok($detail->barang_id, -$detail->hasil);
    }

    /**
     * Helper function untuk update stok
     */
    private function updateStok($barangId, $jumlah)
    {
        if ($jumlah == 0) return;

        $stok = Stok::firstOrCreate(
            ['barang_id' => $barangId],
            ['stok_saat_ini' => 0]
        );

        $stok->stok_saat_ini += $jumlah;
        $stok->save();
    }
}

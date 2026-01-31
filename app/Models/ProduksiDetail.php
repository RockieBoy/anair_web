<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_produksi';

    protected $fillable = [
        'laporan_produksi_id',
        'barang_id',
        'nomor_batch',
        'tanggal_produksi', // Moved here
        'target',
        'hasil',
        'reject',
    ];

    public function laporan_produksi()
    {
        return $this->belongsTo(Produksi::class, 'laporan_produksi_id');
    }

    public function barang()
    {
        return $this->belongsTo(Produk::class, 'barang_id');
    }
}
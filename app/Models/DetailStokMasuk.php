<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStokMasuk extends Model
{
    use HasFactory;

    protected $table = 'detail_stok_masuk';

    protected $fillable = [
        'stok_masuk_id',
        'barang_id',
        'jumlah',
    ];

    public function barang()
    {
        return $this->belongsTo(Produk::class, 'barang_id');
    }

    public function header()
    {
        return $this->belongsTo(StokMasuk::class, 'stok_masuk_id');
    }
}

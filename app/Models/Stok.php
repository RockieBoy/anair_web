<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok_barang';

    protected $fillable = [
        'barang_id',
        'stok_saat_ini',
        // 'last_updated' is handled by timestamp column definition but can be added if manual override needed
    ];

    public function barang()
    {
        return $this->belongsTo(Produk::class, 'barang_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'tbl_produk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'harga',
    ];

    public function stok_barang()
    {
        return $this->hasOne(Stok::class, 'barang_id');
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;

    protected $table = 'laporan_produksi';

    protected $fillable = [
        'tanggal', // Tanggal Laporan
        'batch_produksi',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(ProduksiDetail::class, 'laporan_produksi_id');
    }
}

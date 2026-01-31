<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;

    protected $table = 'stok_masuk';

    protected $fillable = [
        'tanggal',
        'keterangan',
    ];

    public function details()
    {
        return $this->hasMany(DetailStokMasuk::class, 'stok_masuk_id');
    }
}

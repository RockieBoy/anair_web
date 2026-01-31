<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'tanggal',
        'nomor_bbk',
        'nama_supir',
        'plat_kendaraan',
        'keterangan',
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}

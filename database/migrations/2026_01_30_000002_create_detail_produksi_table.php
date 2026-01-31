<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_produksi_id')->constrained('laporan_produksi')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('tbl_produk')->onDelete('cascade');
            $table->date('tanggal_produksi')->nullable();
            $table->integer('target');
            $table->integer('hasil');
            $table->integer('reject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_produksi');
    }
};

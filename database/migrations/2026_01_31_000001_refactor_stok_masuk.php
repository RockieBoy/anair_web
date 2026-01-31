<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Rename existing table to be the Header
        if (Schema::hasTable('barang_masuk') && !Schema::hasTable('stok_masuk')) {
            // Drop foreign key BEFORE renaming to avoid naming confusion
            Schema::table('barang_masuk', function (Blueprint $table) {
                // We use try-catch because in some dev environments the FK might be missing or named differently
                try {
                    $table->dropForeign(['barang_id']); 
                } catch (\Exception $e) {
                    // Fallback: try explicit predictable name
                    try {
                        $table->dropForeign('barang_masuk_barang_id_foreign');
                    } catch (\Exception $e2) {}
                }
            });
            
            Schema::rename('barang_masuk', 'stok_masuk');
        }

        if (Schema::hasTable('stok_masuk')) {
            Schema::table('stok_masuk', function (Blueprint $table) {
                // Drop columns that moved to detail
                if (Schema::hasColumn('stok_masuk', 'barang_id')) {
                    // Just in case rename happened but drop didn't (interrupted migration)
                    try {
                        $table->dropForeign(['barang_id']); // This now refers to stok_masuk_barang_id_foreign
                    } catch (\Exception $e) {}
                    
                    $table->dropColumn('barang_id');
                }
                
                if (Schema::hasColumn('stok_masuk', 'jumlah')) {
                    $table->dropColumn('jumlah');
                }
            });
        }

        // 2. Create Detail table
        if (!Schema::hasTable('detail_stok_masuk')) {
            Schema::create('detail_stok_masuk', function (Blueprint $table) {
                $table->id();
                $table->foreignId('stok_masuk_id')->constrained('stok_masuk')->onDelete('cascade');
                $table->foreignId('barang_id')->constrained('tbl_produk')->onDelete('cascade');
                $table->integer('jumlah');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_stok_masuk');
        
        if (Schema::hasTable('stok_masuk')) {
            Schema::table('stok_masuk', function (Blueprint $table) {
                $table->foreignId('barang_id')->constrained('tbl_produk')->onDelete('cascade');
                $table->integer('jumlah')->default(0); // Add default to avoid error on creation
            });

            if (!Schema::hasTable('barang_masuk')) {
                Schema::rename('stok_masuk', 'barang_masuk');
            }
        }
    }
};

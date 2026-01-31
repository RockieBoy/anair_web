<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        \App\Models\Produksi::observe(\App\Observers\ProduksiObserver::class);
        \App\Models\ProduksiDetail::observe(\App\Observers\ProduksiDetailObserver::class);
        \App\Models\DetailTransaksi::observe(\App\Observers\DetailTransaksiObserver::class);
        \App\Models\DetailStokMasuk::observe(\App\Observers\DetailStokMasukObserver::class);
    }
}

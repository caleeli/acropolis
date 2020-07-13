<?php

namespace App\Providers;

use App\Aporte;
use App\Diario;
use App\Observers\AporteObserver;
use App\Observers\DiarioObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Diario::observe(DiarioObserver::class);
        Aporte::observe(AporteObserver::class);
    }
}

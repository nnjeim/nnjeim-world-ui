<?php

namespace App\Providers;

use App\Services\TrustedProxyGeolocateService;
use Illuminate\Support\ServiceProvider;
use Nnjeim\World\Geolocate\GeolocateService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(
            GeolocateService::class,
            fn (): TrustedProxyGeolocateService => new TrustedProxyGeolocateService,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

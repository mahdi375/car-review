<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();
    }

    public function map(): void
    {
        $this->mapApiRoutes();
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(600);
        });
    }

    private function mapApiRoutes()
    {
        Route::prefix('api/v1')
            ->name('v1.')
            ->middleware('api')
            ->group(base_path('routes/v1/api.php'));
    }
}

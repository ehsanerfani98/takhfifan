<?php

namespace App\Providers;

use App\Services\Zarinpal\ZarinPalService;
use Illuminate\Support\ServiceProvider;

class ZarinPalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge configuration
        $this->mergeConfigFrom(
            config_path('zarinpal.php'), 'zarinpal'
        );

        // Register ZarinPal service as a singleton
        $this->app->singleton('zarinpal', function ($app) {
            return new ZarinPalService(
                get_setting('merchantId'),
                boolval(get_setting('payment_gateway_status'))
            );
        });

        // Also bind ZarinPalService so it can be type-hinted
        $this->app->bind(ZarinPalService::class, function ($app) {
            return $app->make('zarinpal');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/zarinpal.php' => config_path('zarinpal.php'),
        ], 'zarinpal-config');
    }
}
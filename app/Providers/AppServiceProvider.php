<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator; // Required for pagination control

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
        /**
         * Forces HTTPS scheme in production environment
         */
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        /**
         * Tell Laravel to use Tailwind CSS for pagination views.
         * This ensures {{ $variable->links() }} renders the correct HTML.
         */
        Paginator::useTailwind();
    }
}
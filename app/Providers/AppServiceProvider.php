<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Don't forget this!
use App\Models\Supplier;             // Ensure your Model path is correct

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
        // This shares the 'suppliers' variable with 'layouts.app' 
        // every single time it is rendered, regardless of the controller.
        View::composer('layouts.app', function ($view) {
            $view->with('suppliers', Supplier::all());
        });
    }
}
<?php

namespace App\Providers;

use App\Policies\MessagePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('store_message', [MessagePolicy::class, 'store']);
        Gate::define('edit_message', [MessagePolicy::class, 'edit']);
        Gate::define('destroy_message', [MessagePolicy::class, 'destroy']);

    }
}

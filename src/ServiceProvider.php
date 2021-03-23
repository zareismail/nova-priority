<?php

namespace Zareismail\NovaPriority;

use Illuminate\Support\Facades\Gate; 
use Illuminate\Contracts\Support\DeferrableProvider; 
use Illuminate\Support\ServiceProvider as LaravelServiceProvider; 
use Laravel\Nova\Nova as LaravelNova; 

class ServiceProvider extends LaravelServiceProvider implements DeferrableProvider
{ 
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/nova-priority'),
        ], 'lang');

        Gate::policy(Models\NovaPriority::class, Policies\Priority::class);

        LaravelNova::resources([
            Nova\Priority::class,
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the events that trigger this service provider to register.
     *
     * @return array
     */
    public function when()
    {
        return [
            \Laravel\Nova\Events\ServingNova::class,
            \Illuminate\Console\Events\ArtisanStarting::class,
        ];
    }
}

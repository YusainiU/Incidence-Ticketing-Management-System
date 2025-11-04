<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LogAdministration extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton('TicketLogService', function ($app) {
            return new \App\Actions\LogManagement\LogAdministration;
        });   
    }
}

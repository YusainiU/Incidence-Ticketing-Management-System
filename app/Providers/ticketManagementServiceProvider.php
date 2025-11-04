<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ticketManagementServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind a singleton
        // $this->app->singleton('TicketService', function ($app) {
        //     return new \App\Actions\TicketManagement\TicketAdministration;
        // });    
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->app->singleton('TicketService', function ($app) {
            return new \App\Actions\TicketManagement\TicketAdministration;
        });          
    }
}

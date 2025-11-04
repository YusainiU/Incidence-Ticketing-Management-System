<?php

namespace App\Providers;

use App\Actions\TicketManagement\TicketAdministration;
use App\Livewire\AddUserToRole;
use Illuminate\Support\ServiceProvider;
use App\Actions\Steps\StepsUserRoles;


class StepsUserRolesServiceProvider extends ServiceProvider
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
        $this->app->singleton(StepsUserRoles::class);      
    }
}

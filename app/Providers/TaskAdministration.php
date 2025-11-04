<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TaskAdministration extends ServiceProvider
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
        $this->app->singleton('TaskService', function ($app) {
            return new \App\Actions\TaskManagement\TaskAdministration;
        });           
    }
}

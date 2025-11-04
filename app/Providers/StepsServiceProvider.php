<?php

namespace App\Providers;

use App\Actions\Fortify\StepsCreateNewUser;
use App\Actions\Steps\Calendar;
use App\Actions\Steps\PublicHoliday;
use App\Actions\Steps\AccessVerification;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
class StepsServiceProvider extends ServiceProvider
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

        Fortify::createUsersUsing(StepsCreateNewUser::class);
        $this->app->singleton(PublicHoliday::class);
        $this->app->singleton(Calendar::class);
        $this->app->singleton(AccessVerification::class); 
        
    }
}

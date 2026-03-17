<?php

namespace App\Providers;

use App\Events\ReservationCreated;
use App\Listeners\LogReservationCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);

        Event::listen(
            ReservationCreated::class,
            LogReservationCreated::class
        );
    }
}

<?php

namespace Slsabil\LaravelHotelBooking;

use Illuminate\Support\ServiceProvider;

class HotelBookingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // تحميل الميجريشنز من الباكيج تلقائيًا
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register()
    {
        //
    }
}

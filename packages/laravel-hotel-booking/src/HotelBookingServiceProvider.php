<?php

namespace Slsabil\LaravelHotelBooking;

use Illuminate\Support\ServiceProvider;
use Slsabil\LaravelHotelBooking\Services\BookingService;
use Illuminate\Support\Facades\Event;
use Slsabil\LaravelHotelBooking\Events\BookingStatusChanged;
use Slsabil\LaravelHotelBooking\Events\BookingCancelled;
use Slsabil\LaravelHotelBooking\Listeners\SendBookingStatusNotification;
use Slsabil\LaravelHotelBooking\Listeners\HandleBookingCancellation;

class HotelBookingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // تحميل الميجريشنز من الباكيج تلقائيًا
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // تحميل الفاكتوريز في حال وجودها داخل الباكيج
        $this->loadFactoriesFrom(__DIR__.'/../database/factories');

        // نشر ملفات التهيئة
        $this->publishes([
            __DIR__.'/../config/hotel-booking.php' => config_path('hotel-booking.php'),
        ], 'config');

        // تسجيل Listeners للأحداث
        Event::listen(
            BookingStatusChanged::class,
            [SendBookingStatusNotification::class, 'handle']
        );

        Event::listen(
            BookingCancelled::class,
            [HandleBookingCancellation::class, 'handle']
        );
    }

    public function register()
    {
        // دمج التهيئة الافتراضية
       // $this->mergeConfigFrom(  __DIR__.'/../config/hotel-booking.php', 'hotel-booking'  );

        // تسجيل BookingService في الـ container
        $this->app->singleton(BookingService::class, function ($app) {
            return new BookingService();
        });
    }
}

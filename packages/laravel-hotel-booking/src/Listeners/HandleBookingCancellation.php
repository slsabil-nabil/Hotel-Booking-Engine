<?php

namespace Slsabil\LaravelHotelBooking\Listeners;

use Slsabil\LaravelHotelBooking\Events\BookingCancelled;
use Illuminate\Support\Facades\Log;

class HandleBookingCancellation
{
    public function handle(BookingCancelled $event)
    {
        // مثال على منطق بسيط عند إلغاء الحجز
        Log::info('Booking cancelled', [
            'booking_id' => $event->booking->id,
        ]);
    }
}

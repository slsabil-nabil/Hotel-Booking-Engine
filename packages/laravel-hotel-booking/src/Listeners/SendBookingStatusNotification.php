<?php

namespace Slsabil\LaravelHotelBooking\Listeners;

use Slsabil\LaravelHotelBooking\Events\BookingStatusChanged;
use Illuminate\Support\Facades\Log;

class SendBookingStatusNotification
{
    public function handle(BookingStatusChanged $event)
    {
        // مثال بسيط لإرسال إشعار عند تغيير حالة الحجز
        Log::info('Booking status changed', [
            'booking_id' => $event->booking->id,
            'new_status' => $event->booking->status,
        ]);
    }
}

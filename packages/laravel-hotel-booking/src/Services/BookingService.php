<?php

namespace Slsabil\LaravelHotelBooking\Services;

use Slsabil\LaravelHotelBooking\Models\Booking;
use Slsabil\LaravelHotelBooking\Events\BookingStatusChanged;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;

class BookingService
{
    public function createBooking(array $data): Booking
    {
        $data['status'] = 'pending';
        $data['reference'] = (string) Str::uuid();

        $booking = Booking::create($data);

        // إطلاق الحدث مباشرة بعد إنشاء الحجز
        Event::dispatch(new BookingStatusChanged($booking));

        return $booking;
    }

    public function processPayment(Booking $booking): Booking
    {
        $booking->status = 'paid';
        $booking->save();

        Event::dispatch(new BookingStatusChanged($booking));

        return $booking;
    }
}

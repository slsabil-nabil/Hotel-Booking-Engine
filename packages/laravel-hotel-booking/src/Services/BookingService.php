<?php

namespace Slsabil\LaravelHotelBooking\Services;

use Slsabil\LaravelHotelBooking\Models\Booking;
use Slsabil\LaravelHotelBooking\Events\BookingStatusChanged;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Carbon\Carbon;
use Exception;

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
        $booking->paid_at = Carbon::now();  // تسجيل وقت الدفع الحالي
        $booking->save();

        Event::dispatch(new BookingStatusChanged($booking));

        return $booking;
    }

    public function cancelBooking(Booking $booking): Booking
    {
        $now = Carbon::now();
        $cutoff = Carbon::parse($booking->check_in_date)->subDay(); // 24 ساعة قبل الوصول

        if ($now->greaterThan($cutoff)) {
            throw new Exception('Cancellation is not allowed within 24 hours of check-in.');
        }

        $booking->status = 'canceled';
        $booking->cancelled_at = $now;
        $booking->save();

        Event::dispatch(new BookingStatusChanged($booking));

        return $booking;
    }
}

<?php

namespace Slsabil\LaravelHotelBooking\Services;

use Slsabil\LaravelHotelBooking\Models\Booking;
use Carbon\Carbon;

class AvailabilityService
{
    public function isAvailable(int $roomId, string $startDate, string $endDate): bool
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // نتحقق إذا في حجز يتعارض مع التواريخ المدخلة
        $conflictingBookingExists = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('check_in_date', [$start, $end])
                      ->orWhereBetween('check_out_date', [$start, $end])
                      ->orWhere(function ($query) use ($start, $end) {
                          $query->where('check_in_date', '<=', $start)
                                ->where('check_out_date', '>=', $end);
                      });
            })
            ->where('status', '!=', 'canceled') // نتجاهل الحجوزات الملغاة
            ->exists();

        return !$conflictingBookingExists;
    }
}

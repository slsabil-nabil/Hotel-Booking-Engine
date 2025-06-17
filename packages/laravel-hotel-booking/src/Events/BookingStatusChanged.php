<?php

namespace Slsabil\LaravelHotelBooking\Events;

use Illuminate\Queue\SerializesModels;
use Slsabil\LaravelHotelBooking\Models\Booking;

class BookingStatusChanged
{
    use SerializesModels;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }
}

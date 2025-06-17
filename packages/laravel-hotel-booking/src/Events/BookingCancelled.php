<?php

namespace Slsabil\LaravelHotelBooking\Events;

use Illuminate\Queue\SerializesModels;
use Slsabil\LaravelHotelBooking\Models\Booking;

class BookingCancelled
{
    use SerializesModels;

    public Booking $booking;
    public ?string $reason;

    public function __construct(Booking $booking, ?string $reason = null)
    {
        $this->booking = $booking;
        $this->reason = $reason;
    }
}

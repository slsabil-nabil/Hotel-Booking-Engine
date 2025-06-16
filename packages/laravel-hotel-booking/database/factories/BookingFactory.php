<?php

namespace Slsabil\LaravelHotelBooking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Slsabil\LaravelHotelBooking\Models\Booking;
use Slsabil\LaravelHotelBooking\Models\Room;
use App\Models\User;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        $checkIn = $this->faker->dateTimeBetween('now', '+1 month');
        $checkOut = $this->faker->dateTimeBetween($checkIn, '+2 months');

        return [
            'room_id' => Room::factory(),
            'user_id' => User::factory(),
            'check_in_date' => $checkIn->format('Y-m-d'),
            'check_out_date' => $checkOut->format('Y-m-d'),
            'total_price' => $this->faker->randomFloat(2, 100, 500),
            'reference' => $this->faker->uuid,
            'status' => 'pending',
            'paid_at' => null,
            'cancelled_at' => null,
            'expires_at' => now()->addMinutes(15),
        ];
    }
}

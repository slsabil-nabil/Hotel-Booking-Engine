<?php

namespace Slsabil\LaravelHotelBooking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Slsabil\LaravelHotelBooking\Models\Room;
use Slsabil\LaravelHotelBooking\Models\RoomType;
use Slsabil\LaravelHotelBooking\Models\Hotel;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'hotel_id' => Hotel::factory(),
            'room_type_id' => RoomType::factory(),
            'room_number' => $this->faker->unique()->numberBetween(100, 999),
        ];
    }
}

<?php

namespace Slsabil\LaravelHotelBooking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Slsabil\LaravelHotelBooking\Models\Hotel;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'location' => $this->faker->city,
        ];
    }
}

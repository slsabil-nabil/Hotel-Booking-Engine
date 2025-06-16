<?php

namespace Slsabil\LaravelHotelBooking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Slsabil\LaravelHotelBooking\Models\RoomType;
use Slsabil\LaravelHotelBooking\Models\Hotel;

class RoomTypeFactory extends Factory
{
    protected $model = RoomType::class;

    public function definition()
    {
        return [
            'hotel_id' => Hotel::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'base_price' => $this->faker->randomFloat(2, 50, 300),
        ];
    }
}

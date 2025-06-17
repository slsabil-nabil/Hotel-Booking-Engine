<?php

namespace Slsabil\LaravelHotelBooking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Slsabil\LaravelHotelBooking\Models\Hotel;
use Faker\Provider\en_US\Company;
use Faker\Provider\en_US\Address;
use Faker\Provider\en_US\Person;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition()
    {
        // إضافة الـ Providers يدوياً
        $this->faker->addProvider(new Company($this->faker));
        $this->faker->addProvider(new Address($this->faker));
        $this->faker->addProvider(new Person($this->faker));

        return [
            'name' => $this->faker->company,
            'location' => $this->faker->city,
        ];
    }
}

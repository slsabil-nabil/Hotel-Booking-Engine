<?php

use Slsabil\LaravelHotelBooking\Models\Hotel;
use Slsabil\LaravelHotelBooking\Models\RoomType;
use Slsabil\LaravelHotelBooking\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Slsabil\LaravelHotelBooking\Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('belongs to a hotel', function () {
    $type = RoomType::factory()->create();
    expect($type->hotel)->toBeInstanceOf(Hotel::class);
});

it('has many rooms', function () {
    $type = RoomType::factory()->create();
    $type->rooms()->createMany(
        Room::factory()->count(2)->make()->toArray()
    );
    expect($type->rooms)->toHaveCount(2);
});

<?php

use Slsabil\LaravelHotelBooking\Models\Hotel;
use Slsabil\LaravelHotelBooking\Models\RoomType;
use Slsabil\LaravelHotelBooking\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Slsabil\LaravelHotelBooking\Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('has many room types', function () {
    $hotel = Hotel::factory()->create();
    $hotel->roomTypes()->createMany(
        RoomType::factory()->count(2)->make()->toArray()
    );
    expect($hotel->roomTypes)->toHaveCount(2);
});

it('has many rooms', function () {
    $hotel = Hotel::factory()->create();
    $hotel->rooms()->createMany(
        Room::factory()->count(2)->make()->toArray()
    );
    expect($hotel->rooms)->toHaveCount(2);
});

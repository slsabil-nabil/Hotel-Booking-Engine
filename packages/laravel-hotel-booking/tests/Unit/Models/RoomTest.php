<?php

use Slsabil\LaravelHotelBooking\Models\Hotel;
use Slsabil\LaravelHotelBooking\Models\RoomType;
use Slsabil\LaravelHotelBooking\Models\Room;
use Slsabil\LaravelHotelBooking\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Slsabil\LaravelHotelBooking\Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('belongs to a room type', function () {
    $room = Room::factory()->create();
    expect($room->roomType)->toBeInstanceOf(RoomType::class);
});

it('belongs to a hotel', function () {
    $room = Room::factory()->create();
    expect($room->hotel)->toBeInstanceOf(Hotel::class);
});

it('has many bookings', function () {
    $room = Room::factory()->create();
    $room->bookings()->createMany(
        Booking::factory()->count(2)->make()->toArray()
    );
    expect($room->bookings)->toHaveCount(2);
});

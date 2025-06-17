<?php

use Slsabil\LaravelHotelBooking\Models\Booking;
use Slsabil\LaravelHotelBooking\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Slsabil\LaravelHotelBooking\Tests\TestCase;

uses(TestCase::class);


uses(RefreshDatabase::class);

it('belongs to a room', function () {
    $booking = Booking::factory()->create();
    expect($booking->room)->toBeInstanceOf(Room::class);
});

it('belongs to a user', function () {
    $booking = Booking::factory()->create();
    expect($booking->user)->toBeInstanceOf(User::class);
});

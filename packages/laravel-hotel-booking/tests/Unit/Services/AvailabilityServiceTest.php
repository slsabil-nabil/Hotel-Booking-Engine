<?php

use Slsabil\LaravelHotelBooking\Models\Booking;
use Slsabil\LaravelHotelBooking\Services\AvailabilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Slsabil\LaravelHotelBooking\Models\Room;
use App\Models\User;

uses( RefreshDatabase::class);

it('returns true when the room is available for the given period', function () {
    $room = Room::factory()->create();
    $user = User::factory()->create();

    $service = new AvailabilityService();
    $isAvailable = $service->isAvailable($room->id, '2025-07-01', '2025-07-05');

    expect($isAvailable)->toBeTrue();
});

it('returns false when the room is already booked in the given period', function () {
    $room = Room::factory()->create();
    $user = User::factory()->create();

    Booking::factory()->create([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'check_in_date' => '2025-07-02',
        'check_out_date' => '2025-07-04',
        'status' => 'confirmed',
        'total_price' => 100.00,
        'reference' => \Illuminate\Support\Str::uuid(),
    ]);

    $service = new AvailabilityService();
    $isAvailable = $service->isAvailable($room->id, '2025-07-01', '2025-07-05');

    expect($isAvailable)->toBeFalse();
});

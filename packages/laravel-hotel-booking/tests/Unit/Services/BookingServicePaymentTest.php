<?php

use Slsabil\LaravelHotelBooking\Models\Booking;
use Slsabil\LaravelHotelBooking\Models\Room;
use App\Models\User;
use Slsabil\LaravelHotelBooking\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Slsabil\LaravelHotelBooking\Events\BookingStatusChanged;

uses( RefreshDatabase::class);

it('processes payment successfully and updates booking status', function () {
    Event::fake();

    $room = Room::factory()->create();
    $user = User::factory()->create();

    $booking = Booking::factory()->create([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'status' => 'pending',
        'paid_at' => null,
        'check_in_date' => '2025-07-10',
        'check_out_date' => '2025-07-15',
        'total_price' => 200,
        'reference' => \Illuminate\Support\Str::uuid(),
    ]);

    $service = new BookingService();
    $updatedBooking = $service->processPayment($booking);

    expect($updatedBooking->status)->toBe('paid');
    expect($updatedBooking->paid_at)->not->toBeNull();

    Event::assertDispatched(BookingStatusChanged::class, fn($e) => $e->booking->id === $booking->id);
});

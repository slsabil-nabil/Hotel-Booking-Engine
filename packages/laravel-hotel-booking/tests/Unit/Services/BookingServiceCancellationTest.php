<?php

use Slsabil\LaravelHotelBooking\Models\Booking;
use Slsabil\LaravelHotelBooking\Models\Room;
use App\Models\User;
use Slsabil\LaravelHotelBooking\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Slsabil\LaravelHotelBooking\Events\BookingStatusChanged;
use Carbon\Carbon;

uses( RefreshDatabase::class);

it('allows cancellation if more than 24 hours before check-in', function () {
    Event::fake();

    $room = Room::factory()->create();
    $user = User::factory()->create();

    $checkInDate = Carbon::now()->addDays(3)->format('Y-m-d'); // بعد 3 أيام

    $booking = Booking::factory()->create([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'status' => 'paid',
        'cancelled_at' => null,
        'check_in_date' => $checkInDate,
        'check_out_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
        'total_price' => 300,
        'reference' => \Illuminate\Support\Str::uuid(),
    ]);

    $service = new BookingService();
    $updatedBooking = $service->cancelBooking($booking);

    expect($updatedBooking->status)->toBe('canceled');
    expect($updatedBooking->cancelled_at)->not->toBeNull();

    Event::assertDispatched(BookingStatusChanged::class, fn($e) => $e->booking->id === $booking->id);
});

it('throws exception if cancellation is attempted within 24 hours of check-in', function () {
    $room = Room::factory()->create();
    $user = User::factory()->create();

    $checkInDate = Carbon::now()->addHours(20)->format('Y-m-d'); // خلال 20 ساعة فقط

    $booking = Booking::factory()->create([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'status' => 'paid',
        'cancelled_at' => null,
        'check_in_date' => $checkInDate,
        'check_out_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
        'total_price' => 300,
        'reference' => \Illuminate\Support\Str::uuid(),
    ]);

    $service = new BookingService();

    $this->expectException(Exception::class);
    $this->expectExceptionMessage('Cancellation is not allowed within 24 hours of check-in.');

    $service->cancelBooking($booking);
});

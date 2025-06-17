<?php

use Slsabil\LaravelHotelBooking\Services\BookingService;
use Slsabil\LaravelHotelBooking\Models\Booking;
use Slsabil\LaravelHotelBooking\Events\BookingStatusChanged;
use Illuminate\Support\Facades\Event;
use Slsabil\LaravelHotelBooking\Tests\TestCase;

uses(TestCase::class);

it('successfully creates a booking with all required fields', function () {
    Event::fake();

    $user = \App\Models\User::factory()->create();
    $room = \Slsabil\LaravelHotelBooking\Models\Room::factory()->create();

    $service = new BookingService();

    $checkInDate = now()->addDay()->toDateString();
    $checkOutDate = now()->addDays(3)->toDateString();

    $bookingData = [
        'room_id' => $room->id,
        'user_id' => $user->id,
        'check_in_date' => $checkInDate,
        'check_out_date' => $checkOutDate,
        'total_price' => 1500.00,
        'status' => 'pending',
        // إزالة حقل reference من البيانات المرسلة
    ];

    $booking = $service->createBooking($bookingData);

    expect($booking)->toBeInstanceOf(Booking::class)
        ->room_id->toBe($room->id)
        ->user_id->toBe($user->id)
        ->check_in_date->format('Y-m-d')->toBe($checkInDate)
        ->check_out_date->format('Y-m-d')->toBe($checkOutDate)
        ->total_price->toEqual(1500.00)
        ->status->toBe('pending')
        ->reference->toBeUuid() // التحقق من أن القيمة UUID صالحة
        ->paid_at->toBeNull()
        ->cancelled_at->toBeNull()
        ->expires_at->toBeNull();

    Event::assertDispatched(BookingStatusChanged::class);
});

it('fails when required fields are missing', function () {
    $service = new BookingService();
    
    $testCases = [
        'missing room_id' => [
            'user_id' => 1,
            'check_in_date' => now()->addDay()->toDateString(),
            'check_out_date' => now()->addDays(3)->toDateString(),
            'total_price' => 1500.00,
        ],
        'missing user_id' => [
            'room_id' => 1,
            'check_in_date' => now()->addDay()->toDateString(),
            'check_out_date' => now()->addDays(3)->toDateString(),
            'total_price' => 1500.00,
        ],
        'missing check_in_date' => [
            'room_id' => 1,
            'user_id' => 1,
            'check_out_date' => now()->addDays(3)->toDateString(),
            'total_price' => 1500.00,
        ],
        'missing check_out_date' => [
            'room_id' => 1,
            'user_id' => 1,
            'check_in_date' => now()->addDay()->toDateString(),
            'total_price' => 1500.00,
        ],
        'missing total_price' => [
            'room_id' => 1,
            'user_id' => 1,
            'check_in_date' => now()->addDay()->toDateString(),
            'check_out_date' => now()->addDays(3)->toDateString(),
        ]
    ];

    foreach ($testCases as $data) {
        expect(fn() => $service->createBooking($data))
            ->toThrow(\Illuminate\Database\QueryException::class);
    }
});

it('sets default values correctly', function () {
    $user = \App\Models\User::factory()->create();
    $room = \Slsabil\LaravelHotelBooking\Models\Room::factory()->create();

    $service = new BookingService();

    $booking = $service->createBooking([
        'room_id' => $room->id,
        'user_id' => $user->id,
        'check_in_date' => now()->addDay()->toDateString(),
        'check_out_date' => now()->addDays(3)->toDateString(),
        'total_price' => 1500.00,
    ]);

    expect($booking)
        ->status->toBe('pending')
        ->reference->not->toBeEmpty()
        ->paid_at->toBeNull()
        ->cancelled_at->toBeNull()
        ->expires_at->toBeNull();
});
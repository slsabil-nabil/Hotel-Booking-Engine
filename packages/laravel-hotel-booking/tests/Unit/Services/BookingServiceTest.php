<?php

namespace Packages\laravelhotelbooking\tests\Unit\Services;

use Slsabil\LaravelHotelBooking\Models\Room;
use Slsabil\LaravelHotelBooking\Models\Booking;
use PSlsabil\LaravelHotelBooking\Models\User;
use Slsabil\LaravelHotelBooking\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BookingService $bookingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookingService = new BookingService();
    }

    public function test_room_availability_on_dates()
    {
        // Arrange: أنشئ غرفة وحجز واحد يغطي فترة معينة
        $room = Room::factory()->create();
        Booking::factory()->create([
            'room_id' => $room->id,
            'check_in_date' => '2025-06-20',
            'check_out_date' => '2025-06-25',
            'status' => 'confirmed',
        ]);

        // Act & Assert
        $isAvailable = $this->bookingService->isRoomAvailable($room->id, '2025-06-15', '2025-06-19');
        $this->assertTrue($isAvailable);

        $isAvailable = $this->bookingService->isRoomAvailable($room->id, '2025-06-22', '2025-06-24');
        $this->assertFalse($isAvailable);
    }

    // تابع باقي الاختبارات بناءً على السيناريوهات
}

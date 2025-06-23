<?php

use Illuminate\Support\Facades\Schema;
use Slsabil\LaravelHotelBooking\Tests\TestCase;



it('room_types table is created by migration', function () {
    $this->artisan('migrate')->run();
    expect(Schema::hasTable('room_types'))->toBeTrue();
});

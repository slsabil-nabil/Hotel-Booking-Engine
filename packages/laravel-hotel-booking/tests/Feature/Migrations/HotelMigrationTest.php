<?php

use Illuminate\Support\Facades\Schema;
use Slsabil\LaravelHotelBooking\Tests\TestCase;


it('hotels table is created by migration', function () {
    $this->artisan('migrate')->run();
    expect(Schema::hasTable('hotels'))->toBeTrue();
});

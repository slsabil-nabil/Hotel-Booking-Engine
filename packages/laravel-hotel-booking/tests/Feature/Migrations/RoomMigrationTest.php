<?php

use Illuminate\Support\Facades\Schema;
use Slsabil\LaravelHotelBooking\Tests\TestCase;

uses(TestCase::class);

it('rooms table is created by migration', function () {
    $this->artisan('migrate')->run();
    expect(Schema::hasTable('rooms'))->toBeTrue();
});

<?php

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

uses(TestCase::class);

it('room_types table is created by migration', function () {
    $this->artisan('migrate')->run();
    expect(Schema::hasTable('room_types'))->toBeTrue();
});

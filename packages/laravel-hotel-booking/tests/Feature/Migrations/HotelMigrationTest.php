<?php

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

uses(TestCase::class);

it('hotels table is created by migration', function () {
    $this->artisan('migrate')->run();
    expect(Schema::hasTable('hotels'))->toBeTrue();
});

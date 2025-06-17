<?php

namespace Slsabil\LaravelHotelBooking\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            \Slsabil\LaravelHotelBooking\HotelBookingServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // تكوين قاعدة البيانات الاختبارية
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        // تحميل ميجريشنز لارافيل الأساسية أولاً
        $this->loadLaravelMigrations();
        
        // ثم تحميل ميجريشنز الباكدج
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
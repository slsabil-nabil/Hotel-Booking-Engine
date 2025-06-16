<?php

namespace Slsabil\LaravelHotelBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Slsabil\LaravelHotelBooking\Database\Factories\HotelFactory;

class Hotel extends Model
{
    use HasFactory;
    protected static function newFactory()
    {
        return HotelFactory::new();
    }
    protected $fillable = ['name', 'location'];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }
}

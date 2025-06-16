<?php

namespace Slsabil\LaravelHotelBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Slsabil\LaravelHotelBooking\Database\Factories\RoomFactory;

class Room extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return RoomFactory::new();
    }
    protected $fillable = [
        'hotel_id',
        'room_type_id',
        'room_number',
        'floor',
        'is_available',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

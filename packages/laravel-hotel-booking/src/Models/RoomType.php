<?php

namespace Slsabil\LaravelHotelBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Slsabil\LaravelHotelBooking\Database\Factories\RoomTypeFactory;

class RoomType extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return RoomTypeFactory::new();
    }
    protected $fillable = ['name', 'description', 'base_price'];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}

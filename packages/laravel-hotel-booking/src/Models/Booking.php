<?php

namespace Slsabil\LaravelHotelBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Slsabil\LaravelHotelBooking\Database\Factories\BookingFactory;

class Booking extends Model
{
    use HasFactory;

     protected static function newFactory()
    {
        return BookingFactory::new();
    }
    protected $fillable = [
        'room_id',
        'user_id',
        'check_in_date',
        'check_out_date',
        'total_price',
        'reference',
        'status',
        'paid_at',
        'cancelled_at',
        'expires_at',
    ];

    // الحالات الممكنة
    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PAID      = 'paid';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED   = 'expired';

    protected $casts = [
        'check_in_date'  => 'date',
        'check_out_date' => 'date',
        'paid_at'        => 'datetime',
        'cancelled_at'   => 'datetime',
        'expires_at'     => 'datetime',
        'total_price'    => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        // عند إنشاء الحجز، نولّد UUID تلقائياً لو ما هو موجود
        static::creating(function ($booking) {
            if (empty($booking->reference)) {
                $booking->reference = (string) Str::uuid();
            }
        });
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_code',
        'user_id',
        'service_id',
        'passenger_count',
        'passenger_details',
        'seats',
        'travel_class',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'special_request',
        'is_checkin',
    ];

    protected $casts = [
        'passenger_details' => 'array',
        'seats' => 'array',
        'total_price' => 'decimal:2',
        'is_checkin' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function cancellation()
    {
        return $this->hasOne(Cancellation::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_code = 'JA' . strtoupper(uniqid());
        });
    }
}
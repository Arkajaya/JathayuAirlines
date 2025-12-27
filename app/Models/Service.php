<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'flight_number',
        'airline_name',
        'departure_city',
        'arrival_city',
        'departure_time',
        'arrival_time',
        'duration',
        'capacity',
        'booked_seats',
        'price',
        'class',
        'description',
        'is_active',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getAvailableSeatsAttribute()
    {
        return $this->capacity - $this->booked_seats;
    }

    public function getOccupancyRateAttribute()
    {
        if ($this->capacity == 0) return 0;
        return ($this->booked_seats / $this->capacity) * 100;
    }
}
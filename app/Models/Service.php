<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   
use Illuminate\Validation\ValidationException;

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
        'duration' => 'integer',
    ];

    protected static function booted()
    {
        static::saving(function ($service) {
            // Capacity and booked seats must be non-negative
            if (isset($service->capacity) && $service->capacity < 0) {
                throw ValidationException::withMessages([
                    'capacity' => 'Capacity must be zero or a positive integer.',
                ]);
            }

            if (isset($service->booked_seats) && $service->booked_seats < 0) {
                throw ValidationException::withMessages([
                    'booked_seats' => 'Booked seats must be zero or a positive integer.',
                ]);
            }

            // booked_seats should not exceed capacity
            if (isset($service->capacity) && isset($service->booked_seats) && $service->booked_seats > $service->capacity) {
                throw ValidationException::withMessages([
                    'booked_seats' => 'Booked seats cannot exceed capacity.',
                ]);
            }
            // Prevent setting departure/arrival in the past relative to now
            if ($service->departure_time && $service->departure_time->lt(now())) {
                throw ValidationException::withMessages([
                    'departure_time' => 'Departure time must be now or in the future.',
                ]);
            }

            if ($service->arrival_time && $service->arrival_time->lt(now())) {
                throw ValidationException::withMessages([
                    'arrival_time' => 'Arrival time must be now or in the future.',
                ]);
            }

            if ($service->departure_time && $service->arrival_time && $service->arrival_time->lt($service->departure_time)) {
                throw ValidationException::withMessages([
                    'arrival_time' => 'Arrival time must be after or equal to departure time.',
                ]);
            }

            if ($service->departure_time && $service->arrival_time) {
                try {
                    $diff = $service->arrival_time->diffInMinutes($service->departure_time);
                    $service->duration = (int) $diff;
                } catch (\Throwable $e) {
                    // ignore parsing errors
                }
            }
        });
    }

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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
        'birth_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function cancellations()
    {
        return $this->hasMany(Cancellation::class);
    }

    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isStaff()
    {
        return $this->role_id === 2;
    }

    public function isUser()
    {
        return $this->role_id === 3;
    }
}
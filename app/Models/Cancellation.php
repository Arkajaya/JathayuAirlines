<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cancellation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['booking_id', 'user_id', 'reason', 'status', 'admin_note', 'refund_amount'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
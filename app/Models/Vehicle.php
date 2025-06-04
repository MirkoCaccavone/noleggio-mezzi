<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'type',
        'brand',
        'model',
        'plate',
        'description',
        'price_per_day',
        'available',
        'image',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

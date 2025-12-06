<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'airline_id',
        'origin_airport_id',
        'destination_airport_id',
        'departure_time',
        'arrival_time',
        'price',
        'class',
        'available_seats',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function origin()
    {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    public function destination()
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
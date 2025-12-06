<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = [
        'iata_code',
        'name',
        'city',
        'country',
    ];

    // Relasi ke penerbangan yang berangkat dari sini
    public function departingFlights()
    {
        return $this->hasMany(Flight::class, 'origin_airport_id');
    }

    // Relasi ke penerbangan yang mendarat di sini
    public function arrivingFlights()
    {
        return $this->hasMany(Flight::class, 'destination_airport_id');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\Airport;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        // Load data relasi agar tidak N+1 Problem
        $flights = Flight::with(['airline', 'origin', 'destination'])->latest()->paginate(10);
        return view('admin.flights.index', compact('flights'));
    }

    public function create()
    {
        $airlines = Airline::all();
        $airports = Airport::all();
        return view('admin.flights.create', compact('airlines', 'airports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flight_number' => 'required|string|max:10',
            'airline_id' => 'required|exists:airlines,id',
            'origin_airport_id' => 'required|exists:airports,id',
            'destination_airport_id' => 'required|exists:airports,id|different:origin_airport_id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1', // Kuota kursi
        ]);

        // Mapping input 'stock' ke kolom database 'available_seats'
        $data = $request->all();
        $data['available_seats'] = $request->stock; 

        Flight::create($data);

        return redirect()->route('admin.flights.index')->with('success', 'Flight created successfully');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('admin.flights.index')->with('success', 'Flight deleted successfully');
    }
}
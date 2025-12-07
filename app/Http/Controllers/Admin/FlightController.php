<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\Airport;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Menampilkan daftar penerbangan
     */
    public function index()
    {
        // Load data relasi agar tidak N+1 Problem
        $flights = Flight::with(['airline', 'origin', 'destination'])->latest()->paginate(10);
        return view('admin.flights.index', compact('flights'));
    }

    /**
     * Menampilkan form tambah penerbangan
     */
    public function create()
    {
        $airlines = Airline::all();
        $airports = Airport::all();
        return view('admin.flights.create', compact('airlines', 'airports'));
    }

    /**
     * Menyimpan data penerbangan baru
     */
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
            'stock' => 'required|integer|min:1', // Kuota kursi (input form)
        ]);

        // Mapping input 'stock' ke kolom database 'available_seats'
        $data = $request->all();
        $data['available_seats'] = $request->stock; 

        Flight::create($data);

        return redirect()->route('admin.flights.index')->with('success', 'Flight created successfully');
    }

    /**
     * [BARU] Menampilkan form edit penerbangan
     * Method ini yang sebelumnya hilang dan menyebabkan error.
     */
    public function edit(Flight $flight)
    {
        $airlines = Airline::all();
        $airports = Airport::all();
        
        // Pastikan Anda sudah membuat view 'admin.flights.edit'
        return view('admin.flights.edit', compact('flight', 'airlines', 'airports'));
    }

    /**
     * [BARU] Menyimpan perubahan data (Update)
     */
    public function update(Request $request, Flight $flight)
    {
        $request->validate([
            'flight_number' => 'required|string|max:10',
            'airline_id' => 'required|exists:airlines,id',
            'origin_airport_id' => 'required|exists:airports,id',
            'destination_airport_id' => 'required|exists:airports,id|different:origin_airport_id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
        ]);

        // Mapping input 'stock' ke kolom database 'available_seats'
        $data = $request->all();
        $data['available_seats'] = $request->stock;

        $flight->update($data);

        return redirect()->route('admin.flights.index')->with('success', 'Flight updated successfully');
    }

    /**
     * Menghapus data penerbangan
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('admin.flights.index')->with('success', 'Flight deleted successfully');
    }
}
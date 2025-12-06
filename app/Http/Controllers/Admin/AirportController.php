<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index()
    {
        $airports = Airport::latest()->paginate(10);
        return view('admin.airports.index', compact('airports'));
    }

    public function create()
    {
        return view('admin.airports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'iata_code' => 'required|unique:airports,iata_code|max:3|uppercase',
            'name'      => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'country'   => 'required|string|max:255',
        ]);

        Airport::create($request->all());

        return redirect()->route('admin.airports.index')->with('success', 'Airport created successfully');
    }

    public function edit(Airport $airport)
    {
        return view('admin.airports.edit', compact('airport'));
    }

    public function update(Request $request, Airport $airport)
    {
        $request->validate([
            'iata_code' => 'required|max:3|uppercase|unique:airports,iata_code,' . $airport->id,
            'name'      => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'country'   => 'required|string|max:255',
        ]);

        $airport->update($request->all());

        return redirect()->route('admin.airports.index')->with('success', 'Airport updated successfully');
    }

    public function destroy(Airport $airport)
    {
        $airport->delete();
        return redirect()->route('admin.airports.index')->with('success', 'Airport deleted successfully');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AirlineController extends Controller
{
    public function index()
    {
        $airlines = Airline::latest()->paginate(10);
        return view('admin.airlines.index', compact('airlines'));
    }

    public function create()
    {
        return view('admin.airlines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:airlines,code|max:5|uppercase',
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('airlines', 'public');
        }

        Airline::create($data);

        return redirect()->route('admin.airlines.index')->with('success', 'Airline created successfully');
    }

    public function edit(Airline $airline)
    {
        return view('admin.airlines.edit', compact('airline'));
    }

    public function update(Request $request, Airline $airline)
    {
        $request->validate([
            'code' => 'required|max:5|uppercase|unique:airlines,code,' . $airline->id,
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($airline->logo) {
                Storage::disk('public')->delete($airline->logo);
            }
            $data['logo'] = $request->file('logo')->store('airlines', 'public');
        }

        $airline->update($data);

        return redirect()->route('admin.airlines.index')->with('success', 'Airline updated successfully');
    }

    public function destroy(Airline $airline)
    {
        if ($airline->logo) {
            Storage::disk('public')->delete($airline->logo);
        }
        $airline->delete();
        return redirect()->route('admin.airlines.index')->with('success', 'Airline deleted successfully');
    }
}
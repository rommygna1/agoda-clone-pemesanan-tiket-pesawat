<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Flight') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('admin.flights.update', $flight->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label for="flight_number" class="block text-sm font-medium text-gray-700">Flight Number</label>
                                <input type="text" name="flight_number" id="flight_number" 
                                       value="{{ old('flight_number', $flight->flight_number) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('flight_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="airline_id" class="block text-sm font-medium text-gray-700">Airline</label>
                                <select name="airline_id" id="airline_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="">Select Airline</option>
                                    @foreach($airlines as $airline)
                                        <option value="{{ $airline->id }}" {{ old('airline_id', $flight->airline_id) == $airline->id ? 'selected' : '' }}>
                                            {{ $airline->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('airline_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="origin_airport_id" class="block text-sm font-medium text-gray-700">Origin Airport</label>
                                <select name="origin_airport_id" id="origin_airport_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="">Select Origin</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ old('origin_airport_id', $flight->origin_airport_id) == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->city }} ({{ $airport->iata_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('origin_airport_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="destination_airport_id" class="block text-sm font-medium text-gray-700">Destination Airport</label>
                                <select name="destination_airport_id" id="destination_airport_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="">Select Destination</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ old('destination_airport_id', $flight->destination_airport_id) == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->city }} ({{ $airport->iata_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('destination_airport_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="departure_time" class="block text-sm font-medium text-gray-700">Departure Time</label>
                                <input type="datetime-local" name="departure_time" id="departure_time" 
                                       value="{{ old('departure_time', \Carbon\Carbon::parse($flight->departure_time)->format('Y-m-d\TH:i')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('departure_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="arrival_time" class="block text-sm font-medium text-gray-700">Arrival Time</label>
                                <input type="datetime-local" name="arrival_time" id="arrival_time" 
                                       value="{{ old('arrival_time', \Carbon\Carbon::parse($flight->arrival_time)->format('Y-m-d\TH:i')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('arrival_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price (IDR)</label>
                                <input type="number" name="price" id="price" min="0" 
                                       value="{{ old('price', $flight->price) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Total Seats (Stock)</label>
                                <input type="number" name="stock" id="stock" min="1" 
                                       value="{{ old('stock', $flight->available_seats) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.flights.index') }}" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300 transition">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                                Update Flight
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
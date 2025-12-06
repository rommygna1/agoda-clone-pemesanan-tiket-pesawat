<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Flight Schedule') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.flights.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="col-span-2 border-b pb-4 mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Aircraft Info</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Airline</label>
                                <select name="airline_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach($airlines as $airline)
                                        <option value="{{ $airline->id }}">{{ $airline->name }} ({{ $airline->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Flight Number</label>
                                <input type="text" name="flight_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="GA-123">
                            </div>

                            <div class="col-span-2 border-b pb-4 mb-4 mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Route Info</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Origin Airport</label>
                                <select name="origin_airport_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">{{ $airport->city }} - {{ $airport->name }} ({{ $airport->iata_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Destination Airport</label>
                                <select name="destination_airport_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">{{ $airport->city }} - {{ $airport->name }} ({{ $airport->iata_code }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Departure Time</label>
                                <input type="datetime-local" name="departure_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Arrival Time</label>
                                <input type="datetime-local" name="arrival_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div class="col-span-2 border-b pb-4 mb-4 mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Price & Seat</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price (IDR)</label>
                                <input type="number" name="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="1000000">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Seats (Quota)</label>
                                <input type="number" name="stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required value="100">
                            </div>

                        </div>
                        <div class="mt-8">
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-md hover:bg-blue-700 font-bold">Save Flight Schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
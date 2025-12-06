<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Flights') }}
            </h2>
            <a href="{{ route('admin.flights.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                + Add Flight Schedule
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Flight No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Route</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Departure</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($flights as $flight)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-bold">{{ $flight->flight_number }}</div>
                                    <div class="text-sm text-gray-500">{{ $flight->airline->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $flight->origin->city }} ({{$flight->origin->iata_code}})</div>
                                    <div class="text-xs text-gray-400">to</div>
                                    <div class="text-sm font-medium text-gray-900">{{ $flight->destination->city }} ({{$flight->destination->iata_code}})</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $flight->departure_time->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-green-600">
                                    IDR {{ number_format($flight->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('admin.flights.destroy', $flight) }}" method="POST" onsubmit="return confirm('Delete flight?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $flights->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
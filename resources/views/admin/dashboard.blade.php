<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 font-bold text-xl">Manage Airports</div>
                    <p class="text-gray-500 mb-4">Add or edit airport destinations.</p>
                    <a href="{{ route('admin.airports.index') }}" class="text-blue-500 hover:underline">Go to Airports &rarr;</a>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 font-bold text-xl">Manage Airlines</div>
                    <p class="text-gray-500 mb-4">Update airline list and logos.</p>
                    <a href="{{ route('admin.airlines.index') }}" class="text-blue-500 hover:underline">Go to Airlines &rarr;</a>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 font-bold text-xl">Manage Flights</div>
                    <p class="text-gray-500 mb-4">Set schedules and prices.</p>
                    <a href="{{ route('admin.flights.index') }}" class="text-blue-500 hover:underline">Go to Flights &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
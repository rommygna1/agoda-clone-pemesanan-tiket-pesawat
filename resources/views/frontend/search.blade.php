<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results - Agoda Clone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-900">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="/" class="text-2xl font-bold text-blue-600">agoda<span class="text-gray-600">Clone</span></a>
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 font-medium">My Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-600 font-medium">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-blue-600 text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold">
                        {{ $origin->city }} ({{ $origin->iata_code }}) 
                        &rarr; 
                        {{ $destination->city }} ({{ $destination->iata_code }})
                    </h1>
                    <p class="text-blue-100 mt-1">{{ \Carbon\Carbon::parse($date)->format('D, d M Y') }} | 1 Passenger</p>
                </div>
                <a href="/" class="mt-4 md:mt-0 bg-white text-blue-600 px-4 py-2 rounded-md text-sm font-bold hover:bg-gray-100">
                    Change Search
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        @if($flights->count() > 0)
            <div class="space-y-4">
                @foreach($flights as $flight)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition duration-200 p-6">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            
                            <div class="flex items-center space-x-4 mb-4 md:mb-0 w-full md:w-1/4">
                                @if($flight->airline->logo)
                                    <img src="{{ asset('storage/' . $flight->flight->airline->logo) }}" alt="Logo" class="h-12 w-12 object-contain">
                                @else
                                    <div class="h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-500">
                                        {{ $flight->airline->code }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-gray-800">{{ $flight->airline->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $flight->flight_number }}</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-center space-x-6 w-full md:w-2/4 text-center">
                                <div>
                                    <div class="text-lg font-bold text-gray-800">{{ $flight->departure_time->format('H:i') }}</div>
                                    <div class="text-xs text-gray-500">{{ $flight->origin->iata_code }}</div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="text-xs text-gray-400">Direct</div>
                                    <div class="w-24 h-[1px] bg-gray-300 my-1 relative">
                                        <div class="absolute -top-[3px] right-0 w-2 h-2 bg-gray-300 rounded-full"></div>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $flight->departure_time->diff($flight->arrival_time)->format('%Hh %Im') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-gray-800">{{ $flight->arrival_time->format('H:i') }}</div>
                                    <div class="text-xs text-gray-500">{{ $flight->destination->iata_code }}</div>
                                </div>
                            </div>

                            <div class="flex flex-col items-end justify-center w-full md:w-1/4 border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6 mt-4 md:mt-0">
                                <div class="text-green-600 text-sm font-semibold mb-1">Available: {{ $flight->available_seats }} seats</div>
                                <div class="text-2xl font-bold text-gray-900 mb-2">
                                    IDR {{ number_format($flight->price, 0, ',', '.') }}
                                </div>
                                
                                {{-- Tombol ini akan mengarah ke logic Booking di Langkah 5 --}}
                                {{-- Kita arahkan ke halaman checkout dengan ID Flight --}}
                                <form action="#" method="GET"> 
                                    <button type="button" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                                        Select Flight
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="text-gray-400 text-6xl mb-4">✈️</div>
                <h3 class="text-xl font-bold text-gray-800">No flights found</h3>
                <p class="text-gray-500 mt-2">We couldn't find any flights for this route on this date.</p>
                <a href="/" class="text-blue-600 font-bold mt-4 inline-block hover:underline">Try searching another date</a>
            </div>
        @endif

    </div>

</body>
</html>
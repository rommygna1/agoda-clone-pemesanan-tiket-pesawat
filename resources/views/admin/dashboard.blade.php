<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Penerbangan</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalFlights }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Bandara Terdaftar</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAirports }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-full text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500 flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Maskapai Partner</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAirlines }}</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-full text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500 flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Transaksi</h3>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalBookings }}</p>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-full text-orange-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-700">Jadwal Penerbangan Terbaru</h3>
                        <a href="{{ route('admin.flights.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-semibold hover:underline">Lihat Semua
                            &rarr;</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No. Penerbangan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Maskapai</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rute Penerbangan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                @forelse($recentFlights as $flight)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $flight->flight_number }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                @if ($flight->airline->logo)
                                                    <img src="{{ asset('storage/' . $flight->airline->logo) }}"
                                                        class="h-10 w-10 object-contain rounded-md"
                                                        alt="{{ $flight->airline->name }}">
                                                @endif
                                                <span
                                                    class="font-bold text-gray-700">{{ $flight->airline->name ?? '-' }}</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-gray-700">
                                                <span class="font-semibold">{{ $flight->origin->city ?? '?' }}</span>
                                                <span
                                                    class="text-gray-500 text-xs ml-1">({{ $flight->origin->iata_code ?? '?' }})</span>

                                                <svg class="w-4 h-4 mx-2 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                </svg>

                                                <span
                                                    class="font-semibold">{{ $flight->destination->city ?? '?' }}</span>
                                                <span
                                                    class="text-gray-500 text-xs ml-1">({{ $flight->destination->iata_code ?? '?' }})</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</span>
                                                <span
                                                    class="text-xs">{{ \Carbon\Carbon::parse($flight->departure_time)->format('d M Y') }}</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-right font-bold text-orange-600 whitespace-nowrap">
                                            Rp {{ number_format($flight->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                            Belum ada data penerbangan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

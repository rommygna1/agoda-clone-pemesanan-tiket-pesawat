<x-app-layout>
    {{-- Background Abu-abu tipis ala Agoda --}}
    <div class="min-h-screen bg-gray-50 pb-12 font-sans">
        
        {{-- Header Section dengan Nama User --}}
        <div class="bg-blue-900 pt-8 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-white flex items-center justify-center text-2xl font-bold text-blue-900 uppercase shadow-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h1>
                        <p class="text-blue-200 text-sm">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Container (Overlap ke Header) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                {{-- SIDEBAR MENU (Kiri) --}}
                <div class="col-span-1">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-gray-100">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Akun Saya</span>
                        </div>
                        <nav class="flex flex-col">
                            {{-- Menu Profil --}}
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span class="text-sm font-medium">Profil Saya</span>
                            </a>

                            {{-- Menu Pesanan Saya (Active State) --}}
                            <a href="{{ route('booking.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-600 bg-blue-50 border-l-4 border-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <span class="text-sm font-medium">Pesanan Saya</span>
                            </a>
                            
                            {{-- Menu Ulasan (Placeholder) --}}
                            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                <span class="text-sm font-medium">Ulasan</span>
                            </a>

                            {{-- Menu Keluar --}}
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-2">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors text-left">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    <span class="text-sm font-medium">Keluar</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>

                {{-- MAIN CONTENT (Kanan) --}}
                <div class="col-span-1 md:col-span-3" x-data="{ activeTab: 'all' }">
                    
                    {{-- Judul Halaman --}}
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Pesanan Saya</h2>
                        <p class="text-gray-500 text-sm">Kelola dan lihat riwayat perjalanan Anda.</p>
                    </div>

                    {{-- TABS NAVIGATION --}}
                    <div class="bg-white rounded-t-lg border-b border-gray-200 shadow-sm">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                            <li class="mr-2">
                                <button @click="activeTab = 'all'" 
                                    :class="activeTab === 'all' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-600 border-transparent hover:border-gray-300'"
                                    class="inline-block p-4 transition-all">
                                    Semua Pesanan
                                </button>
                            </li>
                            <li class="mr-2">
                                <button @click="activeTab = 'flights'" 
                                    :class="activeTab === 'flights' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-600 border-transparent hover:border-gray-300'"
                                    class="inline-block p-4 transition-all">
                                    <i class="fas fa-plane mr-1"></i> Tiket Pesawat
                                </button>
                            </li>
                            <li class="mr-2">
                                <button @click="activeTab = 'reviews'" 
                                    :class="activeTab === 'reviews' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-600 border-transparent hover:border-gray-300'"
                                    class="inline-block p-4 transition-all">
                                    Ulasan
                                </button>
                            </li>
                            <li class="mr-2">
                                <a href="{{ route('profile.edit') }}" 
                                    class="inline-block p-4 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 text-gray-500 transition-all">
                                    Profil
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- CONTENT AREA --}}
                    <div class="bg-white rounded-b-lg shadow-sm p-6 min-h-[400px]">
                        
                        {{-- TAB: SEMUA PESANAN & TIKET PESAWAT --}}
                        <div x-show="activeTab === 'all' || activeTab === 'flights'" x-transition:enter="transition ease-out duration-300">
                            
                            @if($bookings->isEmpty())
                                <div class="text-center py-12">
                                    {{-- Placeholder Image jika kosong --}}
                                    <svg class="mx-auto w-24 h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <h3 class="text-lg font-bold text-gray-800 mb-2">Belum ada pesanan</h3>
                                    <p class="text-gray-500 mb-6">Ayo mulai petualangan Anda sekarang!</p>
                                    <a href="{{ route('home') }}" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition-all">
                                        Cari Penerbangan
                                    </a>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($bookings as $booking)
                                        <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow bg-white relative">
                                            
                                            {{-- Header Card --}}
                                            <div class="flex justify-between items-start mb-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-gray-800 text-lg">
                                                            {{ $booking->flight->origin->city ?? 'Origin' }} <span class="text-gray-400 mx-1">&rarr;</span> {{ $booking->flight->destination->city ?? 'Destination' }}
                                                        </h3>
                                                        <p class="text-sm text-gray-500">
                                                            Kode Booking: <span class="font-mono font-medium text-gray-700">{{ $booking->booking_code }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                {{-- Status Badge --}}
                                                @php
                                                    $statusClass = match($booking->status) {
                                                        'paid', 'confirmed', 'success' => 'bg-green-100 text-green-700',
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'cancelled', 'failed' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800'
                                                    };
                                                @endphp
                                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusClass }}">
                                                    {{ $booking->status }}
                                                </span>
                                            </div>

                                            <hr class="border-gray-100 my-4">

                                            {{-- Detail Penerbangan --}}
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                <div>
                                                    <p class="text-gray-500 text-xs uppercase mb-1">Maskapai</p>
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-500">
                                                            {{ substr($booking->flight->airline->name ?? 'A', 0, 1) }}
                                                        </div>
                                                        <span class="font-semibold text-gray-700">{{ $booking->flight->airline->name ?? 'Maskapai' }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 text-xs uppercase mb-1">Jadwal Berangkat</p>
                                                    <p class="font-semibold text-gray-700">
                                                        {{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('d M Y, H:i') }}
                                                    </p>
                                                </div>
                                                <div class="text-right flex flex-col justify-end">
                                                     <a href="{{ route('booking.show', $booking->booking_code) }}" class="text-blue-600 font-semibold hover:underline text-sm">
                                                        Lihat E-Tiket &rsaquo;
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- TAB: ULASAN --}}
                        <div x-show="activeTab === 'reviews'" x-transition:enter="transition ease-out duration-300" style="display: none;">
                            <div class="text-center py-12">
                                <div class="inline-block p-4 rounded-full bg-gray-100 mb-4 text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">Belum ada ulasan</h3>
                                <p class="text-gray-500">Anda belum menulis ulasan untuk perjalanan apapun.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
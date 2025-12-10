<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                {{-- LOGO (Disesuaikan) --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : url('/') }}">
                        <img src="https://images.seeklogo.com/logo-png/37/1/agoda-logo-png_seeklogo-371025.png" alt="Agoda" class="h-20 md:h-16 w-auto">
                    </a>
                </div>

                {{-- NAVIGASI DESKTOP --}}
                <div class="hidden sm:-my-px sm:ml-10 sm:flex">

                    @if(Auth::user()->role === 'admin')
                        {{-- MENU ADMIN --}}
                        <div class="flex space-x-8">
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.airports.index')" :active="request()->routeIs('admin.airports.*')">
                                {{ __('Airports') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.airlines.index')" :active="request()->routeIs('admin.airlines.*')">
                                {{ __('Airlines') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.flights.index')" :active="request()->routeIs('admin.flights.*')">
                                {{ __('Flights') }}
                            </x-nav-link>

                            {{-- [BARU] Transactions --}}
                            <x-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.*')">
                                {{ __('Transactions') }}
                            </x-nav-link>
                        </div>
                    @else
                        {{-- MENU USER (Gaya Agoda) --}}
                        <div class="flex h-full items-end space-x-6 pb-5 text-gray-500 font-medium text-sm">
                            <a href="#" class="hover:text-black inline-flex items-end transition duration-150 ease-in-out">
                                Pesawat + Hotel
                            </a>
                            <a href="#" class="hover:text-black inline-flex items-end transition duration-150 ease-in-out">
                                Akomodasi
                            </a>
                            <a href="#" class="hover:text-black inline-flex items-end transition duration-150 ease-in-out">
                                Transportasi <i class="fa-solid fa-chevron-down text-xs ml-1 opacity-70 mb-1"></i>
                            </a>
                            <a href="#" class="hover:text-black inline-flex items-end transition duration-150 ease-in-out">
                                Aktivitas
                            </a>
                            <a href="#" class="hover:text-black inline-flex items-end transition duration-150 ease-in-out">
                                Kupon & Promo
                            </a>
                            <a href="#" class="hover:text-black inline-flex items-end transition duration-150 ease-in-out">
                                eSIM
                            </a>
                            <a href="#" class="hover:text-black inline-flex items-end transition duration-150 ease-in-out">
                                Panduan Perjalanan
                            </a>
                            <a href="{{ url('/my-bookings') }}" class="{{ request()->is('my-bookings') ? 'text-blue-600 font-bold' : 'hover:text-black' }} inline-flex items-end transition duration-150 ease-in-out ml-4">
                                Akun saya
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            {{-- PROFIL USER (Kanan Atas) --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger Mobile Menu --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- NAVIGASI MOBILE --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.airports.index')" :active="request()->routeIs('admin.airports.*')">
                    {{ __('Airports') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.airlines.index')" :active="request()->routeIs('admin.airlines.*')">
                    {{ __('Airlines') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.flights.index')" :active="request()->routeIs('admin.flights.*')">
                    {{ __('Flights') }}
                </x-responsive-nav-link>
                {{-- Mobile Transactions --}}
                <x-responsive-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.*')">
                    {{ __('Transactions') }}
                </x-responsive-nav-link>
            @else
                <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">Akomodasi</a>
                <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">Transportasi</a>
                <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">Aktivitas</a>
                <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out">Kupon & Promo</a>
                <x-responsive-nav-link :href="url('/my-bookings')" :active="request()->is('my-bookings')">
                    {{ __('My Bookings') }}
                </x-responsive-nav-link>
            @endif
        </div>

        {{-- Mobile Profile --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
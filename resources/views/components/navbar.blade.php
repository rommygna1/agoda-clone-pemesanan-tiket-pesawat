<nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-2 cursor-pointer no-underline">
                    <div class="flex gap-1">
                        <span class="h-3 w-3 rounded-full bg-red-500"></span>
                        <span class="h-3 w-3 rounded-full bg-yellow-400"></span>
                        <span class="h-3 w-3 rounded-full bg-green-500"></span>
                        <span class="h-3 w-3 rounded-full bg-blue-500"></span>
                        <span class="h-3 w-3 rounded-full bg-purple-500"></span>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-800 ml-2">agoda</span>
                </a>

                <div class="hidden md:ml-8 md:flex md:space-x-6 text-sm font-medium text-gray-600">
                    <a href="#" class="hover:text-blue-600 transition">Pesawat + Hotel</a>
                    <a href="#" class="hover:text-blue-600 transition">Akomodasi</a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                
                @guest
                    <div class="flex gap-3 items-center">
                        <a href="{{ route('login') }}" class="text-blue-600 font-bold text-sm hover:text-blue-800 transition px-3 py-2">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-blue-600 border border-blue-600 font-bold text-sm px-4 py-2 rounded hover:bg-blue-50 transition">
                            Buat akun
                        </a>
                    </div>
                @else
                    <div class="relative ml-3" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 focus:outline-none p-1 pr-2 rounded hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-bold text-gray-700 hidden sm:block">
                                {{ Auth::user()->name }}
                            </span>
                            <svg class="w-4 h-4 text-gray-500" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             style="display: none;"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-100 origin-top-right ring-1 ring-black ring-opacity-5">
                            
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                <p class="text-xs text-gray-500 uppercase font-bold">Akun Saya</p>
                                <p class="text-sm font-bold text-gray-900 truncate mt-1">{{ Auth::user()->email }}</p>
                            </div>

                            @if(Auth::user()->usertype === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-red-600 bg-red-50 hover:bg-red-100 font-bold transition">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Ke Dashboard Admin
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                            @endif

                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50 transition">
                                    <svg class="w-4 h-4 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
<header class="sticky top-0 bg-white shadow-md z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <nav class="flex items-center space-x-6 text-sm font-medium hidden md:flex">
                <a href="{{ route('movies.index') }}" class="{{ request()->routeIs('movies.*') ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                    Đặt vé phim
                </a>
                <a href="{{ route('showtimes.index') }}" class="{{ request()->routeIs('showtimes.*') ? 'text-red-600 font-bold' : 'text-gray-700' }} hover:text-gray-900 py-2 transition">
                    Lịch chiếu rạp
                </a>
                <a href="{{ route('movies.index') }}" class="{{ request()->routeIs('movies.*') ? 'text-red-600 font-bold' : 'text-gray-700' }} hover:text-gray-900 py-2 transition">
                    Phim
                </a>
                <a href="{{ route('news.index') }}" class="{{ request()->routeIs('news.*') ? 'text-red-600 font-bold' : 'text-gray-700' }} hover:text-gray-900 py-2 transition">
                    Tin tức
                </a>
            </nav>

            <div class="absolute left-1/2 transform -translate-x-1/2 md:static md:transform-none">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('logo.png') }}" alt="Cinema Logo" class="h-10 w-auto object-contain">
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <form action="{{ route('movies.index') }}" method="GET" class="relative hidden sm:block">
                    <input type="text" name="search" placeholder="Tìm kiếm phim..." class="w-48 lg:w-64 pl-4 pr-10 py-2 text-sm border border-gray-300 rounded-full focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false" class="p-1 hover:bg-gray-100 rounded-full transition focus:outline-none flex items-center">
                        @auth
                            @if(Auth::user()->avatar_url)
                                <img src="{{ asset(Auth::user()->avatar_url) }}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                            @else
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold uppercase">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        @else
                            <div class="p-2 bg-gray-100 rounded-full text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        @endauth
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl z-50 py-1 overflow-hidden origin-top-right" 
                         style="display: none;">
                        
                        @guest
                            <a href="{{ route('login') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition text-gray-700 font-medium">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                Đăng nhập
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition text-gray-700 font-medium">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Đăng ký
                            </a>
                        @endguest

                        @auth
                            <div class="px-4 py-3 border-b bg-gray-50">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            @if(in_array(Auth::user()->role, ['admin', 'manager']))
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 text-blue-600 transition font-semibold">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    Trang quản trị
                                </a>
                            @endif

                           {{-- Link đến trang Hồ sơ cá nhân --}}
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 hover:bg-gray-50 text-gray-700 transition">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Tài khoản
                            </a>

                            {{-- Link đến trang Lịch sử vé --}}
                            <a href="{{ route('booking.history') }}" class="flex items-center px-4 py-2 hover:bg-gray-50 text-gray-700 transition">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Lịch sử vé
                            </a>

                            <div class="border-t my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-red-600 hover:bg-red-50 transition font-medium">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                    Đăng xuất
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
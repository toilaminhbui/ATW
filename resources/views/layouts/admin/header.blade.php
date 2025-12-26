<header class="w-full flex justify-between items-center h-full px-6">
    <div>
        <h2 class="text-gray-500 text-sm">Welcome back,</h2>
        <p class="text-gray-800 font-bold text-lg">{{ Auth::user()->name }}</p>
    </div>

    <div class="flex items-center space-x-6">
        
        <button class="relative p-2 text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        <div class="h-6 w-px bg-gray-300"></div>

        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-gray-200 overflow-hidden border border-gray-300 flex items-center justify-center">
                @if(Auth::user()->avatar_url)
                    <img src="{{ str_starts_with(Auth::user()->avatar_url, 'http') ? Auth::user()->avatar_url : asset(Auth::user()->avatar_url) }}" 
                         alt="Admin Avatar" 
                         class="w-full h-full object-cover">
                @else
                    <svg class="text-gray-500 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                @endif
            </div>

            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Bạn có chắc chắn muốn đăng xuất không?');">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-sm text-red-600 hover:text-red-800 font-medium transition" title="Đăng xuất">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </div>
</header>
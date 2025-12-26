<div class="h-full flex flex-col bg-[#12263f] text-white shadow-xl">
    <div class="h-16 flex items-center justify-center border-b border-gray-700">
        <h1 class="text-xl font-bold tracking-wider text-blue-400">
            CINEMA ADMIN
        </h1>
    </div>

    {{-- Hiển thị thông tin người dùng đang đăng nhập --}}
    <div class="px-6 py-4 border-b border-gray-700 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-lg font-bold">
            {{ substr(auth()->user()->name, 0, 1) }}
        </div>
        <div>
            <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400 uppercase">{{ auth()->user()->role }}</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-2">
            
            {{-- NHÓM 1: CHỈ ADMIN MỚI THẤY (Dashboard Doanh thu) --}}
            @if(auth()->user()->role === 'admin')
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Dashboard</span>
                </a>
            </li>
            @endif

            {{-- NHÓM 2: ADMIN VÀ MANAGER ĐỀU THẤY --}}
            {{-- (Không cần if cũng được nếu middleware đã chặn, nhưng thêm vào để chắc chắn về mặt giao diện) --}}
            
            {{-- Quản lý Phim --}}
            <li>
                <a href="{{ route('admin.movies.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium {{ request()->routeIs('admin.movies.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                    <span>Quản lý Phim</span>
                </a>
            </li>

            {{-- Lịch chiếu --}}
            <li>
                <a href="{{ route('admin.showtimes.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium {{ request()->routeIs('admin.showtimes.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Lịch chiếu</span>
                </a>
            </li>

            {{-- Quản lý Rạp --}}
            <li>
                <a href="{{ route('admin.theaters.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium {{ request()->routeIs('admin.theaters.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span>Quản lý Rạp</span>
                </a>
            </li>

            {{-- Quản lý Banners --}}
            <li>
                <a href="{{ route('admin.banners.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium {{ request()->routeIs('admin.banners.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Quản lý Banners</span>
                </a>
            </li>

            {{-- Đơn hàng --}}
            <li>
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    <span>Đơn hàng</span>
                </a>
            </li>

            {{-- NHÓM 3: CHỈ ADMIN MỚI THẤY (Quản lý User) --}}
            @if(auth()->user()->role === 'admin')
            <li>
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Người dùng</span>
                </a>
            </li>
            @endif

            {{-- Tin tức (Admin và Manager) --}}
            <li>
                <a href="{{ route('admin.news.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors font-medium {{ request()->routeIs('admin.news.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <span>Tin tức</span>
                </a>
            </li>

            {{-- Phản hồi (Tùy bạn, thường Admin/Manager đều xem được) --}}
            {{-- <li>
                <a href="{{ route('admin.feedbacks.index') }}" ... --}}
        </ul>
    </nav>

    <div class="p-4 border-t border-gray-700 text-xs text-center text-gray-500">
        &copy; {{ date('Y') }} Cinema System
    </div>
</div>
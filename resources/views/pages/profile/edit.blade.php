@extends('layouts.app')
@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        
        {{-- HEADER BACKGROUND --}}
        <div class="h-40 bg-gradient-to-r from-[#12263f] to-[#1e3a5f] relative">
            <h1 class="absolute bottom-4 left-6 text-white text-3xl font-bold opacity-90">
                Hồ sơ cá nhân
            </h1>
        </div>

        <div class="relative px-8 pb-8">
            {{-- Thông báo thành công --}}
            @if (session('status') === 'profile-updated')
                <div class="absolute top-4 right-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-10 shadow-md" role="alert" id="success-alert">
                    <span class="block sm:inline font-medium">Cập nhật hồ sơ thành công!</span>
                </div>
            @endif

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                {{-- --- AVATAR (CHỈ HIỂN THỊ) --- --}}
                <div class="relative -mt-16 mb-8 flex items-end">
                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white flex items-center justify-center">
                        {{-- Hiển thị avatar_url nếu có, không thì tạo avatar theo tên --}}
                        <img src="{{ $user->avatar_url ? $user->avatar_url : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=256' }}" 
                             alt="{{ $user->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="ml-4 mb-2">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                        <span class="text-sm text-gray-500 font-medium bg-gray-100 px-2 py-1 rounded">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    {{-- CỘT TRÁI: THÔNG TIN CÁ NHÂN --}}
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Thông tin chung
                        </h3>
                        
                        {{-- Họ tên (Cho sửa) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Họ và Tên</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email (Read only) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Email
                            </label>
                            <div class="flex items-center bg-gray-100 border border-gray-200 rounded-lg p-3 text-gray-500 cursor-not-allowed select-none">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>{{ $user->email }}</span>
                            </div>
                        </div>

                        {{-- Ngày tham gia --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Ngày tham gia</label>
                            <div class="flex items-center space-x-2 text-gray-600">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- CỘT PHẢI: ĐỔI MẬT KHẨU --}}
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Đổi mật khẩu
                        </h3>
                        <p class="text-xs text-gray-500 mb-4 bg-blue-50 p-2 rounded border border-blue-100">
                            Để trống các ô bên dưới nếu bạn không muốn đổi mật khẩu.
                        </p>

                        {{-- 1. Mật khẩu CŨ --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Nhập mật khẩu đang dùng...">
                            @error('current_password') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- 2. Mật khẩu MỚI --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Mật khẩu mới</label>
                                <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Mật khẩu mới...">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- 3. Xác nhận Mật khẩu MỚI --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nhập lại mật khẩu mới</label>
                                <input type="password" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="Khớp với bên cạnh...">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BUTTON SUBMIT --}}
                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="flex items-center space-x-2 px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-lg font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        <span>Lưu thay đổi</span>
                    </button>
                </div>
            </form>

            {{-- FOOTER: LỊCH SỬ --}}
            <div class="mt-10 pt-6 border-t border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Hoạt động gần đây</h3>
                    <a href="{{ route('booking.history') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                        Xem lịch sử vé đã đặt <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Tự động ẩn thông báo thành công sau 3 giây
    setTimeout(function() {
        var alertBox = document.getElementById('success-alert');
        if(alertBox) {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = 0;
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000);
</script>
@endsection
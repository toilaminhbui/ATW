@extends('layouts.app')
@section('title', 'Đăng ký tài khoản')

@section('content')
<div class="flex justify-center items-center py-16 min-h-[60vh]">
    <div class="w-full max-w-md p-8 bg-white shadow-xl rounded-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Đăng Ký Thành Viên</h2>
        <p class="text-center text-gray-500 mb-6 text-sm">Tạo tài khoản để nhận ưu đãi vé phim</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       class="mt-1 block w-full px-3 py-2 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:ring-2 focus:ring-[#12263f] focus:border-transparent transition">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="mt-1 block w-full px-3 py-2 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:ring-2 focus:ring-[#12263f] focus:border-transparent transition">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                <input type="password" name="password" required 
                       class="mt-1 block w-full px-3 py-2 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:ring-2 focus:ring-[#12263f] focus:border-transparent transition">
                <p class="text-[10px] text-gray-400 mt-1">* Tối thiểu 8 ký tự, gồm chữ hoa, thường, số và ký tự đặc biệt.</p>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" required 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-[#12263f] focus:border-transparent transition">
            </div>

            <button type="submit" class="w-full py-3 bg-[#12263f] text-white font-bold rounded-md hover:bg-[#0f2036] shadow-md hover:shadow-lg transition duration-200">
                Đăng Ký
            </button>
        </form>
        
        <div class="mt-6 text-center text-sm border-t pt-4">
            Đã có tài khoản? <a href="{{ route('login') }}" class="text-[#12263f] font-bold hover:underline">Đăng nhập</a>
        </div>
    </div>
</div>
@endsection
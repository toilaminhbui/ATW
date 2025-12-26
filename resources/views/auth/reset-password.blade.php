@extends('layouts.app')
@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="flex justify-center items-center py-20 min-h-[50vh]">
    <div class="w-full max-w-sm p-8 bg-white shadow-xl rounded-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Đặt Lại Mật Khẩu</h2>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" 
                       value="{{ old('email', $email) }}" {{-- Ưu tiên hiển thị email từ controller --}}
                       required readonly 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mật khẩu mới</label>
                <input type="password" name="password" required autofocus
                       class="mt-1 block w-full px-3 py-2 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:ring-2 focus:ring-blue-900 transition">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nhập lại mật khẩu mới</label>
                <input type="password" name="password_confirmation" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-900 transition">
            </div>

            <button type="submit" class="w-full py-3 bg-blue-900 text-white font-bold rounded hover:bg-blue-800 transition shadow-lg">
                Xác Nhận Đổi
            </button>
        </form>
    </div>
</div>
@endsection
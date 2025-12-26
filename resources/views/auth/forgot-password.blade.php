@extends('layouts.app')
@section('title', 'Quên mật khẩu')

@section('content')
<div class="flex justify-center items-center py-20 min-h-[50vh]">
    <div class="w-full max-w-sm p-8 bg-white shadow-xl rounded-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Quên Mật Khẩu</h2>
        <p class="text-gray-500 text-sm text-center mb-6">
            Nhập email của bạn, chúng tôi sẽ gửi link để đặt lại mật khẩu.
        </p>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm font-medium rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Email đăng ký</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 block w-full px-3 py-2 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:ring-2 focus:ring-blue-900 focus:border-transparent transition">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full py-3 bg-blue-900 text-white font-bold rounded hover:bg-blue-800 transition shadow-lg">
                Gửi Link Reset
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900">Quay lại đăng nhập</a>
        </div>
    </div>
</div>
@endsection
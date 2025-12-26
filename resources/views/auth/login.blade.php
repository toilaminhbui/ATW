@extends('layouts.app')
@section('title', 'Đăng nhập')

@section('content')
{{-- Thêm Script reCAPTCHA của Google --}}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="flex justify-center items-center py-20 min-h-[60vh]">
    <div class="w-full max-w-sm p-8 bg-white shadow-xl rounded-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Đăng nhập tài khoản
        </h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm font-medium text-center rounded animate-pulse">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email" class="block text-base font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 block w-full px-3 py-2 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#12263f] focus:border-transparent sm:text-sm h-10 transition">
            </div>

            <div>
                <div class="flex justify-between items-center">
                    <label for="password" class="block text-base font-medium text-gray-700">Mật khẩu</label>
                    <a href="{{ route('password.request') }}" class="text-sm text-[#12263f] hover:underline">Quên mật khẩu?</a>
                </div>
                <input type="password" name="password" id="password" required 
                       class="mt-1 block w-full px-3 py-2 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#12263f] focus:border-transparent sm:text-sm h-10 transition">
            </div>

            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-[#12263f] focus:ring-[#12263f] border-gray-300 rounded cursor-pointer">
                <label for="remember" class="ml-2 block text-sm text-gray-900 cursor-pointer">Ghi nhớ đăng nhập</label>
            </div>

            {{-- --- PHẦN CAPTCHA MỚI THÊM --- --}}
            <div class="flex justify-center my-4">
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            </div>
            @if ($errors->has('g-recaptcha-response'))
                <span class="text-red-500 text-sm block text-center">
                    Vui lòng xác thực bạn không phải là robot.
                </span>
            @endif
            {{-- ----------------------------- --}}

            <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-md shadow-lg text-lg font-semibold text-white bg-[#12263f] hover:bg-[#0f2036] hover:shadow-xl transition duration-200">
                Đăng nhập
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <span class="text-gray-500">Chưa có tài khoản? </span>
            <a href="{{ route('register') }}" class="font-bold text-[#12263f] hover:underline">
                Đăng ký ngay!
            </a>
        </div>
    </div>
</div>
@endsection
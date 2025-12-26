@extends('layouts.app')
@section('title', 'Xác thực OTP')

@section('content')
<div class="flex justify-center items-center py-20 min-h-[60vh]">
    <div class="w-full max-w-sm p-8 bg-white shadow-xl rounded-lg border border-gray-100 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Xác Thực Hai Bước</h2>
        <p class="text-gray-500 mb-6 text-sm">Vui lòng nhập mã 6 số đã được gửi đến email của bạn.</p>

        @if(session('success'))
            <div class="mb-4 text-green-600 text-sm font-medium bg-green-50 p-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify.submit') }}" class="space-y-6">
            @csrf

            <div>
                <input type="text" name="otp" placeholder="Enter 6-digit code" maxlength="6" autofocus
                       class="block w-full text-center text-2xl tracking-widest px-3 py-3 border {{ $errors->has('otp') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#12263f] focus:border-transparent transition">
                @error('otp') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-md shadow-lg text-lg font-semibold text-white bg-[#12263f] hover:bg-[#0f2036] transition duration-200">
                Xác nhận
            </button>
        </form>

        <div class="mt-6 text-sm">
            <span class="text-gray-500">Không nhận được mã? </span>
            <form action="{{ route('otp.resend') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-[#12263f] font-bold hover:underline bg-transparent border-none cursor-pointer">
                    Gửi lại
                </button>
            </form>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('login') }}" class="text-gray-400 text-xs hover:text-gray-600">Quay lại đăng nhập</a>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title', 'Vé của tôi')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl min-h-screen">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Lịch sử đặt vé</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        @forelse($orders as $order)
            <div class="p-6 border-b last:border-0 hover:bg-gray-50 transition">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    {{-- Thông tin phim --}}
                    <div>
                        <h3 class="text-lg font-bold text-blue-900">{{ $order->movie_title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-semibold">{{ $order->theater_name }}</span> 
                            <span class="mx-2 text-gray-300">|</span>
                            {{ \Carbon\Carbon::parse($order->show_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($order->show_date)->format('d/m/Y') }}
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                Ghế: {{ $order->seat_list }}
                            </span>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-0.5 rounded">
                                Mã đơn: #{{ $order->id }}
                            </span>
                        </div>
                    </div>

                    {{-- Giá tiền --}}
                    <div class="text-left md:text-right min-w-[120px]">
                        <span class="block text-xl font-bold text-gray-800">
                            {{ number_format($order->total_price) }} đ
                        </span>
                        <span class="text-xs text-gray-500 block mt-1">
                            Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-10 text-center text-gray-500">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <p class="mb-4">Bạn chưa đặt vé nào.</p>
                <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Đặt vé ngay
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
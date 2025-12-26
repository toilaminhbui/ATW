@extends('layouts.app')
@section('title', $movie->title)

@section('content')
<div class="min-h-screen bg-gray-50 pb-20 font-sans text-[#333]">
    
    {{-- Banner / Header --}}
    <div class="relative h-[450px] md:h-[550px] bg-[#0f172a] overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center blur-xl opacity-40 scale-110" style="background-image: url('{{ asset($movie->image_url) }}')"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/60 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#0f172a]/90 via-[#0f172a]/40 to-transparent"></div>

        <div class="relative max-w-7xl mx-auto px-4 h-full flex flex-col md:flex-row items-end md:items-center pt-20 pb-10 gap-8">
            <div class="hidden md:block w-72 h-[420px] flex-shrink-0 rounded-xl shadow-2xl overflow-hidden border-4 border-white/10 relative z-10 transform translate-y-16">
                <img src="{{ asset($movie->image_url) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
            </div>

            <div class="text-white flex-1 mb-4 md:mb-0 relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-bold px-3 py-1 rounded uppercase tracking-wider {{ $movie->is_showing ? 'bg-green-500' : 'bg-orange-500' }}">
                        {{ $movie->is_showing ? "Đang chiếu" : "Sắp chiếu" }}
                    </span>
                    <span class="bg-white/20 text-white text-xs font-bold px-2 py-1 rounded border border-white/30">2D</span>
                </div>

                <h1 class="text-3xl md:text-5xl font-extrabold mb-4 leading-tight drop-shadow-lg">{{ $movie->title }}</h1>

                <div class="flex gap-4 mb-6">
                    <a href="{{ $movie->trailer_url }}" target="_blank" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-full font-bold transition shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Xem Trailer
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 mt-20 md:mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-8">
            
            {{-- Nội dung phim --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-[#12263f] mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                    Nội dung phim
                </h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line text-justify">{{ $movie->description }}</p>
            </div>

            {{-- Lịch Chiếu --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-[#12263f] mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Lịch Chiếu
                </h2>

                @if($groupedShowtimes->count() > 0)
                    <div class="space-y-8">
                        @foreach($groupedShowtimes as $theaterName => $showtimes)
                            <div class="border-b last:border-0 pb-6 last:pb-0 border-dashed border-gray-200">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="bg-blue-50 p-2 rounded-full">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <h3 class="font-bold text-lg text-gray-800">{{ $theaterName }}</h3>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    @foreach($showtimes as $show)
                                        {{-- ⚠️ ĐÃ SỬA: Thay booking.show thành booking.index --}}
                                        <a href="{{ route('booking.index', $show->id) }}" class="group flex flex-col items-center justify-center border border-gray-200 bg-white hover:bg-[#12263f] hover:border-[#12263f] hover:text-white rounded-xl px-5 py-2 transition-all min-w-[100px] shadow-sm hover:shadow-md">
                                            <span class="text-lg font-bold text-gray-800 group-hover:text-white">
                                                {{ \Carbon\Carbon::parse($show->show_time)->format('H:i') }}
                                            </span>
                                            <span class="text-[11px] text-gray-400 group-hover:text-gray-300 font-medium uppercase tracking-wider mt-1">
                                                {{ \Carbon\Carbon::parse($show->show_date)->format('d/m') }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <p class="text-gray-500 font-medium">Chưa có lịch chiếu cho phim này.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                <h3 class="font-bold text-gray-800 mb-6 text-lg border-l-4 border-blue-600 pl-3">Thông tin chi tiết</h3>
                <ul class="space-y-4 text-sm text-gray-600">
                    <li class="flex justify-between items-start border-b border-gray-50 pb-3">
                        <span class="text-gray-400 font-medium w-24">Khởi chiếu</span>
                        <span class="font-semibold text-right flex-1">{{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</span>
                    </li>
                    <li class="flex justify-between items-start">
                        <span class="text-gray-400 font-medium w-24">Thời lượng</span>
                        <span class="font-semibold text-right flex-1">{{ $movie->rating }} phút</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title', 'Tin tức điện ảnh')

@section('content')
<div class="min-h-screen bg-gray-100 font-sans">
    
    {{-- --- PHẦN 1: BANNERS TỪ CSDL --- --}}
    {{-- Sử dụng Carousel đơn giản với CSS Snap --}}
    @if($banners->count() > 0)
    <div class="relative w-full h-[100px] md:h-[150px] overflow-hidden bg-black group">
        {{-- Slider Wrapper --}}
        <div class="flex overflow-x-auto snap-x snap-mandatory h-full scrollbar-hide" id="banner-slider">
            @foreach($banners as $banner)
                <div class="snap-center flex-shrink-0 w-full h-full relative">
                    <img 
                        src="{{ asset($banner->image_url) }}" 
                        alt="Banner" 
                        class="w-full h-full object-cover opacity-60"
                    >
                    {{-- Overlay Text (Giống hình mẫu Tin điện ảnh) --}}
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                        <h1 class="text-1xl md:text-2xl font-bold text-white drop-shadow-lg mb-2 uppercase tracking-wider">
                            Tin Điện Ảnh
                        </h1>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Nút điều hướng (Ẩn hiện khi hover) --}}
        <button onclick="document.getElementById('banner-slider').scrollBy({left: -window.innerWidth, behavior: 'smooth'})" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button onclick="document.getElementById('banner-slider').scrollBy({left: window.innerWidth, behavior: 'smooth'})" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
    @else
        {{-- Fallback nếu chưa có banner --}}
        <div class="bg-[#12263f] text-white py-16 text-center">
            <h1 class="text-4xl font-bold">Tin Điện Ảnh</h1>
        </div>
    @endif


    {{-- --- PHẦN 2: DANH SÁCH TIN TỨC (DỌC) --- --}}
    <div class="max-w-5xl mx-auto px-4 py-10">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50">
                <h2 class="text-xl font-bold text-gray-800 border-l-4 border-blue-600 pl-3">Mới nhất</h2>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($newsList as $item)
                    {{-- Item Tin tức --}}
                    <div class="p-6 hover:bg-gray-50 transition duration-200">
                        <div class="flex flex-col md:flex-row gap-6">
                            
                            {{-- Ảnh Thumbnail (Bên trái) --}}
                            <div class="w-full md:w-64 h-40 flex-shrink-0">
                                <a href="{{ route('news.show', $item->id) }}" class="block w-full h-full overflow-hidden rounded-lg">
                                    <img 
                                        src="{{ Str::startsWith($item->image_url, 'http') ? $item->image_url : asset($item->image_url) }}" 
                                        alt="{{ $item->title }}" 
                                        class="w-full h-full object-cover transform hover:scale-105 transition duration-500"
                                        loading="lazy"
                                    >
                                </a>
                            </div>

                            {{-- Nội dung (Bên phải) --}}
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2 leading-tight">
                                        <a href="{{ route('news.show', $item->id) }}" class="hover:text-blue-600 transition">
                                            {{ $item->title }}
                                        </a>
                                    </h3>
                                    
                                    {{-- Meta info --}}
                                    <div class="flex items-center text-xs text-gray-500 mb-3 space-x-2">
                                        <span class="font-medium text-red-500">{{ $item->author ?? 'Admin' }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $item->created_at->diffForHumans() }}</span> 
                                        {{-- diffForHumans() sẽ hiển thị dạng "2 giờ trước", "1 ngày trước" --}}
                                    </div>

                                    {{-- Tóm tắt --}}
                                    <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed">
                                        {{ $item->summary ?? Str::limit(strip_tags($item->content), 150) }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-500">
                        Chưa có tin tức nào được đăng tải.
                    </div>
                @endforelse
            </div>

            {{-- Phân trang --}}
            @if($newsList->hasPages())
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    {{ $newsList->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Style ẩn thanh cuộn cho slider --}}
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection
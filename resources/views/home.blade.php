@extends('layouts.app')
@section('title', 'Trang chủ')

@section('content')
<div class="min-h-screen bg-white font-sans text-[#333]">
    
    <div class="relative w-full h-[200px] md:h-[300px] bg-[#0f172a] overflow-hidden group">
        @if(count($banners) > 0)
            <div class="swiper mySwiper h-full w-full">
                <div class="swiper-wrapper">
                    @foreach($banners as $banner)
                        <div class="swiper-slide relative w-full h-full">
                            <img src="{{ Str::startsWith($banner->image_url, 'http') ? $banner->image_url : asset($banner->image_url) }}" 
                                 class="w-full h-full object-cover" alt="Banner">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent opacity-90"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-transparent"></div>

                            <div class="absolute bottom-10 left-4 md:bottom-20 md:left-20 max-w-2xl text-white z-10 p-4">
                                <h2 class="text-3xl md:text-5xl font-extrabold mb-4 leading-tight drop-shadow-lg">
                                    Trải Nghiệm Điện Ảnh <br /> Đỉnh Cao
                                </h2>
                                <div class="flex gap-4 mt-6">
                                    <a href="{{ route('movies.index') }}" class="bg-white text-[#12263f] hover:bg-gray-100 px-8 py-3 rounded-full font-bold transition flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        Đặt vé ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        @else
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-30">
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            </div>
            <div class="relative z-10 h-full flex flex-col justify-center items-center text-center px-4">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-500/20 text-blue-300 text-xs font-bold tracking-wider mb-4 border border-blue-500/30">RẠP CHIẾU PHIM HIỆN ĐẠI</span>
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight leading-tight text-white">
                    Thế Giới Điện Ảnh <br /> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">Trong Tầm Tay Bạn</span>
                </h1>
                <a href="{{ route('movies.index') }}" class="bg-[#e71a0f] hover:bg-[#c4160c] text-white px-8 py-3 rounded-full font-bold transition shadow-lg flex items-center gap-2">
                    Đặt vé ngay <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 -mt-8 relative z-20 bg-white rounded-t-3xl shadow-xl border-t border-gray-100" 
         x-data="{ activeTab: 'showing' }">
        
        <div class="flex justify-center mb-10 mt-6">
            <div class="flex space-x-8 text-[16px] uppercase font-bold tracking-wide">
                <button @click="activeTab = 'showing'" 
                        :class="activeTab === 'showing' ? 'text-[#12263f] border-[#e71a0f]' : 'text-gray-400 border-transparent hover:text-gray-600'"
                        class="pb-2 transition-all border-b-2">
                    Đang chiếu
                </button>
                <span class="text-gray-300 font-light">|</span>
                <button @click="activeTab = 'upcoming'" 
                        :class="activeTab === 'upcoming' ? 'text-[#12263f] border-[#e71a0f]' : 'text-gray-400 border-transparent hover:text-gray-600'"
                        class="pb-2 transition-all border-b-2">
                    Sắp chiếu
                </button>
            </div>
        </div>

        <div class="min-h-[400px]">
            
            <div x-show="activeTab === 'showing'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-8 mb-16">
                    @foreach($showingMovies as $movie)
                        @include('partials.movie-card', ['movie' => $movie])
                    @endforeach
                </div>
            </div>

            <div x-show="activeTab === 'upcoming'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-8 mb-16">
                    @foreach($upcomingMovies as $movie)
                        @include('partials.movie-card', ['movie' => $movie])
                    @endforeach
                </div>
            </div>

        </div>

        @if(count($newsList) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-10 border-t border-gray-100">
                <div class="lg:col-span-2">
                    @php $firstNews = $newsList->first(); @endphp
                    <a href="{{ route('news.show', $firstNews->id) }}" class="group block h-full flex flex-col">
                        <div class="rounded-lg overflow-hidden mb-4 relative aspect-video shadow-sm">
                            <img src="{{ asset($firstNews->image_url) }}" alt="{{ $firstNews->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <h2 class="text-[24px] font-bold text-[#333] mb-3 group-hover:text-[#e71a0f] transition-colors leading-tight">
                            {{ $firstNews->title }}
                        </h2>
                        <div class="flex items-center text-[13px] text-gray-500 mb-3 space-x-2">
                            <span class="text-[#e71a0f] font-bold uppercase">{{ $firstNews->category ?? 'Tin điện ảnh' }}</span>
                            <span class="text-gray-300">•</span>
                            <span>{{ $firstNews->created_at->format('d/m/Y') }}</span>
                        </div>
                        <p class="text-[15px] text-gray-600 leading-relaxed line-clamp-3">{{ $firstNews->summary }}</p>
                    </a>
                </div>

                <div class="lg:col-span-1 flex flex-col gap-0">
                    @foreach($newsList->slice(1) as $item)
                        <a href="{{ route('news.show', $item->id) }}" class="group block border-b border-gray-100 py-4 first:pt-0 last:border-0">
                            <h3 class="text-[15px] font-bold text-[#333] mb-2 leading-snug group-hover:text-[#e71a0f] transition-colors line-clamp-2">
                                {{ $item->title }}
                            </h3>
                            <div class="flex items-center text-[12px] text-gray-400 space-x-2">
                                <span class="text-[#e71a0f] font-semibold">{{ $item->category ?? 'Review' }}</span>
                                <span class="text-gray-300">•</span>
                                <span>{{ $item->created_at->format('d/m/Y') }}</span>
                            </div>
                        </a>
                    @endforeach
                    
                    <div class="mt-6 text-center lg:text-left">
                        <a href="{{ route('news.index') }}" class="inline-flex items-center text-[#e71a0f] font-bold text-sm hover:underline">
                            XEM TẤT CẢ TIN TỨC <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".mySwiper", {
        effect: "fade",
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
    });
</script>
@endsection
@extends('layouts.app')
@section('title', 'Danh sách phim')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-[#333]">
    
    {{-- --- PHẦN 1: BANNERS ĐỘNG TỪ CSDL --- --}}
    @if(isset($banners) && $banners->count() > 0)
        <div class="relative w-full h-[100px] md:h-[150px] overflow-hidden bg-black group">
            {{-- Slider Wrapper --}}
            <div class="flex overflow-x-auto snap-x snap-mandatory h-full scrollbar-hide" id="movie-banner-slider">
                @foreach($banners as $banner)
                    <div class="snap-center flex-shrink-0 w-full h-full relative">
                        <img 
                            src="{{ asset($banner->image_url) }}" 
                            alt="Banner Phim" 
                            class="w-full h-full object-cover opacity-70"
                        >
                        {{-- Overlay Text (Giống style cũ nhưng nằm trên banner) --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                        <h1 class="text-1xl md:text-2xl font-bold text-white drop-shadow-lg mb-2 uppercase tracking-wider">
                            Kho phim khổng lồ
                        </h1>
                    </div>
                    </div>
                @endforeach
            </div>

            {{-- Nút điều hướng Slider --}}
            <button onclick="document.getElementById('movie-banner-slider').scrollBy({left: -window.innerWidth, behavior: 'smooth'})" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition duration-300 backdrop-blur-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button onclick="document.getElementById('movie-banner-slider').scrollBy({left: window.innerWidth, behavior: 'smooth'})" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition duration-300 backdrop-blur-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    @else
        {{-- Fallback: Nếu chưa có banner nào trong DB thì hiển thị lại cái cũ --}}
        <div class="relative bg-[#0f172a] text-white py-16 overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
                    Kho Phim <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500">Khổng Lồ</span>
                </h1>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Cập nhật liên tục các bộ phim bom tấn, phim nghệ thuật và phim chiếu rạp mới nhất.
                </p>
            </div>
        </div>
    @endif

    {{-- --- PHẦN 2: DANH SÁCH & BỘ LỌC --- --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 -mt-8 relative z-20">
        {{-- Thanh công cụ lọc --}}
        <div class="bg-white rounded-xl shadow-lg p-4 mb-10 border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            
            <div class="flex bg-gray-100 p-1 rounded-lg w-full md:w-auto">
                <a href="{{ route('movies.index', ['tab' => 'showing']) }}" 
                   class="flex-1 md:flex-none px-6 py-2 rounded-md text-sm font-bold transition-all duration-200 {{ $tab == 'showing' ? 'bg-white text-[#12263f] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Đang Chiếu
                </a>
                <a href="{{ route('movies.index', ['tab' => 'upcoming']) }}" 
                   class="flex-1 md:flex-none px-6 py-2 rounded-md text-sm font-bold transition-all duration-200 {{ $tab == 'upcoming' ? 'bg-white text-[#12263f] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Sắp Chiếu
                </a>
            </div>

            <form method="GET" action="{{ route('movies.index') }}" class="relative w-full md:w-96 group">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm tên phim..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm">
                <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>

        {{-- Lưới phim --}}
        @if($movies->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-6 gap-y-10">
                @foreach($movies as $movie)
                    <div class="group flex flex-col h-full">
                        <div class="relative rounded-xl overflow-hidden mb-4 shadow-md group-hover:shadow-2xl transition-all duration-500 bg-gray-200">
                            <a href="{{ route('movies.show', $movie->id) }}">
                                <div class="aspect-[2/3] w-full relative overflow-hidden">
                                    <img src="{{ asset($movie->image_url) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                                        <span class="text-white text-xs font-medium mb-2 opacity-90 line-clamp-2">{{ $movie->description }}</span>
                                    </div>
                                </div>
                            </a>
                            
                            <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-md text-white text-xs font-bold px-2 py-1 rounded-md flex items-center gap-1">
                                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                {{ $movie->rating }}
                            </div>
                        </div>

                        <div class="flex flex-col flex-1">
                            <h3 class="text-base font-bold text-gray-800 line-clamp-1 mb-1 group-hover:text-red-600 transition-colors">
                                <a href="{{ route('movies.show', $movie->id) }}">{{ $movie->title }}</a>
                            </h3>
                            <div class="flex items-center justify-between text-xs text-gray-500 font-medium mb-3">
                                <span>{{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</span>
                                <span>{{ $movie->rating }} phút</span>
                            </div>
                            
                            <a href="{{ route('movies.show', $movie->id) }}" 
                               class="mt-auto w-full py-2.5 rounded-lg text-sm font-bold flex items-center justify-center gap-2 transition-all shadow-sm {{ $tab == 'showing' ? 'bg-[#e71a0f] text-white hover:bg-[#c4160c]' : 'bg-[#12263f] text-white hover:bg-[#0f172a]' }}">
                                {{ $tab == 'showing' ? 'Mua Vé' : 'Chi Tiết' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-10">
                {{ $movies->withQueryString()->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                <div class="bg-gray-50 p-6 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Không tìm thấy phim nào</h3>
                <p class="text-gray-500 text-sm">Thử thay đổi từ khóa tìm kiếm hoặc chuyển tab khác xem sao nhé.</p>
            </div>
        @endif
    </div>
</div>

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
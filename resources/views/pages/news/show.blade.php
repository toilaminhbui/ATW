@extends('layouts.app') {{-- Giả sử bạn có layout chính, nếu không hãy bỏ dòng này và thêm thẻ html/body --}}

@section('content')
<div class="min-h-screen bg-gray-50 pb-20">
    {{-- --- HEADER IMAGE / BREADCRUMB --- --}}
    <div class="bg-[#12263f] text-white py-12">
        <div class="max-w-4xl mx-auto px-4">
            {{-- Nút quay lại --}}
            <a href="{{ route('news.index') }}" class="inline-flex items-center text-blue-300 hover:text-white transition mb-6">
                {{-- Icon ArrowLeft --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Quay lại tin tức
            </a>

            <div class="block mb-4">
                <span class="inline-block bg-blue-600 text-xs font-bold px-2 py-1 rounded uppercase">
                    {{ $news->category ?? 'Tin tức chung' }}
                </span>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-6">
                {{ $news->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-300">
                {{-- Tác giả --}}
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>{{ $news->author ?? 'Admin' }}</span>
                </div>
                
                {{-- Ngày tháng --}}
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span>{{ \Carbon\Carbon::parse($news->created_at)->format('d/m/Y') }}</span>
                </div>

                {{-- Thời gian đọc (Hardcode hoặc tính toán) --}}
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span>5 phút đọc</span>
                </div>
            </div>
        </div>
    </div>

    {{-- --- MAIN CONTENT --- --}}
    <div class="max-w-4xl mx-auto px-4 -mt-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden p-8">
            
            {{-- Ảnh bìa bài viết --}}
            @if($news->image_url)
            <div class="mb-8 rounded-lg overflow-hidden shadow-sm">
                {{-- Logic hiển thị ảnh: Nếu là link http thì dùng luôn, nếu không thì dùng asset storage --}}
                <img 
                    src="{{ Str::startsWith($news->image_url, 'http') ? $news->image_url : asset($news->image_url) }}" 
                    alt="{{ $news->title }}" 
                    class="w-full h-auto object-cover max-h-[500px]"
                        >
            </div>
            @endif

            {{-- Tóm tắt (Sapo) --}}
            @if($news->summary)
            <div class="text-lg font-semibold text-gray-700 mb-8 border-l-4 border-blue-600 pl-4 italic">
                {{ $news->summary }}
            </div>
            @endif

            {{-- Nội dung chi tiết (HTML) --}}
            {{-- LƯU Ý BẢO MẬT: {!! !!} sẽ in raw HTML. Dữ liệu này PHẢI được sanitize ở Backend trước khi lưu vào DB --}}
            <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                {!! $news->content !!}
            </div>

            {{-- Footer bài viết --}}
            <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
                <div class="flex items-center gap-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94 .94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                    <span class="text-sm">
                        Từ khóa: Phim, Rạp chiếu, Review
                    </span>
                </div>
                
                <button class="text-blue-600 font-medium hover:underline flex items-center gap-1">
                    Chia sẻ bài viết
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
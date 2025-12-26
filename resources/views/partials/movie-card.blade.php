<div class="group flex flex-col h-full">
    <div class="relative rounded-lg overflow-hidden mb-3 shadow-sm group-hover:shadow-md transition-shadow">
        <a href="{{ route('movies.show', $movie->id) }}">
            <div class="aspect-[2/3] w-full relative">
                <img src="{{ Str::startsWith($movie->image_url, 'http') ? $movie->image_url : asset($movie->image_url) }}" 
                     alt="{{ $movie->title }}" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
            </div>
        </a>
        <a href="{{ route('movies.show', $movie->id) }}" 
           class="block w-full bg-[#e71a0f] text-white text-center py-2 text-[13px] font-bold uppercase hover:bg-[#c4160c] transition-colors">
            Mua vé
        </a>
    </div>
    
    <div class="px-1 flex flex-col flex-1">
        <h3 class="text-[15px] font-bold text-[#333] mb-1 leading-snug line-clamp-2 min-h-[40px] group-hover:text-[#e71a0f] transition-colors">
            <a href="{{ route('movies.show', $movie->id) }}">{{ $movie->title }}</a>
        </h3>
        <div class="flex items-center text-[13px] font-medium mt-auto pt-1 border-t border-gray-50">
            <span class="text-gray-500">{{ \Carbon\Carbon::parse($movie->release_date)->format('d/m') }}</span>
            @if($movie->rating > 0)
                <span class="ml-auto flex items-center gap-1 text-[#44c052]">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"/></svg>
                    <span>{{ $movie->rating }}%</span>
                </span>
            @endif
        </div>
    </div>
</div>
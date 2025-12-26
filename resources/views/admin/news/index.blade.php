@extends('layouts.admin')
@section('title', 'Quản lý Tin tức')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Quản lý Tin tức</h1>
        <a href="{{ route('admin.news.create') }}" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Viết bài mới
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Hình ảnh</th>
                    <th class="p-4">Tiêu đề / Tóm tắt</th>
                    <th class="p-4">Danh mục</th>
                    <th class="p-4">Tác giả</th>
                    <th class="p-4 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @foreach($news as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-medium">#{{ $item->id }}</td>
                        <td class="p-4">
                            <img src="{{ asset($item->image_url) }}" class="w-16 h-12 object-cover rounded shadow-sm">
                        </td>
                        <td class="p-4 max-w-md">
                            <div class="font-bold text-gray-800 line-clamp-1">{{ $item->title }}</div>
                            <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $item->summary }}</div>
                        </td>
                        <td class="p-4">
                            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-medium">{{ $item->category }}</span>
                            @if($item->movie)
                                <div class="mt-1 text-[10px] text-gray-400">Phim: {{ $item->movie->title }}</div>
                            @endif
                        </td>
                        <td class="p-4 text-gray-600">{{ $item->author }}</td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Xóa bài viết này?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-100">{{ $news->links() }}</div>
    </div>
@endsection
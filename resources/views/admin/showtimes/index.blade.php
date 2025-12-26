@extends('layouts.admin')
@section('title', 'Quản lý Lịch Chiếu')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Quản lý Lịch Chiếu</h1>
        
        <a href="{{ route('admin.showtimes.create') }}" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm lịch chiếu
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
                    <th class="p-4">Phim</th>
                    <th class="p-4">Rạp / Phòng</th>
                    <th class="p-4">Ngày giờ chiếu</th>
                    <th class="p-4">Giá vé (Thường / VIP)</th>
                    <th class="p-4 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($showtimes as $st)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-medium">#{{ $st->id }}</td>
                        
                        {{-- Cột Phim --}}
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ $st->movie->title ?? 'Phim đã xóa' }}</div>
                        </td>

                        {{-- Cột Rạp --}}
                        <td class="p-4">
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold border border-gray-200">
                                {{ $st->theater->name ?? 'Rạp đã xóa' }}
                            </span>
                        </td>

                        {{-- Ngày giờ --}}
                        <td class="p-4">
                            <div class="font-medium text-blue-600">
                                {{ \Carbon\Carbon::parse($st->show_time)->format('H:i') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($st->show_date)->format('d/m/Y') }}
                            </div>
                        </td>

                        {{-- Giá vé --}}
                        <td class="p-4">
                            <div class="text-xs space-y-1">
                                <div class="flex justify-between w-32">
                                    <span class="text-gray-500">Thường:</span>
                                    <span class="font-medium">{{ number_format($st->normal_price) }}đ</span>
                                </div>
                                <div class="flex justify-between w-32">
                                    <span class="text-gray-500">VIP:</span>
                                    <span class="font-medium text-purple-600">{{ number_format($st->vip_price) }}đ</span>
                                </div>
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.showtimes.edit', $st->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.showtimes.destroy', $st->id) }}" method="POST" onsubmit="return confirm('Xóa lịch chiếu này?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-gray-500">Chưa có lịch chiếu nào.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-4 border-t border-gray-100">{{ $showtimes->links() }}</div>
    </div>
@endsection
@extends('layouts.admin')
@section('title', 'Quản lý Rạp Chiếu')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Quản lý Rạp Chiếu</h1>
        
        <a href="{{ route('admin.theaters.create') }}" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm phòng chiếu
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
                    <th class="p-4">Tên Phòng/Rạp</th>
                    <th class="p-4">Vị trí (Tầng)</th>
                    <th class="p-4">Loại màn hình</th>
                    <th class="p-4">Tổng số ghế</th>
                    <th class="p-4 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($theaters as $theater)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-medium">#{{ $theater->id }}</td>
                        
                        <td class="p-4 font-bold text-gray-800">
                            {{ $theater->name }}
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $theater->address ?? '---' }}
                        </td>

                        <td class="p-4">
                            @php
                                $badgeColor = match($theater->type) {
                                    'IMAX' => 'bg-purple-100 text-purple-700',
                                    '3D' => 'bg-orange-100 text-orange-700',
                                    default => 'bg-blue-100 text-blue-700',
                                };
                            @endphp
                            <span class="text-xs font-bold px-2 py-1 rounded {{ $badgeColor }}">
                                {{ $theater->type }}
                            </span>
                        </td>

                        <td class="p-4 font-medium">
                            {{ $theater->total_seats }} ghế
                        </td>

                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                {{-- Nút Sửa --}}
                                <a href="{{ route('admin.theaters.edit', $theater->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded transition" title="Sửa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                
                                {{-- Nút Xóa --}}
                                <form action="{{ route('admin.theaters.destroy', $theater->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa phòng chiếu này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded transition" title="Xóa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            Chưa có phòng chiếu nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-4 border-t border-gray-100">
            {{ $theaters->links() }}
        </div>
    </div>
@endsection
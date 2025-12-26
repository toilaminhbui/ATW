@extends('layouts.admin')
@section('title', 'Quản lý Banner')

@section('content')
    {{-- Header: Tiêu đề & Nút thêm mới --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Quản lý Banner</h1>
        
        <a href="{{ route('admin.banners.create') }}" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            {{-- Icon Plus --}}
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm banner mới
        </a>
    </div>

    {{-- Alert thông báo --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table danh sách --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Hình ảnh</th>
                    <th class="p-4">Tên File</th>
                    <th class="p-4">Ngày tạo</th>
                    <th class="p-4 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($banners as $banner)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-medium">#{{ $banner->id }}</td>
                        
                        <td class="p-4">
                            {{-- Banner thường nằm ngang nên để w-32 h-auto sẽ đẹp hơn poster phim dọc --}}
                            <div class="w-32 h-16 rounded overflow-hidden shadow-sm border border-gray-200 bg-gray-100">
                                <img 
                                    src="{{ asset($banner->image_url) }}" 
                                    alt="Banner" 
                                    class="w-full h-full object-cover"
                                    onerror="this.src='https://via.placeholder.com/150?text=Error'"
                                >
                            </div>
                        </td>

                        <td class="p-4 font-semibold text-gray-800">
                            {{ $banner->file_name }}
                        </td>

                        <td class="p-4">
                            {{ $banner->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                {{-- Nút Xóa (Banner thường ít khi Sửa, chỉ Xóa đi tạo lại, nhưng nếu cần Sửa thì thêm vào sau) --}}
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa banner này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded transition" title="Xóa">
                                        {{-- Icon Trash --}}
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            Chưa có banner nào được tạo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        {{-- Phân trang (Nếu controller dùng paginate) --}}
        @if($banners instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="p-4 border-t border-gray-100">
                {{ $banners->links() }}
            </div>
        @endif
    </div>
@endsection
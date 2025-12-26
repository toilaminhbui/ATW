@extends('layouts.admin')
@section('title', 'Thêm Rạp Mới')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-2 mb-6 text-gray-500 text-sm">
        <a href="{{ route('admin.theaters.index') }}" class="hover:text-blue-600">Quản lý Rạp</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Thêm mới</span>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Thông tin phòng chiếu</h2>

        <form action="{{ route('admin.theaters.store') }}" method="POST">
            @csrf
            
            {{-- Tên Rạp --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tên Phòng / Rạp <span class="text-red-500">*</span></label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" placeholder="Ví dụ: Phòng 01, IMAX Hall..." required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                {{-- Loại Rạp --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Loại màn hình</label>
                    <select name="type" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                        <option value="2D">Standard (2D)</option>
                        <option value="3D">3D</option>
                        <option value="IMAX">IMAX</option>
                        <option value="4DX">4DX</option>
                    </select>
                </div>

                {{-- Tổng số ghế --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tổng số ghế <span class="text-red-500">*</span></label>
                    <input type="number" name="total_seats" value="60" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" min="1" required>
                </div>
            </div>

            {{-- Địa chỉ / Vị trí --}}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Vị trí (Tùy chọn)</label>
                <input type="text" name="address" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" placeholder="Ví dụ: Tầng 3, Khu A">
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.theaters.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">Hủy bỏ</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                    Lưu phòng chiếu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
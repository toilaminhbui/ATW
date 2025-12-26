@extends('layouts.admin')
@section('title', 'Thêm Lịch Chiếu')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-2 mb-6 text-gray-500 text-sm">
        <a href="{{ route('admin.showtimes.index') }}" class="hover:text-blue-600">Lịch Chiếu</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Thêm mới</span>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Tạo lịch chiếu mới</h2>

        <form action="{{ route('admin.showtimes.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Chọn Phim --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Chọn Phim <span class="text-red-500">*</span></label>
                    <select name="movie_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                        <option value="">-- Chọn phim --</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Chọn Rạp --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Chọn Rạp/Phòng <span class="text-red-500">*</span></label>
                    <select name="theater_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                        <option value="">-- Chọn rạp --</option>
                        @foreach($theaters as $theater)
                            <option value="{{ $theater->id }}">
                                {{ $theater->name }} ({{ $theater->type }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Ngày chiếu --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ngày chiếu</label>
                    <input type="date" name="show_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                </div>

                {{-- Giờ chiếu --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Giờ chiếu</label>
                    <input type="time" name="show_time" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                {{-- Giá vé thường --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Giá vé Thường (VNĐ)</label>
                    <input type="number" name="normal_price" value="50000" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                </div>

                {{-- Giá vé VIP --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Giá vé VIP (VNĐ)</label>
                    <input type="number" name="vip_price" value="90000" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.showtimes.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">Hủy</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">Lưu lịch chiếu</button>
            </div>
        </form>
    </div>
</div>
@endsection
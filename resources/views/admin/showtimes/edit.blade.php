@extends('layouts.admin')
@section('title', 'Cập nhật Lịch Chiếu')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-2 mb-6 text-gray-500 text-sm">
        <a href="{{ route('admin.showtimes.index') }}" class="hover:text-blue-600">Lịch Chiếu</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Cập nhật #{{ $showtime->id }}</span>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Cập nhật lịch chiếu</h2>

        <form action="{{ route('admin.showtimes.update', $showtime->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Chọn Phim --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Phim</label>
                    <select name="movie_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ $showtime->movie_id == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Chọn Rạp --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Rạp</label>
                    <select name="theater_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                        @foreach($theaters as $theater)
                            <option value="{{ $theater->id }}" {{ $showtime->theater_id == $theater->id ? 'selected' : '' }}>
                                {{ $theater->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ngày chiếu</label>
                    <input type="date" name="show_date" value="{{ $showtime->show_date }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Giờ chiếu</label>
                    <input type="time" name="show_time" value="{{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Giá vé Thường</label>
                    <input type="number" name="normal_price" value="{{ $showtime->normal_price }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Giá vé VIP</label>
                    <input type="number" name="vip_price" value="{{ $showtime->vip_price }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.showtimes.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">Hủy</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
@endsection
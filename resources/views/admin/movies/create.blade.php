@extends('layouts.admin')
@section('title', 'Thêm phim mới')

@section('content')
<div class="w-full">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.movies.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Thêm phim mới</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên phim</label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ngày khởi chiếu</label>
                            <input type="date" name="release_date" value="{{ old('release_date') }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                            @error('release_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Thời lượng (phút)</label>
                            <input type="number" name="rating" value="{{ old('rating') }}" required min="0" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                            @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Trailer (Youtube)</label>
                        <input type="url" name="trailer_url" value="{{ old('trailer_url') }}" required placeholder="https://www.youtube.com/watch?v=..." class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                        @error('trailer_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-wrap gap-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="is_showing" value="1" {{ old('is_showing') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">Đang chiếu</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="is_upcoming" value="1" {{ old('is_upcoming') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">Sắp chiếu</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="is_hot" value="1" {{ old('is_hot') ? 'checked' : '' }} class="w-4 h-4 text-red-600 rounded focus:ring-red-500">
                            <span class="text-sm font-medium text-red-600">Phim HOT</span>
                        </label>
                    </div>
                </div>

                <div class="space-y-6">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Poster Phim</label>
                        <div class="flex items-start gap-6">
                            <div class="w-32 h-48 bg-gray-100 rounded-lg border border-gray-200 overflow-hidden flex-shrink-0 shadow-sm flex items-center justify-center relative">
                                <img id="preview-img" src="#" alt="Preview" class="w-full h-full object-cover hidden">
                                
                                <div id="placeholder-icon" class="text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>

                            <div class="flex-1">
                                <label class="block mb-2 text-sm text-gray-500">Chọn ảnh từ máy tính</label>
                                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2" 
                                       name="image" 
                                       type="file" 
                                       accept="image/*" 
                                       required
                                       onchange="previewImage(event)">
                                <p class="mt-1 text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
                                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="h-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả nội dung</label>
                        <textarea name="description" required rows="6" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t mt-2">
                <a href="{{ route('admin.movies.index') }}" class="px-6 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg transition font-medium">Hủy bỏ</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition shadow-md hover:shadow-lg">
                    Lưu phim mới
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview-img');
            const placeholder = document.getElementById('placeholder-icon');
            
            output.src = reader.result;
            output.classList.remove('hidden'); // Hiện ảnh
            placeholder.classList.add('hidden'); // Ẩn icon placeholder
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
@extends('layouts.admin')
@section('title', 'Viết bài mới')

@section('content')
<div class="w-full">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.news.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Viết bài mới</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề bài viết</label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tóm tắt (Summary)</label>
                        <textarea name="summary" rows="3" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('summary') }}</textarea>
                        @error('summary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nội dung chi tiết</label>
                        <textarea id="editor" name="content">{{ old('content') }}</textarea>
                        @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh bìa bài viết</label>
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-full h-48 bg-gray-100 rounded-lg border border-gray-200 overflow-hidden flex items-center justify-center relative">
                                <img id="preview-img" src="#" alt="Preview" class="w-full h-full object-cover hidden">
                                <div id="placeholder-icon" class="text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2" 
                                   name="image" type="file" accept="image/*" required onchange="previewImage(event)">
                        </div>
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                        <select name="category" class="w-full border border-gray-300 rounded-lg p-2.5">
                            <option value="Tin tức">Tin tức chung</option>
                            <option value="Review">Review Phim</option>
                            <option value="Khuyến mãi">Khuyến mãi</option>
                            <option value="Sự kiện">Sự kiện</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phim liên quan (Optional)</label>
                        <select name="movie_id" class="w-full border border-gray-300 rounded-lg p-2.5">
                            <option value="">-- Không chọn --</option>
                            @foreach($movies as $movie)
                                <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Chọn nếu bài viết này review về một bộ phim cụ thể.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t mt-2">
                <a href="{{ route('admin.news.index') }}" class="px-6 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg transition font-medium">Hủy bỏ</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition shadow-md">Đăng bài</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // 1. CKEditor setup
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => { console.error(error); });

    // 2. Preview Image
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview-img');
            const placeholder = document.getElementById('placeholder-icon');
            output.src = reader.result;
            output.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
    }
</script>
<style>
    /* Fix chiều cao CKEditor */
    .ck-editor__editable_inline { min-height: 300px; }
</style>
@endsection
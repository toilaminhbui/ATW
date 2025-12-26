@extends('layouts.admin')
@section('title', 'Sửa bài viết')

@section('content')
<div class="w-full">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.news.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Sửa bài viết: {{ $news->title }}</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề bài viết</label>
                        <input type="text" name="title" value="{{ old('title', $news->title) }}" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tóm tắt</label>
                        <textarea name="summary" rows="3" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('summary', $news->summary) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nội dung chi tiết</label>
                        <textarea id="editor" name="content">{{ old('content', $news->content) }}</textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh bìa</label>
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-full h-48 bg-gray-100 rounded-lg border border-gray-200 overflow-hidden flex items-center justify-center relative">
                                <img id="preview-img" src="{{ asset($news->image_url) }}" alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 p-2" 
                                   name="image" type="file" accept="image/*" onchange="previewImage(event)">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                        <select name="category" class="w-full border border-gray-300 rounded-lg p-2.5">
                            @foreach(['Tin tức', 'Review', 'Khuyến mãi', 'Sự kiện'] as $cat)
                                <option value="{{ $cat }}" {{ $news->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phim liên quan</label>
                        <select name="movie_id" class="w-full border border-gray-300 rounded-lg p-2.5">
                            <option value="">-- Không chọn --</option>
                            @foreach($movies as $movie)
                                <option value="{{ $movie->id }}" {{ $news->movie_id == $movie->id ? 'selected' : '' }}>{{ $movie->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t mt-2">
                <a href="{{ route('admin.news.index') }}" class="px-6 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg transition font-medium">Hủy bỏ</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition shadow-md">Cập nhật bài viết</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#editor')).catch(error => { console.error(error); });
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){ document.getElementById('preview-img').src = reader.result; };
        if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
    }
</script>
<style>.ck-editor__editable_inline { min-height: 300px; }</style>
@endsection
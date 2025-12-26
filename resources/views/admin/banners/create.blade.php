@extends('layouts.admin')
@section('title', 'Thêm banners mới')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        {{-- Nút quay lại --}}
        <a href="{{ route('admin.banners.index') }}" class="text-gray-500 hover:text-blue-600 flex items-center mb-4 transition">
            ← Quay lại danh sách
        </a>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">Upload Banner Mới</h2>
            </div>
            
            <div class="p-6">
                {{-- Form Upload --}}
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Input File --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Chọn hình ảnh</label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Tải ảnh lên</span>
                                        <input id="file-upload" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 5MB</p>
                            </div>
                        </div>

                        {{-- Hiển thị lỗi validation --}}
                        @error('image')
                            <p class="text-red-500 text-xs mt-2 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview ảnh trước khi upload --}}
                    <div class="mb-6 hidden" id="preview-container">
                        <p class="text-sm font-bold text-gray-700 mb-2">Xem trước:</p>
                        <img id="preview-img" class="w-full h-64 object-cover rounded-lg shadow-sm border">
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition">Hủy bỏ</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded shadow transition">
                            Lưu Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script xem trước ảnh đơn giản
    function previewImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('preview-container');
        const previewImg = document.getElementById('preview-img');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
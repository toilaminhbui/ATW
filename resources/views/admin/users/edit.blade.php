@extends('layouts.admin')
@section('title', 'Cập nhật User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Cập nhật: {{ $user->name }}</h2>
        
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Email (Không thể sửa)</label>
                <input type="email" value="{{ $user->email }}" class="w-full border rounded-lg px-4 py-2 bg-gray-100 text-gray-500" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Họ tên</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded-lg px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Mật khẩu mới (Để trống nếu không đổi)</label>
                <input type="password" name="password" class="w-full border rounded-lg px-4 py-2" placeholder="********">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Vai trò</label>
                <select name="role" class="w-full border rounded-lg px-4 py-2 bg-white">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Khách hàng</option>
                    <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Quản lý</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">* Chỉ Admin mới có quyền thay đổi mục này.</p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">Hủy</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
@endsection
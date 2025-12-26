@extends('layouts.admin')
@section('title', 'Quản lý Người dùng')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Danh sách Người dùng</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tạo User mới
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    {{-- Bộ lọc --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-700 mb-1">Tìm kiếm</label>
                <input type="text" name="search" value="{{ request('search') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Tên hoặc Email...">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Vai trò</label>
                <select name="role" class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white min-w-[150px]">
                    <option value="">Tất cả</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Customer</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">Lọc</button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-200">Reset</a>
        </form>
    </div>

    {{-- Bảng --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Thông tin</th>
                    <th class="p-4">Vai trò</th>
                    <th class="p-4">Ngày tham gia</th>
                    <th class="p-4 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4">#{{ $user->id }}</td>
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="p-4">
                            @php
                                $colors = [
                                    'admin' => 'bg-red-100 text-red-700',
                                    'manager' => 'bg-blue-100 text-blue-700',
                                    'user' => 'bg-green-100 text-green-700'
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-bold uppercase {{ $colors[$user->role] ?? 'bg-gray-100' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:bg-blue-50 p-2 rounded"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Xóa người dùng này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded {{ $user->id == auth()->id() ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $user->id == auth()->id() ? 'disabled' : '' }}>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-6 text-center text-gray-500">Không tìm thấy user nào.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-100">{{ $users->withQueryString()->links() }}</div>
    </div>
@endsection
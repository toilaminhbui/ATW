@extends('layouts.admin')
@section('title', 'Quản lý Đơn Vé')

@section('content')
    <div class="flex justify-between items-end mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Danh sách Đơn vé</h1>
            <p class="text-sm text-gray-500 mt-1">Quản lý lịch sử đặt vé của khách hàng</p>
        </div>
    </div>

    {{-- Form Tìm kiếm & Lọc --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            
            {{-- Tìm từ khóa --}}
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-700 mb-1">Tìm kiếm</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500" 
                    placeholder="Mã đơn, Tên khách, Email, Tên phim...">
            </div>

            {{-- Lọc ngày đặt --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Ngày đặt</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
            </div>

            {{-- Nút Filter --}}
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Lọc
            </button>
            
            {{-- Nút Reset --}}
            @if(request()->has('keyword') || request()->has('date'))
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium transition">
                    Xóa lọc
                </a>
            @endif
        </form>
    </div>

    {{-- Bảng danh sách --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4 border-b">Mã Đơn</th>
                        <th class="p-4 border-b">Khách hàng</th>
                        <th class="p-4 border-b">Thông tin Phim</th>
                        <th class="p-4 border-b">Ghế & Rạp</th>
                        <th class="p-4 border-b">Tổng tiền</th>
                        <th class="p-4 border-b">Ngày đặt</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            {{-- Mã đơn --}}
                            <td class="p-4 font-mono font-bold text-blue-600">
                                #{{ $order->id }}
                            </td>
                            
                            {{-- Khách hàng --}}
                            <td class="p-4">
                                <div class="font-bold text-gray-800">{{ $order->user_name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->user_email }}</div>
                            </td>

                            {{-- Phim --}}
                            <td class="p-4">
                                <div class="font-bold text-gray-800 line-clamp-1 max-w-[200px]" title="{{ $order->movie_title }}">
                                    {{ $order->movie_title }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ \Carbon\Carbon::parse($order->show_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($order->show_date)->format('d/m/Y') }}
                                </div>
                            </td>

                            {{-- Ghế --}}
                            <td class="p-4">
                                <div class="font-bold text-gray-800">{{ $order->theater_name }}</div>
                                <div class="mt-1">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-0.5 rounded">
                                        {{ $order->seat_list }}
                                    </span>
                                </div>
                            </td>

                            {{-- Tiền --}}
                            <td class="p-4 font-bold text-green-600">
                                {{ number_format($order->total_price) }} đ
                            </td>

                            {{-- Ngày đặt --}}
                            <td class="p-4 text-gray-500 text-xs">
                                {{ $order->created_at->format('H:i d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    <p>Không tìm thấy đơn hàng nào.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Phân trang --}}
        <div class="p-4 border-t border-gray-100">
            {{-- withQueryString() giúp giữ lại các tham số tìm kiếm khi chuyển trang --}}
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
@endsection
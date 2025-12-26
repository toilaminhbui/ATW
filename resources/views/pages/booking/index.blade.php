@extends('layouts.app')
@section('title', 'Đặt vé - ' . $showtime->movie->title)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    {{-- Header: Thông tin phim --}}
    <div class="flex items-center gap-6 mb-8 bg-white p-6 rounded-xl shadow-sm">
        <img src="{{ asset($showtime->movie->image_url) }}" class="w-24 h-36 object-cover rounded-lg shadow">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $showtime->movie->title }}</h1>
            <p class="text-gray-600 mt-1">Rạp: <span class="font-bold text-blue-600">{{ $showtime->theater->name }}</span></p>
            <p class="text-gray-600">Suất chiếu: <span class="font-bold">{{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }}</span> - {{ \Carbon\Carbon::parse($showtime->show_date)->format('d/m/Y') }}</p>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6 text-center font-bold">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Cột trái: Sơ đồ ghế --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm">
            <h2 class="text-center text-gray-400 mb-2 text-sm uppercase tracking-widest">Màn hình chiếu</h2>
            <div class="w-full h-2 bg-gray-300 rounded-full mb-10 shadow-lg relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-gray-200 to-white opacity-50"></div>
            </div>

            <form action="{{ route('booking.book') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                
                {{-- Grid ghế: Chia thành 10 cột --}}
                <div class="grid grid-cols-10 gap-2 md:gap-3 justify-center mx-auto max-w-lg">
                    @foreach($seats as $seat)
                        @php
                            // Xác định màu ghế
                            $isBooked = $seat->booked_by ? true : false;
                            $isVip = $seat->seat_type == 'VIP';
                            
                            // Class cơ bản
                            $classes = "relative flex items-center justify-center h-8 md:h-10 rounded text-xs font-bold transition cursor-pointer select-none";
                            
                            if ($isBooked) {
                                $classes .= " bg-gray-300 text-gray-500 cursor-not-allowed"; // Ghế đã đặt
                            } elseif ($isVip) {
                                $classes .= " border-2 border-orange-400 text-orange-600 hover:bg-orange-50 peer-checked:bg-orange-500 peer-checked:text-white peer-checked:border-orange-500"; // Ghế VIP
                            } else {
                                $classes .= " border border-gray-300 text-gray-600 hover:bg-blue-50 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600"; // Ghế thường
                            }
                        @endphp

                        <label class="group relative">
                            {{-- Checkbox ẩn để xử lý logic --}}
                            <input type="checkbox" name="seats[]" value="{{ $seat->seat_number }}" 
                                class="peer sr-only" 
                                {{ $isBooked ? 'disabled' : '' }}
                                data-price="{{ $isVip ? $showtime->vip_price : $showtime->normal_price }}"
                                onchange="updateTotal()"
                            >
                            
                            {{-- Giao diện ghế hiển thị --}}
                            <div class="{{ $classes }}">
                                {{ $seat->seat_number }}
                            </div>
                        </label>
                    @endforeach
                </div>

                {{-- Chú thích --}}
                <div class="flex justify-center gap-6 mt-10 text-sm text-gray-600">
                    <div class="flex items-center gap-2"><div class="w-5 h-5 border border-gray-300 rounded"></div> Thường</div>
                    <div class="flex items-center gap-2"><div class="w-5 h-5 border-2 border-orange-400 rounded"></div> VIP</div>
                    <div class="flex items-center gap-2"><div class="w-5 h-5 bg-blue-600 rounded"></div> Đang chọn</div>
                    <div class="flex items-center gap-2"><div class="w-5 h-5 bg-gray-300 rounded"></div> Đã đặt</div>
                </div>
            </form>
        </div>

        {{-- Cột phải: Thông tin thanh toán --}}
        <div class="bg-white p-6 rounded-xl shadow-sm h-fit sticky top-4">
            <h3 class="text-lg font-bold border-b pb-4 mb-4">Tổng cộng</h3>
            
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Ghế đang chọn:</span>
                <span class="font-bold text-gray-800" id="selectedSeatsCount">0</span>
            </div>
            
            <div class="flex justify-between mb-6 text-xl">
                <span class="font-bold text-gray-800">Thành tiền:</span>
                <span class="font-bold text-blue-600" id="totalPrice">0 đ</span>
            </div>

            <button type="submit" form="bookingForm" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-lg">
                Xác nhận đặt vé
            </button>
        </div>
    </div>
</div>

<script>
    // JS thuần để tính tiền ngay trên giao diện
    function updateTotal() {
        const checkboxes = document.querySelectorAll('input[name="seats[]"]:checked');
        let total = 0;
        let count = 0;

        checkboxes.forEach(box => {
            total += parseInt(box.getAttribute('data-price'));
            count++;
        });

        document.getElementById('selectedSeatsCount').innerText = count;
        // Format tiền tệ VNĐ
        document.getElementById('totalPrice').innerText = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
    }
</script>
@endsection
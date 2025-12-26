@extends('layouts.admin')
@section('title', 'Dashboard Thống Kê')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tổng quan hệ thống</h1>
        <p class="text-gray-500 text-sm">Chào mừng quay trở lại, Admin!</p>
    </div>

    {{-- 1. CARDS STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-green-600 uppercase mb-1">Doanh thu</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['revenue']) }} đ</h3>
                </div>
                <div class="p-2 bg-green-100 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-blue-600 uppercase mb-1">Vé đã bán</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['tickets']) }}</h3>
                </div>
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-purple-600 uppercase mb-1">Khách hàng</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['users']) }}</h3>
                </div>
                <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-orange-600 uppercase mb-1">Tổng phim</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['movies'] }}</h3>
                </div>
                <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- 2. BIỂU ĐỒ (Chiếm 2/3) --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Doanh thu 7 ngày qua</h3>
            <div class="relative h-72 w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- 3. TOP PHIM (Chiếm 1/3) --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Top 5 Phim Hot</h3>
            <div class="overflow-y-auto max-h-80">
                <table class="w-full text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                        <tr>
                            <th class="px-3 py-2">Phim</th>
                            <th class="px-3 py-2 text-right">Vé</th>
                            <th class="px-3 py-2 text-right">Thu</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @foreach($topMovies as $movie)
                        <tr>
                            <td class="px-3 py-3 font-medium text-gray-800 line-clamp-1" title="{{ $movie->movie_title }}">
                                {{ $movie->movie_title }}
                            </td>
                            <td class="px-3 py-3 text-right font-bold text-blue-600">
                                {{ $movie->ticket_count }}
                            </td>
                            <td class="px-3 py-3 text-right text-gray-600 text-xs">
                                {{ number_format($movie->revenue) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SCRIPT VẼ BIỂU ĐỒ --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Nhận dữ liệu từ Laravel Controller
        const labels = @json($chartLabels);
        const data = @json($chartValues);

        new Chart(ctx, {
            type: 'line', // Loại biểu đồ: đường
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: data,
                    borderColor: '#2563eb', // Màu xanh blue-600
                    backgroundColor: 'rgba(37, 99, 235, 0.1)', // Màu nền mờ dưới đường
                    borderWidth: 2,
                    tension: 0.3, // Độ cong của đường
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Ẩn chú thích nếu không cần
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Format tiền tệ trục Y
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', maximumSignificantDigits: 3 }).format(value);
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
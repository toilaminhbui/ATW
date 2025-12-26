<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Thống kê tổng quan (Cards)
        $stats = [
            'revenue' => OrderDetail::sum('total_price'),
            'tickets' => OrderDetail::count(), // Hoặc sum('quantity') nếu bảng có cột số lượng
            'users'   => User::where('role', 'user')->count(),
            'movies'  => Movie::count(),
        ];

        // 2. Biểu đồ doanh thu 7 ngày gần nhất
        $revenueData = OrderDetail::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        // Chuẩn bị dữ liệu cho Chart.js
        // Mảng ngày (Trục hoành)
        $chartLabels = $revenueData->pluck('date')->map(function($date){
            return Carbon::parse($date)->format('d/m');
        })->toArray();
        
        // Mảng tiền (Trục tung)
        $chartValues = $revenueData->pluck('total')->toArray();

        // 3. Top 5 Phim bán chạy nhất
        $topMovies = OrderDetail::select(
            'movie_title',
            'movie_id', // Lấy thêm ID để link tới trang chi tiết phim nếu cần
            DB::raw('count(*) as ticket_count'),
            DB::raw('SUM(total_price) as revenue')
        )
        ->groupBy('movie_title', 'movie_id')
        ->orderBy('revenue', 'desc')
        ->limit(5)
        ->get();

        return view('admin.dashboard.index', compact('stats', 'chartLabels', 'chartValues', 'topMovies'));
    }
}
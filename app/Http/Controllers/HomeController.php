<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\News;
use App\Models\MovieBanner; // 1. Sử dụng đúng Model bạn đã tạo
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Lấy phim Đang chiếu (is_showing = 1)
        $showingMovies = Movie::where('is_showing', true)
                            ->orderBy('release_date', 'desc')
                            ->take(12)
                            ->get();

        // 2. Lấy phim Sắp chiếu (is_upcoming = 1)
        $upcomingMovies = Movie::where('is_upcoming', true)
                               ->orderBy('release_date', 'asc')
                               ->take(12)
                               ->get();

        // 3. Lấy Tin tức mới nhất
        $newsList = News::orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

        // 4. Lấy Banners từ Database (Đã sửa)
        // Lấy tất cả banner mới nhất
        $banners = MovieBanner::latest()->get(); 

        return view('home', compact('showingMovies', 'upcomingMovies', 'newsList', 'banners'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\MovieBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    // Hiển thị trang chủ hoặc trang danh sách banner cho khách
    public function index()
    {
        // Lấy danh sách banner mới nhất
        $banners = MovieBanner::latest()->get();

        // Trả về View hiển thị (Ví dụ: Trang chủ có Slider)
        return view('home', compact('banners')); 
        // Hoặc: return view('banners.index', compact('banners'));
    }
}
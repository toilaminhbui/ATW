<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieBanner;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Trang danh sách phim (MoviesPage)
    public function index(Request $request)
    {
        $query = Movie::query();

        // 1. Tìm kiếm
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 2. Lọc theo Tab
        $tab = $request->get('tab', 'showing');
        if ($tab === 'upcoming') {
            $query->where('is_upcoming', true);
        } else {
            $query->where('is_showing', true);
        }

        // 3. Lấy dữ liệu phim
        $movies = $query->orderBy('release_date', 'desc')->paginate(12);

        // 4. Lấy Banners từ CSDL (Mới thêm)
        $banners = MovieBanner::latest()->get();

        return view('pages.movies.index', compact('movies', 'tab', 'banners'));
    }

    // Trang chi tiết phim (MovieDetailPage)
    public function show($id)
    {
        $movie = Movie::with(['showtimes' => function($q) {
            $q->orderBy('show_date')->orderBy('show_time')->with('theater');
        }])->findOrFail($id);

        // Group lịch chiếu theo tên rạp (Thay thế hàm JS groupShowtimesByTheater)
        $groupedShowtimes = $movie->showtimes->groupBy(function ($item) {
            return $item->theater ? $item->theater->name : 'Rạp khác';
        });

        return view('pages.movies.show', compact('movie', 'groupedShowtimes'));
    }
}
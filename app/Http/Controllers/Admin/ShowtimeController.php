<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Theater;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    /**
     * Hiển thị danh sách lịch chiếu
     */
    public function index()
    {
        // Eager load movie và theater để tránh N+1 Query
        $showtimes = Showtime::with(['movie', 'theater'])
            ->orderByDesc('show_date')
            ->orderBy('show_time')
            ->paginate(10);

        return view('admin.showtimes.index', compact('showtimes'));
    }

    /**
     * Form thêm mới
     */
    public function create()
    {
        // Lấy danh sách phim đang chiếu hoặc sắp chiếu để chọn
        $movies = Movie::where('is_showing', true)->orWhere('is_upcoming', true)->get();
        $theaters = Theater::all();

        return view('admin.showtimes.create', compact('movies', 'theaters'));
    }

    /**
     * Lưu lịch chiếu
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'show_date' => 'required|date',
            'show_time' => 'required',
            'normal_price' => 'required|integer|min:0',
            'vip_price' => 'required|integer|min:0',
        ]);

        Showtime::create($request->all());

        return redirect()->route('admin.showtimes.index')->with('success', 'Tạo lịch chiếu thành công!');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit($id)
    {
        $showtime = Showtime::findOrFail($id);
        $movies = Movie::all();
        $theaters = Theater::all();

        return view('admin.showtimes.edit', compact('showtime', 'movies', 'theaters'));
    }

    /**
     * Cập nhật
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'show_date' => 'required|date',
            'show_time' => 'required',
            'normal_price' => 'required|integer|min:0',
            'vip_price' => 'required|integer|min:0',
        ]);

        $showtime = Showtime::findOrFail($id);
        $showtime->update($request->all());

        return redirect()->route('admin.showtimes.index')->with('success', 'Cập nhật lịch chiếu thành công!');
    }

    /**
     * Xóa
     */
    public function destroy($id)
    {
        Showtime::destroy($id);
        return redirect()->route('admin.showtimes.index')->with('success', 'Đã xóa lịch chiếu!');
    }
}
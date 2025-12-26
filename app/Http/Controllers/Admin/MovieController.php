<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie; // Đảm bảo đã import Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    // 1. Danh sách phim
    public function index()
    {
        $movies = Movie::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    // 2. Giao diện Thêm mới (GET)
    public function create()
    {
        return view('admin.movies.create');
    }

    // 3. Xử lý Thêm mới (POST)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'trailer_url' => 'required|url',
            'image' => 'required|image|max:2048', // Bắt buộc có ảnh
            'description' => 'required|string',
            'release_date' => 'required|date',
            'rating' => 'required|integer|min:0',
        ], [
            'image.required' => 'Vui lòng chọn poster phim.',
            'image.max' => 'Kích thước ảnh tối đa là 2MB.'
        ]);

        $data = $request->except('image');
        
        // Checkbox: Nếu không tích thì trả về false
        $data['is_hot'] = $request->has('is_hot');
        $data['is_showing'] = $request->has('is_showing');
        $data['is_upcoming'] = $request->has('is_upcoming');

        // Upload ảnh
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('movies', $fileName, 'public');
            $data['image_url'] = '/storage/' . $path;
            $data['file_name'] = $fileName;
        }

        Movie::create($data);

        return redirect()->route('admin.movies.index')->with('success', 'Thêm phim mới thành công!');
    }

    // 4. Giao diện Chỉnh sửa (GET)
    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    // 5. Xử lý Cập nhật (PUT)
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'trailer_url' => 'required|url',
            'image' => 'nullable|image|max:2048', // Ảnh không bắt buộc khi sửa
            'description' => 'required|string',
            'release_date' => 'required|date',
            'rating' => 'required|integer|min:0',
        ]);

        $data = $request->except(['image', '_method', '_token']);
        
        $data['is_hot'] = $request->has('is_hot');
        $data['is_showing'] = $request->has('is_showing');
        $data['is_upcoming'] = $request->has('is_upcoming');

        // Xử lý ảnh mới nếu có upload
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($movie->file_name && Storage::disk('public')->exists('movies/' . $movie->file_name)) {
                Storage::disk('public')->delete('movies/' . $movie->file_name);
            }
            
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('movies', $fileName, 'public');
            $data['image_url'] = '/storage/' . $path;
            $data['file_name'] = $fileName;
        }

        $movie->update($data);

        return redirect()->route('admin.movies.index')->with('success', 'Cập nhật phim thành công!');
    }

    // 6. Xóa phim
    public function destroy(Movie $movie)
    {
        if ($movie->file_name && Storage::disk('public')->exists('movies/' . $movie->file_name)) {
            Storage::disk('public')->delete('movies/' . $movie->file_name);
        }
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Đã xóa phim!');
    }
}
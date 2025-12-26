<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Movie; // Để lấy list phim cho dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use Mews\Purifier\Facades\Purifier; // Uncomment nếu đã cài package này

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('movie')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $movies = Movie::select('id', 'title')->get();
        return view('admin.news.create', compact('movies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'required|image|max:2048',
            'category' => 'nullable|string',
            'movie_id' => 'nullable|exists:movies,id',
        ]);

        $data = $request->except('image');
        
        // Xử lý dữ liệu (Nếu chưa cài Purifier thì dùng strip_tags hoặc để nguyên)
        // $data['content'] = clean($request->content); 
        $data['author'] = Auth::user()->name;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('news', $fileName, 'public');
            $data['image_url'] = '/storage/' . $path;
            $data['file_name'] = $fileName;
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Đã đăng bài viết mới!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $movies = Movie::select('id', 'title')->get();
        return view('admin.news.edit', compact('news', 'movies'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['image', '_method', '_token']);
        
        // $data['content'] = clean($request->content); 

        if ($request->hasFile('image')) {
            if ($news->file_name && Storage::disk('public')->exists('news/' . $news->file_name)) {
                Storage::disk('public')->delete('news/' . $news->file_name);
            }

            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('news', $fileName, 'public');
            $data['image_url'] = '/storage/' . $path;
            $data['file_name'] = $fileName;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        if ($news->file_name && Storage::disk('public')->exists('news/' . $news->file_name)) {
            Storage::disk('public')->delete('news/' . $news->file_name);
        }
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Đã xóa bài viết!');
    }
}
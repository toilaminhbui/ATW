<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\MovieBanner;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        // 1. Lấy danh sách tin tức (Mới nhất lên đầu, phân trang 10 bài)
        $newsList = News::orderBy('created_at', 'desc')->paginate(10);

        // 2. Lấy danh sách Banners từ CSDL
        $banners = MovieBanner::latest()->get();

        return view('pages.news.index', compact('newsList', 'banners'));
    }

    public function show($id)
    {
    // 1. Đổi $article thành $news
    $news = News::findOrFail($id); 

    // Logic lấy tin liên quan (sửa $article thành $news ở đây luôn)
    $relatedNews = News::where('category', $news->category) // Sửa $article->category
                        ->where('id', '!=', $id)
                        ->limit(4)
                        ->get();

    // 2. Truyền biến $news vào view
    // Lúc trước là: compact('article', 'relatedNews')
    // Sửa thành:
    return view('pages.news.show', compact('news', 'relatedNews'));
    }
}
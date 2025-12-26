<?php

namespace App\Http\Controllers\Admin; // Namespace dành riêng cho Admin

use App\Http\Controllers\Controller;
use App\Models\MovieBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    // Danh sách banner (Giao diện Admin - dạng bảng)
    public function index()
    {
       $banners = MovieBanner::latest()->paginate(10);
    
        return view('admin.banners.index', compact('banners'));
    }

    // Form thêm mới
    public function create()
    {
        return view('admin.banners.create');
    }

    // Xử lý lưu banner
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // Max 5MB
        ], [
            'image.required' => 'Vui lòng chọn ảnh',
            'image.image' => 'File phải là định dạng ảnh',
            'image.max' => 'Ảnh không được quá 5MB',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Lưu vào storage/app/public/banners
            $path = $file->storeAs('banners', $fileName, 'public');

            MovieBanner::create([
                'image_url' => '/storage/' . $path,
                'file_name' => $fileName
            ]);

            return redirect()->route('admin.banners.index')->with('success', 'Thêm banner thành công!');
        }

        return back()->with('error', 'Lỗi upload ảnh');
    }

    // Xóa banner
    public function destroy($id)
    {
        $banner = MovieBanner::findOrFail($id);

        if ($banner->file_name && Storage::disk('public')->exists('banners/' . $banner->file_name)) {
            Storage::disk('public')->delete('banners/' . $banner->file_name);
        }

        $banner->delete();

        return redirect()->back()->with('success', 'Đã xóa banner!');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    /**
     * Hiển thị danh sách rạp
     */
    public function index()
    {
        // Phân trang 10 rạp mỗi trang
        $theaters = Theater::latest()->paginate(10);
        return view('admin.theaters.index', compact('theaters'));
    }

    /**
     * Form thêm mới
     */
    public function create()
    {
        return view('admin.theaters.create');
    }

    /**
     * Lưu rạp mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'type' => 'required|string',
            'total_seats' => 'required|integer|min:1'
        ], [
            'name.required' => 'Tên rạp không được để trống',
            'total_seats.min' => 'Số ghế phải lớn hơn 0'
        ]);

        Theater::create($request->all());

        return redirect()->route('admin.theaters.index')->with('success', 'Thêm rạp chiếu thành công!');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit($id)
    {
        $theater = Theater::findOrFail($id);
        return view('admin.theaters.edit', compact('theater'));
    }

    /**
     * Cập nhật rạp
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'total_seats' => 'required|integer|min:1'
        ]);

        $theater = Theater::findOrFail($id);
        $theater->update($request->all());

        return redirect()->route('admin.theaters.index')->with('success', 'Cập nhật thông tin rạp thành công!');
    }

    /**
     * Xóa rạp
     */
    public function destroy($id)
    {
        $theater = Theater::findOrFail($id);
        $theater->delete();

        return redirect()->route('admin.theaters.index')->with('success', 'Đã xóa rạp chiếu!');
    }
}
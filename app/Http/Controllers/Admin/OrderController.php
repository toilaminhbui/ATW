<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng (kèm lọc và tìm kiếm)
     */
    public function index(Request $request)
    {
        $query = OrderDetail::query();

        // 1. Tìm kiếm theo ID, Email hoặc Tên
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('id', 'like', "%$keyword%")
                  ->orWhere('user_email', 'like', "%$keyword%")
                  ->orWhere('user_name', 'like', "%$keyword%")
                  ->orWhere('movie_title', 'like', "%$keyword%"); // Thêm tìm theo tên phim
            });
        }

        // 2. Lọc theo ngày đặt
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Sắp xếp đơn mới nhất lên đầu và phân trang
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }
}
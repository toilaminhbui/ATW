<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Showtime;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // 1. Hiển thị sơ đồ ghế (View)
    public function index($showtimeId)
    {
        // Kiểm tra và tạo ghế nếu chưa có
        $count = Seat::where('showtime_id', $showtimeId)->count();
        if ($count == 0) {
            $this->generateSeats($showtimeId);
        }

        // Lấy danh sách ghế
        $seats = Seat::where('showtime_id', $showtimeId)->get();
        
        // Lấy thông tin suất chiếu + phim + rạp
        $showtime = Showtime::with(['movie', 'theater'])->findOrFail($showtimeId);

        return view('pages.booking.index', compact('showtime', 'seats'));
    }

    // Helper tạo ghế (Giữ nguyên)
    private function generateSeats($showtimeId)
    {
        $rows = ['A', 'B', 'C', 'D', 'E', 'F'];
        $data = [];
        foreach ($rows as $row) {
            for ($i = 1; $i <= 10; $i++) {
                $type = in_array($row, ['D', 'E']) ? 'VIP' : 'NORMAL'; // D, E là hàng VIP
                $data[] = [
                    'seat_number' => $row . $i,
                    'seat_type' => $type,
                    'showtime_id' => $showtimeId,
                    'created_at' => now(), 'updated_at' => now(),
                ];
            }
        }
        Seat::insert($data);
    }

    // 2. Xử lý đặt vé (Form POST)
    public function bookTicket(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats' => 'required|array|min:1', // seats là mảng checkbox
        ], [
            'seats.required' => 'Vui lòng chọn ít nhất 1 ghế.'
        ]);

        $user = Auth::user();
        $seatList = $request->seats; // Mảng các ghế được chọn (VD: ['A1', 'A2'])
        
        $showtime = Showtime::with(['movie', 'theater'])->findOrFail($request->showtime_id);

        try {
            DB::beginTransaction();

            // Lock rows để tránh trùng
            $lockedSeats = Seat::where('showtime_id', $showtime->id)
                ->whereIn('seat_number', $seatList)
                ->lockForUpdate()
                ->get();

            // Kiểm tra lại lần cuối xem có ai nhanh tay đặt trước không
            foreach ($lockedSeats as $seat) {
                if ($seat->booked_by) {
                    DB::rollBack();
                    return back()->with('error', "Ghế {$seat->seat_number} vừa có người đặt. Vui lòng chọn ghế khác.");
                }
            }

            $totalPrice = 0;
            foreach ($lockedSeats as $seat) {
                $price = ($seat->seat_type == 'VIP') ? $showtime->vip_price : $showtime->normal_price;
                $totalPrice += $price;
                
                $seat->booked_by = $user->email; // Đánh dấu đã đặt
                $seat->save();
            }

            // Tạo hóa đơn
            OrderDetail::create([
                'showtime_id' => $showtime->id,
                'theater_name' => $showtime->theater->name ?? 'Rạp mặc định',
                'movie_id' => $showtime->movie_id,
                'movie_title' => $showtime->movie->title,
                'show_time' => $showtime->show_time,
                'show_date' => $showtime->show_date,
                'seat_list' => implode(', ', $seatList),
                'total_price' => $totalPrice,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
            ]);

            DB::commit();

            return redirect()->route('booking.history')->with('success', 'Đặt vé thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    // 3. Xem lịch sử vé
    public function history()
    {
        $user = Auth::user();
        $orders = OrderDetail::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.booking.history', compact('orders'));
    }
}
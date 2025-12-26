<?php

use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;

// Import Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Controllers\Admin\TheaterController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;


/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Ai cũng truy cập được)
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Phim & Lịch chiếu
// Lưu ý: Route booking.index cần tham số, không nên gọi trực tiếp từ menu nếu không có ID
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/showtimes', [HomeController::class, 'index'])->name('showtimes.index'); // Tạm trỏ về Home hoặc trang lịch chiếu riêng

// Tin tức
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');


/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATION (Đăng nhập, Đăng ký, Quên mật khẩu)
|--------------------------------------------------------------------------
*/

// Nhóm khách (Chưa đăng nhập)
Route::middleware('guest')->group(function () {
    // Đăng nhập & Đăng ký
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Quên mật khẩu
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

    // Xác thực OTP
    Route::get('/verify-otp', [AuthController::class, 'showVerifyForm'])->name('otp.verify');
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('otp.verify.submit');
    Route::post('/resend-otp', [AuthController::class, 'resendOTP'])->name('otp.resend');
});

// Đăng xuất (Cần đăng nhập mới logout được)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| 3. USER ROUTES (Cần đăng nhập: Customer, Manager, Admin đều vào được)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Đặt vé & Lịch sử
    Route::get('/booking/{showtime_id}', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking/book', [BookingController::class, 'bookTicket'])->name('booking.book');
    Route::get('/my-tickets', [BookingController::class, 'history'])->name('booking.history');

    // 1. Xem trang hồ sơ
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // 2. Cập nhật hồ sơ (Tên, Mật khẩu, Avatar)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


/*
|--------------------------------------------------------------------------
| 4. ADMIN & MANAGER ROUTES (Khu vực quản trị)
|--------------------------------------------------------------------------
*/

// Gom nhóm chung cho Admin Panel
// URL: domain.com/admin/...
// Tên route: admin....
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/', function () {
        $user = auth()->user();

        // Nếu là Admin -> Vào Dashboard xem doanh thu
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Nếu là Manager -> Vào trang Quản lý Phim (hoặc Đơn hàng)
        if ($user->role === 'manager') {
            return redirect()->route('admin.movies.index'); 
        }

        // Nếu là Customer mà lỡ lạc vào đây -> Đá về trang chủ
        return redirect()->route('home');
    });

    // --- NHÓM 1: CHỈ ADMIN MỚI ĐƯỢC VÀO ---
    Route::middleware(['role:admin'])->group(function () {
        
        // Dashboard thống kê (Chỉ Admin xem doanh thu)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Quản lý User (Chỉ Admin mới được thêm/xóa nhân viên)
        Route::resource('users', UserController::class);
    });


    // --- NHÓM 2: ADMIN VÀ MANAGER ĐỀU ĐƯỢC VÀO (Quản lý nội dung) ---
    Route::middleware(['role:admin,manager'])->group(function () {
        
        // Quản lý Phim
        Route::resource('movies', AdminMovieController::class);

        // Quản lý Lịch chiếu
        Route::resource('showtimes', ShowtimeController::class);

        // Quản lý Rạp
        Route::resource('theaters', TheaterController::class);

        // Quản lý Banner
        Route::resource('banners', AdminBannerController::class);

        // Quản lý Tin tức
        Route::resource('news', AdminNewsController::class);

        // Xem danh sách đơn hàng (Manager cần xem để hỗ trợ khách)
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    });

});
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    // --- KHAI BÁO CÁC VIEW ---
    public function showLoginForm() { return view('auth.login'); }
    public function showRegisterForm() { return view('auth.register'); }
    
    // Hiển thị form nhập OTP
    public function showVerifyForm() {
        // Nếu không có session 'auth_otp_id' (chưa qua bước login/register) thì đá về login
        if (!session()->has('auth_otp_id')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    // =========================================================
    // 1. XỬ LÝ ĐĂNG KÝ (Sửa lại)
    // =========================================================
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tạo user nhưng chưa login
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'is_active' => true, // Hoặc false nếu muốn chặt chẽ hơn
        ]);

        // Gửi OTP
        $this->sendOTP($user);

        // Lưu ID user tạm thời vào session để qua trang OTP biết là ai
        session(['auth_otp_id' => $user->id]);

        return redirect()->route('otp.verify')->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email để lấy mã OTP.');
    }

    // =========================================================
    // 2. XỬ LÝ ĐĂNG NHẬP (Sửa lại)
    // =========================================================
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     // Tìm user theo email
    //     $user = User::where('email', $request->email)->first();

    //     // Kiểm tra password thủ công (KHÔNG dùng Auth::attempt để tránh login luôn)
    //     if ($user && Hash::check($request->password, $user->password)) {
            
    //         // Nếu tài khoản bị khóa
    //         if (!$user->is_active) {
    //             return back()->withErrors(['email' => 'Tài khoản đã bị khóa.']);
    //         }

    //         // Đúng tài khoản mật khẩu -> Gửi OTP
    //         $this->sendOTP($user);

    //         // Lưu ID tạm vào session
    //         session(['auth_otp_id' => $user->id]);

    //         return redirect()->route('otp.verify')->with('success', 'Vui lòng nhập mã OTP đã gửi về email.');
    //     }

    //     return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
    // }
    public function login(Request $request)
{
    // 1. Validate Form input và Captcha
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'g-recaptcha-response' => 'required', // Bắt buộc phải tick captcha
    ], [
        'g-recaptcha-response.required' => 'Vui lòng xác thực bạn không phải là người máy.',
    ]);

    // 2. Gửi request xác thực lên Google
    try {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        // Kiểm tra kết quả trả về từ Google
        if (!$response->successful() || !$response->json()['success']) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Xác thực Captcha không hợp lệ. Vui lòng thử lại.',
            ]);
        }
    } catch (\Exception $e) {
        // Bắt lỗi nếu không kết nối được đến Google hoặc lỗi validation trên
        if ($e instanceof ValidationException) {
            throw $e;
        }
        
        return back()->withErrors(['g-recaptcha-response' => 'Lỗi kết nối xác thực Captcha.']);
    }

    // --- LOGIC CŨ CỦA BẠN (OTP Flow) ---

    // Tìm user theo email
    $user = User::where('email', $request->email)->first();

    // Kiểm tra password thủ công (KHÔNG dùng Auth::attempt để tránh login luôn)
    if ($user && Hash::check($request->password, $user->password)) {
        
        // Nếu tài khoản bị khóa
        if (!$user->is_active) {
            return back()->withErrors(['email' => 'Tài khoản đã bị khóa.']);
        }

        // Đúng tài khoản mật khẩu -> Gửi OTP
        $this->sendOTP($user);

        // Lưu ID tạm vào session
        session(['auth_otp_id' => $user->id]);

        return redirect()->route('otp.verify')->with('success', 'Vui lòng nhập mã OTP đã gửi về email.');
    }

    return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
}

    // =========================================================
    // 3. XÁC THỰC OTP (Logic mới)
    // =========================================================
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        // Lấy ID user từ session
        $userId = session('auth_otp_id');
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Phiên đăng nhập hết hạn.');
        }

        $user = User::find($userId);

        // 1. Kiểm tra mã OTP có đúng không
        if ($user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác.']);
        }

        // 2. Kiểm tra OTP còn hạn không (ví dụ 5 phút)
        if (Carbon::now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn. Vui lòng gửi lại.']);
        }

        // --- MỌI THỨ OK -> ĐĂNG NHẬP CHÍNH THỨC ---
        
        // Xóa OTP cũ
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Xóa session tạm
        session()->forget('auth_otp_id');

        // Đăng nhập user
        Auth::login($user);
        $request->session()->regenerate();

        // Điều hướng
        if ($user->role === 'admin' || $user->role === 'manager') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    }

    // =========================================================
    // 4. GỬI LẠI OTP (Resend)
    // =========================================================
    public function resendOTP()
    {
        $userId = session('auth_otp_id');
        if (!$userId) return redirect()->route('login');

        $user = User::find($userId);
        $this->sendOTP($user);

        return back()->with('success', 'Đã gửi lại mã OTP.');
    }

    // =========================================================
    // HELPER: HÀM SINH VÀ GỬI OTP
    // =========================================================
    private function sendOTP($user)
    {
        // Sinh số ngẫu nhiên 6 chữ số
        $otp = rand(100000, 999999);

        // Lưu vào DB (Hết hạn sau 5 phút)
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        // Gửi mail (Nhớ cấu hình .env MAIL_*)
        Mail::to($user->email)->send(new OTPMail($otp));
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRules;

class PasswordResetController extends Controller
{
    // 1. Hiển thị Form nhập Email
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Xử lý gửi Link Reset về Email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Gửi link reset (Laravel tự lo phần token và mail)
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Đã gửi link đặt lại mật khẩu vào email của bạn!');
        }

        return back()->withErrors(['email' => 'Không tìm thấy người dùng với email này.']);
    }

    // 3. Hiển thị Form đặt lại mật khẩu mới (Khi bấm link từ mail)
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', ['token' => $request->route('token'),'email' => $request->query('email', '')]);
    }

    // 4. Xử lý cập nhật mật khẩu mới
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRules::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ], [
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            // ... thêm các message lỗi khác nếu cần
        ]);

        // Xử lý đổi mật khẩu
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                // Tự động đăng nhập lại luôn cho tiện
                // event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.');
        }

        return back()->withErrors(['email' => 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.']);
    }
}
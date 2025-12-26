<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Hiển thị trang hồ sơ
     */
    public function edit(Request $request): View
    {
        return view('pages.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Xử lý cập nhật (Tên & Mật khẩu)
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validate dữ liệu
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            
            // Nếu có nhập mật khẩu mới thì bắt buộc phải nhập mật khẩu cũ
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'], // confirmed = khớp với password_confirmation
        ], [
            'current_password.required_with' => 'Vui lòng nhập mật khẩu hiện tại để thay đổi mật khẩu mới.',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng khớp.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
        ]);

        // 2. Cập nhật Tên
        $user->name = $request->name;

        // 3. Xử lý Đổi mật khẩu
        if ($request->filled('password')) {
            // Kiểm tra mật khẩu cũ có đúng không
            if (!Hash::check($request->current_password, $user->password)) {
                // Nếu sai, trả về lỗi ngay tại ô current_password
                throw ValidationException::withMessages([
                    'current_password' => 'Mật khẩu hiện tại không chính xác.',
                ]);
            }

            // Nếu đúng, mã hóa và lưu mật khẩu mới
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
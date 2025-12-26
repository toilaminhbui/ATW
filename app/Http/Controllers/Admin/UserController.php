<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * 1. Danh sách User (Tìm kiếm + Phân trang)
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        // Lọc Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * 2. Form Tạo mới
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * 3. Xử lý Tạo mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,manager,user',
        ], [
            'email.unique' => 'Email này đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Tạo người dùng thành công!');
    }

    /**
     * 4. Form Chỉnh sửa
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * 5. Xử lý Cập nhật
     */
    public function update(Request $request, $id)
    {
        $targetUser = User::findOrFail($id);
        $currentUser = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'role' => 'nullable|in:admin,manager,user',
        ]);

        $data = ['name' => $request->name];

        // Nếu có nhập pass mới thì đổi, không thì giữ nguyên
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // --- Logic Phân Quyền ---
        if ($request->filled('role')) {
            $newRole = $request->role;

            // Nếu role thay đổi
            if ($newRole !== $targetUser->role) {
                // Rule 1: Chỉ Admin mới được đổi role
                if ($currentUser->role !== 'admin') {
                    return back()->with('error', 'Bạn không có quyền thay đổi vai trò người dùng.');
                }

                // Rule 2: Không được hạ quyền của Admin khác
                if ($targetUser->role === 'admin' && $targetUser->id !== $currentUser->id) {
                    return back()->with('error', 'Không thể thay đổi vai trò của tài khoản Admin khác.');
                }

                $data['role'] = $newRole;
            }
        }

        $targetUser->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật thông tin thành công!');
    }

    /**
     * 6. Xóa User
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Chặn tự xóa chính mình
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Đã xóa người dùng thành công.');
    }
}
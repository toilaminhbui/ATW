<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  // Nhận danh sách các role được phép (admin, manager...)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Kiểm tra đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // 2. Kiểm tra Role của user có nằm trong danh sách cho phép không
        // Ví dụ: role:admin,manager -> $roles sẽ là ['admin', 'manager']
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Nếu không có quyền -> Báo lỗi 403 (Forbidden)
        abort(403, 'Bạn không có quyền truy cập!');
    }
}
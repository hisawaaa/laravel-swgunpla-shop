<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem user đã đăng nhập và có role là 'admin'
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request); // Cho phép đi tiếp
        }

        // Nếu không phải admin, về trang chủ
        return redirect('/');
    }
}

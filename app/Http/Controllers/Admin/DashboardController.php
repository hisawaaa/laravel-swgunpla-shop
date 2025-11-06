<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard với các số liệu thống kê.
     */
    public function index()
    {
        // Tổng doanh thu (chỉ tính đơn hàng đã hoàn thành)
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        // Đơn hàng đang chờ xử lý
        $pendingOrders = Order::where('status', 'pending')->count();

        // Tổng số khách hàng (không tính admin)
        $totalCustomers = User::where('role', 'user')->count();

        // Tổng số sản phẩm
        $totalProducts = Product::count();

        // Lấy 5 đơn hàng mới nhất để hiển thị
        $recentOrders = Order::with('user') // Eager loading thông tin 'user'
                            ->latest()      // Sắp xếp mới nhất
                            ->take(5)       // Lấy 5 đơn
                            ->get();

        // Gửi 5 biến sang View
        return view('admin.dashboard', compact(
            'totalRevenue',
            'pendingOrders',
            'totalCustomers',
            'totalProducts',
            'recentOrders'
        ));
    }
}

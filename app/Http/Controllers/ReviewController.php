<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Lưu một đánh giá mới vào CSDL.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id', // Cần biết đơn hàng nào
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $userId = Auth::id(); // Lấy ID user đang đăng nhập
        $productId = $request->product_id;
        $orderId = $request->order_id;

        // KIỂM TRA QUYỀN
        $order = Order::where('id', $orderId)
                      ->where('user_id', $userId)
                      ->where('status', 'completed') // Chỉ cho phép đánh giá đơn hàng đã HOÀN THÀNH
                      ->whereHas('items', function($query) use ($productId) {
                          $query->where('product_id', $productId);
                      })
                      ->first();
        
        if (!$order) {
            return back()->with('error', 'Bạn không thể đánh giá sản phẩm này từ đơn hàng này.');
        }

        // KIỂM TRA TRÙNG LẶP
        // (Giới hạn 1 user = 1 đánh giá / 1 sản phẩm)
        $alreadyReviewed = Review::where('user_id', $userId)
                                 ->where('product_id', $productId)
                                 ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // LƯU ĐÁNH GIÁ
        Review::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã gửi đánh giá!');
    }
}

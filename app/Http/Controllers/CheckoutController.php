<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;
use App\Models\Voucher;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang Checkout
     */
    public function index(Request $request)
    {
        $cartItems = session()->get('cart', []);

        // Nếu giỏ hàng rỗng, về trang giỏ hàng
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Lấy địa chỉ user
        $addresses = $request->user()->addresses()->latest()->get();
        
        // Nếu user chưa có địa chỉ, chuyển hướng họ đến trang tạo địa chỉ
        if($addresses->isEmpty()) {
            return redirect()->route('addresses.create')->with('info', 'Vui lòng thêm địa chỉ nhận hàng trước khi thanh toán.');
        }

        $cartItems = session()->get('cart', []);
        $subTotal = 0;
        foreach ($cartItems as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $finalTotal = $subTotal;
        $voucherSession = session()->get('voucher');

        if ($voucherSession) {
            if ($voucherSession['type'] == 'fixed') {
                $discount = $voucherSession['value'];
            } elseif ($voucherSession['type'] == 'percent') {
                $discount = ($subTotal * $voucherSession['value']) / 100;
            }
            if ($discount > $subTotal) $discount = $subTotal;
            
            $finalTotal = $subTotal - $discount;
        }

        // Truyền các giá trị sang view
        return view('checkout.index', compact('cartItems', 'subTotal', 'discount', 'finalTotal', 'addresses'));
    }

    /**
     * Xử lý đặt hàng
     */
    public function placeOrder(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'address_id' => [
                'required',
                // Đảm bảo address_id gửi lên tồn tại và thuộc về user đang đăng nhập
                Rule::exists('addresses', 'id')->where('user_id', $request->user()->id)
            ],
            'payment_method' => 'required|string|in:cod',
        ]);
        
        // Kiểm tra giỏ hàng/tổng tiền
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $subTotal = 0;
        foreach ($cartItems as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $finalTotal = $subTotal;
        $voucherSession = session()->get('voucher');
        $voucherId = null; // ID voucher để lưu vào CSDL
        
        if ($voucherSession) {
            // Kiểm tra lại voucher trong CSDL một lần nữa
            $voucher = Voucher::find($voucherSession['id']);
            if ($voucher && $voucher->quantity > 0 && (!$voucher->expires_at || $voucher->expires_at >= Carbon::now())) {
                
                if ($voucher->type == 'fixed') {
                    $discount = $voucher->value;
                } elseif ($voucher->type == 'percent') {
                    $discount = ($subTotal * $voucher->value) / 100;
                }
                if ($discount > $subTotal) $discount = $subTotal;
                
                $finalTotal = $subTotal - $discount;
                $voucherId = $voucher->id; // Gán ID
            }
        }
        // Sử dụng Database Transaction
        // Đảm bảo tất cả các thao tác CSDL (tạo order, tạo order_items, trừ kho)
        // hoặc thành công CÙNG NHAU, hoặc thất bại CÙNG NHAU.
        try {
            DB::beginTransaction();
            
            // Kiểm tra tồn kho (Lần 2)
            foreach ($cartItems as $id => $item) {
                $product = Product::find($id);
                if ($product->stock < $item['quantity']) {
                    // Nếu không đủ hàng, hủy transaction và báo lỗi
                    DB::rollBack();
                    return redirect()->route('cart.index')->with('error', 'Sản phẩm "' . $item['name'] . '" không đủ số lượng tồn kho!');
                }
            }

            // Tạo Đơn hàng (Order)
            $order = Order::create([
                'user_id' => $request->user()->id, 
                'address_id' => $request->address_id,
                'total_amount' => $finalTotal,
                'status' => 'pending', 
                'payment_method' => $request->payment_method,
                'voucher_id' => $voucherId,
            ]);

            // Tạo Chi tiết đơn hàng (Order Items) và Trừ kho
            foreach ($cartItems as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                
                // Trừ kho
                Product::find($id)->decrement('stock', $item['quantity']);
            }

            if ($voucherId) {
                Voucher::find($voucherId)->decrement('quantity');
            }

            // Nếu mọi thứ thành công, commit transaction
            DB::commit();

            // Xóa giỏ hàng khỏi session
            session()->forget('cart');
            session()->forget('voucher');
            
            // Chuyển hướng đến trang thành công
            return redirect()->route('checkout.success')->with('success', 'Bạn đã đặt hàng thành công!');

        } catch (\Exception $e) {
            // Nếu có lỗi, rollback tất cả
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại. Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị trang đặt hàng thành công
     */
    public function success()
    {
        // Chỉ cho phép truy cập trang này nếu có session 'success'
        if (!session('success')) {
            return redirect()->route('products.index');
        }
        
        return view('checkout.success');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * Hiển thị trang giỏ hàng
     */
    public function index()
    {
        $cartItems = session()->get('cart', []); // Lấy giỏ hàng từ session, mặc định là mảng rỗng
        
        // Tính tổng tiền
        $subTotal = 0;
        foreach ($cartItems as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }

        // === LOGIC TÍNH TOÁN ===
        $discount = 0;
        $finalTotal = $subTotal;
        $voucherSession = session()->get('voucher');

        if ($voucherSession) {
            $discount = $this->calculateDiscount($voucherSession, $subTotal);
            $finalTotal = $subTotal - $discount;
        }
        
        // Truyền sang view
        return view('cart.index', compact('cartItems', 'subTotal', 'discount', 'finalTotal'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // Kiểm tra tồn kho
        if ($product->stock < $request->quantity) {
             return back()->with('error', 'Sản phẩm không đủ số lượng tồn kho!');
        }

        // Nếu sản phẩm đã có trong giỏ hàng
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $request->quantity;
            
            if ($product->stock < $newQuantity) {
                 return back()->with('error', 'Sản phẩm không đủ số lượng tồn kho!');
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;

        } else { // Nếu sản phẩm chưa có trong giỏ hàng
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "image" => $product->first_image_url // Lấy ảnh đầu tiên (nếu có)
            ];
        }

        session()->put('cart', $cart); // Lưu giỏ hàng vào session

        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $product = Product::findOrFail($request->product_id);
            
            if ($product->stock < $request->quantity) {
                 return back()->with('error', 'Sản phẩm không đủ số lượng tồn kho!');
            }

            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            return back()->with('success', 'Cập nhật giỏ hàng thành công!');
        }
        
        return back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]); // Xóa sản phẩm khỏi mảng
            session()->put('cart', $cart); // Lưu lại session
            
            return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
        
        return back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
    }

    /**
     * HÀM ÁP DỤNG VOUCHER
     */
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        // Kiểm tra Voucher
        if (!$voucher) {
            return back()->with('error', 'Mã giảm giá không tồn tại.');
        }

        if ($voucher->quantity <= 0) {
            return back()->with('error', 'Mã giảm giá đã hết lượt sử dụng.');
        }

        if ($voucher->expires_at && $voucher->expires_at < Carbon::now()) {
            return back()->with('error', 'Mã giảm giá đã hết hạn.');
        }

        // Lưu voucher vào session
        session()->put('voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'type' => $voucher->type,
            'value' => $voucher->value,
        ]);

        return back()->with('success', 'Áp dụng mã giảm giá thành công.');
    }

    /**
     * HÀM XÓA VOUCHER
     */
    public function removeVoucher()
    {
        session()->forget('voucher');
        return back()->with('success', 'Đã xóa mã giảm giá.');
    }
    
    /**
     * HÀM HỖ TRỢ TÍNH TOÁN KHUYẾN MÃI (private)
     */
    private function calculateDiscount($voucher, $subTotal)
    {
        $discount = 0;
        
        if ($voucher['type'] == 'fixed') {
            $discount = $voucher['value'];
        } elseif ($voucher['type'] == 'percent') {
            $discount = ($subTotal * $voucher['value']) / 100;
        }
        
        // Đảm bảo tiền giảm không vượt quá tổng tiền
        if ($discount > $subTotal) {
            $discount = $subTotal;
        }
        
        return $discount;
    }
}

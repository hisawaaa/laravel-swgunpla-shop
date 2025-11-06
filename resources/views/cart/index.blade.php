@extends('layouts.guest')

@section('title', 'Giỏ hàng - SWGunpla')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Giỏ hàng của bạn</h1>

    @if(empty($cartItems))
        <div class="alert alert-info">
            Giỏ hàng của bạn đang trống. <a href="{{ route('products.index') }}">Tiếp tục mua sắm</a>
        </div>
    @else
        <div class="table-responsive mb-4">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 10%;">Ảnh</th>
                        <th style="width: 35%;">Tên sản phẩm</th>
                        <th style="width: 15%;">Đơn giá</th>
                        <th style="width: 15%;">Số lượng</th>
                        <th style="width: 15%;">Thành tiền</th>
                        <th style="width: 10%;">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $id => $item)
                    <tr>
                        <td>
                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80' }}" alt="{{ $item['name'] }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: contain;">
                        </td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }} VNĐ</td>
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center cart-update-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm text-center" style="width: 70px;">
                                <button type="submit" class="btn btn-outline-primary btn-sm ms-2" title="Cập nhật">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VNĐ</td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này?');">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end">
            <div class="col-md-6 col-lg-5 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                         @if(!session('voucher'))
                        <form action="{{ route('cart.apply_voucher') }}" method="POST">
                            @csrf
                            <label class="form-label fw-bold">Mã giảm giá</label>
                            <div class="input-group">
                                <input type="text" name="code" class="form-control" placeholder="Nhập mã của bạn">
                                <button type="submit" class="btn btn-primary">Áp dụng</button>
                            </div>
                        </form>
                        @else
                        <label class="form-label fw-bold">Mã giảm giá</label>
                        <div class="alert alert-success d-flex justify-content-between align-items-center mb-0 p-2">
                            <span class="small">
                                Đã áp dụng: <strong>{{ session('voucher')['code'] }}</strong>
                            </span>
                            <a href="{{ route('cart.remove_voucher') }}" class="btn-close btn-sm" title="Xóa mã"></a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                     <div class="card-header bg-light">
                        <h5 class="mb-0">Tổng cộng</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($subTotal, 0, ',', '.') }} VNĐ</span>
                            </li>
                             <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Giảm giá:</span>
                                <span class="text-danger">
                                    @if(session('voucher'))
                                        (-{{ number_format($discount, 0, ',', '.') }} VNĐ)
                                    @else
                                        -0 VNĐ
                                    @endif
                                </span>
                            </li>
                             <li class="list-group-item d-flex justify-content-between px-0 fw-bold fs-5 border-0">
                                <span>Thành tiền:</span>
                                <span class="text-danger">
                                    {{ number_format($finalTotal, 0, ',', '.') }} VNĐ
                                </span>
                            </li>
                        </ul>
                        <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100 btn-lg">Tiến hành Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
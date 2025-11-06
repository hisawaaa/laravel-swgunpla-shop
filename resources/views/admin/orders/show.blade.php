@extends('layouts.admin')

@section('title', 'Chi tiết Đơn hàng #' . $order->id) 

@section('content') 
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Chi tiết Đơn hàng #{{ $order->id }}</h1>
     <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Quay lại Danh sách
     </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0">Các sản phẩm trong đơn</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th style="width: 50%;">Sản phẩm</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}</td>
                                <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                <td class="text-center">x {{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light border-top fs-5 fw-bold text-end text-danger">
                Tổng cộng: {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                     <div class="card-header bg-light border-bottom"><h5 class="mb-0">Khách hàng</h5></div>
                     <div class="card-body small">
                        <strong>Tên:</strong> {{ $order->user->name ?? 'N/A' }}<br>
                        <strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}
                     </div>
                </div>
            </div>
             <div class="col-md-6">
                <div class="card shadow-sm h-100">
                     <div class="card-header bg-light border-bottom"><h5 class="mb-0">Địa chỉ giao hàng</h5></div>
                     <div class="card-body small">
                        @if($order->address)
                            <strong>{{ $order->address->full_name }}</strong> ({{ $order->address->phone }})<br>
                            {{ $order->address->address_line }}, {{ $order->address->ward }}, {{ $order->address->district }}, {{ $order->address->city }}
                        @else
                            <span class="text-danger">Không có thông tin địa chỉ.</span>
                        @endif
                     </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card sticky-top shadow-sm" style="top: 20px;">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0">Thông tin & Cập nhật</h5>
            </div>
            <div class="card-body">
                <p class="small">
                    <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Phương thức TT:</strong> {{ strtoupper($order->payment_method) }}<br>
                    <strong>Voucher đã dùng:</strong> {{ $order->voucher->code ?? 'Không có' }}
                </p>
                <hr>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT') 

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Cập nhật Trạng thái đơn hàng</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" @selected($order->status == 'pending')>
                                Chờ xử lý
                            </option>
                            <option value="processing" @selected($order->status == 'processing')>
                                Đang xử lý
                            </option>
                            <option value="completed" @selected($order->status == 'completed')>
                                Hoàn thành
                            </option>
                            <option value="cancelled" @selected($order->status == 'cancelled')>
                                Đã hủy
                            </option>
                        </select>
                         @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i> Lưu thay đổi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
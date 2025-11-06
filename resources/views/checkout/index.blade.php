@extends('layouts.guest')

@section('title', 'Thanh toán - SWGunpla')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Thanh toán</h1>

    <form action="{{ route('checkout.place') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Chọn Địa chỉ nhận hàng</h5>
                    </div>
                    <div class="card-body">
                        @if($addresses->isEmpty())
                            <div class="alert alert-warning small">
                                Bạn chưa có địa chỉ nào.
                                <a href="{{ route('addresses.create', ['redirect' => 'checkout']) }}">Thêm địa chỉ mới</a>
                            </div>
                        @else
                            @foreach($addresses as $address)
                            <div class="form-check mb-3 p-3 border rounded address-option">
                                <input class="form-check-input" type="radio" name="address_id" id="address{{ $address->id }}" value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }} required>
                                <label class="form-check-label w-100" for="address{{ $address->id }}">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>{{ $address->full_name }}</strong> ({{ $address->phone }})
                                            @if($address->is_default)<span class="badge bg-primary ms-2">Mặc định</span>@endif
                                        </div>
                                        <a href="{{ route('addresses.edit', [$address, 'redirect' => 'checkout']) }}" class="btn btn-sm btn-outline-secondary py-0 px-1"><i class="bi bi-pencil"></i></a>
                                    </div>
                                    <small class="d-block text-muted">{{ $address->address_line }}, {{ $address->ward }}, {{ $address->district }}, {{ $address->city }}</small>
                                </label>
                            </div>
                            @endforeach
                            @error('address_id') <div class="text-danger mt-2 small">{{ $message }}</div> @enderror
                        @endif
                        <a href="{{ route('addresses.create', ['redirect' => 'checkout']) }}" class="btn btn-outline-primary mt-2 btn-sm">
                            <i class="bi bi-plus-lg"></i> Thêm địa chỉ mới
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm">
                     <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-credit-card-fill me-2"></i>Phương thức thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check border rounded p-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod" checked>
                            <label class="form-check-label" for="payment_cod">
                                <strong>COD</strong> - Thanh toán khi nhận hàng
                            </label>
                        </div>
                        {{-- Thêm phương thức khác ở đây nếu có --}}
                        @error('payment_method') <div class="text-danger mt-2 small">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card sticky-top shadow-sm" style="top: 80px;"> {{-- Tăng top --}}
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Tóm tắt đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush small mb-3">
                            @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item['image'] ?? 'https://via.placeholder.com/50' }}" alt="" width="50" height="50" class="me-2 rounded object-fit-contain">
                                    <div>
                                        {{ $item['name'] }}
                                        <small class="d-block text-muted">SL: {{ $item['quantity'] }}</small>
                                    </div>
                                </div>
                                <span class="text-nowrap">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VNĐ</span>
                            </li>
                            @endforeach
                        </ul>

                        <hr>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($subTotal, 0, ',', '.') }} VNĐ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Giảm giá:</span>
                                <span class="text-danger">
                                    @if(session('voucher'))
                                        ({{ session('voucher')['code'] }}) -{{ number_format($discount, 0, ',', '.') }} VNĐ
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

                        <button type="submit" class="btn btn-danger w-100 btn-lg mt-3" {{ $addresses->isEmpty() ? 'disabled' : '' }}>
                            <i class="bi bi-bag-check-fill me-1"></i> ĐẶT HÀNG
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .address-option label { cursor: pointer; }
    .address-option input[type="radio"]:checked + label {
        border-color: var(--bs-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), .25);
    }
</style>
@endpush
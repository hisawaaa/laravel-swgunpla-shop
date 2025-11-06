@extends('layouts.guest')

@section('title', 'Đặt hàng thành công - SWGunpla')

@section('content')
<div class="container text-center py-5 my-5">
    <h1 class="display-3 text-success mb-3"><i class="bi bi-check-circle-fill"></i></h1>
    <h2 class="mb-3 fw-bold">Đặt hàng thành công!</h2>
    <p class="lead">{{ session('success') }}</p>
    <p>Cảm ơn bạn đã mua sắm tại SWGunpla. Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng sớm nhất.</p>
    <div class="mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-primary me-2">
            <i class="bi bi-arrow-left me-1"></i> Tiếp tục mua sắm
        </a>
        <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary">
            Xem lịch sử đơn hàng <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</div>
@endsection
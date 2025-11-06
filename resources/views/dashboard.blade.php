@extends('layouts.app')

@section('title', 'Tài khoản')

@section('header')
    <h2 class="h4 mb-0 fw-bold">
        Tài khoản
    </h2>
@endsection

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="card-title">Xin chào, {{ Auth::user()->name }}!</h5>
            <p class="card-text text-muted">Đây là trang quản lý tài khoản của bạn.</p>
            <hr>
            
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="list-group">
                        <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-person-fill me-2"></i> Thông tin cá nhân
                        </a>
                        <a href="{{ route('addresses.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-geo-alt-fill me-2"></i> Địa chỉ
                        </a>
                        <a href="{{ route('user.orders.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-receipt me-2"></i> Đơn hàng của tôi
                        </a>
                    </div>
                </div>
                <div class="col-md-8">
                    <p>Xem các đơn hàng, quản lý địa chỉ giao hàng và cập nhật thông tin cá nhân.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
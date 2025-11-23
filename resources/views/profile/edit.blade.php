@extends('layouts.app')

@section('title', 'Cài đặt tài khoản')

@section('header')
    <h2 class="h4 mb-0 fw-bold">Cài đặt tài khoản</h2>
@endsection

@section('content')
    <div class="row g-4 justify-content-center">
        
        {{-- CẬP NHẬT THÔNG TIN CÁ NHÂN --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-person-lines-fill me-2"></i> Thông tin hồ sơ
                    </h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- ĐỔI MẬT KHẨU --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-shield-lock-fill me-2"></i> Đổi mật khẩu
                    </h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- XÓA TÀI KHOẢN --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 border-danger">
                <div class="card-header bg-white border-bottom border-danger py-3">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Xóa tài khoản
                    </h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
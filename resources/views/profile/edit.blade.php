@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

@section('header')
    <h2 class="h4 mb-0 fw-bold">
        Thông tin cá nhân
    </h2>
@endsection

@section('content')
    <div class="row g-4">
        {{-- Cập nhật thông tin --}}
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Cập nhật Thông tin</h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Cập nhật mật khẩu --}}
        <div class="col-12">
             <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0">Cập nhật Mật khẩu</h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Xóa tài khoản --}}
        <div class="col-12">
             <div class="card shadow-sm border-0 border-danger">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 text-danger">Xóa Tài khoản</h5>
                </div>
                <div class="card-body p-4">
                     @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
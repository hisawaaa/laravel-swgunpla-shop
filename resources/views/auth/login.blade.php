@extends('layouts.guest')

@section('title', 'Đăng nhập')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                 <div class="card-header bg-light border-bottom text-center py-3">
                     <h4 class="mb-0">Đăng nhập</h4>
                 </div>

                <div class="card-body p-4">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                             <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password">
                             @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-block mt-4 mb-3">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="d-flex items-center justify-content-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 me-3" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <button type="submit" class="btn btn-primary ms-3">
                                {{ __('Log in') }}
                            </button>
                        </div>
                         <div class="text-center mt-3">
                            <p class="small">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
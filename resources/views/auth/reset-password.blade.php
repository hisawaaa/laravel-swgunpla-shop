@extends('layouts.guest')

@section('title', 'Đặt lại Mật khẩu')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
             <div class="card shadow-sm">
                 <div class="card-header bg-light border-bottom text-center py-3">
                     <h4 class="mb-0">Đặt lại Mật khẩu</h4>
                 </div>
                 <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                             @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password">
                             @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                           <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                           <input id="password_confirmation" class="form-control"
                                           type="password"
                                           name="password_confirmation" required autocomplete="new-password">
                           {{-- No specific error needed here as password confirmation error is tied to 'password' field --}}
                        </div>

                        <div class="d-flex items-center justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
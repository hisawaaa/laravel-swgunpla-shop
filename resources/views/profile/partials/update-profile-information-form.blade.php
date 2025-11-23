<section>
    <header class="mb-4">
        <p class="text-muted small">
            Cập nhật thông tin hồ sơ và địa chỉ email của tài khoản.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        {{-- Tên --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Họ và tên</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        Địa chỉ email của bạn chưa được xác minh.
                        <button form="send-verification" class="btn btn-link p-0 align-baseline">
                            Nhấn vào đây để gửi lại email xác minh.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success mt-2 small" role="alert">
                            Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>

            @if (session('status') === 'profile-updated')
                <span 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small fw-bold"
                ><i class="bi bi-check-circle"></i> Đã lưu.</span>
            @endif
        </div>
    </form>
</section>
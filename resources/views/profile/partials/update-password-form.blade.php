<section>
    <header class="mb-4">
        <p class="text-muted small">
            Hãy sử dụng mật khẩu dài theo quy định để đảm bảo an toàn.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        {{-- Mật khẩu hiện tại --}}
        <div class="mb-3">
            <label for="current_password" class="form-label fw-semibold">Mật khẩu hiện tại</label>
            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="current_password" name="current_password" autocomplete="current-password">
            @error('current_password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Mật khẩu mới --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Mật khẩu mới</label>
            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
            @error('password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Nhập lại mật khẩu --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-semibold">Nhập lại mật khẩu mới</label>
            <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>

            @if (session('status') === 'password-updated')
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
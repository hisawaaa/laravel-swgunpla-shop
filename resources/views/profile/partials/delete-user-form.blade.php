<section>
    <header class="mb-4">
        <p class="text-muted small">
            Khi bạn xóa tài khoản, tất cả dữ liệu và tài nguyên liên quan sẽ bị xóa vĩnh viễn. Vui lòng sao lưu bất kỳ dữ liệu nào bạn muốn giữ lại trước khi thực hiện.
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        Xóa tài khoản
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
                @csrf
                @method('delete')

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-danger fw-bold" id="modalLabel">Bạn có chắc chắn muốn xóa tài khoản?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted small">
                        Khi tài khoản bị xóa, toàn bộ dữ liệu sẽ mất vĩnh viễn. Vui lòng nhập mật khẩu của bạn để xác nhận hành động này.
                    </p>

                    <div class="mt-3">
                        <label for="password" class="form-label visually-hidden">Mật khẩu</label>
                        <input 
                            type="password" 
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Nhập mật khẩu để xác nhận"
                        >
                        @error('password', 'userDeletion') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa vĩnh viễn</button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Script nhỏ để giữ Modal mở nếu có lỗi validation (khi nhập sai mật khẩu) --}}
    @if($errors->userDeletion->isNotEmpty())
        <script type="module">
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
                myModal.show();
            });
        </script>
    @endif
</section>
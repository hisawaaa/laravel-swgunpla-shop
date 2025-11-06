<div class="bg-white border-bottom py-3 px-3 d-flex justify-content-between align-items-center shadow-sm">
    <div class="fw-semibold">
        <i class="bi bi-gear-wide-connected me-1"></i> ADMINISTRATOR
    </div>
    <div class="small text-muted">
        @auth
            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }} ({{ auth()->user()->role }})
        @endauth
    </div>
</div>
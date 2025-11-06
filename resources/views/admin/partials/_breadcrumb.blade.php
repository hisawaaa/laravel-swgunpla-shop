@hasSection ('breadcrumb')
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb bg-light rounded-2 px-3 py-2 mb-0 small">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Admin</a></li>
        @yield('breadcrumb')
    </ol>
</nav>
@endif
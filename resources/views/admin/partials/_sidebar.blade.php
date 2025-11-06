<h5 class="mb-3 border-bottom border-secondary pb-2">
    <a href="{{ route('home') }}" class="text-white text-decoration-none d-flex align-items-center">
        <img src="{{ asset('images/logoconstrast.png') }}" alt="Logo" style="height: 30px; margin-right: 8px;">
        <span>SWGunpla</span>
    </a>
</h5>

<nav class="nav nav-pills flex-column gap-1">
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-white-50' }}"
           href="{{ route('admin.dashboard') }}">
           <i class="bi bi-speedometer2 me-2"></i> Tổng quan
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.products.*') ? 'active' : 'text-white-50' }}"
           href="{{ route('admin.products.index') }}">
           <i class="bi bi-box-seam me-2"></i> Sản phẩm
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.categories.*') ? 'active' : 'text-white-50' }}"
           href="{{ route('admin.categories.index') }}">
           <i class="bi bi-folder2-open me-2"></i> Danh mục
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.brands.*') ? 'active' : 'text-white-50' }}"
           href="{{ route('admin.brands.index') }}">
           <i class="bi bi-tags me-2"></i> Thương hiệu
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.orders.*') ? 'active' : 'text-white-50' }}"
           href="{{ route('admin.orders.index') }}">
           <i class="bi bi-receipt me-2"></i> Đơn hàng
        </a>
    </li>
     <li class="nav-item">
        <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.vouchers.*') ? 'active' : 'text-white-50' }}"
           href="{{ route('admin.vouchers.index') }}">
           <i class="bi bi-tag-fill me-2"></i> Voucher
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.reviews.*') ? 'active' : 'text-white-50' }}"
           href="{{ route('admin.reviews.index') }}">
           <i class="bi bi-star-half me-2"></i> Đánh giá
        </a>
    </li>
    
    <li class="nav-item mt-auto pt-3 border-top border-secondary">
        @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-warning w-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
            </button>
        </form>
        @endauth
    </li>
</nav>
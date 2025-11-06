<nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top py-0"> 
    <div class="container">
        <a class="navbar-brand fs-4 py-3" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="SWGunpla Logo" style="height: 40px; margin-right: 0px;">
            <span class="fs-4 fw-bold">SWGunpla</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-stretch">
                {{-- Mục Shop --}}
                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-shop me-1"></i> Shop
                    </a>
                </li>
                {{-- Dấu ngăn cách --}}
                <li class="nav-item nav-item-divider d-none d-lg-flex align-items-center">|</li>

                {{-- Mục Giỏ hàng --}}
                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart me-1"></i> Giỏ hàng
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="badge bg-danger rounded-pill ms-2">{{ $cartCount }}</span> {{-- Tăng margin --}}
                        @endif
                    </a>
                </li>

                @auth 
                {{-- Menu khi đã đăng nhập --}}
                    {{-- Dấu ngăn cách --}}
                    <li class="nav-item nav-item-divider d-none d-lg-flex align-items-center">|</li>
                    <li class="nav-item dropdown">
                        <a class="nav-link px-3 dropdown-toggle d-flex align-items-center" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Tài khoản</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.orders.index') }}">Đơn hàng</a></li>
                            @if(Auth::user()->role === 'admin')
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Quản trị</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                       <i class="bi bi-box-arrow-right me-1"></i> Đăng xuất
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else {{-- Menu khi là khách --}}
                    {{-- Dấu ngăn cách --}}
                    <li class="nav-item nav-item-divider d-none d-lg-flex align-items-center">|</li>
                    <li class="nav-item">
                        <a class="nav-link px-3 d-flex align-items-center {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Đăng nhập</a>
                    </li>
                    {{-- Dấu ngăn cách --}}
                    <li class="nav-item nav-item-divider d-none d-lg-flex align-items-center">|</li>
                     <li class="nav-item">
                        <a class="nav-link px-3 d-flex align-items-center {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Đăng ký</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
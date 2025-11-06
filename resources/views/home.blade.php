@extends('layouts.guest')

@section('title', 'Trang chủ - SWGunpla')

@section('content')
    {{-- HERO SECTION --}}
    {{-- Dùng nền trắng trực tiếp, bỏ bg-light --}}
    <div class="container-fluid bg-light py-5 border-bottom mb-0" style="overflow-x: hidden;">
        <div class="container">
            <div class="row align-items-center g-5">
                {{-- Cột Trái: Nội dung chữ --}}
                <div class="col-lg-6 hero-text-col">
                    <h1 class="display-3 fw-bold mb-3 text-uppercase text-dark" style="letter-spacing: 2px;">
                        <span class="text-secondary small fw-normal d-block mb-n2" style="font-size: 0.6em; letter-spacing: 1px;">ガンダムシリーズ</span>
                        GUNDAM
                    </h1>
                    <p class="lead mb-4 text-secondary">
                        Bandai đã mang Gunpla (Gundam plastic model kits)
                        đến với thế giới từ năm 1980, không chỉ hoàn thiện nghệ thuật của mình mà còn mở rộng
                        các loại kit và cấp độ kỹ năng để bất kỳ ai cũng có thể tận hưởng sở thích
                        thú vị và đầy thử thách này.
                    </p>
                    {{-- Dùng màu Xanh cho nút chính --}}
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 fw-bold">
                        Mua ngay &rarr;
                    </a>
                </div>

                {{-- Cột Phải: Ảnh Hero --}}
                <div class="col-lg-6 text-center hero-image-col">
                    <img src="{{ asset('images/hero1.png') }}"
                        class="img-fluid hero-image-png"
                        alt="SWGunpla Hero Image">
                </div>
            </div>
        </div>
    </div>

    {{-- TICKER / MARQUEE --}}
    {{-- Nền đen, chữ trắng, dấu hoa thị vàng --}}
    <div class="bg-dark text-white py-2 border-bottom border-top border-dark overflow-hidden ticker-container mb-5">
        <div class="ticker-text d-flex align-items-center">
            @for ($i = 0; $i < 10; $i++)
                <span class="mx-3 text-uppercase small fw-bold" style="white-space: nowrap;">
                    <i class="bi bi-asterisk text-warning me-2"></i> GUNDAM シリーズ 
                </span>
                 <span class="mx-3 text-uppercase small fw-bold" style="white-space: nowrap;">
                    <i class="bi bi-asterisk text-warning me-2"></i> GUNDAM
                </span>
                 <span class="mx-3 text-uppercase small fw-bold" style="white-space: nowrap;">
                    <i class="bi bi-asterisk text-warning me-2"></i> BUILDS 
                </span>
                 <span class="mx-3 text-uppercase small fw-bold" style="white-space: nowrap;">
                    <i class="bi bi-asterisk text-warning me-2"></i> COMMUNITY 
                </span>
            @endfor
        </div>
    </div>

    {{-- HÀNG MỚI VỀ (NEW ARRIVALS) --}}
    <div class="container mb-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold mb-0 text-uppercase d-flex align-items-center text-dark">
                    New Arrival is Here!
                    <span class="badge bg-warning text-dark ms-2 fs-6 fw-normal">新入荷はコチラ！</span>
                </h2>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-secondary mb-0 small">
                    Chúng tôi cung cấp các mẫu Gundam mới nhất với hệ thống đặt hàng trước trực tiếp từ Nhật Bản.<br>Tìm kiếm mẫu Gundam mà bạn yêu thích ngay!
                </p>
            </div>
        </div>

        {{-- Lưới Sản phẩm --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($newArrivals as $product)
                <div class="col">
                    <div class="card h-100 product-card-custom">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ $product->first_image_url }}" class="card-img-top" alt="{{ $product->name }}">
                        </a>
                        <div class="card-body d-flex flex-column p-3"> 
                            <p class="card-text mb-1"><small class="text-secondary">{{ $product->category->name ?? $product->brand->name ?? 'N/A Grade' }}</small></p>
                            <h5 class="card-title fs-6 fw-bold flex-grow-1 mb-2"> 
                                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark stretched-link">
                                    {{ Str::limit($product->name, 50) }} 
                                </a>
                            </h5>
                            {{-- Dùng màu Đỏ cho giá --}}
                            <p class="card-text text-danger fs-5 fw-bold mt-auto mb-0"> 
                                {{ number_format($product->price, 0, ',', '.') }} VNĐ
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-secondary">Chưa có sản phẩm mới.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- NỔI BẬT (FEATURED BUILDS) --}}
    <div class="container-fluid bg-light py-5 border-top border-bottom">
        <div class="container">
            <div class="text-center mb-4">
                 <p class="text-secondary text-uppercase small mb-1">注目のビルド</p>
                 <h2 class="fw-bold text-dark text-uppercase">Featured Builds</h2>
                 <p class="text-secondary small">Xem các bản dựng Gundam tùy chỉnh từ mọi người trên khắp thế giới, cảm nhận niềm vui sáng tạo!</p>
            </div>

            {{-- Lưới Sản phẩm cho mục Nổi bật --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @forelse($featuredProducts as $product)
                    <div class="col">
                        <div class="card h-100 product-card-custom">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->first_image_url }}" class="card-img-top" alt="{{ $product->name }}">
                            </a>
                            <div class="card-body d-flex flex-column p-3">
                                <p class="card-text mb-1"><small class="text-secondary">{{ $product->category->name ?? $product->brand->name ?? 'N/A Grade' }}</small></p>
                                <h5 class="card-title fs-6 fw-bold flex-grow-1 mb-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark stretched-link">
                                        {{ Str::limit($product->name, 50) }}
                                    </a>
                                </h5>
                                <p class="card-text text-danger fs-5 fw-bold mt-auto mb-0">
                                    {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                     <div class="col-12">
                        <p class="text-center text-secondary">Chưa có sản phẩm nổi bật.</p>
                    </div>
                @endforelse
            </div>
             <div class="text-center mt-4">
                 <a href="{{ route('products.index') }}" class="btn btn-outline-dark">
                     Xem tất cả sản phẩm
                 </a>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Đảm bảo nền body là màu trắng */
    body { background-color: #fff !important; }

    /* Chi tiết Hero Section */
    .display-3 { line-height: 1.1; }

    /* CSS cho Ticker (Chỉnh tốc độ animation nếu cần) */
    .ticker-container { white-space: nowrap; }
    .ticker-text { display: inline-block; animation: ticker-scroll 70s linear infinite; }
    @keyframes ticker-scroll {
        0% { transform: translateX(0%); }
        100% { transform: translateX(-50%); }
    }
    .ticker-container:hover .ticker-text { animation-play-state: paused; }

    /* Chỉnh sửa Product Card */
     .product-card-custom {
        border: 1px solid #eee; /* Viền ban đầu nhạt hơn */
        transition: all 0.2s ease-in-out;
        background-color: #fff; /* Đảm bảo nền card trắng */
    }
    .product-card-custom:hover {
        border-color: #000; /* Viền đen khi hover */
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        transform: translateY(-3px); /* Hiệu ứng nhấc nhẹ */
    }
     .product-card-custom .card-img-top {
        aspect-ratio: 4 / 3; /* Giữ tỉ lệ */
        object-fit: contain; /* Đảm bảo ảnh vừa vặn */
        background-color: #fff; /* Nền trắng cho khu vực ảnh */
        padding: 0.5rem;
    }
    .product-card-custom .card-body {
        background-color: #fff;
    }
    .product-card-custom .card-title a { color: #212529 !important; } /* Đảm bảo tiêu đề màu đen */
    .product-card-custom .card-title a:hover { color: var(--bs-primary) !important; } /* Tiêu đề thành màu xanh khi hover */

    /* Màu nút */
    .btn-primary { /* Xanh */
        background-color: #0d6efd;
        border-color: #0d6efd;
        /* Thêm các thuộc tính từ ảnh tham khảo nếu muốn (vd: bo góc ít hơn) */
        /* border-radius: 4px; */
        /* padding: 0.75rem 1.5rem; */
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
    .text-danger { /* Đỏ */
        color: #dc3545 !important;
    }
    .text-warning, .bg-warning { /* Vàng */
        color: #000 !important; /* Chữ đen trên nền vàng */
        background-color: #ffc107 !important;
    }
    .text-secondary { color: #6c757d !important; } /* Xám cho chữ ít quan trọng */
    .text-dark { color: #212529 !important; } /* Đảm bảo chữ chính màu đen */
    .btn-outline-dark { /* Nút viền đen */
        color: #000;
        border-color: #000;
    }
     .btn-outline-dark:hover {
        color: #fff;
        background-color: #000;
        border-color: #000;
    }

</style>
@endpush
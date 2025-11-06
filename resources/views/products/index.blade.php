@extends('layouts.guest')

@section('title', 'Cửa hàng - SWGunpla')

@section('content')
<div class="container mt-4"> 
    <div class="row">
        <div class="col-lg-3 filter-sidebar mb-4 mb-lg-0"> 
            <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                <input type="hidden" name="category" value="{{ request('category') }}">
                <input type="hidden" name="brand" value="{{ request('brand') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm tên..." value="{{ request('search') }}">
                    <button class="btn btn-outline-dark btn-sm" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            @if(request('category') || request('brand'))
                <div class="mb-3">
                    <a href="{{ route('products.index', ['search' => request('search')]) }}" class="btn btn-sm btn-light w-100 border">
                        <i class="bi bi-x-lg me-1"></i> Xóa bộ lọc
                    </a>
                </div>
            @endif

            <div class="card mb-3">
                <div class="card-header">Danh mục</div>
                <div class="list-group list-group-flush">
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', array_merge(request()->query(), ['category' => $category->slug, 'page' => 1])) }}"
                           class="list-group-item list-group-item-action {{ request('category') == $category->slug ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Thương hiệu</div>
                <div class="list-group list-group-flush">
                    @foreach($brands as $brand)
                        <a href="{{ route('products.index', array_merge(request()->query(), ['brand' => $brand->slug, 'page' => 1])) }}"
                           class="list-group-item list-group-item-action {{ request('brand') == $brand->slug ? 'active' : '' }}">
                            {{ $brand->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <h1 class="h3 mb-4">Cửa hàng Gunpla</h1>
            
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($products as $product)
                    <div class="col">
                         <div class="card h-100 product-card-custom">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->first_image_url }}" class="card-img-top" alt="{{ $product->name }}">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <p class="card-text mb-1"><small class="text-muted">{{ $product->brand->name ?? '' }}</small></p>
                                <h5 class="card-title fs-6 flex-grow-1">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark stretched-link">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                <p class="card-text text-danger fs-5 fw-bold mt-2">
                                    {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Không tìm thấy sản phẩm nào phù hợp.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
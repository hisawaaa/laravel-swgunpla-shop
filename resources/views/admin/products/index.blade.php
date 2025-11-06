@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Quản lý Sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Thêm mới
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-light border-bottom">
        <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Tìm tên sản phẩm..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                <i class="bi bi-search me-1"></i> Tìm
            </button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light text-uppercase small">
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 10%;">Ảnh</th>
                        <th style="width: 30%;">Tên sản phẩm</th>
                        <th style="width: 15%;">Giá (VNĐ)</th>
                        <th style="width: 10%;">Kho</th>
                        <th style="width: 15%;">Danh mục</th>
                        <th style="width: 15%;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: contain;">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-warning btn-sm py-0 px-1" title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-1" title="Xóa">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Chưa có sản phẩm nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($products->hasPages())
    <div class="card-footer bg-light border-top">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
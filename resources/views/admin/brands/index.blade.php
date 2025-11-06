@extends('layouts.admin')

@section('title', 'Quản lý Thương hiệu')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Thương hiệu</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Quản lý Thương hiệu</h1>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Thêm mới
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-light border-bottom">
        <form action="{{ route('admin.brands.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Tìm tên thương hiệu..." value="{{ request('search') }}">
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
                        <th style="width: 10%;">ID</th>
                        <th style="width: 30%;">Tên Thương hiệu</th>
                        <th style="width: 30%;">Slug</th>
                        <th style="width: 15%;">Số SP</th>
                        <th style="width: 15%;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td class="text-muted">{{ $brand->slug }}</td>
                        <td>{{ $brand->products_count ?? 0 }}</td>
                        <td>
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-outline-warning btn-sm py-0 px-1" title="Sửa">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa thương hiệu này?')">
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
                        <td colspan="5" class="text-center py-4">Chưa có thương hiệu nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
     @if ($brands->hasPages())
    <div class="card-footer bg-light border-top">
        {{ $brands->links() }}
    </div>
    @endif
</div>
@endsection
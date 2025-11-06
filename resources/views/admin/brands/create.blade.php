@extends('layouts.admin')

@section('title', 'Thêm Thương hiệu mới')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">Thương hiệu</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
@endsection

@section('content')
<h1 class="h3 mb-3">Thêm Thương hiệu mới</h1>

<form action="{{ route('admin.brands.store') }}" method="POST" class="card shadow-sm">
    @csrf
    <div class="card-body">
        <div class="mb-3">
            <label for="name" class="form-label">Tên Thương hiệu*</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
             @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="card-footer bg-light border-top d-flex justify-content-end gap-2">
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Hủy</a>
        <button type="submit" class="btn btn-primary">Lưu Thương hiệu</button>
    </div>
</form>
@endsection
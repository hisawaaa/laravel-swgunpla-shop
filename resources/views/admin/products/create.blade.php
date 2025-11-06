@extends('layouts.admin')

@section('title', 'Thêm Sản phẩm mới')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
@endsection

@section('content')
<h1 class="h3 mb-3">Thêm Sản phẩm mới</h1>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm">
    @csrf
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label for="name" class="form-label">Tên sản phẩm*</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="price" class="form-label">Giá (VNĐ)*</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required min="0">
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="stock" class="form-label">Tồn kho*</label>
                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" required min="0">
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="category_id" class="form-label">Danh mục*</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="brand_id" class="form-label">Thương hiệu*</label>
                <select class="form-select @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" required>
                     <option value="">-- Chọn thương hiệu --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                 @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-12">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-12">
                <label for="images" class="form-label">Hình ảnh sản phẩm</label>
                <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                <div class="form-text">Có thể chọn nhiều ảnh. Định dạng: jpg, jpeg, png, webp. Tối đa 2MB/ảnh.</div>
                @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="card-footer bg-light border-top d-flex justify-content-end gap-2">
         <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
         <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
    </div>
</form>
@endsection
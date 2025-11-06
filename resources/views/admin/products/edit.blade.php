@extends('layouts.admin')
@use Illuminate\Support\Facades\Storage; {{-- Thêm để dùng Storage::url() --}}

@section('title', 'Cập nhật Sản phẩm #' . $product->id)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
    <li class="breadcrumb-item active" aria-current="page">Cập nhật #{{ $product->id }}</li>
@endsection

@section('content')
<h1 class="h3 mb-3">Cập nhật Sản phẩm #{{ $product->id }}</h1>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="card shadow-sm mb-4">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label for="name" class="form-label">Tên sản phẩm*</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="price" class="form-label">Giá (VNĐ)*</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0">
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="stock" class="form-label">Tồn kho*</label>
                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="category_id" class="form-label">Danh mục*</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
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
                        <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                 @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-12">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-12">
                <label for="images" class="form-label">Thêm hình ảnh mới</label>
                <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                 <div class="form-text">Có thể chọn nhiều ảnh. Ảnh mới sẽ được thêm vào, không thay thế ảnh cũ.</div>
                @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="card-footer bg-light border-top d-flex justify-content-end gap-2">
         <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
         <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
    </div>
</form>

{{-- HIỂN THỊ VÀ XÓA ẢNH --}}
<div class="card shadow-sm">
    <div class="card-header bg-light border-bottom">
        <h6 class="mb-0">Các ảnh hiện tại</h6>
    </div>
    <div class="card-body">
         <div class="row g-3">
            @forelse($product->images as $image)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="card position-relative product-image-thumb">
                        <img src="{{ Storage::url($image->image_path) }}" class="card-img-top object-fit-contain" alt="Product Image" style="height: 100px;">
                        {{-- Nút Xóa Ảnh --}}
                        <form
                            action="{{ route('admin.products.image.destroy', $image->id) }}"
                            method="POST"
                            class="position-absolute top-0 end-0 p-1"
                            onsubmit="return confirm('Bạn có chắc muốn xóa ảnh này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-circle py-0 px-1 border-white" style="line-height: 1;">
                                <i class="bi bi-x small"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12"><p>Sản phẩm này chưa có hình ảnh.</p></div>
            @endforelse
        </div>
    </div>
</div>
@endsection
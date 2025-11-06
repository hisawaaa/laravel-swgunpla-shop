@extends('layouts.admin')

@section('title', 'Tạo Voucher mới')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Voucher</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
@endsection

@section('content')
<h1 class="h3 mb-3">Tạo Mã giảm giá mới</h1>

<form action="{{ route('admin.vouchers.store') }}" method="POST" class="card shadow-sm">
    @csrf
   <div class="card-body">
        <div class="mb-3">
            <label for="code" class="form-label">Mã (Code)*</label>
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="type" class="form-label">Loại giảm giá*</label>
                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="fixed" @selected(old('type') == 'fixed')>Giảm cố định (VNĐ)</option>
                    <option value="percent" @selected(old('type') == 'percent')>Giảm phần trăm (%)</option>
                </select>
                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="value" class="form-label">Giá trị* (Nhập số)</label>
                <input type="number" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value') }}" required min="0">
                @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">Nếu là %, nhập số phần trăm (ví dụ: 10). Nếu là VNĐ, nhập số tiền (ví dụ: 50000).</div>
            </div>
        </div>

         <div class="row">
            <div class="col-md-6 mb-3">
                <label for="quantity" class="form-label">Số lượng*</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required min="0">
                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="expires_at" class="form-label">Ngày hết hạn (Bỏ trống nếu không hết hạn)</label>
                <input type="date" class="form-control @error('expires_at') is-invalid @enderror" id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                @error('expires_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div class="card-footer bg-light border-top d-flex justify-content-end gap-2">
         <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Hủy</a>
         <button type="submit" class="btn btn-primary">Lưu Voucher</button>
    </div>
</form>
@endsection
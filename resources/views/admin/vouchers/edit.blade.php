@extends('layouts.admin')

@section('title', 'Cập nhật Voucher #' . $voucher->id)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Voucher</a></li>
    <li class="breadcrumb-item active" aria-current="page">Cập nhật #{{ $voucher->id }}</li>
@endsection

@section('content')
<h1 class="h3 mb-3">Cập nhật Mã giảm giá #{{ $voucher->id }}</h1>

<form action="{{ route('admin.vouchers.update', $voucher) }}" method="POST" class="card shadow-sm">
    @csrf
    @method('PUT')
   <div class="card-body">
        <div class="mb-3">
            <label for="code" class="form-label">Mã (Code)*</label>
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $voucher->code) }}" required>
            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="type" class="form-label">Loại giảm giá*</label>
                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="fixed" @selected(old('type', $voucher->type) == 'fixed')>Giảm cố định (VNĐ)</option>
                    <option value="percent" @selected(old('type', $voucher->type) == 'percent')>Giảm phần trăm (%)</option>
                </select>
                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="value" class="form-label">Giá trị* (Nhập số)</label>
                <input type="number" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value', $voucher->value) }}" required min="0">
                @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

         <div class="row">
            <div class="col-md-6 mb-3">
                <label for="quantity" class="form-label">Số lượng*</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $voucher->quantity) }}" required min="0">
                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="expires_at" class="form-label">Ngày hết hạn</label>
                <input type="date" class="form-control @error('expires_at') is-invalid @enderror" id="expires_at" name="expires_at" value="{{ old('expires_at', $voucher->expires_at ? $voucher->expires_at->format('Y-m-d') : '') }}">
                @error('expires_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div class="card-footer bg-light border-top d-flex justify-content-end gap-2">
         <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Quay lại</a>
         <button type="submit" class="btn btn-primary">Cập nhật Voucher</button>
    </div>
</form>
@endsection
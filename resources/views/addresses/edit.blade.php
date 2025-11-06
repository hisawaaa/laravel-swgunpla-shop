@extends('layouts.app')

@section('title', 'Sửa địa chỉ')

@section('header')
<h2 class="h4 mb-0 fw-bold">
    Sửa địa chỉ
</h2>
@endsection

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('addresses.update', $address) }}" method="POST">
                @csrf
                @method('PUT')
                @if(request('redirect') == 'checkout')
                    <input type="hidden" name="redirect_to" value="{{ route('checkout.index') }}">
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label">Họ và tên*</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name', $address->full_name) }}" required>
                        @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Số điện thoại*</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $address->phone) }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address_line" class="form-label">Địa chỉ (Số nhà, Tên đường)*</label>
                    <input type="text" class="form-control @error('address_line') is-invalid @enderror" id="address_line" name="address_line" value="{{ old('address_line', $address->address_line) }}" required>
                    @error('address_line') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                 <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="city" class="form-label">Tỉnh/Thành phố*</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $address->city) }}" required>
                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="district" class="form-label">Quận/Huyện*</label>
                        <input type="text" class="form-control @error('district') is-invalid @enderror" id="district" name="district" value="{{ old('district', $address->district) }}" required>
                        @error('district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ward" class="form-label">Phường/Xã*</label>
                        <input type="text" class="form-control @error('ward') is-invalid @enderror" id="ward" name="ward" value="{{ old('ward', $address->ward) }}" required>
                        @error('ward') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_default">
                        Đặt làm địa chỉ mặc định
                    </label>
                </div>
                 <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Cập nhật địa chỉ</button>
                     <a href="{{ request('redirect') == 'checkout' ? route('checkout.index') : route('addresses.index') }}" class="btn btn-outline-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection
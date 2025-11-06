@extends('layouts.app')

@section('title', 'Địa chỉ')

@section('header')
<h2 class="h4 mb-0 fw-bold">
    Sổ địa chỉ
</h2>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('addresses.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Thêm địa chỉ mới
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            @if($addresses->isEmpty())
                <p class="text-muted">Bạn chưa có địa chỉ nào.</p>
            @else
                @foreach($addresses as $address)
                <div class="card mb-3 address-card {{ $address->is_default ? 'border-primary shadow-sm' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $address->full_name }}</strong>
                                @if($address->is_default)<span class="badge bg-primary ms-2 small">Mặc định</span>@endif
                                <p class="mb-1 small text-muted">
                                    {{ $address->phone }} <br>
                                    {{ $address->address_line }}, {{ $address->ward }}, {{ $address->district }}, {{ $address->city }}
                                </p>
                            </div>
                            <div class="d-flex gap-2 align-items-start flex-wrap"> {{-- Nút sửa/xóa --}}
                                <a href="{{ route('addresses.edit', $address) }}" class="btn btn-outline-secondary btn-sm py-0 px-2"><i class="bi bi-pencil"></i> Sửa</a>
                                <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Xóa địa chỉ này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2"><i class="bi bi-trash3"></i> Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
@extends('layouts.admin') 

@section('title', 'Quản lý Đơn hàng') 

@section('content') 
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Quản lý Đơn hàng</h1>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-light border-bottom">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Tìm ID đơn hàng hoặc Tên KH..." value="{{ request('search') }}">
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
                        <th>ID Đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền (VNĐ)</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Chờ xử lý</span>
                            @elseif($order->status == 'processing')
                                <span class="badge bg-info text-dark">Đang xử lý</span>
                            @elseif($order->status == 'completed')
                                <span class="badge bg-success">Hoàn thành</span>
                            @elseif($order->status == 'cancelled')
                                <span class="badge bg-danger">Đã hủy</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-primary btn-sm py-0 px-1" title="Xem chi tiết">
                                <i class="bi bi-eye"></i> Xem
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Không tìm thấy đơn hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
     @if ($orders->hasPages())
    <div class="card-footer bg-light border-top">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
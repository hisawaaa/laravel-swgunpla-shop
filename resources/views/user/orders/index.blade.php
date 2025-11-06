@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('header')
<h2 class="h4 mb-0 fw-bold">
    Đơn hàng của tôi
</h2>
@endsection

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
             <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID Đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền (VNĐ)</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
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
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.orders.show', $order) }}" class="btn btn-primary btn-sm">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-muted">Bạn chưa có đơn hàng nào.</td>
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
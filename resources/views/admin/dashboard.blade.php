@extends('layouts.admin') 

@section('title', 'Administrator')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Tổng quan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tổng Doanh thu (Hoàn thành)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalRevenue, 0, ',', '.') }} VNĐ
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cash-stack fs-2 text-black-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Đơn hàng chờ xử lý</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pendingOrders }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-hourglass-split fs-2 text-black-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số Khách hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalCustomers }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people-fill fs-2 text-black-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tổng số dòng sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalProducts }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fs-2 text-black-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-light border-bottom">
                    <h6 class="m-0 fw-bold text-primary">Đơn hàng gần đây</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small text-uppercase">
                                <tr>
                                    <th>ID</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                    <th></th> {{-- Cột xem --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}">
                                            #{{ $order->id }}
                                        </a>
                                    </td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
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
                                    <td class="small text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary py-0 px-1" title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Chưa có đơn hàng nào.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
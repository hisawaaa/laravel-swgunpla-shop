@extends('layouts.admin')

@section('title', 'Quản lý Đánh giá')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Đánh giá</li>
@endsection

@section('content')
<h1 class="h3 mb-3">Quản lý Đánh giá</h1>

<div class="card shadow-sm">
     <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light text-uppercase small">
                    <tr>
                        <th style="width: 25%;">Sản phẩm</th>
                        <th style="width: 15%;">Người dùng</th>
                        <th style="width: 10%;">Rating</th>
                        <th style="width: 20%;">Bình luận</th>
                        <th style="width: 10%;">Trạng thái</th>
                        <th style="width: 20%;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr>
                        <td>
                            <a href="{{ route('admin.products.edit', $review->product_id) }}" title="Xem sản phẩm">
                                {{ $review->product->name ?? 'N/A' }}
                            </a>
                        </td>
                        <td>{{ $review->user->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ $review->rating }} <i class="bi bi-star-fill small"></i>
                            </span>
                        </td>
                        <td class="small">{{ Str::limit($review->comment, 100) }}</td>
                        
                        {{-- HIỂN THỊ STATUS --}}
                        <td>
                            @if($review->status == 'pending')
                                <span class="badge bg-secondary">Chờ duyệt</span>
                            @elseif($review->status == 'approved')
                                <span class="badge bg-success">Đã duyệt</span>
                            @endif
                        </td>
                        
                        <td>
                            {{-- Chỉ hiển thị nút duyệt nếu đang 'pending' --}}
                            @if($review->status == 'pending')
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-success btn-sm py-0 px-1" title="Duyệt">
                                        <i class="bi bi-check-lg"></i> Duyệt
                                    </button>
                                </form>
                            @endif

                            {{-- Nút Xóa (Dùng cho cả pending và approved) --}}
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa đánh giá này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-1" title="Xóa">
                                    <i class="bi bi-trash3"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                     @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Chưa có đánh giá nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
     @if ($reviews->hasPages())
    <div class="card-footer bg-light border-top">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection
@extends('front')

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                    <i class="fas fa-history text-white"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1">Riwayat Pesanan</h2>
                    <p class="text-muted mb-0">Lihat status dan detail pesanan Anda</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-shopping-bag text-muted" style="font-size: 5rem;"></i>
                </div>
                <h3 class="mb-3">Belum Ada Pesanan</h3>
                <p class="text-muted mb-4">Anda belum memiliki riwayat pesanan.</p>
                <a href="{{ url('menu') }}" class="btn btn-primary px-4 py-2">
                    <i class="fas fa-utensils me-2"></i> Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0 fw-bold">Daftar Pesanan</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="searchOrder" placeholder="Cari pesanan...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="orderTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No. Pesanan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="ps-4 fw-medium">#{{ $order->idorder }}</td>
                                    <td>{{ date('d M Y, H:i', strtotime($order->tglorder)) }}</td>
                                    <td class="fw-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status == 1)
                                            <span class="badge bg-warning">Belum Dibayar</span>
                                        @elseif($order->status == 2)
                                            <span class="badge bg-success">Sudah Dibayar</span>
                                        @elseif($order->status == 3)
                                            <span class="badge bg-info">Sedang Diproses</span>
                                        @elseif($order->status == 4)
                                            <span class="badge bg-primary">Siap Diambil</span>
                                        @elseif($order->status == 5)
                                            <span class="badge bg-secondary">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('order-detail/' . $order->idorder) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 text-muted">Menampilkan {{ $orders->count() }} pesanan</p>
                    </div>
                    <div class="pagination-container">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* Enhanced pagination styling */
    .pagination-container .pagination {
        gap: 8px;
    }

    .pagination-container .page-item .page-link {
        border-radius: var(--border-radius-full);
        color: var(--gray-700);
        border: 1px solid var(--gray-200);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        transition: all var(--transition-fast) ease;
    }

    .pagination-container .page-item .page-link:hover {
        background-color: var(--primary-light);
        color: var(--primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .pagination-container .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        box-shadow: var(--shadow);
    }

    .pagination-container .page-item.disabled .page-link {
        color: var(--gray-400);
        background-color: var(--gray-100);
        border-color: var(--gray-200);
        opacity: 0.7;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchOrder');
        const orderTable = document.getElementById('orderTable');

        if (searchInput && orderTable) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = orderTable.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection

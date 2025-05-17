@extends('front')

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="fas fa-receipt text-white"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-1">Detail Pesanan #{{ $order->idorder }}</h2>
                        <p class="text-muted mb-0">{{ date('d F Y, H:i', strtotime($order->tglorder)) }}</p>
                    </div>
                </div>
                <a href="{{ url('order-history') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
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

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Item Pesanan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" width="5%">No</th>
                                    <th width="40%">Menu</th>
                                    <th width="15%">Harga</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderDetails as $key => $detail)
                                    <tr>
                                        <td class="ps-4">{{ $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('gambar/'.$detail->gambar) }}"
                                                     alt="{{ $detail->menu }}"
                                                     class="rounded me-3"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0">{{ $detail->menu }}</h6>
                                                    <small class="text-muted">{{ $detail->kategori ?? 'Umum' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($detail->hargajual, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $detail->jumlah }}</td>
                                        <td class="fw-bold">Rp {{ number_format($detail->hargajual * $detail->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status</span>
                            <div>
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
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Nomor Pesanan</span>
                            <span class="fw-medium">#{{ $order->idorder }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tanggal Pesanan</span>
                            <span class="fw-medium">{{ date('d M Y, H:i', strtotime($order->tglorder)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Metode Pembayaran</span>
                            <span class="fw-medium">
                                <i class="fas fa-money-bill-wave text-success me-1"></i> Tunai
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-medium">Rp {{ number_format($order->total - ($order->total * 0.1), 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Pajak (10%)</span>
                            <span class="fw-medium">Rp {{ number_format($order->total * 0.1, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-primary fs-5">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    @if($order->status >= 2)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Bayar</span>
                            <span class="fw-medium">Rp {{ number_format($order->bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Kembali</span>
                            <span class="fw-medium">Rp {{ number_format($order->kembali, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Aksi</h6>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Cetak Struk
                        </button>
                        @if($order->status == 1)
                            <a href="#" class="btn btn-success">
                                <i class="fas fa-credit-card me-2"></i> Bayar Sekarang
                            </a>
                        @endif
                        <a href="{{ url('menu') }}" class="btn btn-outline">
                            <i class="fas fa-utensils me-2"></i> Pesan Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

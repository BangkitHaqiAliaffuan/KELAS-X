@extends('front')

@section('content')
    @if (session('cart'))
        <div class="container-fluid px-0">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Keranjang Belanja</h2>
                            <p class="text-muted mb-0">Review dan checkout pesanan Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Item Pesanan</h5>
                            <a class="btn btn-outline-danger btn-sm" href="{{ url('batal') }}">
                                <i class="fas fa-trash-alt me-2"></i> Kosongkan Keranjang
                            </a>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $total = 0;
                                $no = 1;
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4" width="5%">No</th>
                                            <th width="40%">Menu</th>
                                            <th width="15%">Harga</th>
                                            <th width="20%">Jumlah</th>
                                            <th width="15%">Total</th>
                                            <th width="5%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (session('cart') as $idmenu => $menu)
                                            <tr>
                                                <td class="ps-4">{{ $no++ }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                            $gambarPath = isset($menu['gambar']) ? 'gambar/'.$menu['gambar'] : 'gambar/default.jpg';
                                                        @endphp
                                                        <img src="{{ asset($gambarPath) }}"
                                                             alt="{{ $menu['menu'] }}"
                                                             class="rounded me-3"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                        <div>
                                                            <h6 class="mb-0">{{ $menu['menu'] }}</h6>
                                                            <small class="text-muted">{{ $menu['kategori'] ?? 'Umum' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Rp {{ number_format($menu['harga'], 0, ',', '.') }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="{{ url('kurang/' . $menu['idmenu']) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-2" title="Kurangi">
                                                            <i class="fas fa-minus"></i>
                                                        </a>
                                                        <span class="mx-2 fw-medium">{{ $menu['jumlah'] }}</span>
                                                        <a href="{{ url('tambah/' . $menu['idmenu']) }}" class="btn btn-sm btn-outline-secondary rounded-circle ms-2" title="Tambah">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="fw-bold">Rp {{ number_format($menu['jumlah'] * $menu['harga'], 0, ',', '.') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ url('hapus/'.$menu['idmenu']) }}" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $total = $total + $menu['jumlah'] * $menu['harga'];
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal</span>
                                <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Pajak (10%)</span>
                                <span class="fw-bold">Rp {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Biaya Layanan</span>
                                <span class="fw-bold">Rp {{ number_format(5000, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold">Total Pembayaran</span>
                                <span class="fs-5 fw-bold text-primary">Rp {{ number_format($total + ($total * 0.1) + 5000, 0, ',', '.') }}</span>
                            </div>

                            <div class="mt-4">
                                <div class="d-grid gap-2">
                                    <a class="btn btn-primary py-3" href="{{ url('checkout') }}">
                                        <i class="fas fa-check-circle me-2"></i> Checkout Sekarang
                                    </a>
                                    <a class="btn btn-outline py-2" href="{{ url('menu') }}">
                                        <i class="fas fa-arrow-left me-2"></i> Lanjutkan Belanja
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Metode Pembayaran</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cash" checked>
                                <label class="form-check-label" for="cash">
                                    <i class="fas fa-money-bill-wave text-success me-2"></i> Tunai
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="transfer">
                                <label class="form-check-label" for="transfer">
                                    <i class="fas fa-university text-primary me-2"></i> Transfer Bank
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="ewallet">
                                <label class="form-check-label" for="ewallet">
                                    <i class="fas fa-wallet text-warning me-2"></i> E-Wallet
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart text-muted" style="font-size: 5rem;"></i>
            </div>
            <h3 class="mb-3">Keranjang Belanja Kosong</h3>
            <p class="text-muted mb-4">Anda belum menambahkan menu apapun ke keranjang.</p>
            <a href="{{ url('menu') }}" class="btn btn-primary px-4 py-2">
                <i class="fas fa-utensils me-2"></i> Lihat Menu
            </a>
        </div>

        <script>
            // Redirect after 3 seconds if cart is empty
            setTimeout(function() {
                window.location.href = '/menu';
            }, 3000);
        </script>
    @endif
@endsection

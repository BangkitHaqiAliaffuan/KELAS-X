@extends('front')

@section('content')
    @if (session('cart'))
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Keranjang Belanja</h4>
                    <a class="btn btn-outline-danger" href="{{ url('batal') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @php
                    $total = 0;
                    $no = 1;
                @endphp

                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" width="5%">No</th>
                                <th width="30%">Menu</th>
                                <th width="15%">Harga</th>
                                <th width="20%">Jumlah</th>
                                <th width="15%">Total</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (session('cart') as $idmenu => $menu)
                                <tr>
                                    <td class="ps-4">{{ $no++ }}</td>
                                    <td>{{ $menu['menu'] }}</td>
                                    <td>Rp {{ number_format($menu['harga'], 0, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ url('kurang/' . $menu['idmenu']) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-2" title="Kurangi">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                                </svg>
                                            </a>
                                            <span class="mx-2 fw-medium">{{ $menu['jumlah'] }}</span>
                                            <a href="{{ url('tambah/' . $menu['idmenu']) }}" class="btn btn-sm btn-outline-secondary rounded-circle ms-2" title="Tambah">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($menu['jumlah'] * $menu['harga'], 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('hapus/'.$menu['idmenu']) }}" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
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

            <div class="card-footer bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
                            <span class="fw-bold">Total Pembayaran:</span>
                            <span class="fs-4 fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <div class="d-grid">
                            <a class="btn btn-success py-2" href="{{ url('checkout') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check me-2" viewBox="0 0 16 16">
                                    <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <script>
            window.location.href = '/';
        </script>
    @endif

<style>
    .table th, .table td {
        vertical-align: middle;
    }

    .btn-outline-secondary {
        border-color: #dee2e6;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }

    .btn-outline-danger:hover {
        transform: scale(1.05);
    }

    .btn-success {
        background-color: #198754;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #157347;
        transform: scale(1.02);
    }
</style>
@endsection

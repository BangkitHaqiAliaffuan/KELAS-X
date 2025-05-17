@extends('backend.back')

@section('admincontent')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-0">Daftar Pesanan</h3>
        <div>
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                </svg>
                Filter
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item" href="#">Semua Pesanan</a></li>
                <li><a class="dropdown-item" href="#">Belum Dibayar</a></li>
                <li><a class="dropdown-item" href="#">Sudah Dibayar</a></li>
            </ul>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3" style="width: 60px;">No</th>
                            <th class="px-4 py-3">Pelanggan</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Bayar</th>
                            <th class="px-4 py-3">Kembali</th>
                            <th class="px-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    @php
                        $no = 1;
                    @endphp
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-4 py-3">{{ $no++ }}</td>
                                <td class="px-4 py-3 fw-medium">
                                    <a href="{{ url('admin/order/'.$order->idorder.'/edit') }}" class="text-decoration-none">
                                        {{ $order->pelanggan }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">{{ date('d M Y', strtotime($order->tglorder)) }}</td>
                                <td class="px-4 py-3 fw-medium">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($order->bayar, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($order->kembali, 0, ',', '.') }}</td>
                                @php
                                    $status = "<span class='badge bg-success'>LUNAS</span>";
                                    if($order->status == 0){
                                        $status = "<a href='".url('admin/order/'.$order->idorder)."' class='btn btn-sm btn-warning'>BAYAR</a>";
                                    }
                                @endphp
                                <td class="px-4 py-3 text-center">{!! $status !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(count($orders) == 0)
    <div class="text-center p-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-receipt text-secondary mb-3" viewBox="0 0 16 16">
            <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.509.51.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z"/>
            <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
        </svg>
        <h5 class="text-secondary">Belum ada pesanan</h5>
        <p class="text-muted">Pesanan baru akan muncul di sini</p>
    </div>
    @endif

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->withQueryString()->links() }}
    </div>
@endsection

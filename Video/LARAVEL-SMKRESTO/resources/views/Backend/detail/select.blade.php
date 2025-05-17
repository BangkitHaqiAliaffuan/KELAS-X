@extends('backend.back')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 fw-bold">Order Detail</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/orderdetail/create') }}" method="get" class="mb-4">
                        <div class="row g-3 align-items-end">
                            @csrf
                            <div class="col-md-4">
                                <label class="form-label" for="tglmulai">Tanggal Mulai</label>
                                <input class="form-control" id="tglmulai" value="{{ old('tglmulai') }}" type="date" name="tglmulai">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="tglakhir">Tanggal Akhir</label>
                                <input class="form-control" id="tglakhir" value="{{ old('tglakhir') }}" type="date" name="tglakhir">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary px-4" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Pelanggan</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="20%">Menu</th>
                                    <th width="15%">Harga</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($details as $detail)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $detail->pelanggan }}</td>
                                        <td>{{ $detail->tglorder }}</td>
                                        <td>{{ $detail->menu }}</td>
                                        <td>{{ number_format($detail->harga, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $detail->jumlah }}</td>
                                        <td>{{ number_format($detail->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $details->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.card {
    border-radius: 10px;
    border: none;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1rem 1.5rem;
}

.table th {
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
    padding: 0.75rem 1rem;
}

.btn {
    font-weight: 500;
    border-radius: 5px;
    transition: all 0.2s;
}

.pagination {
    margin-bottom: 0;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ced4da;
    padding: 0.5rem 0.75rem;
}

.form-control:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    border-color: #86b7fe;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}
</style>

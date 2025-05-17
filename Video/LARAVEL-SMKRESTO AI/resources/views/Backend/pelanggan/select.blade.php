@extends('backend.back')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 fw-bold">Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Pelanggan</th>
                                    <th width="20%">Email</th>
                                    <th width="25%">Alamat</th>
                                    <th width="15%">Telp</th>
                                    <th width="15%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($pelanggans as $pelanggan)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $pelanggan->pelanggan }}</td>
                                        <td>{{ $pelanggan->email }}</td>
                                        <td>{{ $pelanggan->alamat }}</td>
                                        <td>{{ $pelanggan->telp }}</td>
                                        <td class="text-center">
                                            @if ($pelanggan->aktif == 0)
                                                <a href="{{ url('admin/pelanggan/' . $pelanggan->idpelanggan) }}" class="btn btn-sm btn-danger px-3">BANNED</a>
                                            @else
                                                <a href="{{ url('admin/pelanggan/' . $pelanggan->idpelanggan) }}" class="btn btn-sm btn-success px-3">AKTIF</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $pelanggans->withQueryString()->links() }}
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

.btn-sm {
    font-size: 0.8rem;
    border-radius: 5px;
    transition: all 0.2s;
}

.pagination {
    margin-bottom: 0;
}
</style>

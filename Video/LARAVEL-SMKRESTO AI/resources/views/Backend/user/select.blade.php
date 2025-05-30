@extends('backend.back')

@section('admincontent')
    <div class="">
        <h1>User</h1>
    </div>
    <div class="">
        <a href="{{ url('admin/user/create') }}" class="btn btn-primary">Tambah Data</a>
        @if (session()->has('pesan'))
            <p class="alert alert-danger">{{ session()->get('pesan') }}</p>
        @endif
    </div>
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Ubah</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->level }}</td>
                        <td>
                            <a href="{{ url('admin/user/'.$user->id.'/edit') }}">Ubah</a>
                        </td>
                        <td>
                            <a href="{{ url('admin/user/'.$user->id) }}">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@endsection

@extends('backend.back')


@section('admincontent')
    <div class="row">
        <div class="col-6">
            <form action="{{ url('admin/user') }}" method="post">
                @csrf
                <div class="mt-2">
                    <label class="form-label" for="">Level</label>
                    <select class="form-select" name="level" id="">
                        <option value="manajer">manajer</option>
                        <option value="admin">admin</option>
                        <option value="kasir">kasir</option>
                    </select>
                </div>
                <div class="mt-2">
                    <label class="form-label" for="">Name</label>
                    <input class="form-control" value="{{ old('name') }}" type="text" name="name">
                    <span class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mt-2">
                    <label class="form-label" for="">Email</label>
                    <input class="form-control" value="{{ old('email') }}" type="email" name="email">
                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mt-2">
                    <label class="form-label" for="">Password</label>
                    <input class="form-control" value="{{ old('password') }}" type="password" name="password">
                    <span class="text-danger">
                        @error('')
                            {{ $message }}
                        @enderror
                    </span>
                </div>


                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
@endsection

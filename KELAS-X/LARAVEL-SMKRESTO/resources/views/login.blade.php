@extends('front')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h3 class="text-center mb-4 fw-bold">Login</h3>

                @if (Session::has('pesan'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('pesan') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ url('/postlogin') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                </svg>
                            </span>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="nama@example.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                                </svg>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2">Login</button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="mb-0">Belum punya akun? <a href="{{ url('register') }}" class="text-decoration-none">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .input-group-text {
        border-right: 0;
    }

    .input-group .form-control {
        border-left: 0;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: scale(1.02);
    }

    .alert-dismissible {
        border-left: 4px solid #dc3545;
    }
</style>
@endsection

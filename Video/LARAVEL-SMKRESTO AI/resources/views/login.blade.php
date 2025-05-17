@extends('front')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="auth-card shadow-lg animate-slideInUp">
            <div class="auth-header text-center">
                <div class="mb-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-circle" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <h2 class="auth-title">Selamat Datang Kembali</h2>
                <p class="auth-subtitle">Silakan login untuk melanjutkan</p>
                <div class="border-bottom border-2 border-primary mx-auto" style="width: 50px; margin-top: 15px;"></div>
            </div>

            @if (Session::has('pesan'))
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div>{{ Session::get('pesan') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ url('/postlogin') }}" method="post" class="auth-form">
                @csrf

                <div class="form-group mb-4">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text border-end-0 bg-light">
                            <i class="fas fa-envelope text-primary"></i>
                        </span>
                        <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" placeholder="nama@example.com" required>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <a href="#" class="text-decoration-none small text-primary">Lupa password?</a>
                    </div>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text border-end-0 bg-light">
                            <i class="fas fa-lock text-primary"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 border-end-0" id="password" name="password" placeholder="••••••••" required>
                        <button class="input-group-text bg-light border-start-0" type="button" id="togglePassword">
                            <i class="fas fa-eye text-primary"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                </div>

                <div class="d-grid gap-2 mb-4">
                    <button type="submit" class="btn btn-primary py-3 rounded-pill shadow-sm fw-semibold">
                        Login <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>

                <div class="auth-footer text-center">
                    <p class="mb-0">Belum punya akun? <a href="{{ url('register') }}" class="text-decoration-none fw-semibold">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            // Toggle type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle icon
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>
@endsection

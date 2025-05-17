@extends('front')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="auth-card shadow-lg animate-slideInUp">
            <div class="auth-header text-center">
                <div class="mb-4">
                    <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-plus" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <h2 class="auth-title">Buat Akun Baru</h2>
                <p class="auth-subtitle">Daftar untuk menikmati layanan SMK Resto</p>
                <div class="border-bottom border-2 border-secondary mx-auto" style="width: 50px; margin-top: 15px;"></div>
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

            <form action="{{ url('/postregister') }}" method="post" class="auth-form">
                @csrf

                <div class="form-group mb-3">
                    <label for="pelanggan" class="form-label fw-semibold">Nama Lengkap</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text border-end-0 bg-light">
                            <i class="fas fa-user text-secondary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="pelanggan" name="pelanggan" value="{{ old('pelanggan') }}" required>
                    </div>
                    @error('pelanggan')
                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text border-end-0 bg-light">
                            <i class="fas fa-map-marker-alt text-secondary"></i>
                        </span>
                        <textarea class="form-control border-start-0" id="alamat" name="alamat" rows="2" required>{{ old('alamat') }}</textarea>
                    </div>
                    @error('alamat')
                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="telp" class="form-label fw-semibold">Nomor Telepon</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text border-end-0 bg-light">
                                <i class="fas fa-phone text-secondary"></i>
                            </span>
                            <span class="input-group-text bg-light border-start-0 border-end-0">+62</span>
                            <input type="text" class="form-control border-start-0" id="telp" name="telp" value="{{ old('telp') }}" required>
                        </div>
                        @error('telp')
                            <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jeniskelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text border-end-0 bg-light">
                                <i class="fas fa-venus-mars text-secondary"></i>
                            </span>
                            <select class="form-select border-start-0" name="jeniskelamin" id="jeniskelamin" required>
                                <option value="L" {{ old('jeniskelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jeniskelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        @error('jeniskelamin')
                            <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text border-end-0 bg-light">
                            <i class="fas fa-envelope text-secondary"></i>
                        </span>
                        <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" placeholder="nama@example.com" required>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text border-end-0 bg-light">
                            <i class="fas fa-lock text-secondary"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 border-end-0" id="password" name="password" placeholder="••••••••" required>
                        <button class="input-group-text bg-light border-start-0" type="button" id="togglePassword">
                            <i class="fas fa-eye text-secondary"></i>
                        </button>
                    </div>
                    <div class="password-strength mt-2 small">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%" id="passwordStrength"></div>
                        </div>
                        <div class="mt-1 text-muted" id="passwordStrengthText">Kekuatan password</div>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya menyetujui <a href="#" class="text-decoration-none text-secondary">syarat dan ketentuan</a> yang berlaku
                        </label>
                    </div>
                </div>

                <div class="d-grid gap-2 mb-4">
                    <button type="submit" class="btn btn-secondary py-3 rounded-pill shadow-sm fw-semibold">
                        Daftar Sekarang <i class="fas fa-user-plus ms-2"></i>
                    </button>
                </div>

                <div class="auth-footer text-center">
                    <p class="mb-0">Sudah punya akun? <a href="{{ url('login') }}" class="text-decoration-none text-secondary fw-semibold">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
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

        // Password strength meter
        const passwordStrength = document.getElementById('passwordStrength');
        const passwordStrengthText = document.getElementById('passwordStrengthText');

        password.addEventListener('input', function() {
            const val = password.value;
            let strength = 0;
            let color = '';
            let text = 'Kekuatan password';

            if (val.length >= 8) strength += 25;
            if (val.match(/[a-z]+/)) strength += 25;
            if (val.match(/[A-Z]+/)) strength += 25;
            if (val.match(/[0-9]+/)) strength += 25;

            if (strength <= 25) {
                color = 'var(--danger)';
                text = 'Lemah';
            } else if (strength <= 50) {
                color = 'var(--warning)';
                text = 'Sedang';
            } else if (strength <= 75) {
                color = 'var(--info)';
                text = 'Kuat';
            } else {
                color = 'var(--success)';
                text = 'Sangat Kuat';
            }

            passwordStrength.style.width = strength + '%';
            passwordStrength.style.backgroundColor = color;
            passwordStrengthText.textContent = text;
        });
    });
</script>
@endsection

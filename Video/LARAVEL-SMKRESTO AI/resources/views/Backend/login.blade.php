<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin Aplikasi Restoran SMK</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <style>
        :root {
            --primary-color: #6D28D9;
            --secondary-color: #60A5FA;
            --accent-color: #10B981;
            --background-color: #F9FAFB;
            --text-color: #1F2937;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            max-width: 400px;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
        }

        .login-header img {
            width: 100px;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .login-header img:hover {
            transform: scale(1.05) rotate(-2deg);
        }

        .login-body {
            padding: 2.5rem;
            background-color: white;
        }

        .form-control {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            border: 2px solid #E5E7EB;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            border-color: var(--accent-color);
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background-color: white;
            border: 2px solid #E5E7EB;
            border-right: none;
            border-radius: 10px 0 0 10px;
            padding: 0.75rem 1rem;
            color: var(--text-color);
        }

        .form-control.left-border-none {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 10px;
            padding: 1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
        }

        .btn-primary {
            padding: 0.75rem 1rem;
            border-radius: 5px;
            background-color: #0d6efd;
            border: none;
            width: 100%;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .alert-danger {
            border-radius: 5px;
            border-left: 4px solid #dc3545;
        }

        .text-danger {
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
                <div class="login-card">
                    <div class="login-header">
                        <img src="{{ asset('gambar/LOGO.png') }}" alt="Logo Restoran" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MCIgaGVpZ2h0PSI4MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmZmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cGF0aCBkPSJNMyA2aDEwdjEwSDN6Ii8+PHBhdGggZD0iTTE0IDZoNHYxMGgtNHoiLz48cGF0aCBkPSJNMTkgNmgydjEwaC0yeiIvPjxwYXRoIGQ9Ik0zIDE3aDE4djFIMzpjLTEuNSAwLTMgMC0zIDB6Ii8+PC9zdmc+'" />
                        <h3 class="mb-0">Admin Panel</h3>
                    </div>

                    <div class="login-body">
                        <h4 class="text-center mb-4">Login</h4>

                        <form action="{{ url('admin/postlogin') }}" method="post">
                            @csrf

                            @if (Session::has('pesan'))
                                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle-fill me-2" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                        </svg>
                                        {{ Session::get('pesan') }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                        </svg>
                                    </span>
                                    <input class="form-control left-border-none" id="email" value="{{ old('email') }}" type="email" name="email" placeholder="admin@example.com">
                                </div>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                                        </svg>
                                    </span>
                                    <input class="form-control left-border-none" id="password" type="password" name="password" placeholder="••••••••">
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">
                                    Login
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ url('/') }}" class="text-decoration-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                    </svg>
                                    Kembali ke Halaman Utama
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

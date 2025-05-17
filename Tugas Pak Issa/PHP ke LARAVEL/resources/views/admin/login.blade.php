<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Game Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --epic-dark: #121212;
            --epic-darker: #18181b;
            --epic-blue: #0078f2;
            --epic-blue-hover: #0086ff;
            --epic-text: #ffffff;
            --epic-text-secondary: #a1a1a1;
            --epic-border: #2a2a2a;
        }

        body {
            background-color: var(--epic-dark);
            color: var(--epic-text);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: var(--epic-darker);
            border-bottom: 1px solid var(--epic-border);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: var(--epic-text);
            font-weight: 600;
            font-size: 1.25rem;
            text-decoration: none;
        }

        .login-container {
            max-width: 420px;
            margin: auto;
            padding: 2rem;
            background: var(--epic-darker);
            border-radius: 8px;
            border: 1px solid var(--epic-border);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1.5rem;
            color: var(--epic-text);
        }

        .form-label {
            color: var(--epic-text-secondary);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control {
            background-color: var(--epic-dark);
            border: 1px solid var(--epic-border);
            color: var(--epic-text);
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: var(--epic-dark);
            border-color: var(--epic-blue);
            box-shadow: 0 0 0 2px rgba(0, 120, 242, 0.25);
            color: var(--epic-text);
        }

        .btn-primary {
            background-color: var(--epic-blue);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--epic-blue-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 120, 242, 0.25);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.2);
            color: #ff6b6b;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="#" class="navbar-brand">Admin Game Store</a>
        </div>
    </header>

    <div class="container my-5">
        <div class="login-container">
            <h2 class="login-title">Admin Login</h2>

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

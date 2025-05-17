@extends('layouts.app')

@section('content')
<style>
/* Epic Games Store Theme - Auth Pages */
:root {
  --epic-dark: #121212;
  --epic-darker: #0e0e0e;
  --epic-blue: #0074e4;
  --epic-blue-hover: #0089ff;
  --epic-light-gray: #2a2a2a;
  --epic-text: #ffffff;
  --epic-text-secondary: #a7a7a7;
}

body {
  background-color: var(--epic-dark);
  color: var(--epic-text);
  font-family: "Open Sans", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background-image: linear-gradient(135deg, rgba(18, 18, 18, 0.95) 0%, rgba(14, 14, 14, 0.95) 100%),
    url("/img/game-bg.jpg");
  background-size: cover;
  background-attachment: fixed;
  background-position: center;
  min-height: 100vh;

}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.login-container,
.register-container {
  background-color: var(--epic-darker);
  border-radius: 8px;
  padding: 2.5rem;
  max-width: 450px;
  margin: 0 auto;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  border: 1px solid var(--epic-light-gray);
  position: relative;
  overflow: hidden;
}

.login-container::before,
.register-container::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, var(--epic-blue), #00c7ff);
}

h2 {
  color: var(--epic-text);
  font-size: 1.8rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.form-label {
  color: var(--epic-text);
  font-weight: 500;
  margin-bottom: 0.5rem;
  display: block;
}

.form-control {
  background-color: var(--epic-light-gray);
  border: none;
  border-radius: 4px;
  color: var(--epic-text);
  padding: 0.75rem 1rem;
  font-size: 1rem;
  width: 100%;
  transition: all 0.3s ease;
  margin-bottom: 0.5rem;
}

.form-control:focus {
  outline: none;
  box-shadow: 0 0 0 2px var(--epic-blue);
  background-color: rgba(42, 42, 42, 0.8);
}

.form-check {
  display: flex;
  align-items: center;
  margin: 1rem 0;
}

.form-check-input {
  margin-right: 0.5rem;
  width: 18px;
  height: 18px;
  accent-color: var(--epic-blue);
}

.form-check-label {
  color: var(--epic-text-secondary);
  font-size: 0.9rem;
}

.btn-primary {
  background-color: var(--epic-blue);
  border: none;
  border-radius: 4px;
  color: white;
  font-weight: 600;
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 1rem;
}

.btn-primary:hover {
  background-color: var(--epic-blue-hover);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 116, 228, 0.3);
}

.btn-primary:active {
  transform: translateY(0);
}

.alert-danger {
  background-color: rgba(220, 53, 69, 0.1);
  color: #ff6b6b;
  border: 1px solid rgba(220, 53, 69, 0.2);
  border-radius: 4px;
  padding: 1rem;
  margin-bottom: 1.5rem;
  font-size: 0.9rem;
}

.alert-danger ul {
  padding-left: 1.5rem;
  margin: 0;
}

.register-link,
.login-link {
  color: var(--epic-blue);
  text-decoration: none;
  font-weight: 500;
  transition: all 0.2s ease;
}

.register-link:hover,
.login-link:hover {
  color: var(--epic-blue-hover);
  text-decoration: underline;
}

.text-center {
  text-align: center;
}

.mt-3 {
  margin-top: 1rem;
}

.mt-4 {
  margin-top: 1.5rem;
}

.mb-4 {
  margin-bottom: 1.5rem;
}

/* Epic Games logo */
.epic-logo {
  text-align: center;
  margin-bottom: 2rem;
}

.epic-logo svg {
  height: 40px;
  width: auto;
}

/* Responsive adjustments */
@media (max-width: 576px) {
  .login-container,
  .register-container {
    padding: 1.5rem;
    margin: 1rem;
  }

  h2 {
    font-size: 1.5rem;
  }
}
</style>

<div class="container" style="margin-top: 100px;">


    <div class="register-container" >
        <h2 class="text-center mb-4">Create Epic Account</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group mb-3">
                <label for="username" class="form-label">Display Name</label>
                <input type="text" class="form-control" id="username" name="username" required
                       minlength="3" maxlength="50" value="{{ old('username') }}">
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email"
                       required value="{{ old('email') }}">
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       required minlength="8">
            </div>
            <div class="form-group mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation"
                       name="password_confirmation" required minlength="8">
            </div>
            <button type="submit" class="btn btn-primary w-100">Create Account</button>
        </form>
        <p class="text-center mt-4">Already have an Epic account? <a href="{{ route('login') }}" class="login-link">Sign In</a></p>
    </div>
</div>
@endsection

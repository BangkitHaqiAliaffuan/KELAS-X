@extends('layouts.app')

@section('content')
<div class="epic-container">
    <div class="epic-card">
        <div class="epic-card-header">
            <h1>VERIFY YOUR EMAIL</h1>
        </div>

        <div class="epic-card-body">
            @if (session('success'))
                <div class="epic-alert epic-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="epic-alert epic-alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <p class="epic-text">We've sent a verification code to your email address. Enter the code below to continue.</p>

            <form method="POST" action="{{ route('verification.verify') }}">
                @csrf

                <div class="epic-form-group">
                    <label for="otp" class="epic-label">VERIFICATION CODE</label>
                    <div class="epic-input-wrapper">
                        <input id="otp" type="text" class="epic-input @error('otp') epic-input-error @enderror" name="otp" required autofocus>

                        @error('otp')
                            <span class="epic-error-message">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="epic-form-actions">
                    <button type="submit" class="epic-button epic-button-primary">
                        VERIFY
                    </button>

                    <a href="{{ route('verification.resend') }}" class="epic-button epic-button-secondary">
                        RESEND CODE
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<style>
/* Updated Epic Games Inspired Theme - Matching Home Page Style */
:root {
    --epic-dark: #121212;
    --epic-darker: #18181b;
    --epic-accent: #0078f2;
    --epic-accent-hover: #0366d6;
    --epic-secondary: #2a2a2a;
    --epic-text: #ffffff;
    --epic-text-secondary: #888;
    --epic-success: #0AC074;
    --epic-error: #FF5757;
    --epic-font: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

body {
    background: #121212;
    color: var(--epic-text);
    font-family: var(--epic-font);
    margin: 0;
    padding: 0;
    min-height: 100vh;

}

.main-content{
    display: flex;
    justify-content: center;
    align-items: center;
}

.epic-container {
    width: 100%;
    max-width: 500px;
    padding: 20px;
}

.epic-card {
    background-color: var(--epic-darker);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
    border: 1px solid #2a2a2a;
    transition: all 0.3s ease;
}

.epic-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
}

.epic-card-header {
    background-color: var(--epic-dark);
    padding: 20px 30px;
    border-bottom: 2px solid var(--epic-accent);
}

.epic-card-header h1 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 1px;
    color: var(--epic-text);
    text-transform: uppercase;
}

.epic-card-body {
    padding: 30px;
}

.epic-text {
    color: var(--epic-text-secondary);
    margin-bottom: 25px;
    font-size: 16px;
    line-height: 1.5;
}

.epic-form-group {
    margin-bottom: 25px;
}

.epic-label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: 0.5px;
    color: var(--epic-text);
    text-transform: uppercase;
}

.epic-input-wrapper {
    position: relative;
}

.epic-input {
    width: 100%;
    padding: 15px;
    background-color: rgba(255, 255, 255, 0.1);
    border: 2px solid #3a3a3a;
    border-radius: 4px;
    color: var(--epic-text);
    font-size: 16px;
    transition: all 0.3s ease;
    box-sizing: border-box;
    letter-spacing: 2px;
    text-align: center;
}

.epic-input:focus {
    border-color: var(--epic-accent);
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 120, 242, 0.3);
}

.epic-input-error {
    border-color: var(--epic-error);
}

.epic-error-message {
    display: block;
    color: var(--epic-error);
    margin-top: 8px;
    font-size: 14px;
}

.epic-form-actions {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 30px;
}

.epic-button {
    display: block;
    padding: 15px;
    border: none;
    border-radius: 4px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    position: relative;
    overflow: hidden;
}

.epic-button-primary {
    background-color: var(--epic-accent);
    color: white;
}

.epic-button-primary:hover {
    background-color: var(--epic-accent-hover);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 120, 242, 0.3);
}

.epic-button-secondary {
    background-color: transparent;
    color: var(--epic-text);
    border: 1px solid #3a3a3a;
}

.epic-button-secondary:hover {
    background-color: rgba(255, 255, 255, 0.05);
    transform: translateY(-2px);
}

.epic-alert {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    font-weight: 500;
}

.epic-alert-success {
    background-color: rgba(10, 192, 116, 0.1);
    border-left: 4px solid var(--epic-success);
    color: var(--epic-success);
}

.epic-alert-danger {
    background-color: rgba(255, 87, 87, 0.1);
    border-left: 4px solid var(--epic-error);
    color: var(--epic-error);
}

/* Add Epic Games styled branding */
.epic-container::before {
    content: 'EPIC VERIFICATION';
    display: block;
    text-align: center;
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 30px;
    letter-spacing: 2px;
    color: white;
    text-shadow: 0 0 10px rgba(0, 120, 242, 0.5);
}

/* Add animated background similar to the home page */
@keyframes gradientAnimation {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #121212 0%, #18181b 50%, #121212 100%);
    background-size: 400% 400%;
    animation: gradientAnimation 15s ease infinite;
    z-index: -1;
}
</style>

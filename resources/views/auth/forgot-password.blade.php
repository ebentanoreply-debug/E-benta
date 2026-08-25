@extends('layouts.app')

@section('title', 'Forgot Password - E-Benta')

@section('styles')
<style>
    .forgot-password-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }

    .forgot-password-card {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.03) 100%);
        border: 2px solid rgba(13, 148, 136, 0.25);
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }

    .forgot-password-header {
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        padding: 3rem 2rem;
        text-align: center;
        color: var(--dark-bg);
    }

    .forgot-password-header h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .forgot-password-header i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        display: block;
    }

    .forgot-password-header p {
        font-size: 0.95rem;
        margin: 0;
        opacity: 0.9;
    }

    .forgot-password-body {
        padding: 2.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        color: var(--text-light);
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: block;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group input {
        background-color: rgba(255, 255, 255, 0.05) !important;
        border: 2px solid rgba(13, 148, 136, 0.3) !important;
        color: var(--text-light) !important;
        padding: 0.85rem 1rem !important;
        border-radius: 0.7rem !important;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-group input::placeholder {
        color: rgba(100, 116, 139, 0.5) !important;
    }

    .form-group input:focus {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border-color: var(--light-green) !important;
        box-shadow: 0 0 0 0.3rem rgba(13, 148, 136, 0.2) !important;
    }

    .submit-btn {
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        color: var(--dark-bg);
        border: none;
        padding: 1rem;
        font-weight: 700;
        font-size: 1.05rem;
        border-radius: 0.8rem;
        transition: all 0.35s ease;
        width: 100%;
        box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #0d9488 0%, var(--light-green) 100%);
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(13, 148, 136, 0.4);
        color: var(--dark-bg);
    }

    .divider {
        border: none;
        border-top: 2px solid rgba(13, 148, 136, 0.2);
        margin: 2rem 0;
    }

    .back-link {
        text-align: center;
        color: #64748b;
        font-size: 0.95rem;
    }

    .back-link a {
        color: var(--light-green);
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s ease;
    }

    .back-link a:hover {
        color: #0d9488;
        text-decoration: underline;
    }

    .error-message {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        font-weight: 500;
    }

    .error-box {
        background-color: rgba(231, 76, 60, 0.1);
        border: 2px solid #e74c3c;
        border-radius: 0.8rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .error-box p {
        color: #e74c3c;
        margin: 0.5rem 0 0;
        font-size: 0.9rem;
    }

    .error-box p:first-child {
        margin: 0;
        font-weight: 600;
    }

    .success-box {
        background-color: rgba(13, 148, 136, 0.1);
        border: 2px solid var(--light-green);
        border-radius: 0.8rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .success-box p {
        color: var(--light-green);
        margin: 0.5rem 0 0;
        font-size: 0.9rem;
    }

    .success-box p:first-child {
        margin: 0;
        font-weight: 600;
    }

    .info-text {
        background-color: rgba(13, 148, 136, 0.1);
        border-left: 4px solid #0d9488;
        color: #64748b;
        padding: 1rem;
        border-radius: 0.6rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .info-text i {
        color: #3498db;
        margin-right: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="forgot-password-container">
    <div class="forgot-password-card">
        <div class="forgot-password-header">
            <i class="fas fa-lock-open"></i>
            <h2>Forgot Password</h2>
            <p>We'll help you recover your account</p>
        </div>
        <div class="forgot-password-body">
            @if ($errors->any())
                <div class="error-box">
                    <p><i class="fas fa-exclamation-circle me-2"></i>Error</p>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="success-box">
                    <p><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</p>
                </div>
            @endif

            <div class="info-text">
                <i class="fas fa-info-circle"></i>
                <span>Enter the email address associated with your account. We'll send you a 6-digit verification code to reset your password.</span>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope me-2" style="color: var(--light-green);"></i>Email Address
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                         id="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane me-2"></i>Send Verification Code
                </button>
            </form>

            <hr class="divider">
            <p class="back-link">
                <i class="fas fa-arrow-left me-2"></i>Remembered your password?
                <a href="{{ route('login') }}">Back to login</a>
            </p>
        </div>
    </div>
</div>
@endsection

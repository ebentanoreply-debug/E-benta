@extends('layouts.app')

@section('title', 'Reset Password - E-Benta')

@section('styles')
<style>
    .reset-password-container {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }

    .reset-password-card {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.03) 100%);
        border: 2px solid rgba(13, 148, 136, 0.25);
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 520px;
        width: 100%;
    }

    .reset-password-header {
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        padding: 2.5rem 2rem;
        text-align: center;
        color: var(--dark-bg);
    }

    .reset-password-header h2 {
        font-size: 1.85rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
    }

    .reset-password-header i {
        font-size: 2.2rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    .reset-password-header p {
        font-size: 0.95rem;
        margin: 0;
        opacity: 0.9;
    }

    .reset-password-body {
        padding: 2.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        color: var(--text-light);
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
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

    .form-group input.otp-input {
        font-size: 1.6rem !important;
        letter-spacing: 0.35em !important;
        text-align: center !important;
        font-weight: 800 !important;
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace !important;
        border: 2px dashed #0d9488 !important;
        background-color: rgba(13, 148, 136, 0.06) !important;
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
        margin: 2rem 0 1.5rem 0;
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
        display: block;
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

    .info-text {
        background-color: rgba(13, 148, 136, 0.08);
        border-left: 4px solid #0d9488;
        color: #64748b;
        padding: 1rem;
        border-radius: 0.6rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .info-text i {
        color: #0d9488;
        margin-right: 0.5rem;
    }

    .password-requirements {
        background-color: rgba(13, 148, 136, 0.05);
        border-left: 4px solid var(--light-green);
        color: #64748b;
        padding: 0.85rem 1rem;
        border-radius: 0.6rem;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
    }

    .password-requirements h5 {
        color: var(--light-green);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
        margin-top: 0;
    }

    .password-requirements ul {
        margin: 0;
        padding-left: 1.25rem;
    }

    .password-requirements li {
        margin-bottom: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="reset-password-container">
    <div class="reset-password-card">
        <div class="reset-password-header">
            <i class="fas fa-key"></i>
            <h2>Reset Password</h2>
            <p>Enter the 6-digit code sent to your email</p>
        </div>
        <div class="reset-password-body">
            @if ($errors->any())
                <div class="error-box">
                    <p><i class="fas fa-exclamation-circle me-2"></i>Please fix the following issues:</p>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" style="background-color: rgba(13, 148, 136, 0.1); border: 2px solid var(--light-green); color: var(--light-green); border-radius: 0.8rem; padding: 1rem; margin-bottom: 1.5rem;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="info-text">
                <i class="fas fa-info-circle"></i>
                <span>Check your email inbox (and spam folder) for the 6-digit verification code. The code expires in 15 minutes.</span>
            </div>

            <form method="POST" action="{{ route('password.reset.update') }}">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope me-2" style="color: var(--light-green);"></i>Email Address
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                         id="email" name="email" value="{{ old('email', $email) }}" placeholder="your@email.com" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 6-Digit Code Field -->
                <div class="form-group">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="code" class="mb-0">
                            <i class="fas fa-shield-alt me-2" style="color: var(--light-green);"></i>6-Digit Reset Code
                        </label>
                        <a href="{{ route('password.forgot') }}" style="font-size: 0.85rem; color: var(--light-green); text-decoration: none;">
                            <i class="fas fa-redo-alt me-1"></i>Resend Code
                        </a>
                    </div>
                    <input type="text" class="form-control otp-input @error('code') is-invalid @enderror" 
                         id="code" name="code" value="{{ old('code', $code) }}" placeholder="123456" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" autocomplete="one-time-code" required autofocus>
                    @error('code')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- New Password Field -->
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock me-2" style="color: var(--light-green);"></i>New Password
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                         id="password" name="password" placeholder="••••••••" required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="password_confirmation">
                        <i class="fas fa-lock-open me-2" style="color: var(--light-green);"></i>Confirm New Password
                    </label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                         id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="password-requirements">
                    <h5><i class="fas fa-shield-alt me-1"></i>Password Guidelines</h5>
                    <ul>
                        <li>Must be at least 8 characters long</li>
                        <li>Include numbers, letters, and symbols for best security</li>
                    </ul>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-check-circle me-2"></i>Reset & Set New Password
                </button>
            </form>

            <hr class="divider">
            <p class="back-link">
                <i class="fas fa-arrow-left me-2"></i>
                <a href="{{ route('login') }}">Back to Login</a>
            </p>
        </div>
    </div>
</div>
@endsection

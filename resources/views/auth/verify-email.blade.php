@extends('layouts.app')

@section('title', 'Verify Email - E-Benta')

@section('content')
<style>
    :root {
        --primary: #0d9488;
        --primary-dark: #0f766e;
        --secondary: #06b6d4;
    }

    .verification-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 85vh;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.05) 0%, rgba(6, 182, 212, 0.05) 50%, rgba(245, 243, 255, 0.5) 100%);
        padding: 2.5rem 1rem;
    }

    .verification-container {
        background: white;
        border-radius: 1.8rem;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08), 0 0 30px rgba(13, 148, 136, 0.05);
        padding: 2.5rem 2rem;
        max-width: 480px;
        width: 100%;
        border: 1px solid #e2e8f0;
        animation: slideInUp 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .verification-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .verification-icon-badge {
        width: 64px;
        height: 64px;
        line-height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
        color: white;
        font-size: 1.8rem;
        margin: 0 auto 1.25rem;
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .verification-header h1 {
        color: #0f172a;
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .verification-header p {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
    }

    .email-display-card {
        background: #f8fafc;
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 1.75rem;
        border: 1.5px solid #e2e8f0;
    }

    .email-display-icon {
        font-size: 1.4rem;
        color: var(--primary);
    }

    .email-display-text {
        color: #0f172a;
        font-weight: 700;
        font-size: 0.95rem;
        word-break: break-all;
    }

    .code-input-group {
        margin-bottom: 1.75rem;
    }

    .code-input-group label {
        display: block;
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .code-input {
        width: 100%;
        padding: 1rem;
        border: 2px dashed #0d9488;
        border-radius: 1rem;
        font-size: 2.2rem;
        letter-spacing: 0.3em;
        text-align: center;
        font-weight: 800;
        color: #0f766e;
        background-color: rgba(13, 148, 136, 0.04);
        font-family: 'Courier New', Courier, monospace;
        transition: all 0.3s ease;
        outline: none;
    }

    .code-input:focus {
        border-color: #059669;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.15);
    }

    .code-input::placeholder {
        color: #cbd5e1;
        letter-spacing: 0.3em;
    }

    .info-box {
        background: #fffbeb;
        border-left: 4px solid #f59e0b;
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        margin-bottom: 1.5rem;
    }

    .info-box p {
        color: #92400e;
        margin: 0;
        font-size: 0.85rem;
        line-height: 1.5;
    }

    .error-message {
        background: rgba(239, 68, 68, 0.1);
        border-left: 4px solid #ef4444;
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        color: #991b1b;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .success-message {
        background: rgba(13, 148, 136, 0.1);
        border-left: 4px solid var(--primary);
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        color: var(--primary-dark);
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .verify-btn {
        width: 100%;
        padding: 1.15rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 1rem;
        font-weight: 800;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
        margin-bottom: 1.25rem;
    }

    .verify-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(13, 148, 136, 0.4);
    }

    .resend-section {
        text-align: center;
        padding-top: 1.25rem;
        border-top: 1px solid #e2e8f0;
    }

    .resend-text {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
    }

    .resend-btn {
        background: none;
        border: 2px solid var(--primary);
        color: var(--primary);
        padding: 0.75rem 1.5rem;
        border-radius: 0.8rem;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .resend-btn:hover {
        background: rgba(13, 148, 136, 0.1);
        color: var(--primary-dark);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="verification-wrapper">
    <div class="verification-container">
        <div class="verification-header">
            <div class="verification-icon-badge">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <h1>Verify Your Email</h1>
            <p>Enter the 6-digit verification code sent to:</p>
        </div>

        <!-- Email Display -->
        <div class="email-display-card">
            <i class="fas fa-envelope email-display-icon"></i>
            <div class="email-display-text">{{ $user->email ?? Auth::user()?->email }}</div>
        </div>

        <!-- Success Message -->
        @if ($message = session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle me-1"></i> {{ $message }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Expiry Info Box -->
        <div class="info-box">
            <p>
                ⏱️ <strong>Code expires in 15 minutes.</strong><br>
                Please check your inbox (and spam folder) for the 6-digit OTP code.
            </p>
        </div>

        <!-- Verification Form -->
        <form action="{{ route('verification.verify') }}" method="POST">
            @csrf

            <div class="code-input-group">
                <label for="code">Enter 6-Digit Code</label>
                <input 
                    type="text" 
                    id="code" 
                    name="code" 
                    class="code-input @error('code') is-invalid @enderror"
                    placeholder="000000"
                    maxlength="6"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    autocomplete="one-time-code"
                    autofocus
                    required>
            </div>

            <button type="submit" class="verify-btn">
                <i class="fas fa-shield-alt me-2"></i>Verify & Complete Registration
            </button>
        </form>

        <!-- Resend Section -->
        <div class="resend-section">
            <p class="resend-text">Didn't receive the verification code?</p>
            <form action="{{ route('verification.resend') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="resend-btn">
                    <i class="fas fa-redo-alt me-1"></i>Resend Code
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<style>
    :root {
        --light-green: #0d9488;
        --dark-green: #0f766e;
        --light-blue: #06b6d4;
        --dark-gray: #1e293b;
        --light-gray: #f1f5f9;
    }

    .verification-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #f0fdf4 0%, #f0f9ff 50%, #f5f3ff 100%);
        padding: 2rem;
    }

    .verification-container {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        max-width: 500px;
        width: 100%;
        animation: slideInUp 0.5s ease-out;
    }

    .verification-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .verification-header h1 {
        color: var(--dark-gray);
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .verification-header p {
        color: #64748b;
        font-size: 0.95rem;
    }

    .email-display {
        background: var(--light-gray);
        border-radius: 1rem;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1.5rem;
        border: 2px solid #e2e8f0;
    }

    .email-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .email-address {
        color: var(--dark-gray);
        font-weight: 700;
        font-size: 0.95rem;
    }

    .code-input-group {
        margin-bottom: 1.5rem;
    }

    .code-input-group label {
        display: block;
        color: var(--dark-gray);
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .code-input {
        width: 100%;
        padding: 1.2rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.9rem;
        font-size: 1.5rem;
        letter-spacing: 0.2em;
        text-align: center;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        transition: all 0.3s ease;
    }

    .code-input:focus {
        outline: none;
        border-color: var(--light-green);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
    }

    .code-input::placeholder {
        color: #cbd5e1;
    }

    .info-box {
        background: #f0f9ff;
        border-left: 4px solid var(--light-blue);
        padding: 1rem;
        border-radius: 0.8rem;
        margin-bottom: 1.5rem;
    }

    .info-box p {
        color: #0369a1;
        margin: 0;
        font-size: 0.85rem;
        line-height: 1.5;
    }

    .error-message {
        background: rgba(231, 76, 60, 0.1);
        border-left: 4px solid #e74c3c;
        padding: 1rem;
        border-radius: 0.8rem;
        color: #c0392b;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .success-message {
        background: rgba(13, 148, 136, 0.1);
        border-left: 4px solid var(--light-green);
        padding: 1rem;
        border-radius: 0.8rem;
        color: var(--dark-green);
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .verify-btn {
        width: 100%;
        padding: 1.1rem;
        background: linear-gradient(135deg, var(--light-green) 0%, var(--dark-green) 100%);
        color: white;
        border: none;
        border-radius: 0.9rem;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
        margin-bottom: 1rem;
    }

    .verify-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 148, 136, 0.3);
    }

    .verify-btn:active {
        transform: translateY(0);
    }

    .verify-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .resend-section {
        text-align: center;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .resend-text {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .resend-btn {
        background: none;
        border: 2px solid var(--light-green);
        color: var(--light-green);
        padding: 0.8rem 1.5rem;
        border-radius: 0.8rem;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .resend-btn:hover {
        background: rgba(13, 148, 136, 0.1);
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

    @media (max-width: 768px) {
        .verification-container {
            padding: 1.5rem;
        }

        .verification-header h1 {
            font-size: 1.5rem;
        }

        .verification-wrapper {
            padding: 1rem;
        }
    }
</style>

<div class="verification-wrapper">
    <div class="verification-container">
        <div class="verification-header">
            <h1>Verify Your Email</h1>
            <p>Enter the 6-digit code we sent to your email</p>
        </div>

        <!-- Email Display -->
        <div class="email-display">
            <div class="email-icon">✉️</div>
            <div class="email-address">{{ $user->email ?? Auth::user()?->email }}</div>
        </div>

        <!-- Success Message -->
        @if ($message = session('success'))
            <div class="success-message">{{ $message }}</div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Info Box -->
        <div class="info-box">
            <p>
                <strong>⏰ Code expires in 10 minutes</strong><br>
                If the code has expired, click "Resend Code" below to get a new one.
            </p>
        </div>

        {{-- DEBUG MODE: Show verification code --}}
        @php
            $latestCode = isset($user) ? \App\Models\EmailVerification::where('user_id', $user->id)
                ->where('used', false)
                ->where('expires_at', '>', now())
                ->latest()
                ->first() : null;
        @endphp
        
        @if ($latestCode)
            <div style="background: #fff3cd; border: 3px solid #ffc107; padding: 1.5rem; border-radius: 0.8rem; margin-bottom: 1.5rem; text-align: center;">
                <p style="margin: 0; color: #856404; font-weight: 700; font-size: 1.1rem;">🔍 YOUR VERIFICATION CODE</p>
                <p style="margin: 1.5rem 0 0 0; color: #856404; font-size: 0.9rem;">Enter this code below:</p>
                <p style="margin: 1rem 0 0 0; color: #856404; font-size: 3rem; font-family: monospace; letter-spacing: 0.5em; font-weight: 900; line-height: 1;">{{ $latestCode->code }}</p>
                <p style="margin: 1rem 0 0 0; color: #b8860b; font-size: 0.85rem;">⏰ Expires: {{ $latestCode->expires_at->format('g:i A') }}</p>
            </div>
        @else
            @if (isset($user))
                <div style="background: #e8f5e9; border: 2px solid #28a745; padding: 1rem; border-radius: 0.8rem; margin-bottom: 1.5rem; text-align: center;">
                    <p style="margin: 0; color: #155724; font-size: 0.9rem;"><strong>📧 No code generated yet</strong><br>Click the <strong>"Resend Code"</strong> button below to get your verification code.</p>
                </div>
            @endif
        @endif

        <!-- Verification Form -->
        <form action="{{ route('verification.verify') }}" method="POST">
            @csrf

            <div class="code-input-group">
                <label for="code">Verification Code</label>
                <input 
                    type="text" 
                    id="code" 
                    name="code" 
                    class="code-input @error('code') is-invalid @enderror"
                    placeholder="000000"
                    maxlength="6"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    autocomplete="off"
                    autofocus
                    required>
            </div>

            <button type="submit" class="verify-btn">
                <i class="fas fa-check me-2"></i>Verify Email
            </button>
        </form>

        <!-- Resend Section -->
        <div class="resend-section">
            <p class="resend-text">Didn't receive the code?</p>
            <form action="{{ route('verification.send') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="resend-btn">
                    <i class="fas fa-redo me-2"></i>Resend Code
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Change Email - E-Benta')

@section('styles')
<style>
    .email-change-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }

    .email-change-card {
        background: linear-gradient(135deg, rgba(46, 204, 113, 0.08) 0%, rgba(46, 204, 113, 0.03) 100%);
        border: 2px solid rgba(46, 204, 113, 0.25);
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }

    .email-change-header {
        background: linear-gradient(135deg, var(--light-green) 0%, #16c784 100%);
        padding: 3rem 2rem;
        text-align: center;
        color: var(--dark-bg);
    }

    .email-change-header h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .email-change-header i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        display: block;
    }

    .email-change-header p {
        font-size: 0.95rem;
        margin: 0;
        opacity: 0.9;
    }

    .email-change-body {
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
        border: 2px solid rgba(46, 204, 113, 0.3) !important;
        color: var(--text-light) !important;
        padding: 0.85rem 1rem !important;
        border-radius: 0.7rem !important;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-group input::placeholder {
        color: rgba(198, 212, 208, 0.5) !important;
    }

    .form-group input:focus {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border-color: var(--light-green) !important;
        box-shadow: 0 0 0 0.3rem rgba(46, 204, 113, 0.2) !important;
    }

    .submit-btn {
        background: linear-gradient(135deg, var(--light-green) 0%, #16c784 100%);
        color: var(--dark-bg);
        border: none;
        padding: 1rem;
        font-weight: 700;
        font-size: 1.05rem;
        border-radius: 0.8rem;
        transition: all 0.35s ease;
        width: 100%;
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        cursor: pointer;
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #16c784 0%, var(--light-green) 100%);
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(46, 204, 113, 0.4);
        color: var(--dark-bg);
    }

    .divider {
        border: none;
        border-top: 2px solid rgba(46, 204, 113, 0.2);
        margin: 2rem 0;
    }

    .back-link {
        text-align: center;
        color: #c6d4d0;
        font-size: 0.95rem;
    }

    .back-link a {
        color: var(--light-green);
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s ease;
    }

    .back-link a:hover {
        color: #16c784;
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
        background-color: rgba(46, 204, 113, 0.1);
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
        background-color: rgba(52, 152, 219, 0.1);
        border-left: 4px solid #3498db;
        color: #c6d4d0;
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

    .current-email {
        background-color: rgba(255, 255, 255, 0.03);
        color: #c6d4d0;
        border: 1px solid rgba(46, 204, 113, 0.3);
        padding: 0.85rem 1rem;
        border-radius: 0.7rem;
    }

    .security-note {
        background-color: rgba(243, 156, 18, 0.1);
        border-left: 4px solid #f39c12;
        color: #c6d4d0;
        padding: 1rem;
        border-radius: 0.6rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .security-note i {
        color: #f39c12;
        margin-right: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="email-change-container">
    <div class="email-change-card">
        <div class="email-change-header">
            <i class="fas fa-envelope-open"></i>
            <h2>Change Email</h2>
            <p>Update your email address securely</p>
        </div>
        <div class="email-change-body">
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
                <span>For security reasons, we'll send a verification link to your new email. You must confirm the change to complete the process.</span>
            </div>

            <div class="security-note">
                <i class="fas fa-lock me-1"></i>
                <span>We'll require your current password to verify this is a legitimate change request.</span>
            </div>

            <form method="POST" action="{{ route('email.change.send') }}">
                @csrf

                <div class="form-group">
                    <label for="current_email">
                        <i class="fas fa-envelope me-2" style="color: var(--light-green);"></i>Current Email
                    </label>
                    <div class="current-email">{{ auth()->user()->email }}</div>
                </div>

                <div class="form-group">
                    <label for="new_email">
                        <i class="fas fa-envelope me-2" style="color: var(--light-green);"></i>New Email Address *
                    </label>
                    <input type="email" class="form-control @error('new_email') is-invalid @enderror" 
                         id="new_email" name="new_email" value="{{ old('new_email') }}" placeholder="newemail@example.com" required autofocus>
                    @error('new_email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-key me-2" style="color: var(--light-green);"></i>Confirm Your Password *
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                         id="password" name="password" placeholder="••••••••" required>
                    <small style="color: #c6d4d0; display: block; margin-top: 0.5rem;">Enter your current password to confirm this request</small>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane me-2"></i>Send Verification Link
                </button>
            </form>

            <hr class="divider">
            <p class="back-link">
                <i class="fas fa-arrow-left me-2"></i>
                <a href="{{ route('profile') }}">Back to profile</a>
            </p>
        </div>
    </div>
</div>
@endsection

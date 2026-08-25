@extends('layouts.app')

@section('title', 'Reset Password - E-Benta')

@section('styles')
<style>
    .reset-password-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }

    .reset-password-card {
        background: linear-gradient(135deg, rgba(46, 204, 113, 0.08) 0%, rgba(46, 204, 113, 0.03) 100%);
        border: 2px solid rgba(46, 204, 113, 0.25);
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }

    .reset-password-header {
        background: linear-gradient(135deg, var(--light-green) 0%, #16c784 100%);
        padding: 3rem 2rem;
        text-align: center;
        color: var(--dark-bg);
    }

    .reset-password-header h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .reset-password-header i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
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

    .password-requirements {
        background-color: rgba(46, 204, 113, 0.1);
        border-left: 4px solid var(--light-green);
        color: #c6d4d0;
        padding: 1rem;
        border-radius: 0.6rem;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
    }

    .password-requirements h5 {
        color: var(--light-green);
        font-weight: 600;
        margin-bottom: 0.5rem;
        margin-top: 0;
    }

    .password-requirements ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .password-requirements li {
        margin-bottom: 0.3rem;
    }
</style>
@endsection

@section('content')
<div class="reset-password-container">
    <div class="reset-password-card">
        <div class="reset-password-header">
            <i class="fas fa-key"></i>
            <h2>Reset Password</h2>
            <p>Create a new password for your account</p>
        </div>
        <div class="reset-password-body">
            @if ($errors->any())
                <div class="error-box">
                    <p><i class="fas fa-exclamation-circle me-2"></i>Error</p>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="info-text">
                <i class="fas fa-info-circle"></i>
                <span>Please enter a strong password for your account.</span>
            </div>

            <form method="POST" action="{{ route('password.reset.update') }}">
                @csrf

                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">

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

                <div class="form-group">
                    <label for="password_confirmation">
                        <i class="fas fa-lock-open me-2" style="color: var(--light-green);"></i>Confirm Password
                    </label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                         id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="password-requirements">
                    <h5><i class="fas fa-check-circle me-1"></i>Password Requirements</h5>
                    <ul>
                        <li>At least 8 characters long</li>
                        <li>At least one uppercase letter</li>
                        <li>At least one number</li>
                        <li>At least one special character</li>
                    </ul>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-check me-2"></i>Reset Password
                </button>
            </form>

            <hr class="divider">
            <p class="back-link">
                <i class="fas fa-arrow-left me-2"></i>
                <a href="{{ route('login') }}">Back to login</a>
            </p>
        </div>
    </div>
</div>
@endsection

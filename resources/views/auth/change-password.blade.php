@extends('layouts.app')

@section('title', 'Change Password - E-Benta')

@section('content')
@php
    $canSkipCurrentPassword = $canSkipCurrentPassword ?? false;
@endphp
<style>
    .cp-page {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(46, 204, 113, 0.05) 100%);
        min-height: 100vh;
        padding: 3rem 0;
    }

    .cp-hero {
        text-align: center;
        margin-bottom: 3rem;
    }

    .cp-hero-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        padding: 1rem;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        color: white;
        font-size: 2rem;
        width: 72px;
        height: 72px;
    }

    .cp-hero h1 {
        color: var(--text-dark);
        font-weight: 800;
        margin-bottom: 0.5rem;
        font-size: 2.2rem;
    }

    .cp-hero p {
        color: #64748b;
        margin: 0;
        font-size: 1rem;
    }

    .cp-form-card {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        padding: 3rem;
    }

    .cp-field-group {
        margin-bottom: 1.5rem;
    }

    .cp-label {
        display: block;
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .cp-input {
        width: 100%;
        background: white;
        border: 2px solid rgba(13, 148, 136, 0.2);
        border-radius: 0.8rem;
        padding: 0.875rem 1rem;
        color: var(--text-dark);
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .cp-input:focus {
        outline: none;
        border-color: var(--light-green);
        box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
        background: white;
    }

    .cp-requirements {
        background: rgba(13, 148, 136, 0.05);
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 0.8rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .cp-requirements h6 {
        color: var(--primary-green);
        margin-bottom: 1rem;
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .cp-requirements ul {
        margin: 0;
        padding-left: 0;
        list-style: none;
        color: #475569;
        font-size: 0.9rem;
    }

    .cp-requirements li {
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .cp-requirements li:last-child {
        margin-bottom: 0;
    }

    .cp-requirements li i {
        color: var(--light-green);
    }

    .cp-btn-primary {
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        color: white;
        border: none;
        border-radius: 0.8rem;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
    }

    .cp-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(13, 148, 136, 0.3);
        color: white;
    }

    .cp-btn-secondary {
        background: white;
        color: #64748b;
        border: 2px solid #e2e8f0;
        border-radius: 0.8rem;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .cp-btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
    }

    .cp-invalid-feedback {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block;
    }

    .cp-info-note {
        background: rgba(13, 148, 136, 0.08);
        border: 1px solid rgba(13, 148, 136, 0.2);
        border-radius: 0.8rem;
        padding: 1rem 1.1rem;
        color: #334155;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .cp-info-note i {
        color: var(--primary-green);
        margin-right: 0.45rem;
    }
</style>

<div class="cp-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <!-- Hero Section -->
                <div class="cp-hero">
                    <div class="cp-hero-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h1>Change Password</h1>
                    <p>
                        {{ $canSkipCurrentPassword
                            ? 'Set a local password for your Google-linked account'
                            : 'Update your password to keep your account secure' }}
                    </p>
                </div>

                <!-- Form Card -->
                <div class="cp-form-card">
                    @if ($canSkipCurrentPassword)
                        <div class="cp-info-note">
                            <i class="fas fa-info-circle"></i>
                            You signed in with Google. Set a local password if you also want to log in using email and password.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.change.update') }}">
                        @csrf

                        <!-- Current Password -->
                        @if (! $canSkipCurrentPassword)
                            <div class="cp-field-group">
                                <label for="current_password" class="cp-label">
                                    Current Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="cp-input @error('current_password') is-invalid @enderror" 
                                     id="current_password" name="current_password" required autofocus>
                                @error('current_password')
                                    <span class="cp-invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <!-- New Password -->
                        <div class="cp-field-group">
                            <label for="password" class="cp-label">
                                New Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" class="cp-input @error('password') is-invalid @enderror" 
                                 id="password" name="password" required @if ($canSkipCurrentPassword) autofocus @endif>
                            @error('password')
                                <span class="cp-invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="cp-field-group">
                            <label for="password_confirmation" class="cp-label">
                                Confirm New Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" class="cp-input @error('password_confirmation') is-invalid @enderror" 
                                 id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <span class="cp-invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Requirements -->
                        <div class="cp-requirements">
                            <h6><i class="fas fa-info-circle"></i> Password Requirements</h6>
                            <ul>
                                <li><i class="fas fa-check"></i> At least 8 characters long</li>
                                <li><i class="fas fa-check"></i> Mix of uppercase and lowercase letters</li>
                                <li><i class="fas fa-check"></i> At least one number</li>
                                <li><i class="fas fa-check"></i> At least one special character (!@#$%^&*)</li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="cp-btn-primary flex-grow-1">
                                <i class="fas fa-check me-2"></i>{{ $canSkipCurrentPassword ? 'Set Password' : 'Update Password' }}
                            </button>
                            <a href="{{ auth()->user()->isSeller() ? route('seller.dashboard') : route('buyer.dashboard') }}" class="cp-btn-secondary flex-grow-1">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Verify Email Change - E-Benta')

@section('styles')
<style>
    .verify-email-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }

    .verify-email-card {
        background: linear-gradient(135deg, rgba(46, 204, 113, 0.08) 0%, rgba(46, 204, 113, 0.03) 100%);
        border: 2px solid rgba(46, 204, 113, 0.25);
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }

    .verify-email-header {
        background: linear-gradient(135deg, var(--light-green) 0%, #16c784 100%);
        padding: 3rem 2rem;
        text-align: center;
        color: var(--dark-bg);
    }

    .verify-email-header h2 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .verify-email-header i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        display: block;
    }

    .verify-email-header p {
        font-size: 0.95rem;
        margin: 0;
        opacity: 0.9;
    }

    .verify-email-body {
        padding: 2.5rem;
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

    .info-box {
        background-color: rgba(52, 152, 219, 0.1);
        border-left: 4px solid #3498db;
        color: #c6d4d0;
        padding: 1.5rem;
        border-radius: 0.6rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .info-box i {
        color: #3498db;
        margin-right: 0.5rem;
    }

    .email-display {
        background-color: rgba(46, 204, 113, 0.1);
        border: 2px solid rgba(46, 204, 113, 0.3);
        color: var(--text-light);
        padding: 1.5rem;
        border-radius: 0.8rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .email-display .label {
        color: #c6d4d0;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .email-display .email {
        color: var(--light-green);
        font-size: 1.2rem;
        font-weight: 700;
    }

    .success-icon {
        font-size: 3rem;
        color: var(--light-green);
        margin-bottom: 1rem;
        display: block;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="verify-email-container">
    <div class="verify-email-card">
        <div class="verify-email-header">
            <i class="fas fa-check-circle"></i>
            <h2>Verify Email Change</h2>
            <p>Complete your email change request</p>
        </div>
        <div class="verify-email-body">
            @if ($errors->any())
                <div class="error-box">
                    <p><i class="fas fa-exclamation-circle me-2"></i>Error</p>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <span>You're about to change your email address. Please review the new email below and confirm the change.</span>
            </div>

            <div class="email-display">
                <span class="label">New Email Address</span>
                <span class="email">{{ $new_email }}</span>
            </div>

            <form method="POST" action="{{ route('email.change.confirm') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <button type="submit" class="submit-btn">
                    <i class="fas fa-check me-2"></i>Confirm Email Change
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

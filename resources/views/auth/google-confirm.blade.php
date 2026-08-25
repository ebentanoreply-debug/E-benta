@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #0d9488;
        --primary-dark: #0f766e;
        --secondary: #06b6d4;
        --light-bg: #f0fdf4;
        --blue-bg: #f0f9ff;
        --purple-bg: #f5f3ff;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body, html {
        width: 100%;
        height: 100%;
    }

    .google-confirm-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(135deg, var(--light-bg) 0%, var(--blue-bg) 50%, var(--purple-bg) 100%);
        padding: 2rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .google-confirm-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .google-confirm-wrapper::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .google-confirm-container {
        background: white;
        border-radius: 2.5rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1), 0 0 50px rgba(13, 148, 136, 0.05);
        padding: 3.5rem 2.5rem;
        max-width: 450px;
        width: 100%;
        text-align: center;
        animation: slideUpIn 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        z-index: 1;
    }

    @keyframes slideUpIn {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .google-confirm-header {
        margin-bottom: 2.5rem;
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s both;
    }

    .google-confirm-header h1 {
        color: #0f172a;
        font-size: 2rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .google-confirm-header p {
        color: #64748b;
        font-size: 1rem;
        font-weight: 500;
        margin: 0;
        letter-spacing: -0.3px;
    }

    .google-profile-card {
        margin: 3rem 0;
        padding: 2rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 50%, #f0f9ff 100%);
        border-radius: 1.8rem;
        border: 2px solid rgba(13, 148, 136, 0.08);
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
        transition: all 0.3s ease;
        position: relative;
    }

    .google-profile-card::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--primary), transparent);
    }

    .google-profile-avatar {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(13, 148, 136, 0.25);
        border: 4px solid white;
        animation: fadeInScale 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .google-profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .google-profile-name {
        color: #0f172a;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 1.5rem 0 0.75rem 0;
        letter-spacing: -0.5px;
    }

    .google-profile-email {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
        font-weight: 500;
    }

    .google-verify-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        padding: 0.6rem 1.2rem;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.1), rgba(6, 182, 212, 0.1));
        border-radius: 2rem;
        font-size: 0.8rem;
        color: var(--primary);
        font-weight: 700;
        border: 1px solid rgba(13, 148, 136, 0.2);
    }

    .google-verify-badge i {
        color: var(--secondary);
    }

    .google-continue-btn {
        width: 100%;
        padding: 1.3rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border: none;
        border-radius: 1.2rem;
        font-weight: 800;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 10px 30px rgba(13, 148, 136, 0.3);
        margin-bottom: 1rem;
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s both;
        position: relative;
        overflow: hidden;
        letter-spacing: -0.3px;
    }

    .google-continue-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transform: skewX(-20deg);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        100% {
            left: 100%;
        }
    }

    .google-continue-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(13, 148, 136, 0.4);
    }

    .google-continue-btn:active {
        transform: translateY(-1px);
    }

    .google-back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 600;
        transition: all 0.3s ease;
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.5s both;
    }

    .google-back-link:hover {
        color: var(--primary);
        transform: translateX(-4px);
    }

    .google-back-link i {
        transition: transform 0.3s ease;
    }

    .google-back-link:hover i {
        transform: translateX(-2px);
    }

    .google-security-section {
        margin-top: 2.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.05) 0%, rgba(6, 182, 212, 0.05) 100%);
        border: 1.5px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.2rem;
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.6s both;
    }

    .google-security-section p {
        color: #15803d;
        font-size: 0.85rem;
        margin: 0;
        line-height: 1.6;
        font-weight: 500;
    }

    .google-security-section i {
        color: var(--primary);
        margin-right: 0.5rem;
    }

    .google-feature-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 2rem;
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.7s both;
    }

    .google-feature-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.85rem;
        color: #475569;
    }

    .google-feature-item i {
        color: var(--secondary);
        font-size: 1rem;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .google-confirm-container {
            padding: 2.5rem 1.5rem;
            border-radius: 2rem;
        }

        .google-confirm-header h1 {
            font-size: 1.5rem;
        }

        .google-profile-avatar {
            width: 90px;
            height: 90px;
        }

        .google-profile-name {
            font-size: 1.3rem;
        }

        .google-continue-btn {
            padding: 1.1rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .google-confirm-wrapper {
            padding: 1rem;
        }

        .google-confirm-container {
            padding: 2rem 1rem;
        }

        .google-confirm-header h1 {
            font-size: 1.3rem;
        }

        .google-profile-card {
            padding: 1.5rem;
        }

        .google-feature-list {
            display: none;
        }
    }
</style>

<div class="google-confirm-wrapper">
    <div class="google-confirm-container">
        <!-- Header -->
        <div class="google-confirm-header">
            <h1>Welcome! 👋</h1>
            <p>Confirm your Google account to continue</p>
        </div>

        <!-- Profile Card -->
        <div class="google-profile-card">
            <div class="google-profile-avatar">
                @if ($user['avatar'])
                    <img src="{{ $user['avatar'] }}" alt="{{ $user['name'] }}" loading="lazy">
                @else
                    <i class="fas fa-user" style="font-size: 2.5rem; color: white;"></i>
                @endif
            </div>

            <div class="google-profile-name">{{ $user['name'] }}</div>
            <p class="google-profile-email">{{ $user['email'] }}</p>

            <div class="google-verify-badge">
                <i class="fas fa-check-circle"></i>
                <span>Verified by Google</span>
            </div>
        </div>

        <!-- Continue Form -->
        <form action="{{ route('auth.google.confirm.post') }}" method="POST">
            @csrf
            <button type="submit" class="google-continue-btn">
                <i class="fas fa-arrow-right me-2"></i>
                Continue as {{ explode(' ', $user['name'])[0] }}
            </button>
        </form>

        <!-- Back Link -->
        <a href="/login" class="google-back-link">
            <i class="fas fa-chevron-left"></i>
            <span>Back to login</span>
        </a>

        <!-- Security Info -->
        <div class="google-security-section">
            <p>
                <i class="fas fa-shield-alt"></i>
                <strong>100% Secure</strong> • Your email is verified by Google
            </p>
        </div>

        <!-- Features List -->
        <div class="google-feature-list">
            <div class="google-feature-item">
                <i class="fas fa-leaf"></i>
                <span>Join a sustainable marketplace</span>
            </div>
            <div class="google-feature-item">
                <i class="fas fa-lock"></i>
                <span>Industry-leading security</span>
            </div>
            <div class="google-feature-item">
                <i class="fas fa-zap"></i>
                <span>Get started in seconds</span>
            </div>
        </div>
    </div>
</div>
@endsection

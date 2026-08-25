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

    .role-selection-wrapper {
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

    .role-selection-wrapper::before {
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

    .role-selection-wrapper::after {
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

    .role-selection-container {
        background: white;
        border-radius: 2.5rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1), 0 0 50px rgba(13, 148, 136, 0.05);
        padding: 3.5rem 2.5rem;
        max-width: 700px;
        width: 100%;
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

    .role-header {
        text-align: center;
        margin-bottom: 2.5rem;
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s both;
    }

    .role-header h1 {
        color: #0f172a;
        font-size: 2rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    .role-header p {
        color: #64748b;
        font-size: 1rem;
        font-weight: 500;
        margin: 0;
        letter-spacing: -0.3px;
    }

    .user-profile-card {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 50%, #f0f9ff 100%);
        border-radius: 1.5rem;
        border: 2px solid rgba(13, 148, 136, 0.08);
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
    }

    .user-avatar-wrapper {
        flex-shrink: 0;
        animation: fadeInScale 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
    }

    .user-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.2);
    }

    .user-avatar-emoji {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.2);
        border: 4px solid white;
    }

    .user-info {
        flex: 1;
    }

    .user-email {
        color: #0f172a;
        font-weight: 800;
        font-size: 1rem;
        margin-bottom: 0.25rem;
        letter-spacing: -0.3px;
    }

    .user-name {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .role-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
    }

    .role-card {
        position: relative;
        border: 2.5px solid #e2e8f0;
        border-radius: 1.5rem;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        background: white;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow: hidden;
    }

    .role-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        opacity: 0;
        transition: opacity 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 1;
        border-radius: 1.5rem;
    }

    .role-card:hover {
        border-color: var(--primary);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.2);
        transform: translateY(-6px);
    }

    .role-card input[type="radio"] {
        display: none;
    }

    .role-card input[type="radio"]:checked {
        opacity: 1 !important;
    }

    .role-card input[type="radio"]:checked::before {
        opacity: 1;
    }

    .role-card:has(input[type="radio"]:checked) {
        border-color: white;
        box-shadow: 0 0 0 3px var(--primary), 0 12px 30px rgba(13, 148, 136, 0.3);
    }

    .role-card input[type="radio"]:checked ~ .role-content {
        color: white;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .role-card input[type="radio"]:checked + .role-bg {
        opacity: 1;
    }

    .role-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        opacity: 0;
        border-radius: 1.5rem;
        transition: opacity 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 0;
    }

    .role-content {
        position: relative;
        z-index: 3;
        color: #0f172a;
        transition: all 0.3s ease;
    }

    .role-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
        transition: transform 0.3s ease;
    }

    .role-card:hover .role-icon {
        transform: scale(1.1);
    }

    .role-card input[type="radio"]:checked ~ .role-content .role-icon {
        animation: bounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .role-title {
        font-size: 1.3rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        display: block;
        letter-spacing: -0.3px;
    }

    .role-description {
        font-size: 0.9rem;
        color: #64748b;
        display: block;
        transition: color 0.3s ease;
        line-height: 1.5;
    }

    .role-card input[type="radio"]:checked ~ .role-content .role-description {
        color: rgba(255, 255, 255, 0.95);
    }

    .role-badge {
        display: inline-block;
        margin-top: 0.75rem;
        padding: 0.5rem 1rem;
        background: rgba(13, 148, 136, 0.1);
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--primary);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .role-card:hover .role-badge {
        background: rgba(13, 148, 136, 0.15);
        transform: scale(1.05);
    }

    .role-card input[type="radio"]:checked ~ .role-content .role-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .form-group {
        margin-bottom: 2rem;
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s both;
    }

    .form-check {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 2rem;
        padding: 1.25rem;
        background: #f8fafc;
        border-radius: 1.2rem;
        border: 1.5px solid #e2e8f0;
        transition: all 0.3s ease;
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.5s both;
    }

    .form-check:hover {
        border-color: var(--primary);
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.02) 0%, rgba(6, 182, 212, 0.02) 100%);
    }

    .form-check input[type="checkbox"] {
        width: 20px;
        height: 20px;
        min-width: 20px;
        margin-top: 0.25rem;
        cursor: pointer;
        accent-color: var(--primary);
        border-radius: 0.4rem;
    }

    .form-check label {
        cursor: pointer;
        color: #475569;
        font-size: 0.95rem;
        margin: 0;
        font-weight: 500;
        line-height: 1.5;
    }

    .form-check a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .form-check a:hover {
        color: var(--secondary);
        text-decoration: underline;
    }

    .error-message {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
        border: 1.5px solid #fca5a5;
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 2rem;
        color: #991b1b;
        font-size: 0.9rem;
        text-align: center;
        font-weight: 600;
        animation: slideUpIn 0.4s ease-out;
    }

    .complete-btn {
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
        animation: slideUpIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.6s both;
        position: relative;
        overflow: hidden;
        letter-spacing: -0.3px;
    }

    .complete-btn::before {
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

    .complete-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(13, 148, 136, 0.4);
    }

    .complete-btn:active {
        transform: translateY(-1px);
    }

    .complete-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    @media (max-width: 768px) {
        .role-selection-container {
            padding: 2.5rem 1.5rem;
            border-radius: 2rem;
        }

        .role-header h1 {
            font-size: 1.6rem;
        }

        .role-options {
            grid-template-columns: 1fr;
        }

        .user-profile-card {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .role-card {
            padding: 1.5rem 1rem;
        }

        .role-icon {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 480px) {
        .role-selection-wrapper {
            padding: 1rem;
        }

        .role-selection-container {
            padding: 2rem 1rem;
        }

        .role-header h1 {
            font-size: 1.3rem;
        }

        .role-header p {
            font-size: 0.9rem;
        }

        .user-profile-card {
            padding: 1rem;
        }

        .role-card {
            padding: 1.25rem 1rem;
        }
    }
</style>

<div class="role-selection-wrapper">
    <div class="role-selection-container">
        @if ($errors->any())
            <div class="error-message">
                @if ($errors->has('role'))
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first('role') }}
                @elseif ($errors->has('agree_terms'))
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first('agree_terms') }}
                @else
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}@unless($loop->last)<br>@endunless
                    @endforeach
                @endif
            </div>
        @endif

        <!-- Header -->
        <div class="role-header">
            <h1>Choose Your Role 🎯</h1>
            <p>Select how you want to use E-Benta</p>
        </div>

        <!-- User Profile Card -->
        <div class="user-profile-card">
            <div class="user-avatar-wrapper">
                @if (session('google_user.avatar'))
                    <img src="{{ session('google_user.avatar') }}" alt="Profile" class="user-avatar" loading="lazy">
                @else
                    <div class="user-avatar-emoji">👤</div>
                @endif
            </div>
            <div class="user-info">
                <div class="user-email">{{ session('google_user.email') }}</div>
                <div class="user-name">{{ session('google_user.name') }}</div>
            </div>
        </div>

        <!-- Role Selection Form -->
        <form action="{{ route('auth.google.complete-registration') }}" method="POST">
            @csrf

            <div class="form-group">
                <div class="role-options">
                    <!-- Seller Option -->
                    <label class="role-card">
                        <input type="radio" name="role" value="seller" required>
                        <div class="role-bg"></div>
                        <div class="role-content">
                            <span class="role-icon">🏪</span>
                            <span class="role-title">Seller</span>
                            <span class="role-description">Sell your e-waste or refurbished items</span>
                            <span class="role-badge">✓ Create Listings</span>
                        </div>
                    </label>

                    <!-- Buyer Option -->
                    <label class="role-card">
                        <input type="radio" name="role" value="buyer" required>
                        <div class="role-bg"></div>
                        <div class="role-content">
                            <span class="role-icon">🛍️</span>
                            <span class="role-title">Buyer</span>
                            <span class="role-description">Browse and purchase e-waste or refurbished items</span>
                            <span class="role-badge">✓ Browse Items</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="form-check">
                <input type="checkbox" id="terms" name="agree_terms" value="1" required>
                <label for="terms">
                    I agree to the <a href="/terms" target="_blank">Terms of Service</a> and <a href="/privacy" target="_blank">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="complete-btn">
                <i class="fas fa-check-circle me-2"></i>Complete Registration
            </button>
        </form>
    </div>
</div>
@endsection

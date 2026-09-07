@extends('layouts.app')

@section('title', 'Login - E-Benta')

@section('styles')
<style>
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
        background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 50%, #f0f9ff 100%);
        position: relative;
        overflow: hidden;
    }

    .login-container::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .login-container::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .login-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        max-width: 1000px;
        width: 100%;
        background: white;
        border-radius: 2rem;
        overflow: hidden;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 2;
    }

    .login-benefits {
        background: linear-gradient(135deg, #0f172e 0%, #1a2d4f 100%);
        padding: 4rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .login-benefits::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.2) 0%, transparent 70%);
        border-radius: 50%;
    }

    .login-benefits::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .login-benefits h3 {
        font-size: 2rem;
        font-weight: 900;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: slideInLeft 0.8s ease-out;
        position: relative;
        z-index: 2;
    }

    .benefit-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        animation: slideInLeft 0.8s ease-out;
        position: relative;
        z-index: 2;
    }

    .benefit-item i {
        font-size: 1.8rem;
        color: #06b6d4;
        flex-shrink: 0;
        animation: float 4s ease-in-out infinite;
    }

    .benefit-item p {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.6;
        color: #cbd5e1;
    }

    .benefit-item strong {
        color: #ffffff;
        display: block;
        margin-bottom: 0.3rem;
    }

    .login-form-wrapper {
        padding: 4rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        animation: slideInRight 0.8s ease-out;
    }

    .login-header {
        margin-bottom: 2rem;
    }

    .login-header h2 {
        font-size: 1.8rem;
        font-weight: 900;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .login-header p {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 0.6rem;
        display: block;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group input {
        background-color: #f8fafc !important;
        border: 2px solid #e2e8f0 !important;
        color: #1e293b !important;
        padding: 0.95rem 1rem !important;
        border-radius: 0.8rem !important;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input::placeholder {
        color: rgba(100, 116, 139, 0.6) !important;
    }

    .form-group input:focus {
        background-color: #ffffff !important;
        border-color: var(--light-green) !important;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1) !important;
    }

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .remember-me input[type="checkbox"] {
        cursor: pointer;
        accent-color: var(--light-green);
        width: 18px;
        height: 18px;
    }

    .remember-me label {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0;
        cursor: pointer;
    }

    .remember-forgot a {
        color: var(--light-green);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .remember-forgot a:hover {
        color: #06b6d4;
    }

    .login-btn {
        background: linear-gradient(135deg, var(--light-green) 0%, #06b6d4 100%);
        color: white;
        border: none;
        padding: 1.1rem;
        font-weight: 800;
        font-size: 1rem;
        border-radius: 0.9rem;
        transition: all 0.35s ease;
        width: 100%;
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.25);
        cursor: pointer;
    }

    .login-btn:hover {
        background: linear-gradient(135deg, #06b6d4 0%, var(--light-green) 100%);
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.35);
    }

    .login-btn:active {
        transform: translateY(0);
    }

    .divider {
        border: none;
        border-top: 2px solid #e2e8f0;
        margin: 2rem 0;
    }

    .register-link {
        text-align: center;
        color: #64748b;
        font-size: 0.95rem;
    }

    .register-link a {
        color: var(--light-green);
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s ease;
    }

    .register-link a:hover {
        color: #06b6d4;
    }

    .error-message {
        color: #e74c3c;
        font-size: 0.8rem;
        margin-top: 0.5rem;
        font-weight: 600;
    }

    .error-box {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.1) 0%, rgba(231, 76, 60, 0.05) 100%);
        border: 2px solid rgba(231, 76, 60, 0.3);
        border-radius: 1rem;
        padding: 1.1rem 1.25rem;
        margin-bottom: 1.5rem;
        animation: slideInLeft 0.4s ease-out;
    }

    .error-box p {
        color: #e74c3c;
        margin: 0.4rem 0 0;
        font-size: 0.85rem;
    }

    .error-box p:first-child {
        margin: 0;
        font-weight: 700;
    }

    .info-box {
        background: rgba(6, 182, 212, 0.1);
        border: 1.5px solid rgba(6, 182, 212, 0.35);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        color: #0891b2;
        font-size: 0.88rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideInLeft 0.4s ease-out;
    }

    .success-box {
        background: rgba(16, 185, 129, 0.1);
        border: 1.5px solid rgba(16, 185, 129, 0.35);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        color: #059669;
        font-size: 0.88rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideInLeft 0.4s ease-out;
    }

    .password-wrapper {
        position: relative;
    }

    .password-wrapper input {
        padding-right: 2.85rem !important;
    }

    .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #94a3b8;
        padding: 6px 8px;
        cursor: pointer;
        font-size: 1.05rem;
        transition: color 0.2s ease;
        z-index: 5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .password-toggle-btn:hover {
        color: var(--light-green);
    }

    .security-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 1.5rem;
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .security-badge i {
        color: var(--light-green);
    }

    .oauth-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 2rem 0 1.5rem 0;
        font-size: 0.85rem;
        color: #64748b;
    }

    .oauth-divider::before,
    .oauth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .oauth-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        padding: 1rem;
        border: 2px solid #e2e8f0;
        background: white;
        border-radius: 0.9rem;
        font-weight: 700;
        color: #1e293b;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 0.75rem;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .oauth-btn:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        transform: translateY(-2px);
    }

    .oauth-btn i {
        font-size: 1.2rem;
    }

    .oauth-google:hover {
        border-color: #4285f4;
        background: rgba(66, 133, 244, 0.05);
    }

    .oauth-google i {
        color: #4285f4;
    }

    .oauth-hint {
        margin: 0;
        color: #64748b;
        font-size: 0.82rem;
        text-align: center;
    }

    /* Dark Mode Theme Support */
    body.dark-mode .login-container {
        background: radial-gradient(circle at 50% 20%, #0d1e2b 0%, #060d13 100%) !important;
    }

    body.dark-mode .login-wrapper {
        background: #0d1b2a !important;
        border: 1px solid rgba(13, 148, 136, 0.25);
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.6);
    }

    body.dark-mode .login-header h2 {
        color: #ffffff !important;
    }

    body.dark-mode .login-header p {
        color: #94a3b8 !important;
    }

    body.dark-mode .form-group label {
        color: #cbd5e1 !important;
    }

    body.dark-mode .form-group input {
        background-color: #0b1522 !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
    }

    body.dark-mode .form-group input::placeholder {
        color: rgba(148, 163, 184, 0.6) !important;
    }

    body.dark-mode .form-group input:focus {
        background-color: #0d1b2a !important;
        border-color: #2dd4bf !important;
        box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.15) !important;
        color: #ffffff !important;
    }

    body.dark-mode .password-toggle-btn {
        color: #94a3b8;
    }

    body.dark-mode .password-toggle-btn:hover {
        color: #2dd4bf;
    }

    body.dark-mode .remember-me label {
        color: #94a3b8 !important;
    }

    body.dark-mode .oauth-btn {
        background: #0b1522 !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        color: #e2e8f0 !important;
    }

    body.dark-mode .oauth-btn:hover {
        background: #112235 !important;
        border-color: rgba(13, 148, 136, 0.4) !important;
        color: #ffffff !important;
    }

    body.dark-mode .oauth-divider {
        color: #64748b !important;
    }

    body.dark-mode .oauth-divider::before,
    body.dark-mode .oauth-divider::after {
        background: rgba(255, 255, 255, 0.08) !important;
    }

    body.dark-mode .divider {
        border-top-color: rgba(255, 255, 255, 0.08) !important;
    }

    body.dark-mode .security-badge {
        color: #64748b !important;
    }

    body.dark-mode .register-link {
        color: #94a3b8 !important;
    }

    body.dark-mode .info-box {
        background: rgba(6, 182, 212, 0.15);
        border-color: rgba(6, 182, 212, 0.4);
        color: #38bdf8;
    }

    body.dark-mode .success-box {
        background: rgba(16, 185, 129, 0.15);
        border-color: rgba(16, 185, 129, 0.4);
        color: #34d399;
    }

    @media (max-width: 768px) {
        .login-container {
            padding: 2rem 1rem calc(95px + env(safe-area-inset-bottom, 0px)) !important;
            min-height: auto;
        }

        .login-wrapper {
            grid-template-columns: 1fr;
            border-radius: 1.5rem;
        }

        .login-benefits {
            display: none;
        }

        .login-form-wrapper {
            padding: 2.25rem 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .login-container {
            padding: 1.5rem 0.75rem calc(95px + env(safe-area-inset-bottom, 0px)) !important;
        }

        .login-form-wrapper {
            padding: 1.75rem 1.15rem;
            border-radius: 1.25rem;
        }

        .login-header h2 {
            font-size: 1.5rem;
        }

        .login-header p {
            font-size: 0.88rem;
        }

        .form-check {
            font-size: 0.85rem;
        }

        .forgot-link {
            font-size: 0.85rem;
        }
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-wrapper">
        <!-- Left Side - Benefits -->
        <div class="login-benefits">
            <h3>Welcome Back to E-Benta</h3>
            
            <div class="benefit-item">
                <i class="fas fa-leaf"></i>
                <div>
                    <strong>Make an Impact</strong>
                    <p>Turn your e-waste into value while protecting the environment</p>
                </div>
            </div>

            <div class="benefit-item">
                <i class="fas fa-lock"></i>
                <div>
                    <strong>100% Secure</strong>
                    <p>Your data is encrypted and protected with industry-leading security</p>
                </div>
            </div>

            <div class="benefit-item">
                <i class="fas fa-handshake"></i>
                <div>
                    <strong>Trusted Community</strong>
                    <p>Join 18,000+ verified users making the circular economy work</p>
                </div>
            </div>

            <div class="benefit-item">
                <i class="fas fa-zap"></i>
                <div>
                    <strong>Quick & Easy</strong>
                    <p>Access your listings and track your impact in seconds</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-form-wrapper">
            <div class="login-header">
                <h2>Login to Your Account</h2>
                <p>Access your E-Benta dashboard</p>
            </div>

            @if (session('info'))
                <div class="info-box">
                    <i class="fas fa-info-circle fa-lg"></i>
                    <div>{{ session('info') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="error-box">
                    <p><i class="fas fa-exclamation-triangle me-2"></i>Authentication Notice</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if (session('status'))
                <div class="info-box">
                    <i class="fas fa-bell fa-lg"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if (session('success'))
                <div class="success-box">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="error-box">
                    <p><i class="fas fa-exclamation-circle me-2"></i>Login Failed</p>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope me-2" style="color: var(--light-green);"></i>Email Address
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                         id="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" 
                         autocomplete="username" required autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-key me-2" style="color: var(--light-green);"></i>Password
                    </label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                             id="password" name="password" placeholder="••••••••" 
                             autocomplete="current-password" required>
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility" title="Show/Hide password">
                            <i class="fas fa-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember" value="on" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="{{ route('password.forgot') }}">
                        <i class="fas fa-question-circle me-1"></i>Forgot password?
                    </a>
                </div>

                <button type="submit" id="loginSubmitBtn" class="login-btn">
                    <i class="fas fa-sign-in-alt me-2"></i>Login to Your Account
                </button>
            </form>

            <div class="security-badge">
                <i class="fas fa-shield-alt"></i>
                <span>Secure Login • SSL Encrypted</span>
            </div>

            <div class="oauth-divider">
                <span>Or continue with</span>
            </div>

            <a href="{{ route('auth.google.redirect') }}" class="oauth-btn oauth-google">
                <i class="fab fa-google"></i>
                <span>Sign in with Google</span>
            </a>
            <p class="oauth-hint">Registered with Google before? Use this button to sign in.</p>

            <hr class="divider">
            <p class="register-link">
                <i class="fas fa-user-plus me-1"></i>Don't have an account?
                <a href="{{ route('register') }}">Create one free</a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passInput = document.getElementById('password');
        const icon = document.getElementById('passwordToggleIcon');
        if (!passInput || !icon) return;

        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('loginSubmitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                // Prevent duplicate form submissions while processing
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing in...';
                submitBtn.style.opacity = '0.75';
            });
        }
    });
</script>
@endsection

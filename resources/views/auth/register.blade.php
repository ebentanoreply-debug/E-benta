@extends('layouts.app')

@section('title', 'Register - E-Benta')

@section('styles')
<style>
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .register-container {
        min-height: 100vh;
        padding: 60px 0;
        background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 50%, #f0f9ff 100%);
        position: relative;
        overflow: hidden;
    }

    .register-container::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -5%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .register-container::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.07) 0%, transparent 70%);
        border-radius: 50%;
    }

    .register-card {
        background: white;
        border-radius: 2rem;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.12);
        overflow: hidden;
        animation: fadeIn 0.6s ease-out;
        position: relative;
        z-index: 2;
    }

    .register-header {
        background: linear-gradient(135deg, #0f172e 0%, #1a2d4f 100%);
        padding: 3.5rem 2.5rem;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .register-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .register-header h2 {
        font-size: 2.2rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        z-index: 2;
    }

    .register-header i {
        font-size: 2.8rem;
        margin-bottom: 1rem;
        display: block;
        color: #06b6d4;
        animation: float 4s ease-in-out infinite;
        position: relative;
        z-index: 2;
    }

    .register-header p {
        font-size: 0.95rem;
        margin: 0;
        color: #cbd5e1;
        position: relative;
        z-index: 2;
    }

    .register-body {
        padding: 3rem 2.5rem;
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2.5rem;
        position: relative;
    }

    .step-indicator::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            #0d9488 0%, 
            #0d9488 var(--step-progress, 0%), 
            #e2e8f0 var(--step-progress, 0%), 
            #e2e8f0 100%);
        z-index: 1;
        transition: background 0.3s ease;
    }

    .step-indicator-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .step-indicator-number {
        width: 45px;
        height: 45px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #64748b;
        font-size: 0.9rem;
    }

    .step-indicator-number.active {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: white;
    }

    .step-indicator-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
        width: 60px;
    }

    .form-group {
        margin-bottom: 1.5rem;
        animation: slideInUp 0.6s ease-out;
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

    .form-group input,
    .form-group select {
        background-color: #f8fafc !important;
        border: 2px solid #e2e8f0 !important;
        color: #1e293b !important;
        padding: 0.95rem 1rem !important;
        border-radius: 0.8rem !important;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input::placeholder,
    .form-group select option {
        color: rgba(100, 116, 139, 0.6) !important;
    }

    .form-group input:focus,
    .form-group select:focus {
        background-color: #ffffff !important;
        border-color: var(--light-green) !important;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1) !important;
    }

    .two-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .conditional-fields {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.05) 100%);
        border: 2px solid rgba(13, 148, 136, 0.2);
        border-radius: 1.2rem;
        padding: 1.8rem;
        margin-top: 1.5rem;
        animation: slideInUp 0.4s ease-out;
    }

    .conditional-fields h6 {
        color: #1e293b;
        font-weight: 800;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .terms-check {
        display: flex;
        align-items: flex-start;
        margin-bottom: 2rem;
        gap: 1rem;
        animation: slideInUp 0.6s ease-out;
    }

    .terms-check input[type="checkbox"] {
        margin-top: 0.5rem;
        cursor: pointer;
        accent-color: var(--light-green);
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }

    .terms-check label {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0;
        font-weight: 500;
        cursor: pointer;
        line-height: 1.5;
    }

    .terms-check a {
        color: var(--light-green);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .terms-check a:hover {
        color: #06b6d4;
        text-decoration: underline;
    }

    .register-btn {
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
        animation: slideInUp 0.6s ease-out;
    }

    .register-btn:hover {
        background: linear-gradient(135deg, #06b6d4 0%, var(--light-green) 100%);
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.35);
    }

    .register-btn:active {
        transform: translateY(0);
    }

    .divider {
        border: none;
        border-top: 2px solid #e2e8f0;
        margin: 2rem 0;
    }

    .login-link {
        text-align: center;
        color: #64748b;
        font-size: 0.95rem;
    }

    .login-link a {
        color: var(--light-green);
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s ease;
    }

    .login-link a:hover {
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
        padding: 1.2rem;
        margin-bottom: 1.5rem;
        animation: slideInUp 0.4s ease-out;
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

    .security-info {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.05) 100%);
        border: 2px solid rgba(13, 148, 136, 0.2);
        border-radius: 1rem;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: #1e293b;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        animation: slideInUp 0.6s ease-out;
    }

    .security-info i {
        color: var(--light-green);
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .oauth-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 2rem 0 1.5rem 0;
        font-size: 0.85rem;
        color: #64748b;
        animation: slideInUp 0.6s ease-out;
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
        margin-bottom: 1rem;
        cursor: pointer;
        font-size: 0.95rem;
        animation: slideInUp 0.6s ease-out;
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

    @media (max-width: 768px) {
        .two-column {
            grid-template-columns: 1fr;
        }

        .step-indicator {
            gap: 0.5rem;
        }

        .step-indicator::before {
            display: none;
        }

        .step-indicator-item {
            flex-direction: row;
            gap: 0.5rem;
        }

        .register-body {
            padding: 2rem 1.5rem;
        }
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease-out;
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 1.5rem;
        box-shadow: 0 25px 100px rgba(0, 0, 0, 0.35), 0 0 60px rgba(13, 148, 136, 0.12);
        width: 90%;
        max-width: 600px;
        max-height: 80vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        padding: 0;
        animation: slideInUp 0.3s ease-out;
        position: relative;
        border: 1px solid rgba(13, 148, 136, 0.1);
    }

    /* Custom scrollbar for modal */
    .modal-content::-webkit-scrollbar {
        width: 8px;
    }

    .modal-content::-webkit-scrollbar-track {
        background: transparent;
    }

    .modal-content::-webkit-scrollbar-thumb {
        background: rgba(13, 148, 136, 0.3);
        border-radius: 4px;
        transition: background 0.2s ease;
    }

    .modal-content::-webkit-scrollbar-thumb:hover {
        background: rgba(13, 148, 136, 0.5);
    }

    .modal-header {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        padding: 2.2rem 2.5rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-height: 75px;
        position: relative;
        box-shadow: 0 2px 8px rgba(13, 148, 136, 0.15);
        flex-shrink: 0;
        z-index: 10;
    }

    .modal-body {
        padding: 2.5rem;
        color: #1e293b;
        line-height: 1.8;
        font-size: 0.95rem;
        overflow-y: auto;
        flex: 1;
    }

    /* Custom scrollbar for modal body */
    .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: rgba(13, 148, 136, 0.3);
        border-radius: 4px;
        transition: background 0.2s ease;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: rgba(13, 148, 136, 0.5);
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .modal-close {
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        line-height: 1;
        padding: 0;
        flex-shrink: 0;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    .modal-close:focus {
        outline: 2px solid rgba(255, 255, 255, 0.6);
        outline-offset: 2px;
    }

    .modal-body h3 {
        color: #0d9488;
        font-weight: 800;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-size: 1.25rem;
        letter-spacing: -0.3px;
    }

    .modal-body h3:first-child {
        margin-top: 0;
    }

    .modal-body p {
        margin-bottom: 1.2rem;
        color: #64748b;
        line-height: 1.7;
    }

    .modal-body ul {
        margin-left: 1.5rem;
        margin-bottom: 1.2rem;
        color: #64748b;
    }

    .modal-body li {
        margin-bottom: 0.6rem;
        color: #64748b;
    }

    @media (max-width: 600px) {
        .modal-content {
            width: 95%;
            max-height: 90vh;
            max-width: 100%;
        }

        .modal-header {
            padding: 1.8rem 1.5rem;
            min-height: 65px;
        }

        .modal-header h2 {
            font-size: 1.4rem;
        }

        .modal-close {
            width: 36px;
            height: 36px;
            font-size: 1.8rem;
        }

        .modal-body {
            padding: 1.8rem;
        }

        .modal-body h3 {
            font-size: 1.1rem;
            margin-top: 1.5rem;
        }
    }

</style>
@endsection

@section('content')
<div class="register-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-user-plus"></i>
                        <h2>Join E-Benta Today</h2>
                        <p>Create your account to start making a positive environmental impact</p>
                    </div>
                    <div class="register-body">
                        <!-- Step Indicator -->
                        <div class="step-indicator">
                            <div class="step-indicator-item">
                                <div class="step-indicator-number active">1</div>
                                <div class="step-indicator-label">Account</div>
                            </div>
                            <div class="step-indicator-item">
                                <div class="step-indicator-number">2</div>
                                <div class="step-indicator-label">Password</div>
                            </div>
                            <div class="step-indicator-item">
                                <div class="step-indicator-number">3</div>
                                <div class="step-indicator-label">Role</div>
                            </div>
                        </div>

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="error-box">
                                <p><i class="fas fa-exclamation-circle me-2"></i>Registration Error</p>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <!-- Security Info -->
                        <div class="security-info">
                            <i class="fas fa-shield-alt"></i>
                            <span>Your data is encrypted and secure • No credit card required</span>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Full Name -->
                            <div class="form-group">
                                <label for="name">
                                    <i class="fas fa-user me-2" style="color: var(--light-green);"></i>Full Name
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                     id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope me-2" style="color: var(--light-green);"></i>Email Address
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                     id="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required>
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Fields -->
                            <div class="two-column">
                                <div class="form-group">
                                    <label for="password">
                                        <i class="fas fa-key me-2" style="color: var(--light-green);"></i>Password
                                    </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                         id="password" name="password" placeholder="••••••••" required>
                                    @error('password')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">
                                        <i class="fas fa-check me-2" style="color: var(--light-green);"></i>Confirm Password
                                    </label>
                                    <input type="password" class="form-control" id="password_confirmation" 
                                         name="password_confirmation" placeholder="••••••••" required>
                                </div>
                            </div>

                            <!-- Account Type -->
                            <div class="form-group">
                                <label for="role">
                                    <i class="fas fa-shield-alt me-2" style="color: var(--light-green);"></i>What is Your Role?
                                </label>
                                <select class="form-control @error('role') is-invalid @enderror" 
                                       id="role" name="role" required onchange="toggleBusinessFields()">
                                    <option value="">Select your account type</option>
                                    <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>
                                        <i class="fas fa-laptop me-2"></i>I have e-waste to sell or donate
                                    </option>
                                    <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>
                                        <i class="fas fa-recycle me-2"></i>I process or recycle e-waste
                                    </option>
                                </select>
                                @error('role')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Conditional Fields for Buyers -->
                            <div id="businessFields" style="display: none;">
                                <div class="conditional-fields">
                                    <h6>
                                        <i class="fas fa-building me-2" style="color: var(--light-green);"></i>Organization Details
                                    </h6>

                                    <div class="form-group">
                                        <label for="business_name">
                                            <i class="fas fa-briefcase me-2" style="color: var(--light-green);"></i>Organization Name
                                        </label>
                                        <input type="text" class="form-control" id="business_name" 
                                             name="business_name" value="{{ old('business_name') }}" placeholder="Your Organization Name">
                                    </div>

                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="phone">
                                            <i class="fas fa-phone me-2" style="color: var(--light-green);"></i>Phone Number
                                        </label>
                                        <input type="tel" class="form-control" id="phone" 
                                             name="phone" value="{{ old('phone') }}" placeholder="(555) 000-0000">
                                    </div>
                                </div>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="terms-check">
                                <input type="checkbox" id="terms" name="terms" required>
                                <label for="terms">
                                    I agree to the <a href="#" onclick="openModal('terms'); return false;">Terms of Service</a>, <a href="#" onclick="openModal('privacy'); return false;">Privacy Policy</a>, and confirm I'm 18+ years old
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="register-btn">
                                <i class="fas fa-check-circle me-2"></i>Create My Free Account
                            </button>
                        </form>

                        <div class="oauth-divider">
                            <span>Or sign up with</span>
                        </div>

                        <a href="{{ route('auth.google.redirect') }}" class="oauth-btn oauth-google">
                            <i class="fab fa-google"></i>
                            <span>Sign up with Google</span>
                        </a>

                        <hr class="divider">
                        <p class="login-link">
                            <i class="fas fa-sign-in-alt me-2"></i>Already have an account?
                            <a href="{{ route('login') }}">Sign in here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms of Service Modal -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Terms of Service</h2>
            <button class="modal-close" onclick="closeModal('terms')">&times;</button>
        </div>
        <div class="modal-body">
            <h3>1. Acceptance of Terms</h3>
            <p>By accessing and using the E-Benta platform, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>

            <h3>2. Use License</h3>
            <p>Permission is granted to temporarily download one copy of the materials (information, software, and graphics) from E-Benta for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
            <ul>
                <li>Modify or copy the materials</li>
                <li>Use the materials for any commercial purpose or for any public display</li>
                <li>Attempt to decompile or reverse engineer any software contained on E-Benta</li>
                <li>Remove any copyright or other proprietary notations from the materials</li>
                <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
            </ul>

            <h3>3. Disclaimer</h3>
            <p>The materials on E-Benta's website are provided on an 'as is' basis. E-Benta makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>

            <h3>4. Limitations</h3>
            <p>In no event shall E-Benta or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on E-Benta's website.</p>

            <h3>5. Accuracy of Materials</h3>
            <p>The materials appearing on E-Benta could include technical, typographical, or photographic errors. E-Benta does not warrant that any of the materials on its website are accurate, complete, or current. E-Benta may make changes to the materials contained on its website at any time without notice.</p>

            <h3>6. Links</h3>
            <p>E-Benta has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by E-Benta of the site. Use of any such linked website is at the user's own risk.</p>

            <h3>7. Modifications</h3>
            <p>E-Benta may revise these terms of service for its website at any time without notice. By using this website, you are agreeing to be bound by the then current version of these terms of service.</p>

            <h3>8. Governing Law</h3>
            <p>These terms and conditions are governed by and construed in accordance with the laws of the jurisdiction where E-Benta operates, and you irrevocably submit to the exclusive jurisdiction of the courts in that location.</p>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div id="privacyModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Privacy Policy</h2>
            <button class="modal-close" onclick="closeModal('privacy')">&times;</button>
        </div>
        <div class="modal-body">
            <h3>1. Information We Collect</h3>
            <p>We collect information you provide directly to us, such as when you create an account, list an item, or contact us. This includes your name, email address, phone number, and payment information.</p>

            <h3>2. How We Use Your Information</h3>
            <p>We use the information we collect to:</p>
            <ul>
                <li>Provide and improve our services</li>
                <li>Process transactions and send related information</li>
                <li>Send technical notices and support messages</li>
                <li>Respond to your comments and questions</li>
                <li>Monitor and analyze trends and usage</li>
                <li>Detect, prevent, and address fraudulent activity</li>
            </ul>

            <h3>3. Information Sharing</h3>
            <p>We do not sell, trade, or otherwise transfer your personally identifiable information to third parties. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, provided those parties agree to keep this information confidential.</p>

            <h3>4. Data Security</h3>
            <p>We implement a variety of security measures to maintain the safety of your personal information. Your personal information is contained behind secured networks and is only accessible by a limited number of persons who have special access rights to such systems.</p>

            <h3>5. User Rights</h3>
            <p>You have the right to access, correct, or delete your personal data at any time by logging into your account or contacting us directly. You may also opt-out of receiving marketing communications from us.</p>

            <h3>6. Cookies</h3>
            <p>We use cookies to enhance your experience while using our website. Cookies are small files that a site or its service provider transfers to your computer's hard drive through your web browser (if you allow). These help us understand website preferences, count visitors, and understand marketing effectiveness.</p>

            <h3>7. Third-Party Links</h3>
            <p>E-Benta's website may contain links to external sites. We are not responsible for the privacy practices of these external sites. We encourage you to review their privacy policies.</p>

            <h3>8. Changes to This Policy</h3>
            <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new privacy policy on this page and updating the "last updated" date.</p>

            <h3>9. Contact Us</h3>
            <p>If you have questions about this privacy policy, please contact us at privacy@ebenta.com or through the contact form on our website.</p>
        </div>
    </div>
</div>

<script>
function toggleBusinessFields() {
    const role = document.getElementById('role').value;
    const businessFields = document.getElementById('businessFields');
    businessFields.style.display = (role === 'buyer') ? 'block' : 'none';
}

// Global Modal Functions - MUST be defined before DOMContentLoaded
function openModal(type) {
    const modalId = type === 'terms' ? 'termsModal' : 'privacyModal';
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(type) {
    const modalId = type === 'terms' ? 'termsModal' : 'privacyModal';
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}

// Step Indicator Functionality
function updateStepIndicator() {
    const nameField = document.getElementById('name').value.trim();
    const emailField = document.getElementById('email').value.trim();
    const passwordField = document.getElementById('password').value.trim();
    const passwordConfirmField = document.getElementById('password_confirmation').value.trim();
    const roleField = document.getElementById('role').value;

    // Step 1: Name and Email
    const step1Complete = nameField && emailField;
    updateStep(1, step1Complete);

    // Step 2: Password and Confirm Password
    const step2Complete = passwordField && passwordConfirmField && passwordField === passwordConfirmField;
    updateStep(2, step2Complete);

    // Step 3: Role Selection
    const step3Complete = roleField !== '';
    updateStep(3, step3Complete);

    // Update progress line
    let completedSteps = 0;
    if (step1Complete) completedSteps++;
    if (step2Complete) completedSteps++;
    if (step3Complete) completedSteps++;

    // Calculate progress percentage (0%, 33%, 66%, 100%)
    const progressPercentage = (completedSteps / 3) * 100;
    document.querySelector('.step-indicator').style.setProperty('--step-progress', progressPercentage + '%');
}

function updateStep(stepNumber, isComplete) {
    const stepElement = document.querySelector(`.step-indicator-item:nth-child(${stepNumber}) .step-indicator-number`);
    if (stepElement) {
        if (isComplete) {
            stepElement.classList.add('active');
        } else {
            stepElement.classList.remove('active');
        }
    }
}

// Listen to all form inputs for changes
document.addEventListener('DOMContentLoaded', function() {
    const formInputs = document.querySelectorAll('input, select');
    formInputs.forEach(input => {
        input.addEventListener('input', updateStepIndicator);
        input.addEventListener('change', updateStepIndicator);
    });

    // Initial check on page load
    updateStepIndicator();

    // Close modal when clicking outside content
    const termsModal = document.getElementById('termsModal');
    const privacyModal = document.getElementById('privacyModal');
    
    if (termsModal) {
        termsModal.addEventListener('click', function(e) {
            if (e.target === termsModal) closeModal('terms');
        });
    }
    
    if (privacyModal) {
        privacyModal.addEventListener('click', function(e) {
            if (e.target === privacyModal) closeModal('privacy');
        });
    }
});
</script>
@endsection

@extends('layouts.app')

@section('title', 'Set Account Password - E-Benta')

@section('styles')
<style>
    .set-password-container {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }

    .set-password-card {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.03) 100%);
        border: 2px solid rgba(13, 148, 136, 0.25);
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }

    .set-password-header {
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        padding: 2.5rem 2rem;
        text-align: center;
        color: var(--dark-bg);
    }

    .set-password-header h2 {
        font-size: 1.85rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
    }

    .set-password-header i {
        font-size: 2.2rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    .set-password-header p {
        font-size: 0.95rem;
        margin: 0;
        opacity: 0.9;
    }

    .set-password-body {
        padding: 2.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        color: var(--text-light);
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .custom-input-wrapper input {
        background-color: rgba(255, 255, 255, 0.05) !important;
        border: 2px solid rgba(13, 148, 136, 0.3) !important;
        color: var(--text-light) !important;
        padding: 0.85rem 2.8rem 0.85rem 1rem !important;
        border-radius: 0.7rem !important;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .custom-input-wrapper input:focus {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border-color: var(--light-green) !important;
        box-shadow: 0 0 0 0.3rem rgba(13, 148, 136, 0.2) !important;
    }

    .toggle-password-btn {
        position: absolute;
        right: 0.85rem;
        background: none;
        border: none;
        color: var(--light-green);
        cursor: pointer;
        font-size: 1rem;
        padding: 0.25rem;
    }

    .submit-btn {
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        color: var(--dark-bg);
        border: none;
        padding: 1rem;
        font-weight: 700;
        font-size: 1.05rem;
        border-radius: 0.8rem;
        transition: all 0.35s ease;
        width: 100%;
        box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #0d9488 0%, var(--light-green) 100%);
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(13, 148, 136, 0.4);
        color: var(--dark-bg);
    }

    .email-badge {
        background-color: rgba(13, 148, 136, 0.1);
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 0.8rem;
        padding: 0.85rem 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--light-green);
        font-weight: 600;
        font-size: 0.95rem;
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

    .error-message {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        font-weight: 500;
        display: block;
    }

    .password-requirements {
        background-color: rgba(13, 148, 136, 0.05);
        border-left: 4px solid var(--light-green);
        color: #64748b;
        padding: 0.85rem 1rem;
        border-radius: 0.6rem;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
    }

    .password-requirements h5 {
        color: var(--light-green);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
        margin-top: 0;
    }

    .password-requirements ul {
        margin: 0;
        padding-left: 1.25rem;
    }
</style>
@endsection

@section('content')
<div class="set-password-container">
    <div class="set-password-card">
        <div class="set-password-header">
            <i class="fas fa-lock"></i>
            <h2>Create Account Password</h2>
            <p>Final Step: Secure your new E-Benta account</p>
        </div>
        <div class="set-password-body">
            @if ($errors->any())
                <div class="error-box">
                    <p><i class="fas fa-exclamation-circle me-2"></i>Please fix the following issues:</p>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" style="background-color: rgba(13, 148, 136, 0.1); border: 2px solid var(--light-green); color: var(--light-green); border-radius: 0.8rem; padding: 1rem; margin-bottom: 1.5rem;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="email-badge">
                <i class="fas fa-user-check"></i>
                <span>Creating password for: <strong>{{ $user->email }}</strong></span>
            </div>

            <form method="POST" action="{{ route('register.save-password') }}">
                @csrf

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-key me-2" style="color: var(--light-green);"></i>New Password
                    </label>
                    <div class="custom-input-wrapper">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                             id="password" name="password" placeholder="Min. 8 characters" required autofocus minlength="8">
                        <button type="button" class="toggle-password-btn" onclick="togglePass('password', this)" title="Show/Hide">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="password_confirmation">
                        <i class="fas fa-check-double me-2" style="color: var(--light-green);"></i>Confirm New Password
                    </label>
                    <div class="custom-input-wrapper">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                             id="password_confirmation" name="password_confirmation" placeholder="Re-type new password" required minlength="8">
                        <button type="button" class="toggle-password-btn" onclick="togglePass('password_confirmation', this)" title="Show/Hide">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="password-requirements">
                    <h5><i class="fas fa-shield-alt me-1"></i>Password Guidelines</h5>
                    <ul>
                        <li>Must be at least 8 characters long</li>
                        <li>Use a combination of letters, numbers, and symbols</li>
                    </ul>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-check-circle me-2"></i>Complete Registration & Open Dashboard
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePass(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection

@extends('layouts.app')

@section('title', 'Settings - E-Benta')

@section('styles')
<style>
    /* Settings Container */
    .settings-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 50%, #f0f9ff 100%);
        padding: 40px 0;
    }

    .settings-wrapper {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 3rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Settings Sidebar */
    .settings-sidebar {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .settings-sidebar-title {
        font-size: 1.3rem;
        font-weight: 900;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .settings-sidebar-title i {
        background: linear-gradient(135deg, #0d9488, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.5rem;
    }

    .settings-nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .settings-nav-item {
        position: relative;
        padding: 0.9rem 1.2rem;
        border-radius: 1rem;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-weight: 600;
        font-size: 0.95rem;
        border-left: 3px solid transparent;
    }

    .settings-nav-item:hover {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.05) 100%);
        color: #0d9488;
        border-left-color: #0d9488;
        transform: translateX(4px);
    }

    .settings-nav-item.active {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%);
        color: #0d9488;
        border-left-color: #0d9488;
    }

    .settings-nav-item i {
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    /* Settings Content */
    .settings-content {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        animation: fadeIn 0.3s ease-out;
    }

    .settings-section {
        display: none;
    }

    .settings-section.active {
        display: block !important;
    }

    .settings-section-header {
        margin-bottom: 2rem;
        border-bottom: 2px solid rgba(13, 148, 136, 0.1);
        padding-bottom: 1.5rem;
    }

    .settings-section-header h2 {
        font-size: 1.8rem;
        font-weight: 900;
        color: #1e293b;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .settings-section-header h2 i {
        background: linear-gradient(135deg, #0d9488, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2rem;
    }

    .settings-section-header p {
        color: #64748b;
        font-size: 1rem;
    }

    /* Settings Items */
    .settings-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        border: 2px solid rgba(13, 148, 136, 0.1);
        border-radius: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .settings-item:hover {
        border-color: rgba(13, 148, 136, 0.3);
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.03) 0%, rgba(6, 182, 212, 0.02) 100%);
    }

    .settings-item-left {
        display: flex;
        gap: 1.2rem;
        align-items: center;
        flex: 1;
    }

    .settings-item-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%);
        border-radius: 1rem;
        font-size: 1.3rem;
        color: #0d9488;
        flex-shrink: 0;
    }

    .settings-item-info h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.3rem;
    }

    .settings-item-info p {
        font-size: 0.85rem;
        color: #94a3b8;
        margin: 0;
    }

    .settings-item-action {
        display: flex;
        gap: 0.8rem;
        align-items: center;
    }

    .settings-btn {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: white;
        border: none;
        padding: 0.7rem 1.8rem;
        border-radius: 0.8rem;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
    }

    .settings-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4);
        color: white;
        text-decoration: none;
    }

    .settings-btn-secondary {
        background: transparent;
        color: #0d9488;
        border: 2px solid #0d9488;
        box-shadow: none;
    }

    .settings-btn-secondary:hover {
        background: #0d9488;
        color: white;
        box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4);
    }

    .settings-toggle {
        position: relative;
        width: 50px;
        height: 26px;
        background: #cbd5e1;
        border-radius: 13px;
        cursor: pointer;
        transition: background 0.3s ease;
        border: none;
        padding: 0;
        pointer-events: auto;
        z-index: 10;
    }

    .settings-toggle:hover {
        opacity: 0.9;
    }

    .settings-toggle.active {
        background: linear-gradient(135deg, #0d9488, #06b6d4);
    }
    }

    .settings-toggle::after {
        content: '';
        position: absolute;
        width: 22px;
        height: 22px;
        background: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: left 0.3s ease;
    }

    .settings-toggle.active::after {
        left: 26px;
    }

    /* Badge Status */
    .status-badge {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 0.6rem;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-verified {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%);
        color: #0d9488;
    }

    .status-pending {
        background: rgba(251, 146, 60, 0.15);
        color: #ea580c;
    }

    .status-unverified {
        background: rgba(255, 0, 0, 0.1);
        color: #dc2626;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .settings-wrapper {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .settings-sidebar {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .settings-container {
            padding: 20px 1rem;
        }

        .settings-content {
            padding: 1.5rem;
        }

        .settings-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .settings-item-action {
            width: 100%;
            justify-content: flex-start;
        }

        .settings-nav {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .settings-sidebar {
            padding: 1.5rem;
        }
    }

    /* Dark Mode Styles */
    body.dark-mode {
        background-color: #1a1a1a !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode .settings-container {
        background: linear-gradient(135deg, #1e1e1e 0%, #0f0f0f 50%, #1a1a1a 100%) !important;
    }

    body.dark-mode .settings-wrapper {
        background: transparent !important;
    }

    body.dark-mode .settings-sidebar {
        background: linear-gradient(135deg, #2a2a2a 0%, #242424 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5) !important;
    }

    body.dark-mode .settings-sidebar-title {
        color: #e0e0e0 !important;
    }

    body.dark-mode .settings-nav-item {
        color: #b0b0b0 !important;
        background-color: transparent !important;
    }

    body.dark-mode .settings-nav-item:hover {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%) !important;
        color: #06b6d4 !important;
        border-left-color: #06b6d4 !important;
    }

    body.dark-mode .settings-nav-item.active {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.2) 0%, rgba(6, 182, 212, 0.15) 100%) !important;
        color: #06b6d4 !important;
        border-left-color: #06b6d4 !important;
    }

    body.dark-mode .settings-content {
        background: linear-gradient(135deg, #2a2a2a 0%, #242424 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5) !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode .settings-section-header {
        border-bottom-color: rgba(6, 182, 212, 0.2) !important;
    }

    body.dark-mode .settings-section-header h2 {
        color: #e0e0e0 !important;
    }

    body.dark-mode .settings-section-header p {
        color: #a0a0a0 !important;
    }

    body.dark-mode .settings-item {
        border-color: rgba(255, 255, 255, 0.1) !important;
        background: transparent !important;
    }

    body.dark-mode .settings-item:hover {
        border-color: rgba(6, 182, 212, 0.3) !important;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(6, 182, 212, 0.05) 100%) !important;
    }

    body.dark-mode .settings-item-info h3 {
        color: #e0e0e0 !important;
    }

    body.dark-mode .settings-item-info p {
        color: #808080 !important;
    }

    body.dark-mode .settings-item-icon {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.2) 0%, rgba(6, 182, 212, 0.15) 100%) !important;
        color: #06b6d4 !important;
    }

    body.dark-mode .settings-btn {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%) !important;
        box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4) !important;
        color: white !important;
    }

    body.dark-mode .settings-btn:hover {
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.6) !important;
    }

    body.dark-mode .status-badge {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.2) 0%, rgba(6, 182, 212, 0.15) 100%) !important;
        color: #06b6d4 !important;
    }

    body.dark-mode .settings-toggle {
        background: #404040 !important;
    }

    body.dark-mode .settings-toggle.active {
        background: linear-gradient(135deg, #0d9488, #06b6d4) !important;
    }

    body.dark-mode h1,
    body.dark-mode h2,
    body.dark-mode h3,
    body.dark-mode h4,
    body.dark-mode h5,
    body.dark-mode h6,
    body.dark-mode p,
    body.dark-mode span,
    body.dark-mode label,
    body.dark-mode a:not(.nav-link):not(.dropdown-item) {
        color: #e0e0e0 !important;
    }

    body.dark-mode .navbar-brand {
        color: #06b6d4 !important;
    }

    body.dark-mode .navbar-brand span {
        color: #06b6d4 !important;
    }

    body.dark-mode .nav-link {
        color: #b0b0b0 !important;
    }

    body.dark-mode .navbar {
        background: linear-gradient(135deg, #2a2a2a 0%, #242424 100%) !important;
        border-bottom-color: rgba(6, 182, 212, 0.2) !important;
    }

    body.dark-mode .navbar {
        background: linear-gradient(135deg, #2a2a2a 0%, #242424 100%) !important;
        border-bottom-color: rgba(6, 182, 212, 0.2) !important;
    }

    body.dark-mode .navbar-brand {
        color: #06b6d4 !important;
    }

    body.dark-mode main {
        background-color: #1a1a1a;
    }
</style>
@endsection

@section('content')
<div class="settings-container">
    <div class="container-lg">
        <div class="settings-wrapper">
            <!-- Sidebar Navigation -->
            <aside class="settings-sidebar">
                <div class="settings-sidebar-title">
                    <i class="fas fa-sliders-h"></i>Settings
                </div>
                <nav class="settings-nav">
                    <a href="#account" class="settings-nav-item active" onclick="switchTab('account')">
                        <i class="fas fa-user-circle"></i>
                        <span>Account</span>
                    </a>
                    <a href="#notifications" class="settings-nav-item" onclick="switchTab('notifications')">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </a>
                    <a href="#privacy" class="settings-nav-item" onclick="switchTab('privacy')">
                        <i class="fas fa-lock"></i>
                        <span>Privacy & Security</span>
                    </a>
                    <a href="#payments" class="settings-nav-item" onclick="switchTab('payments')">
                        <i class="fas fa-credit-card"></i>
                        <span>Payments</span>
                    </a>
                    <a href="#seller" class="settings-nav-item" onclick="switchTab('seller')">
                        <i class="fas fa-store"></i>
                        <span>Seller Settings</span>
                    </a>
                    <a href="#preferences" class="settings-nav-item" onclick="switchTab('preferences')">
                        <i class="fas fa-cog"></i>
                        <span>Preferences</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="settings-content">

                <!-- Account Settings -->
                <div id="account" class="settings-section active">
                    <div class="settings-section-header">
                        <h2><i class="fas fa-user-circle"></i> Account Settings</h2>
                        <p>Manage your account information and profile details.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="settings-item" style="display:block; padding:1.5rem;">
                            <div class="settings-item-left" style="display:block; margin-bottom:1rem;">
                                <div class="settings-item-icon" style="margin-bottom:1rem;">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="settings-item-info" style="width:100%;">
                                    <h3>Personal Information</h3>
                                    <p>Update your profile.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone number</label>
                                    <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', auth()->user()->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if(auth()->user()->isSeller() || auth()->user()->isBuyer())
                                    <div class="col-12">
                                        <label for="business_name" class="form-label">
                                            {{ auth()->user()->isSeller() ? 'Business name' : 'Organization name' }}
                                        </label>
                                        <input type="text" name="business_name" id="business_name" class="form-control @error('business_name') is-invalid @enderror" value="{{ old('business_name', auth()->user()->business_name) }}">
                                        @error('business_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <div class="col-12">
                                    <label for="business_description" class="form-label">Business description</label>
                                    <textarea name="business_description" id="business_description" class="form-control @error('business_description') is-invalid @enderror" rows="4">{{ old('business_description', auth()->user()->business_description) }}</textarea>
                                    @error('business_description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="settings-item" style="display:flex; justify-content:flex-end; padding:1rem 1.5rem;">
                            <button type="submit" class="settings-btn"><i class="fas fa-save me-2"></i>Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Notification Settings -->
                <div id="notifications" class="settings-section" style="display: none;">
                    <div class="settings-section-header">
                        <h2><i class="fas fa-bell"></i> Notification Preferences</h2>
                        <p>Control how you receive updates.</p>
                    </div>

                    <form id="notification-settings-form" method="POST" action="{{ route('settings.notifications.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="email_notifications" id="email_notifications" value="{{ auth()->user()->email_notifications ? 1 : 0 }}">
                        <input type="hidden" name="sms_notifications" id="sms_notifications" value="{{ auth()->user()->sms_notifications ? 1 : 0 }}">
                        <input type="hidden" name="marketing_updates" id="marketing_updates" value="{{ auth()->user()->marketing_updates ? 1 : 0 }}">
                        <div class="settings-item">
                            <div class="settings-item-left">
                                <div class="settings-item-icon"><i class="fas fa-envelope"></i></div>
                                <div class="settings-item-info">
                                    <h3>Email Notifications</h3>
                                    <p>Get updates about offers and listings by email.</p>
                                </div>
                            </div>
                            <div class="settings-item-action">
                                <button type="button" class="settings-toggle {{ auth()->user()->email_notifications ? 'active' : '' }}" data-pref="email_notifications" aria-pressed="{{ auth()->user()->email_notifications ? 'true' : 'false' }}"></button>
                            </div>
                        </div>

                        <div class="settings-item">
                            <div class="settings-item-left">
                                <div class="settings-item-icon"><i class="fas fa-comment-dots"></i></div>
                                <div class="settings-item-info">
                                    <h3>SMS Notifications</h3>
                                    <p>Receive urgent alert messages by text.</p>
                                </div>
                            </div>
                            <div class="settings-item-action">
                                <button type="button" class="settings-toggle {{ auth()->user()->sms_notifications ? 'active' : '' }}" data-pref="sms_notifications" aria-pressed="{{ auth()->user()->sms_notifications ? 'true' : 'false' }}"></button>
                            </div>
                        </div>

                        <div class="settings-item">
                            <div class="settings-item-left">
                                <div class="settings-item-icon"><i class="fas fa-megaphone"></i></div>
                                <div class="settings-item-info">
                                    <h3>Marketing Updates</h3>
                                    <p>Receive product and feature announcements.</p>
                                </div>
                            </div>
                            <div class="settings-item-action">
                                <button type="button" class="settings-toggle {{ auth()->user()->marketing_updates ? 'active' : '' }}" data-pref="marketing_updates" aria-pressed="{{ auth()->user()->marketing_updates ? 'true' : 'false' }}"></button>
                            </div>
                        </div>

                        <div class="settings-item" style="display:flex; justify-content:flex-end; padding:1rem 1.5rem;">
                            <button type="submit" class="settings-btn"><i class="fas fa-save me-2"></i>Save Notification Preferences</button>
                        </div>
                    </form>
                </div>

                <!-- Privacy & Security -->
                <div id="privacy" class="settings-section" style="display: none;">
                    <div class="settings-section-header">
                        <h2><i class="fas fa-lock"></i> Privacy & Security</h2>
                        <p>Manage your account security and profile access.</p>
                    </div>

                    <form method="POST" action="{{ route('settings.privacy.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="settings-item" style="display:block; padding:1.5rem;">
                            <div class="settings-item-left" style="margin-bottom:1rem;">
                                <div class="settings-item-icon"><i class="fas fa-user-secret"></i></div>
                                <div class="settings-item-info">
                                    <h3>Profile Visibility</h3>
                                    <p>Choose whether other users can view your public profile.</p>
                                </div>
                            </div>
                            <label for="profile_visibility" class="form-label">Who can view your profile?</label>
                            <select name="profile_visibility" id="profile_visibility" class="form-select @error('profile_visibility') is-invalid @enderror">
                                <option value="public" {{ old('profile_visibility', auth()->user()->profile_visibility) === 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ old('profile_visibility', auth()->user()->profile_visibility) === 'private' ? 'selected' : '' }}>Private</option>
                            </select>
                            @error('profile_visibility')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="settings-item" style="display:flex; justify-content:flex-end; padding:1rem 1.5rem;">
                            <button type="submit" class="settings-btn"><i class="fas fa-save me-2"></i>Save Privacy Settings</button>
                        </div>
                    </form>

                    <div class="settings-item">
                        <div class="settings-item-left">
                            <div class="settings-item-icon"><i class="fas fa-key"></i></div>
                            <div class="settings-item-info">
                                <h3>Password</h3>
                                <p>Change your account password securely.</p>
                            </div>
                        </div>
                        <div class="settings-item-action">
                            <a href="{{ route('password.change') }}" class="settings-btn">Change Password</a>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-left">
                            <div class="settings-item-icon"><i class="fas fa-envelope"></i></div>
                            <div class="settings-item-info">
                                <h3>Email Address</h3>
                                <p>Request a secure email change.</p>
                            </div>
                        </div>
                        <div class="settings-item-action">
                            <a href="{{ route('email.change.request') }}" class="settings-btn">Change Email</a>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-left">
                            <div class="settings-item-icon"><i class="fas fa-shield-alt"></i></div>
                            <div class="settings-item-info">
                                <h3>Account Security</h3>
                                <p>Review your profile and account status.</p>
                            </div>
                        </div>
                        <div class="settings-item-action">
                            <a href="{{ route('profile') }}" class="settings-btn">View Profile</a>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div id="payments" class="settings-section" style="display: none;">
                    <div class="settings-section-header">
                        <h2><i class="fas fa-credit-card"></i> Payment Settings</h2>
                        <p>Manage your payout and billing preferences.</p>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-left">
                            <div class="settings-item-icon"><i class="fas fa-university"></i></div>
                            <div class="settings-item-info">
                                <h3>Bank Account</h3>
                                <p>Available when your seller payout details are configured.</p>
                            </div>
                        </div>
                        <div class="settings-item-action">
                            <span class="status-badge status-unverified">Not Added</span>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-left">
                            <div class="settings-item-icon"><i class="fas fa-wallet"></i></div>
                            <div class="settings-item-info">
                                <h3>Wallet</h3>
                                <p>Use wallet preferences for faster settlement.</p>
                            </div>
                        </div>
                        <div class="settings-item-action">
                            <a href="{{ route('profile') }}" class="settings-btn-secondary settings-btn">Review</a>
                        </div>
                    </div>
                </div>

                <!-- Seller Settings -->
                <div id="seller" class="settings-section" style="display: none;">
                    <div class="settings-section-header">
                        <h2><i class="fas fa-store"></i> Seller Settings</h2>
                        <p>Manage your selling workflow and listings.</p>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-left">
                            <div class="settings-item-icon"><i class="fas fa-tag"></i></div>
                            <div class="settings-item-info">
                                <h3>Listings</h3>
                                <p>Open your seller dashboard to manage active listings.</p>
                            </div>
                        </div>
                        <div class="settings-item-action">
                            <a href="{{ route('seller.dashboard') }}" class="settings-btn">Open Dashboard</a>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-left">
                            <div class="settings-item-icon"><i class="fas fa-plus-circle"></i></div>
                            <div class="settings-item-info">
                                <h3>Create Listing</h3>
                                <p>List a new device for sale or recycling.</p>
                            </div>
                        </div>
                        <div class="settings-item-action">
                            <a href="{{ route('listings.create') }}" class="settings-btn">Create Listing</a>
                        </div>
                    </div>
                </div>

                <!-- Preferences -->
                <div id="preferences" class="settings-section" style="display: none;">
                    <div class="settings-section-header">
                        <h2><i class="fas fa-cog"></i> General Preferences</h2>
                        <p>Customize how E-Benta looks and behaves.</p>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-left">
                            <div class="settings-item-icon"><i class="fas fa-moon"></i></div>
                            <div class="settings-item-info">
                                <h3>Dark Mode</h3>
                                <p>Switch the interface to a darker theme.</p>
                            </div>
                        </div>
                        <div class="settings-item-action">
                            <button type="button" class="settings-toggle" id="darkModeToggle" title="Toggle Dark Mode"></button>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</div>

<script>
function switchTab(tabName, event) {
    if (event) {
        event.preventDefault();
    }

    document.querySelectorAll('.settings-section').forEach(section => {
        section.classList.remove('active');
        section.style.display = 'none';
    });

    const targetSection = document.getElementById(tabName);
    if (targetSection) {
        targetSection.classList.add('active');
        targetSection.style.display = 'block';
    }

    document.querySelectorAll('.settings-nav-item').forEach(item => {
        item.classList.remove('active');
    });

    const navItem = document.querySelector('.settings-nav-item[href="#' + tabName + '"]');
    if (navItem) {
        navItem.classList.add('active');
    }
}

function syncPreferenceToggle(toggle) {
    const key = toggle.dataset.pref;
    if (!key) {
        return;
    }

    const hiddenInput = document.getElementById(key);

    toggle.addEventListener('click', function() {
        const isActive = this.classList.toggle('active');
        this.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        if (hiddenInput) {
            hiddenInput.value = isActive ? '1' : '0';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');

    if (darkModeToggle) {
        const isDarkMode = localStorage.getItem('darkModeEnabled') === 'true';
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
            darkModeToggle.classList.add('active');
        }

        darkModeToggle.addEventListener('click', function() {
            const isActive = this.classList.toggle('active');
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkModeEnabled', isActive ? 'true' : 'false');
        });
    }

    document.querySelectorAll('.settings-toggle[data-pref]').forEach(syncPreferenceToggle);

    document.querySelectorAll('.settings-nav-item').forEach(item => {
        item.addEventListener('click', function(event) {
            const hash = this.getAttribute('href');
            if (hash && hash.startsWith('#')) {
                switchTab(hash.replace('#', ''), event);
            }
        });
    });
});
</script>
@endsection

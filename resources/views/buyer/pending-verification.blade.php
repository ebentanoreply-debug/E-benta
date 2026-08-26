@extends('layouts.app')

@section('title', 'Account Under Verification - E-Benta')

@section('styles')
<style>
    /* ==========================================================================
       ACCOUNT UNDER VERIFICATION - PREMIUM UI
       ========================================================================== */
    .pv-container {
        min-height: calc(100vh - 70px);
        padding: 2.5rem 1rem 4rem;
        position: relative;
        overflow: hidden;
    }

    /* Ambient background glows */
    .pv-glow-1 {
        position: absolute;
        top: -100px;
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 400px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.25) 0%, rgba(6, 182, 212, 0.08) 50%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    .pv-glow-2 {
        position: absolute;
        bottom: 10%;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    /* Top Badge */
    .pv-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.35);
        color: #fbbf24;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 0.6rem 1.4rem;
        border-radius: 50px;
        box-shadow: 0 4px 20px rgba(245, 158, 11, 0.2);
        backdrop-filter: blur(8px);
        margin-bottom: 2rem;
    }

    .pv-pulse-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #f59e0b;
        box-shadow: 0 0 12px #f59e0b;
        animation: pulseDot 2s infinite ease-in-out;
    }

    @keyframes pulseDot {
        0%, 100% { transform: scale(1); opacity: 1; box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        50% { transform: scale(1.2); opacity: 0.8; box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
    }

    /* Main Glass Card */
    .pv-main-card {
        position: relative;
        z-index: 1;
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.85) 0%, rgba(15, 23, 42, 0.95) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 1.75rem;
        padding: 3rem 2.5rem;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4), inset 0 1px 1px rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        margin-bottom: 2rem;
    }

    .pv-icon-header {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 1.25rem;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: #ffffff;
        box-shadow: 0 10px 30px rgba(13, 148, 136, 0.4);
        animation: floatIcon 3s ease-in-out infinite;
    }

    @keyframes floatIcon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .pv-title {
        color: #ffffff;
        font-weight: 800;
        font-size: 2.1rem;
        letter-spacing: -0.5px;
        margin-bottom: 0.75rem;
    }

    .pv-desc {
        color: #cbd5e1;
        font-size: 1.05rem;
        line-height: 1.7;
        max-width: 580px;
        margin: 0 auto 2.5rem;
    }

    /* Stepper / Timeline Container */
    .pv-steps-wrapper {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.25rem;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: left;
    }

    .pv-steps-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.75rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .pv-steps-header-icon {
        width: 34px;
        height: 34px;
        border-radius: 0.5rem;
        background: rgba(13, 148, 136, 0.2);
        color: #2dd4bf;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .pv-steps-header h4 {
        color: #ffffff;
        font-weight: 700;
        font-size: 1.15rem;
        margin: 0;
    }

    .pv-timeline {
        display: flex;
        flex-direction: column;
        gap: 0;
        position: relative;
    }

    .pv-step-item {
        display: flex;
        gap: 1.25rem;
        position: relative;
        padding-bottom: 2rem;
    }

    .pv-step-item:last-child {
        padding-bottom: 0;
    }

    .pv-step-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 19px;
        top: 40px;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, rgba(13, 148, 136, 0.6) 0%, rgba(255, 255, 255, 0.1) 100%);
    }

    .pv-badge {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1rem;
        flex-shrink: 0;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .pv-badge.active {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        box-shadow: 0 0 20px rgba(13, 148, 136, 0.5);
    }

    .pv-badge.pending {
        background: rgba(30, 41, 59, 0.9);
        color: #94a3b8;
        border: 2px solid rgba(255, 255, 255, 0.15);
    }

    .pv-step-body {
        flex: 1;
        padding-top: 0.35rem;
    }

    .pv-step-name {
        font-weight: 700;
        font-size: 1.05rem;
        margin: 0 0 0.35rem 0;
    }

    .pv-step-name.highlight {
        color: #2dd4bf;
    }

    .pv-step-name.normal {
        color: #f1f5f9;
    }

    .pv-step-text {
        color: #94a3b8;
        font-size: 0.92rem;
        line-height: 1.6;
        margin: 0;
    }

    /* Timeframe Info */
    .pv-timeframe-box {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1.75rem;
        padding: 0.85rem 1.25rem;
        background: rgba(13, 148, 136, 0.1);
        border: 1px solid rgba(13, 148, 136, 0.25);
        border-radius: 0.75rem;
    }

    .pv-timeframe-box i {
        color: #2dd4bf;
        font-size: 1.1rem;
    }

    .pv-timeframe-box span {
        color: #e2e8f0;
        font-size: 0.92rem;
    }

    .pv-timeframe-box strong {
        color: #2dd4bf;
    }

    /* While You Wait Box */
    .pv-wait-box {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.12) 0%, rgba(13, 148, 136, 0.08) 100%);
        border: 1px solid rgba(14, 165, 233, 0.3);
        border-radius: 1rem;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        text-align: left;
    }

    .pv-wait-icon {
        width: 38px;
        height: 38px;
        border-radius: 0.6rem;
        background: rgba(14, 165, 233, 0.25);
        color: #38bdf8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .pv-wait-text {
        color: #e2e8f0;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    .pv-wait-text strong {
        color: #38bdf8;
    }

    /* Buttons */
    .pv-btn-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .pv-btn-primary {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff !important;
        font-weight: 700;
        padding: 1rem 1.5rem;
        border-radius: 0.85rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        font-size: 0.95rem;
        box-shadow: 0 6px 20px rgba(13, 148, 136, 0.3);
        transition: all 0.25s ease;
        border: none;
    }

    .pv-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(13, 148, 136, 0.45);
        color: #ffffff !important;
    }

    .pv-btn-secondary {
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff !important;
        font-weight: 700;
        padding: 1rem 1.5rem;
        border-radius: 0.85rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        font-size: 0.95rem;
        backdrop-filter: blur(10px);
        transition: all 0.25s ease;
    }

    .pv-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.35);
        transform: translateY(-2px);
        color: #ffffff !important;
    }

    /* Support Footer */
    .pv-card-footer {
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .pv-card-footer a {
        color: #2dd4bf;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .pv-card-footer a:hover {
        color: #38bdf8;
        text-decoration: underline;
    }

    /* Benefits Section */
    .pv-benefits-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        position: relative;
        z-index: 1;
    }

    .pv-benefit-card {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.6) 0%, rgba(15, 23, 42, 0.8) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.25rem;
        padding: 1.75rem 1.5rem;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
    }

    .pv-benefit-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
    }

    .pv-benefit-icon-teal {
        background: rgba(13, 148, 136, 0.2);
        color: #2dd4bf;
    }

    .pv-benefit-icon-green {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
    }

    .pv-benefit-card h5 {
        color: #ffffff;
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 0.5rem;
    }

    .pv-benefit-card p {
        color: #94a3b8;
        font-size: 0.88rem;
        line-height: 1.6;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pv-main-card {
            padding: 2rem 1.25rem;
            border-radius: 1.25rem;
        }

        .pv-title {
            font-size: 1.65rem;
        }

        .pv-desc {
            font-size: 0.95rem;
        }

        .pv-steps-wrapper {
            padding: 1.25rem 1rem;
        }

        .pv-btn-grid,
        .pv-benefits-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@include('buyer.sidebar')

<div class="main-content-wrapper">
    <div class="pv-container">
        <!-- Ambient decorative glows -->
        <div class="pv-glow-1"></div>
        <div class="pv-glow-2"></div>

        <div class="container" style="max-width: 760px; position: relative; z-index: 1;">
            <!-- Status Badge -->
            <div class="text-center">
                <div class="pv-status-pill">
                    <span class="pv-pulse-dot"></span>
                    <span>Application Under Review</span>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="pv-main-card text-center">
                <!-- Glowing Animated Header Icon -->
                <div class="pv-icon-header">
                    <i class="fas fa-hourglass-half"></i>
                </div>

                <h1 class="pv-title">Welcome to E-Benta!</h1>
                <p class="pv-desc">
                    Thank you for joining our circular economy marketplace. Our compliance team is currently reviewing your account to ensure a safe, verified trading community.
                </p>

                <!-- Stepper / Timeline -->
                <div class="pv-steps-wrapper">
                    <div class="pv-steps-header">
                        <div class="pv-steps-header-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h4>Verification Process</h4>
                    </div>

                    <div class="pv-timeline">
                        <!-- Step 1 (Active) -->
                        <div class="pv-step-item">
                            <div class="pv-badge active">
                                <i class="fas fa-check" style="font-size: 0.85rem;"></i>
                            </div>
                            <div class="pv-step-body">
                                <h5 class="pv-step-name highlight">1. Review Your Information</h5>
                                <p class="pv-step-text">Our verification team reviews your registration details and profile information to ensure authenticity.</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="pv-step-item">
                            <div class="pv-badge pending">2</div>
                            <div class="pv-step-body">
                                <h5 class="pv-step-name normal">2. Ensure Security & Compliance</h5>
                                <p class="pv-step-text">We verify your details match our marketplace standards and ethical e-waste recycling policies.</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="pv-step-item">
                            <div class="pv-badge pending">3</div>
                            <div class="pv-step-body">
                                <h5 class="pv-step-name normal">3. Account Activation</h5>
                                <p class="pv-step-text">Once verified, you will receive full access to submit offers, message sellers, and purchase devices.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Typical Timeframe -->
                    <div class="pv-timeframe-box">
                        <i class="fas fa-clock"></i>
                        <span><strong>Estimated review time:</strong> Typically completed within 24 to 48 hours.</span>
                    </div>
                </div>

                <!-- While You Wait Banner -->
                <div class="pv-wait-box">
                    <div class="pv-wait-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="pv-wait-text">
                        <strong>While you wait:</strong> You can explore all verified active listings on the marketplace. You will be able to make offers as soon as your account is approved!
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pv-btn-grid">
                    <a href="{{ route('listings.index') }}" class="pv-btn-primary">
                        <i class="fas fa-search"></i>
                        <span>Browse Marketplace</span>
                    </a>
                    <a href="{{ route('profile') }}" class="pv-btn-secondary">
                        <i class="fas fa-user-circle"></i>
                        <span>View My Profile</span>
                    </a>
                </div>

                <!-- Support Footer -->
                <div class="pv-card-footer">
                    <span>Questions or need urgent assistance? </span>
                    <a href="{{ url('/#faq') }}">Visit FAQs</a>
                    <span class="mx-1">•</span>
                    <a href="mailto:support@e-benta.com">Contact Support</a>
                </div>
            </div>

            <!-- Trust & Security Benefits -->
            <div class="pv-benefits-grid">
                <div class="pv-benefit-card">
                    <div class="pv-benefit-icon-box pv-benefit-icon-teal">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5>100% Verified Community</h5>
                    <p>Every buyer and seller is verified to protect transactions and eliminate fraud.</p>
                </div>

                <div class="pv-benefit-card">
                    <div class="pv-benefit-icon-box pv-benefit-icon-green">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h5>Eco-Impact Tracking</h5>
                    <p>Your approved account gains access to carbon reduction & e-waste sustainability certificates.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

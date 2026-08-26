@extends('layouts.app')

@section('title', 'E-Benta - Responsible E-Waste Disposal')

@section('styles')
<style>
    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.7); }
        70% { box-shadow: 0 0 0 30px rgba(13, 148, 136, 0); }
        100% { box-shadow: 0 0 0 0 rgba(13, 148, 136, 0); }
    }

    @keyframes rotate-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes slide-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Hero Section */
    .hero {
        padding: 60px 0 120px;
        background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 50%, #f0f9ff 100%);
        position: relative;
        overflow: hidden;
        min-height: 750px;
        display: flex;
        align-items: center;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 900px;
        height: 900px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulse-ring 3s infinite;
    }

    .hero::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -5%;
        width: 700px;
        height: 700px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-graphics {
        position: absolute;
        right: 5%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 120px;
        opacity: 0.15;
        animation: float 4s ease-in-out infinite;
        z-index: 1;
    }

    .hero-graphics-2 {
        position: absolute;
        left: 2%;
        bottom: 10%;
        font-size: 100px;
        opacity: 0.12;
        animation: float 5s ease-in-out infinite;
        z-index: 1;
    }

    .hero h1 {
        font-size: 3.8rem;
        font-weight: 900;
        line-height: 1.15;
        margin-bottom: 1.5rem;
        color: #1e293b;
        letter-spacing: -1px;
        animation: slide-up 0.8s ease-out;
    }

    .hero h1 .accent {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        display: inline-block;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: #64748b;
        margin-bottom: 2.5rem;
        max-width: 580px;
        line-height: 1.7;
        font-weight: 500;
        animation: slide-up 0.8s ease-out 0.2s backwards;
    }

    .hero-buttons {
        display: flex;
        gap: 1.2rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
        animation: slide-up 0.8s ease-out 0.4s backwards;
    }

    .btn-primary-green {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        border: none;
        padding: 1.1rem 2.8rem;
        font-weight: 800;
        font-size: 1.05rem;
        border-radius: 1rem;
        transition: all 0.35s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        box-shadow: 0 10px 30px rgba(13, 148, 136, 0.4);
    }

    .btn-primary-green:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 45px rgba(13, 148, 136, 0.5);
        text-decoration: none;
        color: #ffffff;
    }

    .hero-buttons .btn-secondary-outline {
        background-color: transparent;
        color: #0d9488;
        border: 2.5px solid #0d9488;
        padding: 1.05rem 2.8rem;
        font-weight: 800;
        border-radius: 1rem;
        transition: all 0.35s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
    }

    .hero-buttons .btn-secondary-outline:hover {
        background-color: #0d9488;
        border-color: #0d9488;
        color: #ffffff;
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(13, 148, 136, 0.3);
        text-decoration: none;
    }


    .badge-certified {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.05) 100%);
        border: 2px solid rgba(13, 148, 136, 0.2);
        padding: 1.8rem;
        border-radius: 1.2rem;
        margin-top: 3rem;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        backdrop-filter: blur(10px);
        animation: slide-up 0.8s ease-out 0.6s backwards;
    }

    .badge-certified-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #06b6d4;
        flex-shrink: 0;
        border: 2px solid rgba(13, 148, 136, 0.25);
    }

    .badge-certified h5 {
        color: #1e293b;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }

    .badge-certified p {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0;
    }

    .hero-image {
        position: relative;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-image-box {
        text-align: center;
        padding: 3rem 2rem;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.04) 100%);
        border: 2px solid rgba(13, 148, 136, 0.15);
        border-radius: 2rem;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        backdrop-filter: blur(5px);
        box-shadow: 0 8px 32px rgba(13, 148, 136, 0.1);
        gap: 1rem;
    }

    .hero-device-icons {
        display: flex;
        gap: 2rem;
        justify-content: center;
        flex-wrap: wrap;
        font-size: 80px;
        color: rgba(13, 148, 136, 0.15);
    }

    .hero-device-icons i {
        animation: float 4s ease-in-out infinite;
    }

    .hero-device-icons i:nth-child(2) {
        animation-delay: 0.3s;
    }

    .hero-device-icons i:nth-child(3) {
        animation-delay: 0.6s;
    }

    /* Image Effects */
    @keyframes image-float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }

    @keyframes image-glow {
        0%, 100% { filter: drop-shadow(0 10px 25px rgba(13, 148, 136, 0.3)); }
        50% { filter: drop-shadow(0 15px 40px rgba(6, 182, 212, 0.5)); }
    }

    @keyframes image-scale {
        0% { transform: scale(0.95); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    .hero-image img {
        animation: image-scale 0.8s ease-out, image-float 4s ease-in-out infinite 0.8s, image-glow 3s ease-in-out infinite;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        position: relative;
        z-index: 2;
    }

    .hero-image img:hover {
        transform: scale(1.05) translateY(-15px);
        filter: drop-shadow(0 20px 50px rgba(13, 148, 136, 0.6));
    }

    /* Parallax effect - subtle scale on scroll */
    .hero-image {
        animation: slide-up 0.8s ease-out 0.8s backwards;
    }

    /* Pathways Section */
    .pathways {
        padding: 120px 0;
        background: linear-gradient(135deg, #0f172e 0%, #1a2d4f 100%);
        position: relative;
    }

    .pathways::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .pathways::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .pathways-title {
        text-align: center;
        margin-bottom: 5rem;
        position: relative;
        z-index: 2;
    }

    .pathways-title h2 {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 1rem;
        color: #ffffff;
    }

    .pathways-title p {
        color: #e2e8f0;
        font-size: 1.2rem;
        max-width: 650px;
        margin: 0 auto;
        font-weight: 500;
    }

    .pathway-card {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.04) 100%);
        border: 2px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.5rem;
        padding: 2.8rem;
        text-align: center;
        transition: all 0.4s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(5px);
        z-index: 2;
    }

    .pathway-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0d9488, #06b6d4);
    }

    .pathway-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 150px;
        background: linear-gradient(180deg, transparent, rgba(13, 148, 136, 0.05));
        border-radius: 1.5rem;
    }

    .pathway-card:hover {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.18) 0%, rgba(6, 182, 212, 0.12) 100%);
        border-color: #06b6d4;
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(13, 148, 136, 0.25);
    }

    .pathway-icon {
        font-size: 4rem;
        background: linear-gradient(135deg, #0d9488, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        display: inline-block;
        animation: float 4s ease-in-out infinite;
        position: relative;
        z-index: 1;
    }

    .pathway-card h4 {
        font-weight: 900;
        margin-bottom: 1rem;
        color: #ffffff;
        font-size: 1.65rem;
        position: relative;
        z-index: 1;
    }

    .pathway-card p {
        color: #e2e8f0;
        margin-bottom: 2rem;
        line-height: 1.7;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    .pathway-link {
        color: #06b6d4;
        text-decoration: none;
        font-weight: 800;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        position: relative;
        z-index: 1;
    }

    .pathway-link:hover {
        color: #0d9488;
        transform: translateX(6px);
    }

    /* Impact Metrics */
    .impact-metrics {
        padding: 120px 0;
        background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
        border-top: 2px solid rgba(13, 148, 136, 0.15);
        border-bottom: 2px solid rgba(13, 148, 136, 0.15);
        position: relative;
    }

    .impact-metrics::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .impact-metrics::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .impact-metrics-header {
        text-align: center;
        margin-bottom: 5rem;
        position: relative;
        z-index: 2;
    }

    .impact-metrics-header h2 {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 1rem;
        color: #1e293b;
    }

    .impact-metrics-header p {
        color: #64748b;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .metric {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 2px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.5rem;
        padding: 2.5rem;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(13, 148, 136, 0.08);
        position: relative;
        z-index: 2;
        overflow: hidden;
    }

    .metric::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #0d9488, #06b6d4);
    }

    .metric:hover {
        border-color: #0d9488;
        background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(13, 148, 136, 0.15);
    }

    .metric-icon {
        font-size: 3rem;
        background: linear-gradient(135deg, #0d9488, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.2rem;
        animation: float 4s ease-in-out infinite;
    }

    .metric-value {
        font-size: 3.2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #0d9488, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .metric-label {
        text-transform: uppercase;
        font-size: 0.9rem;
        color: #64748b;
        letter-spacing: 1.5px;
        margin-bottom: 0.75rem;
        font-weight: 800;
    }

    .metric-change {
        font-size: 1rem;
        background: linear-gradient(135deg, #0d9488, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
    }

    /* Process Section */
    .process {
        padding: 120px 0;
        background: linear-gradient(135deg, #0f172e 0%, #1a2d4f 100%);
        position: relative;
    }

    .process::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .process::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .process-title {
        text-align: center;
        margin-bottom: 5rem;
        position: relative;
        z-index: 2;
    }

    .process-title h2 {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 1rem;
        color: #ffffff;
    }

    .process-title p {
        color: #cbd5e1;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .process-steps-container {
        position: relative;
        z-index: 2;
    }

    .process-steps-connector {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #0d9488, #06b6d4, #0d9488);
        transform: translateY(-50%);
        z-index: 1;
    }

    @media (max-width: 768px) {
        .process-steps-connector {
            display: none;
        }
    }

    .process-step {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.12) 0%, rgba(6, 182, 212, 0.08) 100%);
        border: 2px solid rgba(13, 148, 136, 0.25);
        border-radius: 1.5rem;
        padding: 2.8rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(5px);
    }

    .process-step::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0d9488, #06b6d4);
    }

    .process-step:hover {
        border-color: #06b6d4;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.18) 0%, rgba(6, 182, 212, 0.12) 100%);
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(13, 148, 136, 0.25);
    }

    .step-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 1.8rem;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.2), rgba(6, 182, 212, 0.15));
        border: 3px solid #06b6d4;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.8rem;
        background: linear-gradient(135deg, #0d9488, #06b6d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: float 4s ease-in-out infinite;
        position: relative;
        z-index: 2;
    }

    .process-step h4 {
        font-weight: 900;
        margin-bottom: 1rem;
        color: #ffffff;
        font-size: 1.65rem;
        position: relative;
        z-index: 1;
    }

    .process-step p {
        color: #cbd5e1;
        font-size: 1rem;
        line-height: 1.7;
        position: relative;
        z-index: 1;
    }

    /* CTA Section */
    .cta-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        border-radius: 2.2rem;
        margin: 100px 0;
        text-align: center;
        box-shadow: 0 25px 60px rgba(13, 148, 136, 0.35);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .cta-background-icon {
        position: absolute;
        font-size: 200px;
        opacity: 0.08;
        left: 5%;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
    }

    .cta-content {
        position: relative;
        z-index: 2;
    }

    .cta-section h2 {
        font-size: 3rem;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .cta-section p {
        font-size: 1.3rem;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 2.5rem;
        font-weight: 600;
    }

    .cta-section .btn {
        background-color: #ffffff;
        color: #0d9488;
        border: none;
        padding: 1.1rem 3.2rem;
        font-weight: 900;
        font-size: 1.1rem;
        border-radius: 0.9rem;
        transition: all 0.35s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .cta-section .btn:hover {
        background-color: rgba(255, 255, 255, 0.95);
        color: #0d9488;
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem;
        }

        .hero-buttons {
            flex-direction: column;
        }

        .btn-primary-green {
            width: 100%;
            justify-content: center;
        }

        .hero::before,
        .hero::after {
            width: 400px;
            height: 400px;
        }

        .pathways-title h2,
        .process-title h2,
        .impact-metrics-header h2,
        .cta-section h2 {
            font-size: 2.2rem;
        }

        .hero h1 .accent {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
            display: inline-block;
        }

        .pathway-icon,
        .step-icon,
        .metric-value,
        .metric-change {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        }
    }

    @media (max-width: 480px) {
        .hero {
            padding: 3rem 0.75rem 2.5rem;
        }

        .hero h1 {
            font-size: 1.95rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1rem;
        }

        .pathways-title h2,
        .process-title h2,
        .impact-metrics-header h2,
        .cta-section h2 {
            font-size: 1.65rem;
        }

        .pathway-card {
            padding: 1.5rem 1.15rem;
            border-radius: 1.25rem;
        }

        .process-step {
            padding: 1.75rem 1.15rem;
            border-radius: 1.25rem;
        }

        .step-icon {
            width: 76px;
            height: 76px;
            font-size: 1.8rem;
            margin-bottom: 1.25rem;
        }

        .metric-card {
            padding: 1.25rem 1rem;
            border-radius: 1.25rem;
        }

        .metric-value {
            font-size: 2rem;
        }

        .cta-section {
            padding: 3rem 1rem;
            border-radius: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-graphics-2">
            <i class="fas fa-battery-full"></i>
        </div>
        <div class="container-fluid px-3 px-md-5">
            <div class="row align-items-center gx-5">
                <div class="col-lg-6 hero-content">
                    <div style="color: var(--light-green); font-weight: 700; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 1.5rem;">
                        <i class="fas fa-earth-americas me-2"></i>Leading the Circular Economy
                    </div>
                    <h1>
                        Transform E-Waste Into
                        <span class="accent">Economic Value</span>
                    </h1>
                    <p class="hero-subtitle">
                        Join thousands of eco-conscious users. Sell functional gadgets for cash, donate to those in need, or recycle responsibly. E-Benta makes e-waste management simple, transparent, and rewarding.
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ auth()->check() ? route('seller.dashboard') : route('register') }}" class="btn btn-primary-green">
                            <i class="fas fa-laptop"></i>List Your Device Today
                        </a>
                        <a href="{{ route('listings.index') }}" class="btn btn-secondary-outline">
                            <i class="fas fa-binoculars me-2"></i>Browse Verified Listings
                        </a>
                    </div>
                    <div class="badge-certified">
                        <div class="badge-certified-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h5>Verified & Certified</h5>
                            <p>100% Secure Transactions & Verified Buyers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="{{ asset('images/E-waste to wealth transformation.png') }}" alt="Transform E-Waste Into Economic Value" style="width: 100%; height: auto; border-radius: 1rem; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1); will-change: transform, filter;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pathways Section -->
    <section class="pathways">
        <div class="container-fluid">
            <div class="pathways-title">
                <h2>Three Powerful Pathways for Your E-Waste</h2>
                <p>Whether you want to earn cash, help others, or recycle responsibly, E-Benta is your complete e-waste solution.</p>
            </div>
            <div class="row g-4">
                <!-- Sell Pathway -->
                <div class="col-lg-4">
                    <div class="pathway-card">
                        <div class="pathway-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h4>Monetize</h4>
                        <p>Turn your old electronics into immediate cash. List devices in seconds, connect with verified buyers, and get paid instantly upon pickup with zero hassle.</p>
                        <a href="{{ auth()->check() ? route('seller.dashboard') : route('register') }}" class="pathway-link">
                            Start Selling <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Donate Pathway -->
                <div class="col-lg-4">
                    <div class="pathway-card">
                        <div class="pathway-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>Give Back</h4>
                        <p>Bridge the digital divide. Donate functional devices to schools and non-profits. Make a direct impact on education and community development worldwide.</p>
                        <a href="{{ route('listings.index') }}" class="pathway-link">
                            Donate Now <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Recycle Pathway -->
                <div class="col-lg-4">
                    <div class="pathway-card">
                        <div class="pathway-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h4>Recycle</h4>
                        <p>End-of-life devices? We ensure 100% responsible recycling through certified partners. Zero landfill, safe hazmat disposal, and environmental accountability tracked.</p>
                        <a href="{{ route('listings.index') }}" class="pathway-link">
                            Recycle Responsibly <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Metrics -->
    <section class="impact-metrics" id="impact">
        <div class="container-fluid">
            <div class="impact-metrics-header">
                <h2>Real-World Impact, One Device at a Time</h2>
                <p>Track the environmental difference we're making together in preventing e-waste pollution</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="metric">
                        <div class="metric-icon">
                            <i class="fas fa-cloud"></i>
                        </div>
                        <div class="metric-label">Carbon Emissions Prevented</div>
                        <div class="metric-value">2,847 Tons</div>
                        <div class="metric-change">↑ 18.5% this month</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="metric">
                        <div class="metric-icon">
                            <i class="fas fa-recycle"></i>
                        </div>
                        <div class="metric-label">E-Waste Diverted from Landfills</div>
                        <div class="metric-value">89,500 kg</div>
                        <div class="metric-change">↑ 12.3% this month</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="metric">
                        <div class="metric-icon">
                            <i class="fas fa-people-group"></i>
                        </div>
                        <div class="metric-label">Active Community Members</div>
                        <div class="metric-value">18,250+</div>
                        <div class="metric-change">↑ 425+ this month</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process" id="process">
        <div class="container-fluid">
            <div class="process-title">
                <h2>Get Started in Three Simple Steps</h2>
                <p>From device to impact—seamless e-waste management from listing to pickup in under 5 minutes</p>
            </div>
            <div class="row g-4 process-steps-container">
                <!-- Step 1 -->
                <div class="col-lg-4">
                    <div class="process-step">
                        <div class="step-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <h4>Photograph & Describe</h4>
                        <p>Snap clear photos of your device condition, specify the model, storage capacity, and any issues. Our AI provides instant fair-market pricing.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-4">
                    <div class="process-step">
                        <div class="step-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Match & Connect</h4>
                        <p>Our intelligent matching algorithm instantly connects you with verified buyers, donors, or certified recyclers. Review ratings and choose your match.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-4">
                    <div class="process-step">
                        <div class="step-icon">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <h4>Complete & Impact</h4>
                        <p>Schedule free pickup, receive instant payment or impact certificate, and track your environmental contribution on your impact dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container">
        <div class="cta-section">
            <div class="cta-background-icon">
                <i class="fas fa-globe"></i>
            </div>
            <div class="cta-content">
                <h2>Every Device Counts.<br>Make an Impact Today.</h2>
                <p>Don't let your old electronics become hazardous waste. Join 18,000+ community members turning e-waste into economic and environmental opportunity.</p>
                <a href="{{ auth()->check() ? route('seller.dashboard') : route('register') }}" class="btn">
                    <i class="fas fa-rocket"></i>Start Your Impact Journey
                </a>
            </div>
        </div>
    </section>
@endsection

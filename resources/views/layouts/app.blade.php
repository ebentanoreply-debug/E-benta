<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Benta - E-Waste Marketplace')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}?v=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #0d9488;
            --emerald-accent: #059669;
            --dark-bg: #ffffff;
            --light-green: #0d9488;
            --text-light: #0f172a;
            --secondary-color: #f0fdf4;
            --accent-green: #06b6d4;
            --muted-label: #64748b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-light);
            scroll-behavior: smooth;
        }

        .navbar {
            background: linear-gradient(135deg, #1e293b 0%, #233651 100%);
            border-bottom: 2px solid transparent;
            border-image: linear-gradient(90deg, #0d9488 0%, #06b6d4 50%, #0d9488 100%);
            border-image-slice: 1;
            padding: 0.5rem 0;
            box-shadow: 0 8px 30px rgba(13, 148, 136, 0.2), inset 0 1px 1px rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1020;
            transition: left 0.2s ease, width 0.2s ease, box-shadow 0.3s ease;
            width: 100%;
        }

        .navbar:hover {
            box-shadow: 0 12px 40px rgba(13, 148, 136, 0.3), inset 0 1px 1px rgba(255, 255, 255, 0.1);
        }

        body, html {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        body {
            padding-top: 60px;
        }

        main {
            flex: 1 0 auto;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            color: #ffffff !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            letter-spacing: -0.5px;
            margin-left: 0;
            position: relative;
        }

        .admin-topbar-toggle-btn {
            background: rgba(13, 148, 136, 0.18);
            border: 1px solid rgba(13, 148, 136, 0.35);
            color: #2dd4bf;
            width: 36px;
            height: 36px;
            border-radius: 0.65rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .admin-topbar-toggle-btn:hover {
            background: rgba(13, 148, 136, 0.35);
            color: #ffffff;
            transform: scale(1.05);
        }

        .admin-workspace-pill {
            background: rgba(13, 148, 136, 0.15);
            border: 1px solid rgba(13, 148, 136, 0.3);
            color: #2dd4bf;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            letter-spacing: 0.3px;
        }

        .navbar-brand:hover {
            transform: scale(1.05) translateY(-1px);
            text-shadow: 0 0 20px rgba(13, 148, 136, 0.4);
        }

        .navbar-brand i {
            font-size: 1.5rem;
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-brand span {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: #cbd5e1 !important;
            margin: 0 1rem;
            transition: all 0.3s ease;
            font-weight: 700;
            font-size: 0.9rem;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            width: 0;
            height: 3px;
            transform: translateX(-50%);
            background: linear-gradient(90deg, #0d9488 0%, #06b6d4 100%);
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        .nav-link:hover {
            color: #ffffff !important;
            text-shadow: 0 0 10px rgba(13, 148, 136, 0.3);
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .dropdown-menu {
            background: linear-gradient(135deg, #1e293b 0%, #0f172e 100%) !important;
            border: 2px solid rgba(13, 148, 136, 0.5) !important;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), inset 0 1px 1px rgba(255, 255, 255, 0.08) !important;
            padding: 0.8rem 0;
            margin-top: 1.2rem;
            backdrop-filter: blur(10px);
        }

        .dropdown-item {
            color: #cbd5e1 !important;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.9rem 1.5rem;
            font-size: 0.95rem;
            position: relative;
            margin: 0.3rem 0.5rem;
            border-radius: 0.5rem;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.4) 0%, rgba(6, 182, 212, 0.3) 100%) !important;
            color: #ffffff !important;
            padding-left: 2rem;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3) inset;
        }

        .dropdown-divider {
            border-color: rgba(13, 148, 136, 0.4) !important;
            margin: 0.8rem 0;
        }

        .navbar-toggler {
            border: 2px solid rgba(13, 148, 136, 0.3) !important;
            padding: 0.5rem 0.8rem;
            transition: all 0.3s ease;
            background: rgba(13, 148, 136, 0.05);
            border-radius: 0.5rem;
        }

        .navbar-toggler:hover,
        .navbar-toggler:focus {
            border-color: #06b6d4 !important;
            background: rgba(13, 148, 136, 0.15);
            box-shadow: 0 0 15px rgba(13, 148, 136, 0.3);
        }

        .navbar-toggler-icon {
            filter: brightness(1.2) invert(1);
            transition: filter 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            border-color: transparent;
            color: #ffffff;
            font-weight: 700;
            padding: 0.65rem 1.6rem;
            border-radius: 0.6rem;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 148, 136, 0.5);
            background: linear-gradient(135deg, #06b6d4 0%, #0d9488 100%);
            color: #ffffff;
        }

        .btn-list-device {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            color: #ffffff;
            font-weight: 700;
            border: none;
            padding: 0.75rem 1.8rem;
            border-radius: 0.7rem;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.3px;
        }

        .btn-list-device::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-list-device:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 148, 136, 0.5), inset 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .btn-list-device:hover::before {
            left: 100%;
        }

        /* Alert Styling */
        .alert {
            margin-top: 1.5rem;
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.03) 100%) !important;
            border: 1px solid rgba(13, 148, 136, 0.2) !important;
            border-left: 4px solid var(--light-green) !important;
            color: var(--text-light) !important;
            border-radius: 0.8rem;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.1);
            animation: slideInDown 0.3s ease;
        }

        .alert-success {
            border-left-color: #0d9488 !important;
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(13, 148, 136, 0.03) 100%) !important;
        }

        .alert-danger {
            border-left-color: #e74c3c !important;
            background: linear-gradient(135deg, rgba(231, 76, 60, 0.08) 0%, rgba(231, 76, 60, 0.03) 100%) !important;
        }

        .alert-info {
            border-left-color: #06b6d4 !important;
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.08) 0%, rgba(6, 182, 212, 0.03) 100%) !important;
        }

        .alert strong {
            font-weight: 800;
            color: var(--light-green);
        }

        .alert-danger strong {
            color: #e74c3c;
        }

        .alert-info strong {
            color: #3498db;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            border: none;
            background-color: rgba(46, 204, 113, 0.05);
            border: 1px solid rgba(46, 204, 113, 0.2);
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            transition: all 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            background-color: rgba(46, 204, 113, 0.1);
            border-color: var(--light-green);
        }

        footer {

        .btn-secondary-outline {
            background-color: transparent;
            color: var(--text-light);
            border: 2px solid var(--text-light);
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-secondary-outline:hover {
            background-color: var(--text-light);
            color: var(--dark-bg);
        }

        /* Form Styling */
        label {
            color: var(--text-light) !important;
            font-weight: 500;
            margin-bottom: 0.5rem !important;
            display: block;
        }

        .form-label {
            color: var(--text-light) !important;
            font-weight: 500;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(46, 204, 113, 0.3) !important;
            color: var(--text-light) !important;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08) !important;
            border-color: var(--light-green) !important;
            box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25) !important;
            color: var(--text-light) !important;
        }

        /* Notification Badge Pulse Animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3), 0 0 0 0 rgba(231, 76, 60, 0.5);
            }
            50% {
                box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3), 0 0 0 8px rgba(231, 76, 60, 0);
            }
            100% {
                box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3), 0 0 0 0 rgba(231, 76, 60, 0);
            }
        }

        /* Slide In Down Animation */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dark Mode Global Styles */
        body.dark-mode {
            background-color: #1a1a1a !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .navbar {
            background: linear-gradient(135deg, #2a2a2a 0%, #242424 100%) !important;
            border-bottom-color: rgba(6, 182, 212, 0.2) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5) !important;
        }

        body.dark-mode .nav-link {
            color: #b0b0b0 !important;
        }

        body.dark-mode .nav-link:hover {
            color: #06b6d4 !important;
        }

        body.dark-mode .navbar-brand {
            color: #06b6d4 !important;
        }

        body.dark-mode .navbar-toggler {
            border-color: #06b6d4 !important;
        }

        body.dark-mode .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(6, 182, 212, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }

        body.dark-mode .dropdown-toggle::after {
            border-top-color: #b0b0b0 !important;
        }

        body.dark-mode .card {
            background-color: #2a2a2a;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        body.dark-mode .form-control {
            background-color: #333333 !important;
            border-color: rgba(6, 182, 212, 0.3) !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control:focus {
            background-color: #3a3a3a !important;
            border-color: #06b6d4 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode main {
            background-color: #1a1a1a;
        }

        body.dark-mode .dropdown-menu {
            background-color: #2a2a2a !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        body.dark-mode .dropdown-item {
            color: #b0b0b0;
        }

        body.dark-mode .dropdown-item:hover,
        body.dark-mode .dropdown-item:focus {
            background-color: rgba(6, 182, 212, 0.15) !important;
            color: #06b6d4;
        }

        body.dark-mode .dropdown-header {
            color: #e0e0e0 !important;
        }

        body.dark-mode .dropdown-divider {
            border-top-color: rgba(255, 255, 255, 0.1) !important;
        }

        body.dark-mode .btn {
            color: #e0e0e0 !important;
        }

        body.dark-mode .btn-close {
            filter: invert(1) !important;
        }

        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode p,
        body.dark-mode span,
        body.dark-mode a {
            color: #e0e0e0 !important;
        }

        body.dark-mode .alert {
            background-color: #2a2a2a !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e0e0e0;
        }

        body.dark-mode footer {
            background-color: #0f0f0f !important;
            color: #e0e0e0 !important;
        }

        /* ==========================================================================
           GLOBAL MOBILE RESPONSIVE ENHANCEMENTS
           ========================================================================== */
        html, body {
            overflow-x: hidden !important;
            width: 100%;
            max-width: 100vw;
            -webkit-text-size-adjust: 100%;
        }

        .navbar-brand {
            margin-left: 0 !important;
            font-size: 1.3rem;
        }

        @media (min-width: 992px) {
            .navbar-brand {
                margin-left: 1.5rem !important;
                margin-right: 2rem !important;
            }
        }

        @media (max-width: 991.98px) {
            .navbar {
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                max-width: 100vw !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .navbar .container-fluid {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .navbar-brand {
                margin-left: 0 !important;
                margin-right: auto !important;
                font-size: 1.25rem;
                flex-shrink: 0;
            }

            .navbar-toggler {
                margin-left: auto !important;
                margin-right: 0 !important;
                padding: 0.4rem 0.65rem !important;
                border: 1.5px solid rgba(13, 148, 136, 0.5) !important;
                border-radius: 0.5rem !important;
                background: rgba(13, 148, 136, 0.1) !important;
                color: #ffffff !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                flex-shrink: 0 !important;
            }

            .navbar-toggler-icon {
                filter: brightness(1.2);
            }

            .navbar-collapse {
                background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
                border-radius: 1rem;
                padding: 1.25rem 1rem;
                margin-top: 0.75rem;
                border: 1px solid rgba(13, 148, 136, 0.3);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
                width: 100%;
            }

            .navbar-nav {
                align-items: stretch !important;
                gap: 0.5rem;
            }

            .navbar-nav .nav-item {
                margin-left: 0 !important;
                width: 100%;
            }

            .navbar-nav .nav-link {
                padding: 0.75rem 1rem !important;
                margin: 0 !important;
                border-radius: 0.6rem;
                display: flex !important;
                align-items: center;
            }

            .navbar-nav .nav-link:hover {
                background: rgba(13, 148, 136, 0.15);
            }

            .navbar-nav .dropdown-menu {
                position: static !important;
                float: none !important;
                width: 100% !important;
                margin-top: 0.5rem !important;
                box-shadow: none !important;
                background: rgba(15, 23, 42, 0.8) !important;
            }

            .navbar-nav .btn {
                width: 100%;
                margin-left: 0 !important;
                margin-top: 0.5rem;
                padding: 0.75rem 1.25rem !important;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #notificationsDropdown + .dropdown-menu {
                position: fixed !important;
                top: 70px !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                width: calc(100vw - 2rem) !important;
                max-width: 400px !important;
                margin: 0 auto !important;
            }

            .notification-item {
                padding: 0.75rem !important;
            }

            .notif-nav-item,
            .user-nav-item {
                margin-left: 0 !important;
                width: 100%;
            }

            .user-display-name {
                max-width: calc(100vw - 120px);
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                display: inline-block;
                vertical-align: middle;
            }
        }

        .notif-nav-item,
        .user-nav-item {
            margin-left: 1.5rem;
            position: relative;
        }

        .user-display-name {
            font-weight: 700;
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            vertical-align: middle;
        }

        /* Touch target minimums and input safety */
        button, a, input, select, textarea {
            touch-action: manipulation;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 56px;
            }

            h1, .h1 { font-size: calc(1.4rem + 1vw) !important; }
            h2, .h2 { font-size: calc(1.25rem + 0.8vw) !important; }
            h3, .h3 { font-size: 1.15rem !important; }

            .container, .container-fluid {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            /* Responsive tables */
            .table-responsive {
                -webkit-overflow-scrolling: touch;
                border-radius: 0.75rem;
                margin-bottom: 1rem;
            }

            /* Form inputs prevent auto-zoom on mobile */
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="tel"],
            select,
            textarea {
                font-size: 16px !important;
            }

            /* Responsive grid cards */
            .card {
                margin-bottom: 1rem;
            }

            /* Modal safety on small devices */
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem) !important;
            }
        }

        /* Responsive Dashboard Main Content Layout */
        .main-content-wrapper {
            transition: margin-left 0.25s ease, width 0.25s ease;
            box-sizing: border-box;
            min-height: 100vh;
            overflow-x: hidden;
        }

        @media (min-width: 992px) {
            .main-content-wrapper {
                margin-left: 260px;
                width: calc(100% - 260px);
            }
        }

        @media (max-width: 991.98px) {
            .main-content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100vw !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <script>
        // Initialize dark mode immediately (before other DOM content)
        if (localStorage.getItem('darkModeEnabled') === 'true') {
            document.body.classList.add('dark-mode');
        }
    </script>
    <!-- Enhanced Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid px-3 px-md-4">
            <!-- Left: Brand & Context Indicator -->
            <div class="d-flex align-items-center gap-2">
                @if(request()->routeIs('admin.*') || (auth()->check() && auth()->user()->isAdmin() && (request()->routeIs('admin.*') || request()->routeIs('admin/*'))))
                    <button type="button" class="admin-topbar-toggle-btn me-1" onclick="toggleAdminSidebar()" title="Toggle Sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                @endif

                <a class="navbar-brand m-0" href="/">
                    <i class="fas fa-leaf"></i>
                    <span>E-Benta</span>
                </a>

                @if(request()->routeIs('admin.*'))
                    <div class="d-none d-md-flex align-items-center ms-2">
                        <span class="admin-workspace-pill">
                            <i class="fas fa-shield-halved" style="color: #10b981;"></i> Admin Workspace
                        </span>
                    </div>
                @endif
            </div>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto" style="align-items: center; gap: 0.35rem;">
                    
                    @if(!request()->routeIs('admin.*'))
                        <!-- Marketplace Link -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('listings.*') ? 'active' : '' }}" href="{{ route('listings.index') }}">
                                <i class="fas fa-store me-1" style="color: var(--light-green);"></i>Marketplace
                            </a>
                        </li>

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}#process">
                                    <i class="fas fa-bolt me-1" style="color: #06b6d4;"></i>How It Works
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}#impact">
                                    <i class="fas fa-leaf me-1" style="color: #10b981;"></i>Eco Impact
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}#calculator">
                                    <i class="fas fa-calculator me-1" style="color: #f59e0b;"></i>Value Calculator
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}#faq">
                                    <i class="fas fa-circle-question me-1" style="color: #a855f7;"></i>FAQ
                                </a>
                            </li>
                        @endguest

                        @auth
                            @if(auth()->user()->isSeller())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('seller.*') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}">
                                        <i class="fas fa-chart-pie me-1"></i>Seller Hub
                                    </a>
                                </li>
                            @elseif(auth()->user()->isBuyer())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('buyer.*') ? 'active' : '' }}" href="{{ route('buyer.dashboard') }}">
                                        <i class="fas fa-chart-line me-1"></i>Buyer Dashboard
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif

                    @auth
                        @if(!request()->routeIs('admin.*'))
                            <!-- Messages Link (Buyers & Sellers Only) -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}" title="Messages">
                                    <i class="fas fa-comments me-1"></i><span class="d-lg-none">Messages</span>
                                </a>
                            </li>
                        @endif

                        <!-- Notifications Dropdown -->
                        <li class="nav-item dropdown notif-nav-item">
                            <a class="nav-link" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="position: relative; transition: all 0.3s ease; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;" onmouseover="this.style.color='#27ae60';" onmouseout="this.style.color='var(--light-green)';">
                                <i class="fas fa-bell" style="font-size: 1.25rem; color: #2dd4bf; transition: all 0.3s ease; transform-origin: center; display: inline-block;" onmouseover="this.style.transform='scale(1.08)';" onmouseout="this.style.transform='scale(1)';"></i>
                                <span id="notification-badge" style="position: absolute; top: -6px; right: -6px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-size: 0.68rem; font-weight: 800; padding: 0.2rem 0.45rem; border-radius: 50%; min-width: 18px; text-align: center; display: none; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4); animation: pulse 2s infinite;">0</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="max-width: 380px; height: auto; max-height: 450px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3); border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 0.8rem; display: none; flex-direction: column; padding: 0; margin: 0; min-width: 320px;">
                                <!-- Header -->
                                <li style="padding: 1rem 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); background: rgba(13, 148, 136, 0.08); flex-shrink: 0; list-style: none; margin: 0;">
                                    <h6 style="margin: 0; font-weight: 800; color: white; font-size: 0.95rem;"><i class="fas fa-bell me-2" style="color: #2dd4bf;"></i>Recent Notifications</h6>
                                </li>
                                <!-- Scrollable Container -->
                                <div style="flex: 1; overflow-y: auto; overflow-x: hidden; min-height: 80px; max-height: calc(450px - 120px);">
                                    <ul id="notifications-menu-container" style="list-style: none; margin: 0; padding: 0.5rem 0; display: flex; flex-direction: column;"></ul>
                                </div>
                                <!-- Footer -->
                                <li style="border-top: 1px solid rgba(255, 255, 255, 0.08); flex-shrink: 0; background: rgba(13, 148, 136, 0.04); list-style: none; padding: 0; margin: 0;">
                                    <a href="{{ route('notifications.index') }}" style="padding: 0.85rem 1.25rem; color: #2dd4bf; font-weight: 700; font-size: 0.88rem; display: block; margin: 0; text-align: center; text-decoration: none;"><i class="fas fa-arrow-right me-2"></i>View All Notifications</a>
                                </li>
                            </ul>
                        </li>

                        <!-- User Capsule Dropdown -->
                        <li class="nav-item dropdown user-nav-item ms-lg-2">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; gap: 0.6rem; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.35rem 0.85rem 0.35rem 0.45rem; border-radius: 2rem; transition: all 0.2s ease;">
                                @if(auth()->user()->avatar_url)
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 2px solid #10b981; flex-shrink: 0;">
                                @else
                                    <div style="width: 30px; height: 30px; background: linear-gradient(135deg, #0d9488 0%, #10b981 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffffff; font-weight: 800; font-size: 0.8rem; flex-shrink: 0;">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="user-display-name" style="font-weight: 700; font-size: 0.88rem; color: #ffffff;">{{ auth()->user()->name }}</span>
                                @if(auth()->user()->isAdmin())
                                    <span class="badge" style="background: #10b981; color: #ffffff; font-size: 0.65rem; font-weight: 800; padding: 0.2rem 0.45rem; border-radius: 0.4rem;">ADMIN</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line me-2" style="color: #2dd4bf;"></i>Admin Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.pending-verifications') }}"><i class="fas fa-id-card me-2" style="color: #38bdf8;"></i>Verifications Queue</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.reports.index') }}"><i class="fas fa-flag me-2" style="color: #f59e0b;"></i>User Reports</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2" style="color: #2dd4bf;"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2" style="color: #2dd4bf;"></i>Settings</a></li>
                                <li><a class="dropdown-item" href="{{ route('password.change') }}"><i class="fas fa-lock me-2" style="color: #2dd4bf;"></i>Change Password</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline; width: 100%;">
                                        @csrf
                                        <button type="submit" class="dropdown-item w-100 text-start" style="color: #fca5a5 !important;"><i class="fas fa-sign-out-alt me-2" style="color: #ef4444;"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                        @if(!request()->routeIs('admin.*'))
                            <li class="nav-item ms-lg-2">
                                <a class="btn btn-sm" href="{{ route('listings.create') }}" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; font-weight: 800; padding: 0.55rem 1.1rem; border-radius: 0.75rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.35); display: inline-flex; align-items: center; gap: 0.4rem;">
                                    <i class="fas fa-plus-circle"></i><span>List Device</span>
                                </a>
                            </li>
                        @endif
                    @else
                        <!-- Login/Register for Guests -->
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link" href="{{ route('login') }}" style="color: #f1f5f9 !important; font-weight: 700;">
                                <i class="fas fa-arrow-right-to-bracket me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item ms-lg-1">
                            <a class="btn" href="{{ route('register') }}" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; font-weight: 800; padding: 0.65rem 1.4rem; border-radius: 0.75rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.35); display: inline-flex; align-items: center; gap: 0.4rem;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(13, 148, 136, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(13, 148, 136, 0.35)';">
                                <i class="fas fa-plus-circle"></i><span>List Device</span>
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if($errors->any())
        <div style="position: fixed; top: 75px; left: 0; right: 0; z-index: 1050; pointer-events: none;">
            <div class="container">
                <div class="alert alert-dismissible fade show js-auto-dismiss" style="background: #ffffff; border: 1px solid rgba(231, 76, 60, 0.4); border-left: 5px solid #e74c3c; padding: 1.25rem 1.5rem; border-radius: 0.85rem; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); animation: slideInDown 0.4s ease; margin-bottom: 0; pointer-events: auto;">
                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <i class="fas fa-exclamation-circle" style="color: #e74c3c; font-size: 1.4rem; flex-shrink: 0; margin-top: 0.1rem;"></i>
                        <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">
                            <strong style="display: block; margin-bottom: 0.25rem; color: #b91c1c;">Please check the following:</strong>
                            @foreach($errors->all() as $error)
                                <div style="color: #475569;">{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0.5); opacity: 0.8; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.filter='brightness(0.8)';" onmouseout="this.style.opacity='0.8'; this.style.filter='brightness(0.5)';"></button>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div style="position: fixed; top: 75px; left: 0; right: 0; z-index: 1050; pointer-events: none;">
            <div class="container">
                <div class="alert alert-dismissible fade show js-auto-dismiss" style="background: #ffffff; border: 1px solid rgba(13, 148, 136, 0.4); border-left: 5px solid #0d9488; padding: 1.25rem 1.5rem; border-radius: 0.85rem; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); animation: slideInDown 0.4s ease; margin-bottom: 0; pointer-events: auto;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-check-circle" style="color: #0d9488; font-size: 1.4rem; flex-shrink: 0;"></i>
                        <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">
                            {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0.5); opacity: 0.8; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.filter='brightness(0.8)';" onmouseout="this.style.opacity='0.8'; this.style.filter='brightness(0.5)';"></button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div style="position: fixed; top: 75px; left: 0; right: 0; z-index: 1050; pointer-events: none;">
            <div class="container">
                <div class="alert alert-dismissible fade show js-auto-dismiss" style="background: #ffffff; border: 1px solid rgba(231, 76, 60, 0.4); border-left: 5px solid #e74c3c; padding: 1.25rem 1.5rem; border-radius: 0.85rem; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); animation: slideInDown 0.4s ease; margin-bottom: 0; pointer-events: auto;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-exclamation-circle" style="color: #e74c3c; font-size: 1.4rem; flex-shrink: 0;"></i>
                        <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">
                            {{ session('error') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0.5); opacity: 0.8; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.filter='brightness(0.8)';" onmouseout="this.style.opacity='0.8'; this.style.filter='brightness(0.5)';"></button>
                </div>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div style="position: fixed; top: 75px; left: 0; right: 0; z-index: 1050; pointer-events: none;">
            <div class="container">
                <div class="alert alert-dismissible fade show js-auto-dismiss" style="background: #ffffff; border: 1px solid rgba(52, 152, 219, 0.4); border-left: 5px solid #3498db; padding: 1.25rem 1.5rem; border-radius: 0.85rem; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); animation: slideInDown 0.4s ease; margin-bottom: 0; pointer-events: auto;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-info-circle" style="color: #3498db; font-size: 1.4rem; flex-shrink: 0;"></i>
                        <div style="color: #1e293b; font-weight: 600; font-size: 0.95rem;">
                            {{ session('info') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0.5); opacity: 0.8; transition: all 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.filter='brightness(0.8)';" onmouseout="this.style.opacity='0.8'; this.style.filter='brightness(0.5)';"></button>
                </div>
            </div>
        </div>
    @endif

    <script>
        window.addEventListener('load', () => {
            const alerts = document.querySelectorAll('.js-auto-dismiss');
            alerts.forEach((alertEl) => {
                setTimeout(() => {
                    const closeBtn = alertEl.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                        return;
                    }

                    alertEl.classList.remove('show');
                    alertEl.classList.add('hide');
                }, 1500);
            });
        });
    </script>

    <style>
        main::-webkit-scrollbar {
            width: 6px;
        }
        main::-webkit-scrollbar-track {
            background: transparent;
        }
        main::-webkit-scrollbar-thumb {
            background: rgba(13, 148, 136, 0.12);
            border-radius: 3px;
        }
        main::-webkit-scrollbar-thumb:hover {
            background: rgba(13, 148, 136, 0.2);
        }
        
        /* Main content wrapper scrollbar */
        .main-content-wrapper::-webkit-scrollbar {
            width: 6px;
        }
        .main-content-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }
        .main-content-wrapper::-webkit-scrollbar-thumb {
            background: rgba(13, 148, 136, 0.12);
            border-radius: 3px;
        }
        .main-content-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(13, 148, 136, 0.2);
        }

        /* Notifications dropdown scrollbar */
        .dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }
        .dropdown-menu::-webkit-scrollbar-track {
            background: rgba(155, 89, 182, 0.05);
            border-radius: 0.8rem;
        }
        .dropdown-menu::-webkit-scrollbar-thumb {
            background: rgba(13, 148, 136, 0.3);
            border-radius: 3px;
        }
        .dropdown-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(13, 148, 136, 0.5);
        }

        /* Notification dropdown scrollable wrapper div */
        .dropdown-menu > div[style*="flex: 1"]::-webkit-scrollbar {
            width: 6px;
        }
        .dropdown-menu > div[style*="flex: 1"]::-webkit-scrollbar-track {
            background: rgba(155, 89, 182, 0.05);
        }
        .dropdown-menu > div[style*="flex: 1"]::-webkit-scrollbar-thumb {
            background: rgba(13, 148, 136, 0.3);
            border-radius: 3px;
        }
        .dropdown-menu > div[style*="flex: 1"]::-webkit-scrollbar-thumb:hover {
            background: rgba(13, 148, 136, 0.5);
        }

        /* Notification menu container ul scrollbar */
        #notifications-menu-container::-webkit-scrollbar {
            width: 6px;
        }
        #notifications-menu-container::-webkit-scrollbar-track {
            background: rgba(155, 89, 182, 0.05);
        }
        #notifications-menu-container::-webkit-scrollbar-thumb {
            background: rgba(13, 148, 136, 0.3);
            border-radius: 3px;
        }
        #notifications-menu-container::-webkit-scrollbar-thumb:hover {
            background: rgba(13, 148, 136, 0.5);
        }

        /* Ensure notification dropdown is hidden by default */
        #notificationsDropdown + .dropdown-menu {
            display: none !important;
        }

        /* Show notification dropdown only when Bootstrap adds show class */
        #notificationsDropdown + .dropdown-menu.show {
            display: flex !important;
            flex-direction: column;
        }

        /* Prevent bell icon shift on scale */
        #notificationsDropdown i {
            transform-origin: center;
        }
    </style>

    <main>
        @yield('content')
    </main>

    <!-- Modern Multi-Column Eco Footer -->
    <footer style="background: linear-gradient(180deg, #09171f 0%, #050d12 100%); color: #94a3b8; border-top: 1px solid rgba(13, 148, 136, 0.25); padding: 4.5rem 0 2rem; margin-top: auto; position: relative; overflow: hidden;">
        <!-- Ambient subtle glow -->
        <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 800px; height: 180px; background: radial-gradient(ellipse at top, rgba(13, 148, 136, 0.15), transparent 70%); pointer-events: none;"></div>

        <div class="container" style="position: relative; z-index: 2;">
            <div class="row g-4 g-lg-5 mb-5">
                <!-- Col 1: Brand & Environmental Mission -->
                <div class="col-lg-4 col-md-6">
                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.25rem;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.4);">
                            <i class="fas fa-leaf" style="color: #ffffff; font-size: 1.2rem;"></i>
                        </div>
                        <span style="font-size: 1.5rem; font-weight: 900; letter-spacing: -0.5px; background: linear-gradient(135deg, #ffffff 0%, #a5f3fc 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">E-Benta</span>
                    </div>
                    <p style="font-size: 0.95rem; line-height: 1.7; color: #94a3b8; margin-bottom: 1.5rem;">
                        The Philippines' premier circular economy platform for certified e-waste monetization, bulk scrap trading, and verifiable zero-landfill recycling.
                    </p>
                    <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(13, 148, 136, 0.12); border: 1px solid rgba(13, 148, 136, 0.3); padding: 0.45rem 0.9rem; border-radius: 2rem; font-size: 0.8rem; color: #5eead4; font-weight: 700;">
                        <i class="fas fa-shield-halved"></i> Verified Zero-Landfill Initiative
                    </div>
                </div>

                <!-- Col 2: Marketplace Navigation -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 style="color: #ffffff; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">Marketplace</h6>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                        <li><a href="{{ route('listings.index') }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-arrow-right me-2" style="font-size: 0.75rem; color: #0d9488;"></i>All Listings</a></li>
                        <li><a href="{{ route('listings.index', ['category' => 'Smartphone']) }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-mobile-screen me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Smartphones</a></li>
                        <li><a href="{{ route('listings.index', ['category' => 'Laptop']) }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-laptop me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Laptops & PCs</a></li>
                        <li><a href="{{ route('listings.index', ['condition' => 'non_functional']) }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-boxes-stacked me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Scrap & Bulk Lots</a></li>
                    </ul>
                </div>

                <!-- Col 3: Platform & Handover -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h6 style="color: #ffffff; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">How It Works</h6>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                        <li><a href="{{ route('home') }}#process" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-bolt me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>4-Step Listing Flow</a></li>
                        <li><a href="{{ route('home') }}#calculator" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-calculator me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>CO₂ & Price Estimator</a></li>
                        <li><a href="{{ route('home') }}#impact" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-chart-line me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>Environmental Scoreboard</a></li>
                        <li><a href="{{ route('home') }}#faq" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-circle-question me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>Frequently Asked Questions</a></li>
                    </ul>
                </div>

                <!-- Col 4: Trust & Quick Action -->
                <div class="col-lg-3 col-md-6">
                    <h6 style="color: #ffffff; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">Start Today</h6>
                    <p style="font-size: 0.88rem; color: #94a3b8; margin-bottom: 1rem; line-height: 1.6;">
                        Have broken gadgets or scrap taking up storage? List in 60 seconds with verified doorstep pickup or safe meetup.
                    </p>
                    <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; font-weight: 800; padding: 0.75rem 1rem; border-radius: 0.6rem; border: none; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <i class="fas fa-plus-circle me-1"></i>Post Free Listing
                    </a>
                </div>
            </div>

            <!-- Bottom Sub-Footer -->
            <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; font-size: 0.85rem;">
                <p class="mb-0" style="color: #64748b;">
                    &copy; {{ date('Y') }} <strong>E-Benta</strong>. All Rights Reserved. Built for Sustainable Circular Innovation.
                </p>
                <div style="display: flex; gap: 1.5rem; align-items: center;">
                    <span style="color: #475569;"><i class="fas fa-lock me-1"></i>256-Bit Encrypted</span>
                    <span style="color: #475569;"><i class="fas fa-id-card me-1"></i>Govt ID Verified</span>
                    <a href="#" style="color: #64748b; text-decoration: none;" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;"><i class="fas fa-arrow-up me-1"></i>Top</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @auth
    <script>
        // Load notifications on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadRecentNotifications();
            // Refresh notifications every 15 seconds (faster updates)
            setInterval(loadRecentNotifications, 15000);
        });

        function loadRecentNotifications() {
            console.log('📡 Fetching /notifications/recent endpoint...');
            fetch('{{ route("notifications.recent") }}')
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('📬 Raw notifications data received:', data);
                    console.table(data);
                    
                    // Count unread notifications (ensure is_read is properly evaluated as boolean)
                    const unreadCount = data.filter(n => {
                        const isRead = Boolean(n.is_read);
                        console.log(`  Notification ${n.id}: is_read=${n.is_read} (type: ${typeof n.is_read}) → Boolean=${isRead} → !Boolean=${!isRead}`);
                        return !isRead;
                    }).length;
                    
                    console.log('📊 Filtered unread count:', unreadCount);
                    console.log('🎯 Calling updateNotificationBell with data length:', data.length);
                    updateNotificationBell(data);
                })
                .catch(error => {
                    console.error('❌ Error loading notifications:', error);
                });
        }

        function updateNotificationBell(data) {
            const badge = document.getElementById('notification-badge');
            const container = document.getElementById('notifications-menu-container');
            
            console.log('🔧 updateNotificationBell called with', data.length, 'notifications');
            console.log('Badge element found:', badge !== null);
            console.log('Container element found:', container !== null);
            
            // Count unread notifications (ensure is_read is properly evaluated as boolean)
            const unreadCount = data.filter(n => {
                // Convert to boolean explicitly: !0, !1, !null, !'0', !'1' should work correctly
                const isRead = Boolean(n.is_read);
                return !isRead;
            }).length;
            
            console.log('🔔 Badge unreadCount:', unreadCount);
            
            // Update badge - explicitly clear and hide
            console.log('  Setting badge.textContent to:', unreadCount);
            badge.textContent = unreadCount;
            
            if (unreadCount > 0) {
                console.log('  ➜ unreadCount > 0, showing badge');
                badge.style.display = 'inline-flex';
                badge.textContent = unreadCount;
            } else {
                console.log('  ➜ unreadCount = 0, HIDING badge');
                badge.style.display = 'none';
                badge.textContent = '0';
            }
            
            console.log('  Final badge state - display:', badge.style.display, 'textContent:', badge.textContent);

            // Display recent notifications
            if (data.length > 0) {
                const notificationIcons = {
                    'new_buyer_registration': 'fa-user-plus',
                    'new_seller_registration': 'fa-store',
                    'account_approved': 'fa-check-circle',
                    'account_rejected': 'fa-times-circle',
                    'offer_received': 'fa-handshake',
                    'offer_accepted': 'fa-smile',
                    'offer_rejected': 'fa-frown',
                    'listing_created': 'fa-clipboard-list',
                    'seller_registration_success': 'fa-star',
                };

                const notificationColors = {
                    'new_buyer_registration': { icon: '#3498db', bg: 'rgba(52, 152, 219, 0.1)' },
                    'new_seller_registration': { icon: '#27ae60', bg: 'rgba(39, 174, 96, 0.1)' },
                    'account_approved': { icon: '#2ecc71', bg: 'rgba(46, 204, 113, 0.1)' },
                    'account_rejected': { icon: '#e74c3c', bg: 'rgba(231, 76, 60, 0.1)' },
                    'offer_received': { icon: '#f39c12', bg: 'rgba(243, 156, 18, 0.1)' },
                    'offer_accepted': { icon: '#2ecc71', bg: 'rgba(46, 204, 113, 0.1)' },
                    'offer_rejected': { icon: '#e74c3c', bg: 'rgba(231, 76, 60, 0.1)' },
                    'listing_created': { icon: '#9b59b6', bg: 'rgba(155, 89, 182, 0.1)' },
                    'seller_registration_success': { icon: '#f39c12', bg: 'rgba(243, 156, 18, 0.1)' },
                };

                let html = '<li><div style="padding: 0.5rem 0;">';
                data.forEach(notification => {
                    const icon = notificationIcons[notification.type] || 'fa-bell';
                    const colors = notificationColors[notification.type] || { icon: '#3498db', bg: 'rgba(52, 152, 219, 0.1)' };
                    const readClass = notification.is_read ? 'text-muted' : 'fw-bold';
                    const readBgStyle = notification.is_read 
                        ? '' 
                        : `style="background-color: ${colors.bg}; border-left: 3px solid ${colors.icon};"`;
                    const titleColor = !notification.is_read ? `color: ${colors.icon}; font-weight: 700;` : '';
                    const timeAgo = new Date(notification.created_at).toLocaleString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    const targetUrl = notification.target_url || `/notifications/${notification.id}/open`;
                    
                    html += `
                        <a class="dropdown-item ${readClass}" href="${targetUrl}" ${readBgStyle} style="padding: 0.75rem 1rem; margin: 0.25rem 0.5rem; border-radius: 0.5rem; transition: all 0.2s ease; display: flex; gap: 0.75rem; align-items: flex-start;">
                            <div style="background: ${colors.bg}; padding: 0.5rem; border-radius: 0.5rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px;">
                                <i class="fas ${icon}" style="color: ${colors.icon}; font-size: 0.9rem;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 0.85rem; ${titleColor}">${notification.title}</div>
                                <small style="color: #a4b8b5; display: block; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">${notification.message.substring(0, 50)}...</small>
                                <small style="color: #7f9e9a; display: block; margin-top: 0.25rem; font-size: 0.75rem;">
                                    <i class="fas fa-clock" style="margin-right: 0.25rem;"></i>${timeAgo}
                                </small>
                            </div>
                        </a>
                    `;
                });
                html += '</div></li>';
                container.innerHTML = html;
            } else {
                container.innerHTML = '<li><a class="dropdown-item text-muted" href="{{ route('notifications.index') }}" style="text-align: center; padding: 1rem;"><i class="fas fa-inbox me-2"></i>No notifications</a></li>';
            }
        }

        // Function to refresh notification bell from other pages
        window.refreshNotificationBell = function() {
            loadRecentNotifications();
        }
    </script>
    @endauth

    @yield('scripts')
</body>
</html>

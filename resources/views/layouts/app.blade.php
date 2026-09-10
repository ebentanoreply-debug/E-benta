<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
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

        html, body {
            overflow-x: clip;
            max-width: 100vw;
        }
        @supports not (overflow-x: clip) {
            html, body {
                overflow-x: hidden;
            }
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

        html {
            min-height: 100%;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        body {
            padding-top: 60px;
        }

        @if(request()->routeIs('admin.*') || (auth()->check() && auth()->user()->isAdmin() && request()->routeIs('settings*')))
        body {
            padding-top: 0 !important;
            background-color: #09171f;
        }
        @endif

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
            background-color: var(--dark-bg);
            color: var(--text-light);
            border-top: 1px solid rgba(46, 204, 113, 0.2);
            padding: 2rem 0;
            margin-top: 4rem;
        }

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

        /* Pagination Styling and SVG Overflow Safeguards */
        nav[aria-label*="pagination"] svg,
        .pagination svg,
        nav svg.w-5.h-5,
        nav svg.w-5,
        nav svg.h-5,
        svg[class*="w-5"],
        svg[class*="h-5"] {
            width: 1.25rem !important;
            height: 1.25rem !important;
            max-width: 20px !important;
            max-height: 20px !important;
            display: inline-block !important;
            vertical-align: middle;
        }

        .pagination {
            margin-bottom: 0;
            gap: 0.25rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .page-item .page-link {
            border-radius: 0.5rem;
            color: #0d9488;
            border-color: #e2e8f0;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
        }

        .page-item.active .page-link {
            background-color: #0d9488;
            border-color: #0d9488;
            color: #ffffff;
        }



        /* ==========================================================================
           E-COMMERCE MARKETPLACE MASTER DESIGN SYSTEM & MOBILE OVERHAUL
           ========================================================================== */
        body.has-commerce-header {
            padding-top: 130px !important;
        }
        @media (max-width: 767.98px) {
            body.has-commerce-header {
                padding-top: 132px !important;
            }
            body {
                padding-bottom: calc(64px + env(safe-area-inset-bottom, 0px)) !important;
            }
            input, select, textarea {
                font-size: 16px !important;
            }
        }

        .commerce-master-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1025;
            background: #0b131f;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .commerce-topbar {
            background: #080f18;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            font-size: 0.76rem;
            padding: 0.3rem 0;
            color: #94a3b8;
        }

        .commerce-topbar a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .commerce-topbar a:hover {
            color: #2dd4bf;
        }

        .commerce-topbar-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(13, 148, 136, 0.18);
            border: 1px solid rgba(13, 148, 136, 0.3);
            color: #2dd4bf;
            padding: 0.12rem 0.55rem;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 0.72rem;
        }

        .commerce-main-nav {
            background: linear-gradient(135deg, #0f1c2d 0%, #16283d 100%);
            border-bottom: 1px solid rgba(13, 148, 136, 0.25);
            padding: 0.5rem 0;
        }

        .commerce-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            border-radius: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.15rem;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.4);
            flex-shrink: 0;
        }

        .commerce-brand-name {
            font-size: 1.35rem;
            font-weight: 900;
            letter-spacing: -0.5px;
            line-height: 1;
            background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 100%);
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }

        .commerce-brand-tag {
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            color: #2dd4bf;
            text-transform: uppercase;
        }

        /* Mega Search */
        .commerce-search-form {
            display: flex;
            align-items: center;
            background: #ffffff;
            border-radius: 0.75rem;
            padding: 3px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(13, 148, 136, 0.35);
            width: 100%;
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .commerce-search-form:focus-within {
            box-shadow: 0 6px 25px rgba(13, 148, 136, 0.4), 0 0 0 2px #0d9488;
        }

        .commerce-search-category {
            border: none;
            background: #f1f5f9;
            color: #1e293b;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 0.5rem 0.65rem;
            border-radius: 0.55rem 0 0 0.55rem;
            outline: none;
            cursor: pointer;
            border-right: 1px solid #e2e8f0;
            max-width: 135px;
        }

        .commerce-search-input {
            border: none;
            background: transparent;
            padding: 0.45rem 0.85rem;
            font-size: 0.88rem;
            color: #0f172a;
            width: 100%;
            outline: none;
        }

        .commerce-search-input::placeholder {
            color: #94a3b8;
            font-size: 0.84rem;
        }

        .commerce-search-btn {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            border: none;
            color: #ffffff;
            padding: 0.5rem 1.15rem;
            border-radius: 0.55rem;
            font-weight: 800;
            font-size: 0.84rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            flex-shrink: 0;
        }

        .commerce-search-btn:hover {
            background: linear-gradient(135deg, #0f766e 0%, #0891b2 100%);
            transform: scale(1.02);
        }

        /* Action Buttons */
        .commerce-action-item {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #e2e8f0;
            text-decoration: none;
            padding: 0.4rem 0.65rem;
            border-radius: 0.6rem;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .commerce-action-item:hover {
            background: rgba(13, 148, 136, 0.2);
            color: #ffffff;
            border-color: rgba(13, 148, 136, 0.4);
        }

        .commerce-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
            color: #ffffff;
            font-size: 0.65rem;
            font-weight: 900;
            padding: 0.15rem 0.42rem;
            border-radius: 1rem;
            min-width: 17px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.5);
            line-height: 1;
        }

        .commerce-sell-btn {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #ffffff !important;
            border: none;
            font-weight: 800;
            font-size: 0.86rem;
            padding: 0.52rem 1.05rem;
            border-radius: 0.65rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            white-space: nowrap;
        }

        .commerce-sell-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(249, 115, 22, 0.55);
            color: #ffffff;
        }

        /* Category Strip */
        .commerce-category-strip {
            background: #09131f;
            border-bottom: 1px solid rgba(13, 148, 136, 0.2);
            padding: 0.35rem 0;
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }

        .commerce-category-strip::-webkit-scrollbar {
            display: none;
        }

        .commerce-cat-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #94a3b8;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            padding: 0.3rem 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .commerce-cat-link:hover, .commerce-cat-link.active {
            background: rgba(13, 148, 136, 0.18);
            color: #2dd4bf;
        }

        /* Mobile Sticky Bottom Navigation */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            height: 60px;
            background: rgba(9, 17, 27, 0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(13, 148, 136, 0.28);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.45);
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #94a3b8;
            font-size: 0.68rem;
            font-weight: 700;
            transition: all 0.2s ease;
            flex: 1;
            height: 100%;
            position: relative;
            padding-top: 4px;
        }

        .mobile-nav-item i {
            font-size: 1.15rem;
            margin-bottom: 3px;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .mobile-nav-item:hover, .mobile-nav-item.active {
            color: #2dd4bf;
        }

        .mobile-nav-item.active i {
            color: #2dd4bf;
            transform: translateY(-2px);
        }

        .mobile-nav-sell {
            position: relative;
            top: -12px;
        }

        .mobile-nav-sell-btn {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d9488 0%, #10b981 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.35rem;
            box-shadow: 0 4px 18px rgba(13, 148, 136, 0.5), 0 0 0 4px #09111b;
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .mobile-nav-sell:active .mobile-nav-sell-btn {
            transform: scale(0.92);
        }

        .mobile-nav-badge {
            position: absolute;
            top: -4px;
            right: -8px;
            background: #ef4444;
            color: #ffffff;
            font-size: 0.6rem;
            font-weight: 900;
            min-width: 16px;
            height: 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
            border: 1.5px solid #09111b;
        }

        .mobile-nav-avatar {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #2dd4bf;
            margin-bottom: 3px;
        }

        /* Modern Eco Footer */
        .eco-footer {
            background: linear-gradient(180deg, #09171f 0%, #050d12 100%);
            color: #94a3b8;
            border-top: 1px solid rgba(13, 148, 136, 0.25);
            padding: 4.5rem 0 2.5rem;
            margin-top: auto;
            position: relative;
            overflow: hidden;
            max-width: 100vw;
        }

        .eco-footer-social-btn {
            width: 38px;
            height: 38px;
            border-radius: 0.55rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .eco-footer-social-btn:hover {
            transform: translateY(-2px);
            color: #ffffff;
        }

        .eco-footer-badge-card {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            padding: 0.85rem 0.75rem;
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            transition: all 0.2s ease;
            height: 100%;
        }

        .eco-footer-badge-card:hover {
            background: rgba(13, 148, 136, 0.1);
            border-color: rgba(13, 148, 136, 0.3);
        }

        .eco-footer-contact-chip {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            border-radius: 0.65rem;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .eco-footer-contact-chip:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(13, 148, 136, 0.35);
        }

        .eco-legal-link {
            color: #64748b;
            text-decoration: none;
            padding: 0.35rem 0.5rem;
            border-radius: 0.4rem;
            font-size: 0.82rem;
            transition: all 0.2s ease;
        }

        .eco-legal-link:hover {
            color: #2dd4bf;
            background: rgba(45, 212, 191, 0.08);
        }

        @media (max-width: 767.98px) {
            .eco-footer {
                padding: 3rem 0 calc(90px + env(safe-area-inset-bottom, 0px)) !important;
            }
            .eco-footer-links {
                gap: 0.35rem !important;
            }
            .eco-footer-links a {
                min-height: 40px;
                display: inline-flex;
                align-items: center;
                font-size: 0.9rem;
                padding: 0.2rem 0;
            }
            .eco-footer-badge-card {
                padding: 0.65rem 0.5rem;
                font-size: 0.78rem;
            }
            .eco-footer-social-btn {
                width: 42px;
                height: 42px;
                font-size: 1.05rem;
            }
        }
    </style>
    @yield('styles')
</head>
@php
    $isWorkspacePage = request()->routeIs('admin.*') || request()->routeIs('seller.*') || request()->routeIs('buyer.*') || request()->routeIs('addresses.*') || request()->routeIs('settings*');
    $savedCount = auth()->check() && auth()->user()->isBuyer() ? auth()->user()->savedListings()->count() : 0;
    $unreadMsgCount = auth()->check() ? auth()->user()->unreadMessagesCount() : 0;
@endphp
<body class="{{ !$isWorkspacePage ? 'has-commerce-header' : '' }}">
    <script>
        // Clean up legacy dark mode preference if previously stored
        if (localStorage.getItem('darkModeEnabled')) {
            localStorage.removeItem('darkModeEnabled');
        }
    </script>
    
    @if(!request()->routeIs('admin.*') && !(auth()->check() && auth()->user()->isAdmin() && request()->routeIs('settings*')))
        @if($isWorkspacePage)
            <!-- Workspace Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
                <div class="container-fluid px-3 px-md-4">
                    <div class="d-flex align-items-center gap-2">
                        @if(auth()->check() && auth()->user()->isSeller() && (request()->routeIs('seller.*') || request()->routeIs('messages.*') || request()->routeIs('addresses.*') || request()->routeIs('settings*')))
                            <button type="button" class="admin-topbar-toggle-btn me-1" onclick="toggleSellerSidebar()" title="Toggle Sidebar">
                                <i class="fas fa-bars"></i>
                            </button>
                        @elseif(auth()->check() && auth()->user()->isBuyer() && (request()->routeIs('buyer.*') || request()->routeIs('messages.*') || request()->routeIs('addresses.*') || request()->routeIs('settings*')))
                            <button type="button" class="admin-topbar-toggle-btn me-1" onclick="toggleBuyerSidebar()" title="Toggle Sidebar">
                                <i class="fas fa-bars"></i>
                            </button>
                        @endif

                        <a class="navbar-brand m-0" href="/">
                            <i class="fas fa-leaf"></i>
                            <span>E-Benta</span>
                        </a>

                        @if(auth()->check() && auth()->user()->isSeller() && (request()->routeIs('seller.*') || request()->routeIs('messages.*') || request()->routeIs('addresses.*') || request()->routeIs('settings*')))
                            <div class="d-none d-md-flex align-items-center ms-2">
                                <span class="admin-workspace-pill">
                                    <i class="fas fa-store" style="color: #10b981;"></i> Seller Hub
                                </span>
                            </div>
                        @elseif(auth()->check() && auth()->user()->isBuyer() && (request()->routeIs('buyer.*') || request()->routeIs('messages.*') || request()->routeIs('addresses.*') || request()->routeIs('settings*')))
                            <div class="d-none d-md-flex align-items-center ms-2">
                                <span class="admin-workspace-pill">
                                    <i class="fas fa-shopping-bag" style="color: #06b6d4;"></i> Buyer Hub
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex align-items-center ms-auto" id="navbarNav">
                        <ul class="navbar-nav ms-auto flex-row align-items-center" style="gap: 0.35rem;">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('listings.*') ? 'active' : '' }}" href="{{ route('listings.index') }}">
                                    <i class="fas fa-store me-1" style="color: var(--light-green);"></i>Marketplace
                                </a>
                            </li>

                            @auth
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}" title="Messages">
                                        <i class="fas fa-comments me-1"></i><span class="d-lg-none">Messages</span>
                                    </a>
                                </li>

                                <!-- Notifications Dropdown -->
                                <li class="nav-item dropdown notif-nav-item">
                                    <a class="nav-link" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="position: relative; transition: all 0.3s ease; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-bell" style="font-size: 1.25rem; color: #2dd4bf;"></i>
                                        <span id="notification-badge" style="position: absolute; top: -6px; right: -6px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-size: 0.68rem; font-weight: 800; padding: 0.2rem 0.45rem; border-radius: 50%; min-width: 18px; text-align: center; display: none; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4); animation: pulse 2s infinite;">0</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="max-width: 380px; height: auto; max-height: 450px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3); border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 0.8rem; display: none; flex-direction: column; padding: 0; margin: 0; min-width: 320px;">
                                        <li style="padding: 1rem 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); background: rgba(13, 148, 136, 0.08); flex-shrink: 0; list-style: none; margin: 0;">
                                            <h6 style="margin: 0; font-weight: 800; color: white; font-size: 0.95rem;"><i class="fas fa-bell me-2" style="color: #2dd4bf;"></i>Recent Notifications</h6>
                                        </li>
                                        <div style="flex: 1; overflow-y: auto; overflow-x: hidden; min-height: 80px; max-height: calc(450px - 120px);">
                                            <ul id="notifications-menu-container" style="list-style: none; margin: 0; padding: 0.5rem 0; display: flex; flex-direction: column;"></ul>
                                        </div>
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
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
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
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
        @else
            <!-- Full E-Commerce Master Header -->
            <header class="commerce-master-header">
                <!-- 1. Top Utility Strip (Desktop only) -->
                <div class="commerce-topbar d-none d-md-block">
                    <div class="container-fluid px-3 px-lg-4 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2 gap-md-3">
                            @auth
                                @php
                                    $userDeliverCity = auth()->user()->addresses()->where('is_primary', true)->first()?->city ?? auth()->user()->address_city;
                                @endphp
                                @if($userDeliverCity)
                                    <span class="commerce-topbar-pill">
                                        <i class="fas fa-location-dot"></i> Deliver to: <strong>{{ $userDeliverCity }}</strong>
                                    </span>
                                    <span class="d-none d-md-inline" style="color: rgba(255,255,255,0.2);">|</span>
                                @endif
                            @endauth
                            @php
                                $totalCo2Header = \App\Models\ImpactLog::sum('co2_saved') + \App\Models\Listing::sum('carbon_footprint');
                            @endphp
                            @if($totalCo2Header > 0)
                                <span class="d-none d-md-inline" style="font-size: 0.75rem; color: #94a3b8;">
                                    <i class="fas fa-leaf me-1 text-emerald-400" style="color: #10b981;"></i> <strong>{{ number_format($totalCo2Header, 1) }} kg</strong> CO₂ Diverted
                                </span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            @if(!auth()->check() || auth()->user()->isSeller())
                                <a href="{{ route('listings.create') }}" class="d-none d-sm-inline">
                                    <i class="fas fa-recycle me-1 text-teal-400" style="color: #2dd4bf;"></i> Sell / Recycle Tech
                                </a>
                            @endif
                            <a href="{{ route('home') }}#process" class="d-none d-md-inline">How It Works</a>
                            <a href="{{ route('home') }}#faq" class="d-none d-lg-inline">Help & FAQ</a>
                        </div>
                    </div>
                </div>

                @php
                    $globalDeviceTypes = \App\Models\DeviceType::orderBy('name')->get();
                    $activeListingCount = \App\Models\Listing::where('status', 'available')->count();
                @endphp

                <!-- 2. Main E-Commerce Search & Action Header -->
                <div class="commerce-main-nav">
                    <!-- Desktop Master Header Row (>= 768px) -->
                    <div class="container-fluid px-3 px-lg-4 d-none d-md-flex align-items-center justify-content-between gap-3">
                        <!-- Brand Logo -->
                        <a class="d-flex align-items-center gap-2 text-decoration-none flex-shrink-0" href="/">
                            <div class="commerce-brand-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="commerce-brand-name">E-Benta</span>
                                <span class="commerce-brand-tag">CIRCULAR MARKETPLACE</span>
                            </div>
                        </a>

                        <!-- Center: Mega Search Input -->
                        <div class="flex-grow-1 mx-1 mx-md-3" style="max-width: 650px;">
                            <form action="{{ route('listings.index') }}" method="GET" class="commerce-search-form">
                                <select name="category" class="commerce-search-category d-none d-md-block">
                                    <option value="">All Categories</option>
                                    @foreach($globalDeviceTypes as $gType)
                                        <option value="{{ $gType->name }}" {{ request('category') == $gType->name ? 'selected' : '' }}>{{ $gType->name }}</option>
                                    @endforeach
                                </select>
                                <div class="position-relative flex-grow-1">
                                    <input type="text" name="search" value="{{ request('search') }}" class="commerce-search-input" placeholder="Search {{ $activeListingCount > 0 ? $activeListingCount . ' available' : 'verified' }} tech listings, brands, scrap..." autocomplete="off">
                                </div>
                                <button type="submit" class="commerce-search-btn">
                                    <i class="fas fa-magnifying-glass"></i>
                                    <span class="d-none d-sm-inline">Search</span>
                                </button>
                            </form>
                        </div>

                        <!-- Right: Actions & User Info -->
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <!-- Wishlist / Saved Items -->
                            @if(!auth()->check() || auth()->user()->isBuyer())
                                <a href="{{ auth()->check() ? route('buyer.saved-items') : route('login') }}" class="commerce-action-item" title="Saved Items / Wishlist">
                                    <i class="fas fa-heart text-danger" style="font-size: 1.05rem; color: #f43f5e !important;"></i>
                                    <div class="d-none d-xl-flex flex-column text-start" style="line-height: 1.1;">
                                        <span style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Wishlist</span>
                                        <span style="font-size: 0.8rem; font-weight: 800; color: #ffffff;">Saved</span>
                                    </div>
                                    @if(auth()->check() && $savedCount > 0)
                                        <span class="commerce-badge">{{ $savedCount }}</span>
                                    @endif
                                </a>
                            @endif

                            @auth
                                <!-- Messages / Chat Room -->
                                <a href="{{ route('messages.index') }}" class="commerce-action-item" title="Messages & Offers">
                                    <i class="fas fa-comment-dots text-info" style="font-size: 1.05rem; color: #38bdf8 !important;"></i>
                                    <div class="d-none d-xl-flex flex-column text-start" style="line-height: 1.1;">
                                        <span style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Offers</span>
                                        <span style="font-size: 0.8rem; font-weight: 800; color: #ffffff;">Messages</span>
                                    </div>
                                    @if($unreadMsgCount > 0)
                                        <span class="commerce-badge bg-info text-white">{{ $unreadMsgCount }}</span>
                                    @endif
                                </a>

                                <!-- Notifications Dropdown -->
                                <div class="dropdown">
                                    <button class="commerce-action-item border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                                        <i class="fas fa-bell text-warning" style="font-size: 1.05rem; color: #fbbf24 !important;"></i>
                                        @php
                                            $userUnreadNotifCount = auth()->user()->notifications()->where('is_read', false)->count();
                                        @endphp
                                        @if($userUnreadNotifCount > 0)
                                            <span class="commerce-badge bg-warning text-dark">{{ $userUnreadNotifCount }}</span>
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg py-2" style="width: 320px; max-height: 400px; overflow-y: auto; background: #0f172a; border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 0.8rem;">
                                        <li class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center" style="border-color: rgba(255,255,255,0.1) !important;">
                                            <strong style="color: #ffffff; font-size: 0.88rem;">Notifications</strong>
                                            <a href="{{ route('notifications.index') }}" style="font-size: 0.75rem; color: #2dd4bf; text-decoration: none;">View All</a>
                                        </li>
                                        @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notif)
                                            <li>
                                                <a class="dropdown-item py-2 px-3 text-wrap" href="{{ route('notifications.open', $notif) }}" style="color: #cbd5e1; font-size: 0.82rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                                    <div class="fw-bold text-white mb-1">{{ $notif->title }}</div>
                                                    <div class="small opacity-75">{{ Str::limit($notif->message, 60) }}</div>
                                                    <small class="text-muted d-block mt-1">{{ $notif->created_at->diffForHumans() }}</small>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="px-3 py-4 text-center text-muted" style="font-size: 0.85rem;">
                                                <i class="fas fa-bell-slash fa-2x mb-2 opacity-50 d-block"></i>
                                                No new notifications
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>

                                <!-- User Account Capsule -->
                                <div class="dropdown">
                                    <button class="commerce-user-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; gap: 0.55rem; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.32rem 0.75rem 0.32rem 0.4rem; border-radius: 2rem; transition: all 0.2s ease;">
                                        <div class="commerce-user-avatar" style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #0d9488 0%, #10b981 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 0.75rem;">
                                            @if(auth()->user()->avatar)
                                                <img src="{{ auth()->user()->avatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                            @else
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div class="d-none d-lg-flex flex-column text-start" style="line-height: 1.1;">
                                            <span style="font-size: 0.65rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">
                                                {{ auth()->user()->role }}
                                            </span>
                                            <span style="font-size: 0.82rem; font-weight: 800; color: #ffffff;">
                                                {{ Str::limit(auth()->user()->name, 12) }}
                                            </span>
                                        </div>
                                        <i class="fas fa-chevron-down" style="font-size: 0.65rem; color: #94a3b8;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="background: #0f172a; border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 0.8rem; min-width: 220px;">
                                        @if(auth()->user()->isAdmin())
                                            <li><div class="px-3 py-1 text-xs text-uppercase fw-bold text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">Administration</div></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line me-2" style="color: #2dd4bf;"></i>Admin Dashboard</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.listings') }}"><i class="fas fa-boxes-stacked me-2" style="color: #38bdf8;"></i>Manage Listings</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.pending-verifications') }}"><i class="fas fa-user-check me-2" style="color: #fbbf24;"></i>Verifications</a></li>
                                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                                        @elseif(auth()->user()->isSeller())
                                            <li><div class="px-3 py-1 text-xs text-uppercase fw-bold text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">Seller Hub</div></li>
                                            <li><a class="dropdown-item" href="{{ route('seller.dashboard') }}"><i class="fas fa-store me-2" style="color: #2dd4bf;"></i>Seller Centre</a></li>
                                            <li><a class="dropdown-item" href="{{ route('seller.listings') }}"><i class="fas fa-boxes-stacked me-2" style="color: #38bdf8;"></i>My Inventory</a></li>
                                            <li><a class="dropdown-item" href="{{ route('seller.transaction-history') }}"><i class="fas fa-receipt me-2" style="color: #10b981;"></i>Sales Orders</a></li>
                                            <li><a class="dropdown-item" href="{{ route('seller.sales-analytics') }}"><i class="fas fa-chart-pie me-2" style="color: #f59e0b;"></i>Sales Analytics</a></li>
                                            <li><a class="dropdown-item" href="{{ route('listings.create') }}"><i class="fas fa-plus-circle me-2" style="color: #34d399;"></i>List New Tech</a></li>
                                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                                        @elseif(auth()->user()->isBuyer())
                                            <li><div class="px-3 py-1 text-xs text-uppercase fw-bold text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">Buyer Account</div></li>
                                            <li><a class="dropdown-item" href="{{ route('buyer.dashboard') }}"><i class="fas fa-bag-shopping me-2" style="color: #2dd4bf;"></i>My Purchases & Orders</a></li>
                                            <li><a class="dropdown-item" href="{{ route('buyer.transaction-history') }}"><i class="fas fa-clock-rotate-left me-2" style="color: #38bdf8;"></i>Order History</a></li>
                                            <li><a class="dropdown-item" href="{{ route('buyer.saved-items') }}"><i class="fas fa-heart me-2" style="color: #f43f5e;"></i>Saved Wishlist</a></li>
                                            <li><a class="dropdown-item" href="{{ route('addresses.index') }}"><i class="fas fa-map-location-dot me-2" style="color: #fbbf24;"></i>Shipping Addresses</a></li>
                                            <li><a class="dropdown-item" href="{{ route('reviews.user', auth()->user()) }}"><i class="fas fa-star me-2" style="color: #eab308;"></i>My Reviews</a></li>
                                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                                        @endif
                                        <li><div class="px-3 py-1 text-xs text-uppercase fw-bold text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">Account & Settings</div></li>
                                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2" style="color: #2dd4bf;"></i>Profile Info</a></li>
                                        <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2" style="color: #94a3b8;"></i>Preferences & Security</a></li>
                                        <li><a class="dropdown-item" href="{{ route('password.change') }}"><i class="fas fa-lock me-2" style="color: #94a3b8;"></i>Change Password</a></li>
                                        <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" style="display: inline; width: 100%;">
                                                @csrf
                                                <button type="submit" class="dropdown-item w-100 text-start" style="color: #fca5a5 !important;"><i class="fas fa-sign-out-alt me-2" style="color: #ef4444;"></i>Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="commerce-action-item text-white" style="font-weight: 700; font-size: 0.84rem;">
                                    <i class="fas fa-arrow-right-to-bracket" style="color: #2dd4bf;"></i>
                                    <span>Sign In</span>
                                </a>
                            @endauth

                            <!-- Sell Device Action Button -->
                            @if(auth()->check() && auth()->user()->isBuyer())
                                <a href="{{ route('buyer.dashboard') }}" class="commerce-sell-btn">
                                    <i class="fas fa-bag-shopping"></i>
                                    <span>My Orders</span>
                                </a>
                            @elseif(!auth()->check() || auth()->user()->isSeller())
                                <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="commerce-sell-btn">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Sell Tech</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Mobile Master Header Rows (< 768px) -->
                    <div class="d-flex d-md-none flex-column gap-2 px-3">
                        <!-- Mobile Row 1: Brand & Top Quick Actions -->
                        <div class="d-flex align-items-center justify-content-between">
                            <a class="d-flex align-items-center gap-2 text-decoration-none" href="/">
                                <div class="commerce-brand-icon" style="width: 32px; height: 32px; font-size: 1rem; border-radius: 0.5rem;">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <span class="commerce-brand-name" style="font-size: 1.22rem;">E-Benta</span>
                            </a>

                            <div class="d-flex align-items-center gap-2">
                                <!-- Mobile Wishlist -->
                                @if(!auth()->check() || auth()->user()->isBuyer())
                                    <a href="{{ auth()->check() ? route('buyer.saved-items') : route('login') }}" class="commerce-action-item p-2" title="Wishlist">
                                        <i class="fas fa-heart" style="font-size: 1rem; color: #f43f5e;"></i>
                                        @if(auth()->check() && $savedCount > 0)
                                            <span class="commerce-badge" style="top: -4px; right: -4px;">{{ $savedCount }}</span>
                                        @endif
                                    </a>
                                @endif

                                @auth
                                    <!-- Mobile Messages -->
                                    <a href="{{ route('messages.index') }}" class="commerce-action-item p-2" title="Messages">
                                        <i class="fas fa-comment-dots" style="font-size: 1rem; color: #38bdf8;"></i>
                                        @if($unreadMsgCount > 0)
                                            <span class="commerce-badge bg-info text-white" style="top: -4px; right: -4px;">{{ $unreadMsgCount }}</span>
                                        @endif
                                    </a>

                                    <!-- Mobile User Menu -->
                                    <div class="dropdown">
                                        <button class="border-0 bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div style="width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #0d9488 0%, #10b981 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 0.75rem; border: 1.5px solid #2dd4bf;">
                                                @if(auth()->user()->avatar)
                                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                                @else
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                @endif
                                            </div>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="background: #0f172a; border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 0.8rem; min-width: 200px;">
                                            <li class="px-3 py-2 border-bottom text-white fw-bold" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.08) !important;">
                                                {{ auth()->user()->name }}
                                                <small class="d-block text-muted text-capitalize" style="font-size: 0.72rem;">{{ auth()->user()->role }}</small>
                                            </li>
                                            @if(auth()->user()->isAdmin())
                                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line me-2 text-teal-400"></i>Dashboard</a></li>
                                            @elseif(auth()->user()->isSeller())
                                                <li><a class="dropdown-item" href="{{ route('seller.dashboard') }}"><i class="fas fa-store me-2 text-teal-400"></i>Seller Hub</a></li>
                                                <li><a class="dropdown-item" href="{{ route('listings.create') }}"><i class="fas fa-plus-circle me-2 text-emerald-400"></i>List Tech</a></li>
                                            @elseif(auth()->user()->isBuyer())
                                                <li><a class="dropdown-item" href="{{ route('buyer.dashboard') }}"><i class="fas fa-bag-shopping me-2 text-teal-400"></i>Purchases</a></li>
                                            @endif
                                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2 text-muted"></i>Profile</a></li>
                                            <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2 text-muted"></i>Settings</a></li>
                                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}" style="display: inline; width: 100%;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item w-100 text-start text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-sm text-white px-2 py-1" style="background: rgba(13, 148, 136, 0.3); border: 1px solid rgba(13, 148, 136, 0.4); font-size: 0.78rem; font-weight: 700; border-radius: 0.5rem;">
                                        Sign In
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Mobile Row 2: Dedicated Full-Width Search Bar -->
                        <div>
                            <form action="{{ route('listings.index') }}" method="GET" class="commerce-search-form w-100">
                                <div class="position-relative flex-grow-1">
                                    <input type="text" name="search" value="{{ request('search') }}" class="commerce-search-input py-2 ps-3 pe-2" placeholder="Search {{ $activeListingCount > 0 ? $activeListingCount . ' items' : 'tech' }}, scrap, brands..." autocomplete="off">
                                </div>
                                <button type="submit" class="commerce-search-btn px-3 py-2">
                                    <i class="fas fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 3. Subnav Category Strip (Touch-momentum horizontal scroll) -->
                <div class="commerce-category-strip">
                    <div class="container-fluid px-3 px-lg-4 d-flex align-items-center gap-2">
                        <a href="{{ route('listings.index') }}" class="commerce-cat-link {{ !request('category') && !request('condition') && !request('sort') ? 'active' : '' }}">
                            <i class="fas fa-border-all text-teal-400" style="color: #2dd4bf;"></i> All Tech
                        </a>
                        @foreach($globalDeviceTypes->take(8) as $dType)
                            <a href="{{ route('listings.index', ['category' => $dType->name]) }}" class="commerce-cat-link {{ request('category') == $dType->name ? 'active' : '' }}">
                                {{ $dType->name }}
                            </a>
                        @endforeach
                        <a href="{{ route('listings.index', ['condition' => 'functional']) }}" class="commerce-cat-link {{ request('condition') == 'functional' ? 'active' : '' }}">
                            <i class="fas fa-certificate" style="color: #10b981;"></i> Working
                        </a>
                        <a href="{{ route('listings.index', ['condition' => 'repairable']) }}" class="commerce-cat-link {{ request('condition') == 'repairable' ? 'active' : '' }}">
                            <i class="fas fa-wrench"></i> Repairable
                        </a>
                        <a href="{{ route('listings.index', ['condition' => 'for_parts']) }}" class="commerce-cat-link {{ request('condition') == 'for_parts' ? 'active' : '' }}">
                            <i class="fas fa-microchip"></i> Parts
                        </a>
                    </div>
                </div>
            </header>
        @endif
    @endif

    @if($errors->any())
        <div style="position: fixed; top: {{ !$isWorkspacePage ? '135px' : '75px' }}; left: 0; right: 0; z-index: 1050; pointer-events: none;">
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
        <div style="position: fixed; top: {{ !$isWorkspacePage ? '135px' : '75px' }}; left: 0; right: 0; z-index: 1050; pointer-events: none;">
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
        <div style="position: fixed; top: {{ !$isWorkspacePage ? '135px' : '75px' }}; left: 0; right: 0; z-index: 1050; pointer-events: none;">
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
        <div style="position: fixed; top: {{ !$isWorkspacePage ? '135px' : '75px' }}; left: 0; right: 0; z-index: 1050; pointer-events: none;">
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

    @if(!request()->routeIs('admin.*') && !(auth()->check() && auth()->user()->isAdmin() && request()->routeIs('settings*')))
    <!-- Modern Multi-Column Eco Footer -->
    <footer class="eco-footer">
        <!-- Ambient subtle glow -->
        <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 900px; max-width: 100vw; height: 220px; background: radial-gradient(ellipse at top, rgba(13, 148, 136, 0.18), transparent 70%); pointer-events: none;"></div>

        <div class="container" style="position: relative; z-index: 2;">
            <!-- Top Footer Grid -->
            <div class="row g-4 g-lg-5 mb-5">
                <!-- Col 1: Brand & Environmental Mission -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 1.15rem;">
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.4);">
                            <i class="fas fa-leaf" style="color: #ffffff; font-size: 1.25rem;"></i>
                        </div>
                        <span style="font-size: 1.6rem; font-weight: 900; letter-spacing: -0.5px; background: linear-gradient(135deg, #ffffff 0%, #a5f3fc 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">E-Benta</span>
                    </div>
                    <p style="font-size: 0.92rem; line-height: 1.75; color: #94a3b8; margin-bottom: 1.25rem;">
                        The Philippines' premier circular economy platform for certified e-waste monetization, bulk electronic scrap trading, and verifiable zero-landfill recycling.
                    </p>

                    <!-- Trust Tag -->
                    <div class="mb-4">
                        <span style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(13, 148, 136, 0.12); border: 1px solid rgba(13, 148, 136, 0.3); padding: 0.45rem 0.95rem; border-radius: 2rem; font-size: 0.8rem; color: #5eead4; font-weight: 700;">
                            <i class="fas fa-shield-halved"></i> Verified Zero-Landfill Initiative
                        </span>
                    </div>

                    <!-- Social Channels -->
                    <div class="mb-4 mb-lg-0">
                        <small style="display: block; color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">Connect With Us</small>
                        <div style="display: flex; gap: 0.6rem; align-items: center; flex-wrap: wrap;">
                            <a href="#" class="eco-footer-social-btn" title="Facebook" onmouseover="this.style.background='#0d9488'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255, 255, 255, 0.06)'; this.style.color='#94a3b8';">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="eco-footer-social-btn" title="Twitter / X" onmouseover="this.style.background='#06b6d4'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255, 255, 255, 0.06)'; this.style.color='#94a3b8';">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="eco-footer-social-btn" title="Instagram" onmouseover="this.style.background='#ec4899'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255, 255, 255, 0.06)'; this.style.color='#94a3b8';">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="eco-footer-social-btn" title="LinkedIn" onmouseover="this.style.background='#3b82f6'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255, 255, 255, 0.06)'; this.style.color='#94a3b8';">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="eco-footer-social-btn" title="Discord" onmouseover="this.style.background='#10b981'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(255, 255, 255, 0.06)'; this.style.color='#94a3b8';">
                                <i class="fab fa-discord"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Marketplace Navigation -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 style="color: #ffffff; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">Marketplace</h6>
                    <ul class="eco-footer-links" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                        <li><a href="{{ route('listings.index') }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-arrow-right me-2" style="font-size: 0.75rem; color: #0d9488;"></i>All Listings</a></li>
                        <li><a href="{{ route('listings.index', ['category' => 'Smartphone']) }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-mobile-screen me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Smartphones</a></li>
                        <li><a href="{{ route('listings.index', ['category' => 'Laptop']) }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-laptop me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Laptops & PCs</a></li>
                        <li><a href="{{ route('listings.index', ['category' => 'Tablet']) }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-tablet-screen-button me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Tablets</a></li>
                        <li><a href="{{ route('listings.index', ['condition' => 'non_functional']) }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-boxes-stacked me-2" style="font-size: 0.75rem; color: #0d9488;"></i>Scrap Lots</a></li>
                    </ul>
                </div>

                <!-- Col 3: Platform Features & How It Works -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 style="color: #ffffff; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">Platform</h6>
                    <ul class="eco-footer-links" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                        <li><a href="{{ route('home') }}#process" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-bolt me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>How It Works</a></li>
                        <li><a href="{{ route('home') }}#calculator" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-calculator me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>CO₂ Estimator</a></li>
                        <li><a href="{{ route('home') }}#impact" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-chart-line me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>Eco Scoreboard</a></li>
                        <li><a href="{{ route('home') }}#faq" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-circle-question me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>Help & FAQ</a></li>
                        @if(!auth()->check() || auth()->user()->isSeller())
                        <li><a href="{{ route('listings.create') }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#2dd4bf'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-plus-circle me-2" style="font-size: 0.75rem; color: #06b6d4;"></i>Post a Listing</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Col 4: Support & Contact Details -->
                <div class="col-lg-4 col-md-6 col-12">
                    <h6 style="color: #ffffff; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">Support & Contact</h6>
                    
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.88rem; margin-bottom: 1.5rem;">
                        <a href="mailto:support@e-benta.ph" class="eco-footer-contact-chip">
                            <i class="fas fa-envelope mt-1" style="color: #0d9488; font-size: 1rem;"></i>
                            <div>
                                <span style="display: block; color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Direct Support Email</span>
                                <span style="color: #e2e8f0; font-weight: 600;">support@e-benta.ph</span>
                            </div>
                        </a>

                        <div class="eco-footer-contact-chip">
                            <i class="fas fa-location-dot mt-1" style="color: #06b6d4; font-size: 1rem;"></i>
                            <div>
                                <span style="display: block; color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Service Coverage</span>
                                <span style="color: #e2e8f0; font-weight: 500;">Nationwide, Philippines</span>
                            </div>
                        </div>

                        <div class="eco-footer-contact-chip">
                            <i class="fas fa-clock mt-1" style="color: #f59e0b; font-size: 1rem;"></i>
                            <div>
                                <span style="display: block; color: #64748b; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Operating Hours</span>
                                <span style="color: #e2e8f0; font-weight: 500;">Mon – Sat: 8:00 AM – 6:00 PM PHT</span>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter / Updates Box -->
                    <div style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 0.85rem; padding: 1rem;">
                        <small style="color: #e2e8f0; font-weight: 700; display: block; margin-bottom: 0.5rem; font-size: 0.85rem;">Stay Updated on Drop-off Drives</small>
                        <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to E-Benta Eco Updates!');" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            <input type="email" placeholder="Enter your email" required style="background: rgba(0, 0, 0, 0.35); border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 0.55rem; color: #ffffff; font-size: 0.88rem; padding: 0.55rem 0.85rem; flex: 1 1 180px; min-height: 42px; outline: none;">
                            <button type="submit" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.55rem; font-weight: 800; font-size: 0.85rem; padding: 0.55rem 1.25rem; min-height: 42px; cursor: pointer; transition: opacity 0.2s ease;">Join</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Middle Trust Badges Bar -->
            <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding: 1.25rem 0; margin-bottom: 2rem;">
                <div class="row g-2 g-md-3 text-center text-md-start align-items-stretch">
                    <div class="col-6 col-md-3">
                        <div class="eco-footer-badge-card">
                            <i class="fas fa-id-card-clip" style="color: #0d9488; font-size: 1.25rem;"></i>
                            <span style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1;">100% ID Verified</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="eco-footer-badge-card">
                            <i class="fas fa-lock" style="color: #06b6d4; font-size: 1.25rem;"></i>
                            <span style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1;">SSL Encrypted</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="eco-footer-badge-card">
                            <i class="fas fa-recycle" style="color: #10b981; font-size: 1.25rem;"></i>
                            <span style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1;">Zero-Landfill Aligned</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="eco-footer-badge-card">
                            <i class="fas fa-truck-fast" style="color: #f59e0b; font-size: 1.25rem;"></i>
                            <span style="font-size: 0.82rem; font-weight: 700; color: #cbd5e1;">Doorstep Pickup</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Sub-Footer -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-3" style="font-size: 0.85rem;">
                <p class="mb-0" style="color: #64748b; font-size: 0.82rem; line-height: 1.6;">
                    &copy; {{ date('Y') }} <strong>E-Benta</strong>. All Rights Reserved. Built for Sustainable Circular Innovation in the Philippines.
                </p>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-2 gap-md-3 align-items-center">
                    <a href="{{ route('home') }}#faq" class="eco-legal-link">Privacy</a>
                    <a href="{{ route('home') }}#faq" class="eco-legal-link">Terms</a>
                    <a href="{{ route('home') }}#faq" class="eco-legal-link">Standards</a>
                    <a href="#" style="color: #2dd4bf; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.65rem; border-radius: 0.4rem; background: rgba(45, 212, 191, 0.08);" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
                        <span>Top</span> <i class="fas fa-arrow-up"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    @endif

    @if(!request()->routeIs('admin.*'))
    <!-- Sticky Mobile Bottom Navigation Bar (Screens < 768px) -->
    <nav class="mobile-bottom-nav d-md-none" aria-label="Mobile Bottom Navigation">
        <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fas fa-house"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('listings.index') }}" class="mobile-nav-item {{ request()->routeIs('listings.index') ? 'active' : '' }}">
            <i class="fas fa-store"></i>
            <span>Explore</span>
        </a>
        @if(auth()->check() && auth()->user()->isBuyer())
            <a href="{{ route('buyer.dashboard') }}" class="mobile-nav-item mobile-nav-sell" title="My Orders">
                <div class="mobile-nav-sell-btn">
                    <i class="fas fa-bag-shopping"></i>
                </div>
                <span>Orders</span>
            </a>
        @elseif(!auth()->check() || auth()->user()->isSeller())
            <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="mobile-nav-item mobile-nav-sell" title="Sell Tech">
                <div class="mobile-nav-sell-btn">
                    <i class="fas fa-plus"></i>
                </div>
                <span>Sell</span>
            </a>
        @endif
        <a href="{{ auth()->check() ? route('messages.index') : route('login') }}" class="mobile-nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
            <div class="position-relative">
                <i class="fas fa-comment-dots"></i>
                @if(auth()->check() && $unreadMsgCount > 0)
                    <span class="mobile-nav-badge">{{ $unreadMsgCount }}</span>
                @endif
            </div>
            <span>Messages</span>
        </a>
        @auth
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isSeller() ? route('seller.dashboard') : route('buyer.dashboard')) }}" class="mobile-nav-item {{ request()->routeIs('*.dashboard') || request()->routeIs('profile') ? 'active' : '' }}">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="mobile-nav-avatar">
                @else
                    <i class="fas fa-circle-user"></i>
                @endif
                <span>Account</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="mobile-nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                <i class="fas fa-arrow-right-to-bracket"></i>
                <span>Sign In</span>
            </a>
        @endauth
    </nav>
    @endif

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

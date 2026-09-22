@extends('layouts.base')

@section('body')
@php
    $unreadMsgCount = auth()->check() ? auth()->user()->unreadMessagesCount() : 0;
@endphp
<style>
    .seller-topbar-nav {
        position: fixed; top: 0; left: 0; right: 0; z-index: 1020; height: 60px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 1.25rem;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.05);
    }
    @media (max-width: 991.98px) {
        .seller-topbar-nav {
            padding: 0 0.65rem !important;
        }
    }
    @media (max-width: 767.98px) {
        body {
            padding-bottom: 72px !important;
        }
    }
</style>
<body style="background-color: #f8fafc; color: #0f172a; padding-top: 0;">
    <script>
        if (localStorage.getItem('darkModeEnabled')) { localStorage.removeItem('darkModeEnabled'); }
    </script>

    {{-- Seller Topbar --}}
    <nav class="seller-topbar-nav" aria-label="Seller Portal Topbar">
        {{-- Left: sidebar toggle + brand --}}
        <div class="d-flex align-items-center gap-1 gap-sm-2 flex-shrink-0">
            <button type="button" id="sellerSidebarToggleBtn"
                onclick="toggleSellerSidebar()"
                title="Toggle Sidebar"
                style="background: #f8fafc; border: 1px solid #e2e8f0; color: #0d9488;
                       width: 36px; height: 36px; border-radius: 0.65rem; display: inline-flex;
                       align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; font-size: 1rem;">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('seller.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none ms-1">
                <div style="width: 30px; height: 30px; border-radius: 8px; background: linear-gradient(135deg, #0d9488 0%, #10b981 100%);
                            display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 8px rgba(13,148,136,0.25); flex-shrink: 0;">
                    <i class="fas fa-store" style="color: #ffffff; font-size: 0.85rem;"></i>
                </div>
                <div class="d-none d-sm-flex flex-column" style="line-height: 1.1;">
                    <span style="color: #0f172a; font-weight: 900; font-size: 0.95rem; letter-spacing: -0.3px;">E-Benta</span>
                    <span class="d-none d-md-inline" style="color: #0d9488; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Seller Studio</span>
                </div>
            </a>
        </div>

        {{-- Center: breadcrumb --}}
        <div class="d-none d-lg-flex align-items-center gap-2" style="font-size: 0.82rem; color: #64748b;">
            <a href="{{ route('seller.dashboard') }}" style="color: #64748b; text-decoration: none; font-weight: 600; transition: color 0.2s ease;" onmouseover="this.style.color='#0d9488'" onmouseout="this.style.color='#64748b'">
                <i class="fas fa-store me-1"></i>Seller Hub
            </a>
            @yield('breadcrumb')
        </div>

        {{-- Right: notifications + user --}}
        <div class="d-flex align-items-center gap-1 gap-sm-2 flex-shrink-0">
            {{-- Quick: Create Listing --}}
            <a href="{{ route('listings.create') }}" class="d-none d-lg-inline-flex align-items-center gap-1"
               style="background: linear-gradient(135deg, #0d9488 0%, #10b981 100%); color: #ffffff; font-weight: 700;
                      font-size: 0.8rem; padding: 0.4rem 1rem; border-radius: 0.55rem; text-decoration: none; transition: all 0.2s ease;">
                <i class="fas fa-plus"></i> <span>New Listing</span>
            </a>

            {{-- Messages --}}
            <a href="{{ route('messages.index') }}"
               style="background: #f8fafc; border: 1px solid #e2e8f0; color: #64748b;
                      width: 36px; height: 36px; border-radius: 0.6rem; display: flex; align-items: center; justify-content: center;
                      text-decoration: none; transition: all 0.2s ease; position: relative;"
               title="Messages"
               onmouseover="this.style.background='#f0fdfa'; this.style.color='#0d9488'; this.style.borderColor='#99f6e4';"
               onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b'; this.style.borderColor='#e2e8f0';">
                <i class="fas fa-comment-dots"></i>
                @if($unreadMsgCount > 0)
                    <span style="position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; font-size: 0.6rem;
                                 font-weight: 800; padding: 0.1rem 0.35rem; border-radius: 50%; min-width: 16px; text-align: center;">{{ $unreadMsgCount }}</span>
                @endif
            </a>

            {{-- Notifications --}}
            <div class="dropdown">
                <button type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    style="background: #f8fafc; border: 1px solid #e2e8f0; color: #64748b;
                           width: 36px; height: 36px; border-radius: 0.6rem; display: flex; align-items: center; justify-content: center;
                           cursor: pointer; transition: all 0.2s ease; position: relative;"
                    title="Notifications"
                    onmouseover="this.style.background='#f0fdfa'; this.style.color='#0d9488'; this.style.borderColor='#99f6e4';"
                    onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b'; this.style.borderColor='#e2e8f0';">
                    <i class="fas fa-bell" id="notification-badge-bell"></i>
                    <span id="notification-badge" style="position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; font-size: 0.6rem;
                                                          font-weight: 800; padding: 0.1rem 0.35rem; border-radius: 50%; min-width: 16px; text-align: center; display: none;">0</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.8rem; min-width: 300px; max-height: 400px; overflow-y: auto; padding: 0; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.1) !important;">
                    <li style="padding: 0.85rem 1.1rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                        <strong style="color: #0f172a; font-size: 0.88rem;">Notifications</strong>
                        <a href="{{ route('notifications.index') }}" style="font-size: 0.75rem; color: #0d9488; text-decoration: none; font-weight: 700;">View All</a>
                    </li>
                    <ul id="notifications-menu-container" style="list-style: none; margin: 0; padding: 0.5rem 0;"></ul>
                </ul>
            </div>

            {{-- User --}}
            <div class="dropdown">
                <button type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    style="display: flex; align-items: center; gap: 0.4rem; background: #f8fafc; border: 1px solid #e2e8f0;
                           padding: 0.3rem 0.5rem 0.3rem 0.35rem; border-radius: 2rem; cursor: pointer; transition: all 0.2s ease;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #0d9488 0%, #10b981 100%);
                                display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 0.75rem; flex-shrink: 0;">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <span class="d-none d-lg-inline" style="font-size: 0.82rem; font-weight: 700; color: #0f172a;">{{ Str::limit(auth()->user()->name, 14) }}</span>
                    <i class="fas fa-chevron-down d-none d-lg-inline" style="font-size: 0.6rem; color: #64748b;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.8rem; min-width: 210px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.1) !important;">
                    <li style="padding: 0.75rem 1rem; border-bottom: 1px solid #f1f5f9;">
                        <div style="color: #0f172a; font-weight: 700; font-size: 0.88rem;">{{ auth()->user()->name }}</div>
                        <small style="color: #0d9488; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Verified Seller</small>
                    </li>
                    <li style="padding: 0.35rem 0;">
                        <a href="{{ route('profile') }}" style="display: flex; align-items: center; gap: 0.65rem; padding: 0.6rem 1rem; color: #475569; text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a';" onmouseout="this.style.background='transparent'; this.style.color='#475569';"><i class="fas fa-user-circle" style="width: 18px; color: #0d9488;"></i> Profile</a>
                        <a href="{{ route('settings') }}" style="display: flex; align-items: center; gap: 0.65rem; padding: 0.6rem 1rem; color: #475569; text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a';" onmouseout="this.style.background='transparent'; this.style.color='#475569';"><i class="fas fa-cog" style="width: 18px; color: #64748b;"></i> Settings</a>
                        <a href="{{ route('seller.listings') }}" style="display: flex; align-items: center; gap: 0.65rem; padding: 0.6rem 1rem; color: #475569; text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a';" onmouseout="this.style.background='transparent'; this.style.color='#475569';"><i class="fas fa-boxes-stacked" style="width: 18px; color: #0284c7;"></i> My Inventory</a>
                        <a href="{{ route('listings.create') }}" style="display: flex; align-items: center; gap: 0.65rem; padding: 0.6rem 1rem; color: #475569; text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a';" onmouseout="this.style.background='transparent'; this.style.color='#475569';"><i class="fas fa-plus-circle" style="width: 18px; color: #059669;"></i> List New Tech</a>
                    </li>
                    <li style="border-top: 1px solid #f1f5f9; padding: 0.35rem 0;">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 0.65rem; padding: 0.6rem 1rem; background: transparent; border: none; color: #ef4444; font-size: 0.88rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#fef2f2';" onmouseout="this.style.background='transparent';"><i class="fas fa-sign-out-alt" style="width: 18px; color: #ef4444;"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Seller Sidebar --}}
    @include('seller.sidebar')

    {{-- Main Content Wrapper --}}
    <div class="main-content-wrapper" style="padding-top: 60px; min-height: 100vh;">
        @include('layouts.partials.flash-messages', ['topOffset' => '75px'])
        <main style="padding: 0;">
            @yield('content')
        </main>
    </div>

    @include('layouts.partials.mobile-bottom-nav')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('layouts.partials.notification-script')
    @yield('scripts')
</body>
@endsection

{{-- Mobile Bottom Nav Bar (shared by buyer/public layouts) --}}
@php $unreadMsgCount = $unreadMsgCount ?? (auth()->check() ? auth()->user()->unreadMessagesCount() : 0); @endphp
<style>
    .mobile-bottom-nav {
        position: fixed; bottom: 0; left: 0; right: 0; z-index: 1030;
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-top: 1px solid rgba(13,148,136,0.3);
        display: flex; align-items: center; justify-content: space-around;
        padding: 0.6rem 0.5rem calc(0.6rem + env(safe-area-inset-bottom));
        box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
        backdrop-filter: blur(10px);
    }
    .mobile-nav-item {
        display: flex; flex-direction: column; align-items: center; gap: 0.25rem;
        color: #64748b; text-decoration: none; font-size: 0.68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px;
        transition: all 0.2s ease; padding: 0.35rem 0.75rem; border-radius: 0.75rem;
        min-width: 52px; text-align: center; position: relative;
    }
    .mobile-nav-item i { font-size: 1.25rem; transition: transform 0.2s ease; }
    .mobile-nav-item:hover, .mobile-nav-item.active { color: #2dd4bf; }
    .mobile-nav-item:hover i, .mobile-nav-item.active i { transform: translateY(-2px); }
    .mobile-nav-item.active { background: rgba(13,148,136,0.12); }
    .mobile-nav-sell { position: relative; }
    .mobile-nav-sell-btn {
        width: 48px; height: 48px; border-radius: 50%;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 15px rgba(13,148,136,0.5);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-bottom: 0.1rem;
    }
    .mobile-nav-sell-btn i { color: #ffffff; font-size: 1.25rem; }
    .mobile-nav-sell:hover .mobile-nav-sell-btn { transform: scale(1.1); box-shadow: 0 8px 25px rgba(13,148,136,0.6); }
    .mobile-nav-badge {
        position: absolute; top: 2px; right: 6px;
        background: #ef4444; color: white; font-size: 0.6rem; font-weight: 800;
        padding: 0.1rem 0.35rem; border-radius: 50%; min-width: 16px; text-align: center;
    }
    .mobile-nav-avatar { width: 24px; height: 24px; border-radius: 50%; object-fit: cover; border: 2px solid #2dd4bf; }
</style>
<nav class="mobile-bottom-nav d-md-none" aria-label="Mobile Bottom Navigation">
    <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="fas fa-house"></i><span>Home</span>
    </a>
    <a href="{{ route('listings.index') }}" class="mobile-nav-item {{ request()->routeIs('listings.index') ? 'active' : '' }}">
        <i class="fas fa-store"></i><span>Explore</span>
    </a>
    @if(auth()->check() && auth()->user()->isBuyer())
        <a href="{{ route('buyer.dashboard') }}" class="mobile-nav-item mobile-nav-sell" title="My Orders">
            <div class="mobile-nav-sell-btn"><i class="fas fa-bag-shopping"></i></div>
            <span>Orders</span>
        </a>
    @elseif(!auth()->check() || auth()->user()->isSeller())
        <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="mobile-nav-item mobile-nav-sell" title="Sell Tech">
            <div class="mobile-nav-sell-btn"><i class="fas fa-plus"></i></div>
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
        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isSeller() ? route('seller.dashboard') : route('buyer.dashboard')) }}"
           class="mobile-nav-item {{ request()->routeIs('*.dashboard') || request()->routeIs('profile') ? 'active' : '' }}">
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="mobile-nav-avatar">
            @else
                <i class="fas fa-circle-user"></i>
            @endif
            <span>Account</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="mobile-nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
            <i class="fas fa-arrow-right-to-bracket"></i><span>Sign In</span>
        </a>
    @endauth
</nav>

<!-- Modernized Buyer Dashboard Sidebar -->
<style>
    :root {
        --buyer-sidebar-w: 260px;
    }

    .buyer-sidebar {
        position: fixed;
        left: 0;
        top: 60px;
        width: var(--buyer-sidebar-w);
        height: calc(100vh - 60px);
        background: #ffffff;
        border-right: 1px solid rgba(226, 232, 240, 0.8);
        display: flex;
        flex-direction: column;
        z-index: 1025;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease, width 0.25s ease;
        box-shadow: 2px 0 16px rgba(15, 23, 42, 0.03);
    }

    body.dark-mode .buyer-sidebar {
        background: #09171f;
        border-right-color: rgba(13, 148, 136, 0.2);
        box-shadow: 2px 0 20px rgba(0, 0, 0, 0.3);
    }
    
    .buyer-sidebar.hidden {
        transform: translateX(-100%);
        opacity: 0;
        pointer-events: none;
    }
    
    .buyer-sidebar::-webkit-scrollbar {
        width: 4px;
    }
    .buyer-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    .buyer-sidebar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 4px;
    }
    body.dark-mode .buyer-sidebar::-webkit-scrollbar-thumb {
        background: rgba(13, 148, 136, 0.25);
    }

    .buyer-nav-section-title {
        padding: 1.25rem 1.25rem 0.4rem;
        color: #94a3b8;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 800;
        margin: 0;
    }

    body.dark-mode .buyer-nav-section-title {
        color: #64748b;
    }

    .buyer-sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.7rem 1.25rem;
        color: #475569;
        text-decoration: none;
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 0.88rem;
        position: relative;
    }
    
    .buyer-sidebar-link:hover {
        background-color: #f8fafc;
        color: #0d9488;
        padding-left: 1.45rem;
    }

    body.dark-mode .buyer-sidebar-link {
        color: #94a3b8;
    }

    body.dark-mode .buyer-sidebar-link:hover {
        background: rgba(13, 148, 136, 0.08);
        color: #ffffff;
        padding-left: 1.45rem;
    }
    
    .buyer-sidebar-link.active {
        color: #0d9488;
        background-color: #f0fdfa;
        border-left-color: #0d9488;
        font-weight: 700;
    }

    body.dark-mode .buyer-sidebar-link.active {
        color: #2dd4bf;
        background: rgba(13, 148, 136, 0.15);
        border-left-color: #14b8a6;
    }
    
    .buyer-sidebar-link i {
        font-size: 1rem;
        width: 20px;
        text-align: center;
        color: inherit;
        transition: transform 0.2s ease;
    }

    .buyer-sidebar-link:hover i {
        transform: scale(1.1);
    }

    .buyer-sidebar-badge {
        margin-left: auto;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 0.2rem 0.55rem;
        border-radius: 2rem;
        line-height: 1;
    }

    .buyer-user-card {
        padding: 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    body.dark-mode .buyer-user-card {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom-color: rgba(13, 148, 136, 0.2);
    }

    .buyer-avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
        flex-shrink: 0;
    }

    @media (max-width: 991.98px) {
        .buyer-sidebar {
            transform: translateX(-100%) !important;
            opacity: 0 !important;
            pointer-events: none !important;
            z-index: 1045 !important;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.4);
            top: 56px !important;
            height: calc(100vh - 56px) !important;
        }
        .buyer-sidebar.show-mobile {
            transform: translateX(0) !important;
            opacity: 1 !important;
            pointer-events: auto !important;
        }
    }
</style>

<!-- Mobile Overlay Backdrop -->
<div class="buyer-sidebar-backdrop" onclick="closeBuyerSidebar()" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1040; backdrop-filter: blur(3px);"></div>

<!-- Buyer Sidebar Navigation -->
<aside class="buyer-sidebar">
    <!-- User Profile Header -->
    <div class="buyer-user-card">
        <div class="buyer-avatar-circle">
            {{ strtoupper(substr(auth()->user()->name ?? 'B', 0, 1)) }}
        </div>
        <div style="overflow: hidden; flex: 1;">
            <div style="display: flex; align-items: center; gap: 0.35rem;">
                <strong style="font-size: 0.9rem; font-weight: 800; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;" class="buyer-name-text">
                    {{ auth()->user()->name ?? 'Buyer Account' }}
                </strong>
            </div>
            <div style="display: flex; align-items: center; gap: 0.35rem; margin-top: 0.15rem;">
                @if(auth()->user()->is_verified ?? false)
                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; font-weight: 800; font-size: 0.68rem; padding: 0.2rem 0.5rem; border-radius: 1rem;">
                        <i class="fas fa-check-circle me-1"></i>Verified
                    </span>
                @else
                    <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706; font-weight: 800; font-size: 0.68rem; padding: 0.2rem 0.5rem; border-radius: 1rem;">
                        <i class="fas fa-clock me-1"></i>Pending ID
                    </span>
                @endif
                <span style="color: #94a3b8; font-size: 0.72rem;">• Buyer Hub</span>
            </div>
        </div>
    </div>

    <!-- Navigation Body -->
    <nav style="flex: 1; overflow-y: auto; padding: 0.5rem 0;">
        <p class="buyer-nav-section-title">Main Portal</p>
        
        <a href="{{ route('buyer.dashboard') }}" class="buyer-sidebar-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('messages.index') }}" class="buyer-sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
            <i class="fas fa-comments"></i>
            <span>Messages</span>
            @php
                $unreadCount = auth()->check() ? \App\Models\Message::where('receiver_id', auth()->id())->whereNull('read_at')->count() : 0;
            @endphp
            @if($unreadCount > 0)
                <span class="buyer-sidebar-badge" style="background: #ef4444; color: #ffffff;">{{ $unreadCount }}</span>
            @endif
        </a>

        <p class="buyer-nav-section-title">Marketplace</p>
        
        <a href="{{ route('listings.index') }}" class="buyer-sidebar-link {{ request()->routeIs('listings.index') || request()->routeIs('listings.search') ? 'active' : '' }}">
            <i class="fas fa-store"></i>
            <span>Browse Items</span>
        </a>
        
        <a href="{{ route('buyer.saved-items') }}" class="buyer-sidebar-link {{ request()->routeIs('buyer.saved-items') ? 'active' : '' }}">
            <i class="fas fa-bookmark"></i>
            <span>Saved Items</span>
        </a>

        <p class="buyer-nav-section-title">Activity & Orders</p>
        
        <a href="{{ route('buyer.transaction-history') }}" class="buyer-sidebar-link {{ request()->routeIs('buyer.transaction-history') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i>
            <span>My Offers & History</span>
        </a>
        
        <a href="{{ route('addresses.index') }}" class="buyer-sidebar-link {{ request()->routeIs('addresses.*') ? 'active' : '' }}">
            <i class="fas fa-map-location-dot"></i>
            <span>Shipping Addresses</span>
        </a>

        <p class="buyer-nav-section-title">Account Settings</p>
        
        <a href="{{ route('settings') }}" class="buyer-sidebar-link {{ request()->routeIs('settings') ? 'active' : '' }}">
            <i class="fas fa-gear"></i>
            <span>Settings</span>
        </a>
        
        <a href="{{ route('profile') }}" class="buyer-sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fas fa-user-gear"></i>
            <span>My Profile</span>
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div style="padding: 1rem; border-top: 1px solid #f1f5f9; background: #ffffff;" class="buyer-sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.6rem; background: rgba(239, 68, 68, 0.08); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 0.65rem; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(239,68,68,0.15)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
                <i class="fas fa-arrow-right-from-bracket"></i>
                <span>Sign Out</span>
            </button>
        </form>
    </div>
</aside>

<script>
    function toggleBuyerSidebar() {
        const sidebar = document.querySelector('.buyer-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const backdrop = document.querySelector('.buyer-sidebar-backdrop');
        const isMobile = window.innerWidth < 992;
        
        if (isMobile) {
            const isOpen = sidebar.classList.toggle('show-mobile');
            if (backdrop) backdrop.style.display = isOpen ? 'block' : 'none';
        } else {
            const isHidden = sidebar.classList.toggle('hidden');
            if (mainContent) {
                mainContent.style.marginLeft = isHidden ? '0' : '260px';
                mainContent.style.width = isHidden ? '100%' : 'calc(100% - 260px)';
            }
            localStorage.setItem('buyerSidebarHidden', isHidden ? 'true' : 'false');
        }
    }

    function closeBuyerSidebar() {
        const sidebar = document.querySelector('.buyer-sidebar');
        const backdrop = document.querySelector('.buyer-sidebar-backdrop');
        if (sidebar) sidebar.classList.remove('show-mobile');
        if (backdrop) backdrop.style.display = 'none';
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeBuyerSidebar();
        }
    });
    
    // Restore sidebar state on desktop load
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.buyer-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const isMobile = window.innerWidth < 992;
        
        if (!isMobile && sidebar) {
            const isHidden = localStorage.getItem('buyerSidebarHidden') === 'true';
            if (isHidden) {
                sidebar.classList.add('hidden');
                if (mainContent) { mainContent.style.marginLeft = '0'; mainContent.style.width = '100%'; }
            } else {
                sidebar.classList.remove('hidden');
                if (mainContent) { mainContent.style.marginLeft = '260px'; mainContent.style.width = 'calc(100% - 260px)'; }
            }
        }
    });
</script>

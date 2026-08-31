<!-- Modern Obsidian Seller Sidebar Navigation -->
<style>
    :root {
        --seller-sidebar-w: 260px;
    }

    .seller-sidebar {
        position: fixed;
        left: 0;
        top: 60px;
        width: var(--seller-sidebar-w);
        height: calc(100vh - 60px);
        background: #09171f;
        border-right: 1px solid rgba(13, 148, 136, 0.2);
        display: flex;
        flex-direction: column;
        z-index: 1025;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease, width 0.25s ease;
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25);
    }

    body.dark-mode .seller-sidebar {
        background: #060e14;
        border-right-color: rgba(13, 148, 136, 0.25);
    }
    
    .seller-sidebar.hidden {
        transform: translateX(-100%);
        pointer-events: none;
    }

    .main-content-wrapper {
        margin-left: var(--seller-sidebar-w, 260px);
        width: calc(100% - var(--seller-sidebar-w, 260px));
        transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1), width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: calc(100vh - 60px);
    }

    @media (max-width: 991.98px) {
        .main-content-wrapper {
            margin-left: 0 !important;
            width: 100% !important;
        }
    }
    
    .seller-sidebar::-webkit-scrollbar {
        width: 4px;
    }
    .seller-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    .seller-sidebar::-webkit-scrollbar-thumb {
        background: rgba(13, 148, 136, 0.3);
        border-radius: 4px;
    }
    
    .seller-sidebar-header {
        padding: 1.15rem 1.25rem;
        background: #060e14;
        border-bottom: 1px solid rgba(13, 148, 136, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .seller-brand-wrap {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .seller-brand-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #0d9488 0%, #10b981 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.05rem;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .seller-brand-text h6 {
        color: #ffffff;
        font-weight: 900;
        font-size: 1rem;
        margin: 0;
        letter-spacing: -0.3px;
        line-height: 1.2;
    }

    .seller-brand-text span {
        color: #10b981;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .sidebar-section-title {
        padding: 1.15rem 1.25rem 0.35rem;
        color: #64748b;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 800;
        margin: 0;
    }

    .sidebar-nav-container {
        flex: 1;
        overflow-y: auto;
        padding: 0.5rem 0.75rem;
    }
    
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.65rem 0.9rem;
        color: #94a3b8;
        text-decoration: none;
        border-radius: 0.6rem;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        font-size: 0.88rem;
        margin-bottom: 0.2rem;
        position: relative;
        border-left: 3px solid transparent;
    }
    
    .sidebar-link:hover {
        background-color: rgba(13, 148, 136, 0.08);
        color: #ffffff;
        padding-left: 1.1rem;
    }
    
    .sidebar-link.active {
        color: #2dd4bf;
        background: linear-gradient(90deg, rgba(13, 148, 136, 0.2) 0%, rgba(13, 148, 136, 0.02) 100%);
        border-left-color: #10b981;
        font-weight: 800;
    }

    .sidebar-link .nav-icon-box {
        width: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: inherit;
    }

    .sidebar-link .badge-counter {
        margin-left: auto;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 0.2rem 0.55rem;
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.08);
        color: #cbd5e1;
    }

    .sidebar-link.active .badge-counter {
        background: rgba(16, 185, 129, 0.25);
        color: #2dd4bf;
    }

    .seller-sidebar-footer {
        padding: 0.85rem 1rem;
        border-top: 1px solid rgba(13, 148, 136, 0.2);
        background: #060e14;
        margin-top: auto;
    }

    .seller-sidebar-footer button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.6rem;
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.25);
        border-radius: 0.55rem;
        font-weight: 700;
        font-size: 0.84rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .seller-sidebar-footer button:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
    }

    @media (max-width: 991.98px) {
        .seller-sidebar {
            top: 0 !important;
            height: 100vh !important;
            transform: translateX(-100%) !important;
            opacity: 0 !important;
            pointer-events: none !important;
            z-index: 1050 !important;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.6);
        }
        .seller-sidebar.show-mobile {
            transform: translateX(0) !important;
            opacity: 1 !important;
            pointer-events: auto !important;
        }
    }
</style>

<div class="sidebar-backdrop" onclick="closeSellerSidebar()" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.65); z-index: 1045; backdrop-filter: blur(4px);"></div>

<aside class="seller-sidebar" aria-label="Seller Panel Sidebar">
    <!-- Sidebar Header -->
    <div class="seller-sidebar-header">
        <a href="{{ route('seller.dashboard') }}" class="seller-brand-wrap text-decoration-none">
            <div class="seller-brand-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="seller-brand-text">
                <h6>Seller Studio</h6>
                <span>E-Benta Platform</span>
            </div>
        </a>
        <button type="button" class="d-lg-none" onclick="closeSellerSidebar()" aria-label="Close Sidebar" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 0.45rem; color: #94a3b8; font-size: 1rem; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="sidebar-nav-container">
        <p class="sidebar-section-title">Operations Hub</p>
        <a href="{{ route('seller.dashboard') }}" class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-chart-pie"></i></span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('seller.listings') }}" class="sidebar-link {{ request()->routeIs('seller.listings') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-boxes-stacked"></i></span>
            <span>My Inventory</span>
        </a>
        <a href="{{ route('messages.index') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-comments"></i></span>
            <span>Messages</span>
        </a>

        <p class="sidebar-section-title">Sales & Orders</p>
        <a href="{{ route('seller.sales-analytics') }}" class="sidebar-link {{ request()->routeIs('seller.sales-analytics') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-chart-line"></i></span>
            <span>Sales Analytics</span>
        </a>
        <a href="{{ route('seller.transaction-history') }}" class="sidebar-link {{ request()->routeIs('seller.transaction-history') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-receipt"></i></span>
            <span>Sales History</span>
        </a>

        <p class="sidebar-section-title">Account & Logistics</p>
        <a href="{{ route('addresses.index') }}" class="sidebar-link {{ request()->routeIs('addresses.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-location-dot"></i></span>
            <span>Pickup Addresses</span>
        </a>
        <a href="{{ route('settings') }}" class="sidebar-link {{ request()->routeIs('settings*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-sliders"></i></span>
            <span>Account Settings</span>
        </a>
    </nav>

    <!-- Footer Profile & Logout -->
    <div class="seller-sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit">
                <i class="fas fa-arrow-right-from-bracket"></i>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>

<script>
    function toggleSellerSidebar() {
        const sidebar = document.querySelector('.seller-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const backdrop = document.querySelector('.sidebar-backdrop');
        const isMobile = window.innerWidth < 992;
        
        if (isMobile) {
            const isOpen = sidebar.classList.toggle('show-mobile');
            if (backdrop) backdrop.style.display = isOpen ? 'block' : 'none';
        } else {
            const isHidden = sidebar.classList.toggle('hidden');
            if (mainContent) {
                mainContent.style.marginLeft = isHidden ? '0' : 'var(--seller-sidebar-w, 260px)';
                mainContent.style.width = isHidden ? '100%' : 'calc(100% - var(--seller-sidebar-w, 260px))';
            }
            localStorage.setItem('sellerSidebarHidden', isHidden ? 'true' : 'false');
        }
    }

    function closeSellerSidebar() {
        const sidebar = document.querySelector('.seller-sidebar');
        const backdrop = document.querySelector('.sidebar-backdrop');
        if (sidebar) sidebar.classList.remove('show-mobile');
        if (backdrop) backdrop.style.display = 'none';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSellerSidebar();
        }
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.seller-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const isMobile = window.innerWidth < 992;
        
        if (!isMobile) {
            const isHidden = localStorage.getItem('sellerSidebarHidden') === 'true';
            if (isHidden) {
                if (sidebar) sidebar.classList.add('hidden');
                if (mainContent) { mainContent.style.marginLeft = '0'; mainContent.style.width = '100%'; }
            } else {
                if (sidebar) sidebar.classList.remove('hidden');
                if (mainContent) { mainContent.style.marginLeft = '260px'; mainContent.style.width = 'calc(100% - 260px)'; }
            }
        }
    });
</script>

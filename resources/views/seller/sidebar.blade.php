<!-- Seller Dashboard Sidebar -->
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
        background: #ffffff;
        border-right: 1px solid rgba(226, 232, 240, 0.8);
        display: flex;
        flex-direction: column;
        z-index: 1025;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease, width 0.25s ease;
        box-shadow: 2px 0 16px rgba(15, 23, 42, 0.03);
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
        background: #e2e8f0;
        border-radius: 4px;
    }
    
    .seller-sidebar-toggle-btn {
        position: fixed;
        left: 12px;
        top: 72px;
        z-index: 1030;
        width: 38px;
        height: 38px;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.6rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-size: 1rem;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
    }
    
    .seller-sidebar-toggle-btn:hover {
        background-color: #f0fdfa;
        color: #0d9488;
        border-color: #99f6e4;
        transform: scale(1.04);
    }

    .seller-sidebar:not(.hidden) ~ .seller-sidebar-toggle-btn {
        left: calc(var(--seller-sidebar-w) + 12px);
    }
    
    .seller-sidebar-header {
        padding: 1.1rem 1.25rem;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
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
        border-radius: 0.55rem;
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.05rem;
        box-shadow: 0 4px 10px rgba(13, 148, 136, 0.3);
    }

    .seller-brand-text h6 {
        color: #ffffff;
        font-weight: 800;
        font-size: 0.95rem;
        margin: 0;
        letter-spacing: -0.2px;
        line-height: 1.2;
    }

    .seller-brand-text span {
        color: #2dd4bf;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .sidebar-section-title {
        padding: 1.1rem 1.25rem 0.35rem;
        color: #94a3b8;
        font-size: 0.68rem;
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
        color: #475569;
        text-decoration: none;
        border-radius: 0.6rem;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        font-size: 0.88rem;
        margin-bottom: 0.15rem;
        position: relative;
    }
    
    .sidebar-link:hover {
        background-color: #f1f5f9;
        color: #0d9488;
        transform: translateX(2px);
    }
    
    .sidebar-link.active {
        color: #0d9488;
        background: #f0fdfa;
        font-weight: 700;
        box-shadow: inset 3px 0 0 #0d9488;
    }

    .sidebar-link .nav-icon-box {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.45rem;
        font-size: 0.95rem;
        color: #64748b;
        transition: all 0.2s ease;
    }

    .sidebar-link:hover .nav-icon-box {
        color: #0d9488;
        background: rgba(13, 148, 136, 0.08);
    }

    .sidebar-link.active .nav-icon-box {
        color: #0d9488;
        background: rgba(13, 148, 136, 0.12);
    }

    .sidebar-link .badge-counter {
        margin-left: auto;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 0.2rem 0.55rem;
        border-radius: 1rem;
        background: #f1f5f9;
        color: #475569;
    }

    .sidebar-link.active .badge-counter {
        background: rgba(13, 148, 136, 0.15);
        color: #0d9488;
    }

    .seller-sidebar-footer {
        padding: 0.85rem 1rem;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        background: #fafafa;
        margin-top: auto;
    }

    .seller-sidebar-footer button {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.6rem;
        background: rgba(239, 68, 68, 0.08);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
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
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }

    @media (max-width: 991.98px) {
        .seller-sidebar {
            top: 0 !important;
            height: 100vh !important;
            transform: translateX(-100%) !important;
            opacity: 0 !important;
            pointer-events: none !important;
            z-index: 1050 !important;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.35);
        }
        .seller-sidebar.show-mobile {
            transform: translateX(0) !important;
            opacity: 1 !important;
            pointer-events: auto !important;
        }
        .seller-sidebar-toggle-btn {
            left: 12px !important;
            top: 68px !important;
        }
        .seller-sidebar:not(.hidden) ~ .seller-sidebar-toggle-btn {
            left: 12px !important;
        }
    }

    /* Dark mode */
    body.dark-mode .seller-sidebar {
        background: #1e293b;
        border-color: rgba(255, 255, 255, 0.08);
    }
    body.dark-mode .seller-sidebar-toggle-btn {
        background: #1e293b;
        border-color: rgba(255, 255, 255, 0.12);
        color: #94a3b8;
    }
    body.dark-mode .sidebar-link {
        color: #94a3b8;
    }
    body.dark-mode .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #2dd4bf;
    }
    body.dark-mode .sidebar-link.active {
        background: rgba(13, 148, 136, 0.15);
        color: #2dd4bf;
    }
    body.dark-mode .seller-sidebar-footer {
        background: #182234;
        border-color: rgba(255, 255, 255, 0.08);
    }
</style>

<div class="sidebar-backdrop" onclick="closeSellerSidebar()" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 1045; backdrop-filter: blur(4px);"></div>

<aside class="seller-sidebar" aria-label="Seller Panel Sidebar">
    <!-- Sidebar Header -->
    <div class="seller-sidebar-header">
        <div class="seller-brand-wrap">
            <div class="seller-brand-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="seller-brand-text">
                <h6>Seller Studio</h6>
                <span>E-Benta Platform</span>
            </div>
        </div>
        <button type="button" class="d-lg-none" onclick="closeSellerSidebar()" aria-label="Close Sidebar" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 0.45rem; color: #cbd5e1; font-size: 1rem; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="sidebar-nav-container">
        <p class="sidebar-section-title">Overview</p>
        <a href="{{ route('seller.dashboard') }}" class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-chart-pie"></i></span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('messages.index') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-comments"></i></span>
            <span>Messages</span>
        </a>

        <p class="sidebar-section-title">Inventory</p>
        <a href="{{ route('listings.create') }}" class="sidebar-link {{ request()->routeIs('listings.create') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-plus-circle"></i></span>
            <span>Create Listing</span>
        </a>
        <a href="{{ route('seller.listings') }}" class="sidebar-link {{ request()->routeIs('seller.listings') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-boxes-stacked"></i></span>
            <span>My Listings</span>
        </a>

        <p class="sidebar-section-title">Analytics & Sales</p>
        <a href="{{ route('seller.sales-analytics') }}" class="sidebar-link {{ request()->routeIs('seller.sales-analytics') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-chart-line"></i></span>
            <span>Sales Analytics</span>
        </a>
        <a href="{{ route('seller.transaction-history') }}" class="sidebar-link {{ request()->routeIs('seller.transaction-history') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-receipt"></i></span>
            <span>Sales History</span>
        </a>
        <a href="{{ route('addresses.index') }}" class="sidebar-link {{ request()->routeIs('addresses.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-location-dot"></i></span>
            <span>Pickup Addresses</span>
        </a>

        <p class="sidebar-section-title">Preferences</p>
        <a href="{{ route('settings') }}" class="sidebar-link {{ request()->routeIs('settings') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-sliders"></i></span>
            <span>Settings</span>
        </a>
        <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="fas fa-user-gear"></i></span>
            <span>My Profile</span>
        </a>
    </nav>

    <!-- Footer -->
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

<button class="seller-sidebar-toggle-btn" onclick="toggleSellerSidebar()" title="Toggle Sidebar Navigation" aria-label="Toggle Sidebar Navigation">
    <i class="fas fa-bars"></i>
</button>

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

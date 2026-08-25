<!-- Seller Dashboard Sidebar -->
<style>
    .seller-sidebar {
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: #ffffff;
        border-right: 1px solid #e2e8f0;
    }
    
    .seller-sidebar.hidden {
        transform: translateX(-100%);
        opacity: 0;
        pointer-events: none;
    }
    
    .seller-sidebar::-webkit-scrollbar {
        width: 2px;
    }
    .seller-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    .seller-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .seller-sidebar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    .seller-sidebar-toggle-btn {
        position: fixed;
        left: 270px;
        top: 10px;
        z-index: 1025;
        width: 40px;
        height: 40px;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 1.1rem;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .seller-sidebar-toggle-btn:hover {
        background-color: #f8fafc;
        color: #0d9488;
    }
    
    .seller-sidebar.hidden + .seller-sidebar-toggle-btn {
        left: 10px;
    }
    
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1.5rem;
        color: #64748b;
        text-decoration: none;
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 0.95rem;
    }
    
    .sidebar-link:hover {
        background-color: #f8fafc;
        color: #0d9488;
    }
    
    .sidebar-link.active {
        color: #0d9488;
        background-color: #f0fdfa;
        border-left-color: #0d9488;
        font-weight: 600;
    }
    
    .sidebar-link i {
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
        color: inherit;
    }
    
    .sidebar-section-title {
        padding: 1.5rem 1.5rem 0.5rem;
        color: #94a3b8;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        margin: 0;
    @media (max-width: 991.98px) {
        .seller-sidebar {
            transform: translateX(-100%) !important;
            opacity: 0 !important;
            pointer-events: none !important;
            transition: transform 0.25s ease, opacity 0.25s ease !important;
            z-index: 1045 !important;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.4);
        }
        .seller-sidebar.show-mobile {
            transform: translateX(0) !important;
            opacity: 1 !important;
            pointer-events: auto !important;
        }
        .seller-sidebar-toggle-btn {
            left: 12px !important;
            top: 8px !important;
            z-index: 1025;
        }
    }
</style>
<div class="sidebar-backdrop" onclick="closeSellerSidebar()" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1040; backdrop-filter: blur(3px);"></div>
<div class="seller-sidebar" style="position: fixed; left: 0; top: 0; width: 260px; height: 100vh; display: flex; flex-direction: column; z-index: 1045; overflow-y: auto;">
    <!-- Sidebar Header -->
    <div style="padding: 1.5rem; border-bottom: 2px solid transparent; border-image: linear-gradient(90deg, #0d9488 0%, #06b6d4 50%, #0d9488 100%); border-image-slice: 1; display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; background: linear-gradient(135deg, #1e293b 0%, #233651 100%);">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-shop" style="font-size: 1.5rem; color: #0d9488;"></i>
            <div>
                <h6 style="color: #ffffff; font-weight: 700; margin: 0; font-size: 1.1rem;">Seller Panel</h6>
                <small style="color: #cbd5e1; font-size: 0.75rem;">E-Benta Platform</small>
            </div>
        </div>
        <button type="button" class="d-lg-none" onclick="closeSellerSidebar()" style="background: none; border: none; color: #cbd5e1; font-size: 1.25rem; padding: 0.25rem 0.5rem; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav style="flex: 1; overflow-y: auto; padding: 1rem 0;">
        <p class="sidebar-section-title">Main</p>
        <a href="{{ route('seller.dashboard') }}" class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <p class="sidebar-section-title">Listings</p>
        <a href="{{ route('listings.create') }}" class="sidebar-link {{ request()->routeIs('listings.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i>
            <span>Create Listing</span>
        </a>
        <a href="{{ route('seller.listings') }}" class="sidebar-link {{ request()->routeIs('seller.listings') ? 'active' : '' }}">
            <i class="fas fa-list"></i>
            <span>My Listings</span>
        </a>

        <p class="sidebar-section-title">Analytics</p>
        <a href="{{ route('seller.sales-analytics') }}" class="sidebar-link {{ request()->routeIs('seller.sales-analytics') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Sales Analytics</span>
        </a>
        <a href="{{ route('seller.transaction-history') }}" class="sidebar-link {{ request()->routeIs('seller.transaction-history') ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>Sales History</span>
        </a>
        <a href="{{ route('addresses.index') }}" class="sidebar-link">
            <i class="fas fa-map-marker-alt"></i>
            <span>Manage Addresses</span>
        </a>

        <p class="sidebar-section-title">Settings</p>
        <a href="{{ route('settings') }}" class="sidebar-link {{ request()->routeIs('settings') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i>
            <span>My Profile</span>
        </a>
    </nav>

    <!-- Footer -->
    <div style="padding: 0.75rem 1rem; border-top: 2px solid transparent; border-image: linear-gradient(90deg, #0d9488 0%, #06b6d4 50%, #0d9488 100%); border-image-slice: 1; background: linear-gradient(135deg, #1e293b 0%, #233651 100%); margin-top: auto;">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.5rem; background: rgba(239, 68, 68, 0.1); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 0.5rem; font-weight: 500; cursor: pointer; transition: all 0.2s ease;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
<button class="seller-sidebar-toggle-btn" onclick="toggleSellerSidebar()" title="Toggle Sidebar">
    <i class="fas fa-bars"></i>
</button>

<script>
    function toggleSellerSidebar() {
        const sidebar = document.querySelector('.seller-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const navbar = document.querySelector('.navbar');
        const backdrop = document.querySelector('.sidebar-backdrop');
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
            if (navbar) {
                navbar.style.left = isHidden ? '0' : '260px';
                navbar.style.width = isHidden ? '100%' : 'calc(100% - 260px)';
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
    
    // Restore sidebar state on page load
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.seller-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const navbar = document.querySelector('.navbar');
        const isMobile = window.innerWidth < 992;
        
        if (!isMobile) {
            const isHidden = localStorage.getItem('sellerSidebarHidden') === 'true';
            if (isHidden) {
                if (sidebar) sidebar.classList.add('hidden');
                if (mainContent) { mainContent.style.marginLeft = '0'; mainContent.style.width = '100%'; }
                if (navbar) { navbar.style.left = '0'; navbar.style.width = '100%'; }
            } else {
                if (sidebar) sidebar.classList.remove('hidden');
                if (mainContent) { mainContent.style.marginLeft = '260px'; mainContent.style.width = 'calc(100% - 260px)'; }
                if (navbar) { navbar.style.left = '260px'; navbar.style.width = 'calc(100% - 260px)'; }
            }
        }
    });
</script>

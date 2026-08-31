<!-- Admin Sidebar Navigation -->
<style>
    .admin-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 260px;
        height: 100vh;
        display: flex;
        flex-direction: column;
        z-index: 1040;
        background: #09171f;
        border-right: 1px solid rgba(13, 148, 136, 0.2);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s ease;
        overflow-y: auto;
    }

    body.dark-mode .admin-sidebar {
        background: #060e14;
        border-right-color: rgba(13, 148, 136, 0.25);
    }
    
    .admin-sidebar.hidden {
        transform: translateX(-100%);
        opacity: 0;
        pointer-events: none;
    }
    
    .admin-sidebar::-webkit-scrollbar {
        width: 4px;
    }
    .admin-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    .admin-sidebar::-webkit-scrollbar-thumb {
        background: rgba(13, 148, 136, 0.3);
        border-radius: 4px;
    }
    
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.75rem 1.4rem;
        color: #94a3b8;
        text-decoration: none;
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .sidebar-link:hover {
        background: rgba(13, 148, 136, 0.08);
        color: #ffffff;
        padding-left: 1.6rem;
    }
    
    .sidebar-link.active {
        color: #2dd4bf;
        background: linear-gradient(90deg, rgba(13, 148, 136, 0.2) 0%, rgba(13, 148, 136, 0.02) 100%);
        border-left-color: #10b981;
        font-weight: 800;
    }
    
    .sidebar-link i {
        font-size: 1.1rem;
        width: 22px;
        text-align: center;
        color: inherit;
    }
    
    .sidebar-section-title {
        padding: 1.25rem 1.4rem 0.4rem;
        color: #64748b;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 800;
        margin: 0;
    }

    .admin-mobile-floating-btn {
        position: fixed;
        top: 14px;
        left: 14px;
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #09171f;
        color: #2dd4bf;
        border: 1px solid rgba(13, 148, 136, 0.4);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        cursor: pointer;
        z-index: 1030;
        transition: all 0.2s ease;
    }
    .admin-mobile-floating-btn:active {
        transform: scale(0.95);
    }

    @media (max-width: 991.98px) {
        .admin-sidebar {
            top: 0 !important;
            height: 100vh !important;
            transform: translateX(-100%) !important;
            opacity: 0 !important;
            pointer-events: none !important;
            z-index: 1050 !important;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.6);
        }
        .admin-sidebar.show-mobile {
            transform: translateX(0) !important;
            opacity: 1 !important;
            pointer-events: auto !important;
        }
    }
</style>

<!-- Floating Toggle Button on Mobile -->
<button type="button" class="admin-mobile-floating-btn d-lg-none" onclick="toggleAdminSidebar()" title="Open Navigation">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar-backdrop" onclick="closeAdminSidebar()" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 1045; backdrop-filter: blur(4px);"></div>

<div class="admin-sidebar">
    <!-- Sidebar Brand Header -->
    <div style="padding: 1.25rem 1.4rem; border-bottom: 1px solid rgba(13, 148, 136, 0.2); display: flex; align-items: center; justify-content: space-between; background: #060e14;">
        <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 0.65rem; text-decoration: none;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #0d9488 0%, #10b981 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                <i class="fas fa-shield-halved" style="color: #ffffff; font-size: 1.1rem;"></i>
            </div>
            <div>
                <span style="color: #ffffff; font-weight: 900; font-size: 1.05rem; display: block; line-height: 1.15;">E-Benta</span>
                <span style="color: #10b981; font-size: 0.68rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Admin Center</span>
            </div>
        </a>
        <button type="button" class="d-lg-none" onclick="closeAdminSidebar()" style="background: none; border: none; color: #94a3b8; font-size: 1.2rem; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav style="flex: 1; overflow-y: auto; padding: 0.75rem 0;">
        <p class="sidebar-section-title">Operations Hub</p>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Overview</span>
        </a>
        <a href="{{ route('admin.pending-verifications') }}" class="sidebar-link {{ request()->routeIs('admin.pending-verifications') ? 'active' : '' }}">
            <i class="fas fa-id-card-clip"></i>
            <span>ID Verifications</span>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="fas fa-flag"></i>
            <span>User Reports</span>
        </a>

        <p class="sidebar-section-title">Marketplace Management</p>
        <a href="{{ route('admin.listings') }}" class="sidebar-link {{ request()->routeIs('admin.listings') ? 'active' : '' }}">
            <i class="fas fa-boxes-stacked"></i>
            <span>Listings</span>
        </a>
        <a href="{{ route('admin.offers') }}" class="sidebar-link {{ request()->routeIs('admin.offers') ? 'active' : '' }}">
            <i class="fas fa-handshake"></i>
            <span>Offers & Trades</span>
        </a>

        <p class="sidebar-section-title">Analytics & Compliance</p>
        <a href="{{ route('admin.impact-logs') }}" class="sidebar-link {{ request()->routeIs('admin.impact-logs') ? 'active' : '' }}">
            <i class="fas fa-leaf"></i>
            <span>Impact Logs</span>
        </a>
        <a href="{{ route('admin.audit-logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>Audit Trail</span>
        </a>
        <a href="{{ route('admin.generate-reports') }}" class="sidebar-link {{ request()->routeIs('admin.generate-reports') ? 'active' : '' }}">
            <i class="fas fa-file-pdf"></i>
            <span>Generate Reports</span>
        </a>

        <p class="sidebar-section-title">Administration</p>
        <a href="{{ route('settings') }}" class="sidebar-link {{ request()->routeIs('settings*') ? 'active' : '' }}">
            <i class="fas fa-sliders"></i>
            <span>System Settings</span>
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div style="padding: 1rem 1.4rem; border-top: 1px solid rgba(13, 148, 136, 0.2); background: rgba(0, 0, 0, 0.2);">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.55rem; background: rgba(239, 68, 68, 0.12); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 0.6rem; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.2s ease;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

<script>
    function toggleAdminSidebar() {
        const sidebar = document.querySelector('.admin-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
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
            localStorage.setItem('adminSidebarHidden', isHidden ? 'true' : 'false');
        }
    }

    function closeAdminSidebar() {
        const sidebar = document.querySelector('.admin-sidebar');
        const backdrop = document.querySelector('.sidebar-backdrop');
        if (sidebar) sidebar.classList.remove('show-mobile');
        if (backdrop) backdrop.style.display = 'none';
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAdminSidebar();
        }
    });
    
    // Restore sidebar state on page load
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.admin-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const isMobile = window.innerWidth < 992;
        
        if (!isMobile) {
            const isHidden = localStorage.getItem('adminSidebarHidden') === 'true';
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

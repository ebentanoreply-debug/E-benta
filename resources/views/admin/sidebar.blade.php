<!-- Admin Sidebar Navigation -->
<style>
    .admin-sidebar {
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: #ffffff;
        border-right: 1px solid #e2e8f0;
    }
    
    .admin-sidebar.hidden {
        transform: translateX(-100%);
        opacity: 0;
        pointer-events: none;
    }
    
    .admin-sidebar::-webkit-scrollbar {
        width: 2px;
    }
    .admin-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    .admin-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .admin-sidebar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    .admin-sidebar-toggle-btn {
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
    
    .admin-sidebar-toggle-btn:hover {
        background-color: #f8fafc;
        color: #0d9488;
    }
    
    .admin-sidebar.hidden + .admin-sidebar-toggle-btn {
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
    }
    @media (max-width: 991.98px) {
        .admin-sidebar {
            z-index: 1045 !important;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.4);
        }
        .admin-sidebar-toggle-btn {
            left: 12px !important;
            top: 8px !important;
            z-index: 1025;
        }
        .admin-sidebar.hidden + .admin-sidebar-toggle-btn {
            left: 12px !important;
        }
    }
</style>
<div class="sidebar-backdrop" onclick="closeAdminSidebar()" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1040; backdrop-filter: blur(3px);"></div>
<div class="admin-sidebar" style="position: fixed; left: 0; top: 0; width: 260px; height: 100vh; display: flex; flex-direction: column; z-index: 1045; overflow-y: auto;">
    <!-- Sidebar Header -->
    <div style="padding: 1.5rem; border-bottom: 2px solid transparent; border-image: linear-gradient(90deg, #0d9488 0%, #06b6d4 50%, #0d9488 100%); border-image-slice: 1; display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; background: linear-gradient(135deg, #1e293b 0%, #233651 100%);">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-shield-alt" style="font-size: 1.5rem; color: #0d9488;"></i>
            <div>
                <h6 style="color: #ffffff; font-weight: 700; margin: 0; font-size: 1.1rem;">Admin Panel</h6>
                <small style="color: #cbd5e1; font-size: 0.75rem;">System Management</small>
            </div>
        </div>
        <button type="button" class="d-lg-none" onclick="closeAdminSidebar()" style="background: none; border: none; color: #cbd5e1; font-size: 1.25rem; padding: 0.25rem 0.5rem; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav style="flex: 1; overflow-y: auto; padding: 1rem 0;">
        <p class="sidebar-section-title">Dashboard</p>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Overview</span>
        </a>

        <p class="sidebar-section-title">Management</p>
        <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </a>
        <a href="{{ route('admin.pending-verifications') }}" class="sidebar-link {{ request()->routeIs('admin.pending-verifications') ? 'active' : '' }}">
            <i class="fas fa-user-check"></i>
            <span>Verifications</span>
        </a>
        <a href="{{ route('admin.listings') }}" class="sidebar-link {{ request()->routeIs('admin.listings') ? 'active' : '' }}">
            <i class="fas fa-boxes"></i>
            <span>Listings</span>
        </a>
        <a href="{{ route('admin.offers') }}" class="sidebar-link {{ request()->routeIs('admin.offers') ? 'active' : '' }}">
            <i class="fas fa-handshake"></i>
            <span>Offers</span>
        </a>

        <p class="sidebar-section-title">Monitoring</p>
        <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
            <i class="fas fa-flag"></i>
            <span>Reports</span>
        </a>
        <a href="{{ route('admin.audit-logs') }}" class="sidebar-link {{ request()->routeIs('admin.audit-logs*') ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>Audit Logs</span>
        </a>
        <a href="{{ route('admin.impact-logs') }}" class="sidebar-link {{ request()->routeIs('admin.impact-logs') ? 'active' : '' }}">
            <i class="fas fa-leaf"></i>
            <span>Impact Logs</span>
        </a>

        <p class="sidebar-section-title">System</p>
        <a href="{{ route('settings') }}" class="sidebar-link {{ request()->routeIs('settings') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
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
<button class="admin-sidebar-toggle-btn" onclick="toggleAdminSidebar()" title="Toggle Sidebar">
    <i class="fas fa-bars"></i>
</button>

<script>
    function toggleAdminSidebar() {
        const sidebar = document.querySelector('.admin-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const navbar = document.querySelector('.navbar');
        const backdrop = document.querySelector('.sidebar-backdrop');
        const isMobile = window.innerWidth < 992;
        const isHidden = sidebar.classList.toggle('hidden');
        
        if (isMobile) {
            if (backdrop) backdrop.style.display = isHidden ? 'none' : 'block';
        } else {
            if (backdrop) backdrop.style.display = 'none';
            if (isHidden) {
                if (mainContent) { mainContent.style.marginLeft = '0'; mainContent.style.width = '100%'; }
                if (navbar) { navbar.style.left = '0'; navbar.style.width = '100%'; }
                localStorage.setItem('adminSidebarHidden', 'true');
            } else {
                if (mainContent) { mainContent.style.marginLeft = '260px'; mainContent.style.width = 'calc(100% - 260px)'; }
                if (navbar) { navbar.style.left = '260px'; navbar.style.width = 'calc(100% - 260px)'; }
                localStorage.setItem('adminSidebarHidden', 'false');
            }
        }
    }

    function closeAdminSidebar() {
        const sidebar = document.querySelector('.admin-sidebar');
        const backdrop = document.querySelector('.sidebar-backdrop');
        if (sidebar) sidebar.classList.add('hidden');
        if (backdrop) backdrop.style.display = 'none';
    }
    
    // Restore sidebar state on page load
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.admin-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const navbar = document.querySelector('.navbar');
        const isMobile = window.innerWidth < 992;
        
        if (isMobile) {
            if (sidebar) sidebar.classList.add('hidden');
            if (mainContent) { mainContent.style.marginLeft = '0'; mainContent.style.width = '100%'; }
            if (navbar) { navbar.style.left = '0'; navbar.style.width = '100%'; }
        } else {
            const isHidden = localStorage.getItem('adminSidebarHidden') === 'true';
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

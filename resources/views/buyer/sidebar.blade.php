<!-- Buyer Dashboard Sidebar -->
<style>
    .buyer-sidebar {
        transition: transform 0.2s ease, opacity 0.2s ease;
        background-color: #ffffff;
        border-right: 1px solid #e2e8f0;
    }
    
    .buyer-sidebar.hidden {
        transform: translateX(-100%);
        opacity: 0;
        pointer-events: none;
    }
    
    .buyer-sidebar::-webkit-scrollbar {
        width: 2px;
    }
    .buyer-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    .buyer-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .buyer-sidebar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    .sidebar-toggle-btn {
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
    
    .sidebar-toggle-btn:hover {
        background-color: #f8fafc;
        color: #0d9488;
    }
    
    .buyer-sidebar.hidden + .sidebar-toggle-btn {
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
    
    .offer-card {
        display: block;
        padding: 0.75rem 1rem;
        margin: 0 1rem 0.5rem;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .offer-card:hover {
        border-color: #cbd5e1;
        background-color: #f8fafc;
    }
    
    .offer-card-accepted { border-left: 3px solid #10b981; }
    .offer-card-rejected { border-left: 3px solid #ef4444; }
    .offer-card-pending { border-left: 3px solid #f59e0b; }
</style>
<div class="buyer-sidebar" style="position: fixed; left: 0; top: 0; width: 260px; height: 100vh; display: flex; flex-direction: column; z-index: 1030; overflow-y: auto;">
    <!-- Sidebar Header -->
    <div style="padding: 1.5rem; border-bottom: 2px solid transparent; border-image: linear-gradient(90deg, #0d9488 0%, #06b6d4 50%, #0d9488 100%); border-image-slice: 1; display: flex; align-items: center; gap: 0.75rem; background: linear-gradient(135deg, #1e293b 0%, #233651 100%);">
        <i class="fas fa-shopping-bag" style="font-size: 1.5rem; color: #0d9488;"></i>
        <div>
            <h6 style="color: #ffffff; font-weight: 700; margin: 0; font-size: 1.1rem;">Buyer Panel</h6>
            <small style="color: #cbd5e1; font-size: 0.75rem;">E-Benta Platform</small>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav style="flex: 1; overflow-y: auto; padding: 1rem 0;">
        <p class="sidebar-section-title">Main</p>
        <a href="{{ route('buyer.dashboard') }}" class="sidebar-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>

        <p class="sidebar-section-title">Marketplace</p>
        <a href="{{ route('listings.index') }}" class="sidebar-link {{ request()->routeIs('listings.index') ? 'active' : '' }}">
            <i class="fas fa-store"></i>
            <span>Browse Listings</span>
        </a>
        <a href="{{ route('buyer.transaction-history') }}" class="sidebar-link {{ request()->routeIs('buyer.transaction-history') ? 'active' : '' }}">
            <i class="fas fa-handshake"></i>
            <span>My Offers</span>
        </a>
        <a href="{{ route('buyer.saved-items') }}" class="sidebar-link {{ request()->routeIs('buyer.saved-items') ? 'active' : '' }}">
            <i class="fas fa-heart"></i>
            <span>Saved Items</span>
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

        <!-- My Offers Section -->
        @if(isset($offers) && $offers && $offers->count() > 0)
            <div style="margin-top: 1rem;">
                <p class="sidebar-section-title">Recent Offers</p>
                @foreach($offers->take(3) as $offer)
                    <a href="{{ route('offers.show', $offer) }}" class="offer-card {{ $offer->status === 'accepted' ? 'offer-card-accepted' : ($offer->status === 'rejected' ? 'offer-card-rejected' : 'offer-card-pending') }}">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                            <span style="color: #334155; font-weight: 600; font-size: 0.8rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 120px;">
                                {{ $offer->listing->category }}
                            </span>
                            <span style="font-size: 0.65rem; padding: 0.15rem 0.4rem; border-radius: 0.25rem; font-weight: 600; text-transform: uppercase; {{ $offer->status === 'accepted' ? 'background: #d1fae5; color: #047857;' : ($offer->status === 'rejected' ? 'background: #fee2e2; color: #b91c1c;' : 'background: #fef3c7; color: #b45309;') }}">
                                {{ $offer->status }}
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #64748b; font-size: 0.75rem;">₱{{ number_format($offer->bid_amount, 0) }}</span>
                            <span style="color: #94a3b8; font-size: 0.7rem;">{{ $offer->created_at->shortAbsoluteDiffForHumans() }}</span>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('buyer.transaction-history') }}" style="display: block; text-align: center; color: #0d9488; font-size: 0.8rem; font-weight: 600; margin-top: 0.5rem; text-decoration: none;">View All Offers →</a>
            </div>
        @endif
    </nav>

    <!-- Footer -->
    <div style="padding: 0.75rem 1rem; border-top: 2px solid transparent; border-image: linear-gradient(90deg, #0d9488 0%, #06b6d4 50%, #0d9488 100%); border-image-slice: 1; background: linear-gradient(135deg, #1e293b 0%, #233651 100%); margin-top: auto;">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.5rem; background: rgba(239, 68, 68, 0.1); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 0.5rem; font-weight: 500; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.1)'">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
<button class="sidebar-toggle-btn" onclick="toggleBuyerSidebar()" title="Toggle Sidebar">
    <i class="fas fa-bars"></i>
</button>

<script>
    function toggleBuyerSidebar() {
        const sidebar = document.querySelector('.buyer-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const navbar = document.querySelector('.navbar');
        const isHidden = sidebar.classList.toggle('hidden');
        
        if (isHidden) {
            mainContent.style.marginLeft = '0';
            mainContent.style.width = '100%';
            if (navbar) {
                navbar.style.left = '0';
                navbar.style.width = '100%';
            }
            localStorage.setItem('buyerSidebarHidden', 'true');
        } else {
            mainContent.style.marginLeft = '260px';
            mainContent.style.width = 'calc(100% - 260px)';
            if (navbar) {
                navbar.style.left = '260px';
                navbar.style.width = 'calc(100% - 260px)';
            }
            localStorage.setItem('buyerSidebarHidden', 'false');
        }
    }
    
    // Restore sidebar state on page load
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.buyer-sidebar');
        const mainContent = document.querySelector('.main-content-wrapper');
        const navbar = document.querySelector('.navbar');
        if (sidebar && mainContent) {
            const isHidden = localStorage.getItem('buyerSidebarHidden') === 'true';
            if (isHidden) {
                sidebar.classList.add('hidden');
                mainContent.style.marginLeft = '0';
                mainContent.style.width = '100%';
                if (navbar) {
                    navbar.style.left = '0';
                    navbar.style.width = '100%';
                }
            } else {
                if (navbar) {
                    navbar.style.left = '260px';
                    navbar.style.width = 'calc(100% - 260px)';
                }
            }
        }
    });
</script>

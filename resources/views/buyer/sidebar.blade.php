<!-- Modern Integrated Buyer Account Navigation Card -->
<style>
    .buyer-account-nav-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }

    @media (min-width: 992px) {
        .buyer-account-nav-sticky {
            position: sticky;
            top: 150px;
            z-index: 10;
        }
    }

    .buyer-nav-user-header {
        padding: 1.25rem 1.25rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .buyer-nav-avatar {
        width: 44px;
        height: 44px;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
        flex-shrink: 0;
    }

    .buyer-nav-section-title {
        padding: 1rem 1.25rem 0.35rem;
        color: #94a3b8;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 800;
        margin: 0;
    }

    .buyer-nav-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.65rem 1.25rem;
        color: #475569;
        text-decoration: none;
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 0.88rem;
        position: relative;
    }

    .buyer-nav-item:hover {
        background-color: #f8fafc;
        color: #0d9488;
        padding-left: 1.45rem;
    }

    .buyer-nav-item.active {
        color: #0d9488;
        background-color: #f0fdfa;
        border-left-color: #0d9488;
        font-weight: 700;
    }

    .buyer-nav-item i {
        font-size: 0.95rem;
        width: 20px;
        text-align: center;
        color: inherit;
        transition: transform 0.2s ease;
    }

    .buyer-nav-item:hover i {
        transform: scale(1.1);
    }

    .buyer-nav-badge {
        margin-left: auto;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 0.2rem 0.55rem;
        border-radius: 2rem;
        line-height: 1;
    }

    .buyer-nav-footer {
        padding: 0.85rem 1.25rem;
        border-top: 1px solid #f1f5f9;
        background: #ffffff;
    }

    /* Mobile Accordion Toggle */
    .buyer-mobile-nav-toggle {
        display: none;
    }

    @media (max-width: 991.98px) {
        .buyer-mobile-nav-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.85rem 1.25rem;
            background: #ffffff;
            border: none;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 700;
            font-size: 0.88rem;
            color: #0f172a;
            cursor: pointer;
        }

        .buyer-mobile-nav-collapse {
            display: none;
        }

        .buyer-mobile-nav-collapse.show {
            display: block;
        }
    }
</style>

<div class="buyer-account-nav-card buyer-account-nav-sticky">
    <!-- User Profile Header -->
    <div class="buyer-nav-user-header">
        <div class="buyer-nav-avatar">
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.75rem;">
            @else
                {{ strtoupper(substr(auth()->user()->name ?? 'B', 0, 1)) }}
            @endif
        </div>
        <div style="overflow: hidden; flex: 1;">
            <strong style="font-size: 0.92rem; font-weight: 800; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;">
                {{ auth()->user()->name ?? 'Buyer Account' }}
            </strong>
            <div style="display: flex; align-items: center; gap: 0.35rem; margin-top: 0.2rem;">
                @if(auth()->user()->is_verified ?? false)
                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; font-weight: 800; font-size: 0.68rem; padding: 0.2rem 0.5rem; border-radius: 1rem;">
                        <i class="fas fa-check-circle me-1"></i>Verified Buyer
                    </span>
                @else
                    <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706; font-weight: 800; font-size: 0.68rem; padding: 0.2rem 0.5rem; border-radius: 1rem;">
                        <i class="fas fa-clock me-1"></i>Pending ID
                    </span>
                @endif
                <span style="color: #94a3b8; font-size: 0.72rem;">• Hub</span>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Toggle Button -->
    <button type="button" class="buyer-mobile-nav-toggle" onclick="toggleBuyerMobileNav()" aria-label="Toggle Portal Navigation">
        <span><i class="fas fa-compass me-2" style="color: #0d9488;"></i>Portal Menu</span>
        <i class="fas fa-chevron-down" id="buyerMobileNavChevron" style="transition: transform 0.2s ease;"></i>
    </button>

    <!-- Navigation Menu (Always visible on desktop, collapsible on mobile) -->
    <div class="buyer-mobile-nav-collapse d-lg-block" id="buyerNavMenuCollapse">
        <nav style="padding: 0.35rem 0;">
            <p class="buyer-nav-section-title">Main Portal</p>
            
            <a href="{{ route('buyer.dashboard') }}" class="buyer-nav-item {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('messages.index') }}" class="buyer-nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i>
                <span>Messages</span>
                @php
                    $unreadCount = auth()->check() ? \App\Models\Message::where('receiver_id', auth()->id())->whereNull('read_at')->count() : 0;
                @endphp
                @if($unreadCount > 0)
                    <span class="buyer-nav-badge" style="background: #ef4444; color: #ffffff;">{{ $unreadCount }}</span>
                @endif
            </a>

            <p class="buyer-nav-section-title">Activity & Orders</p>
            
            <a href="{{ route('buyer.transaction-history') }}" class="buyer-nav-item {{ request()->routeIs('buyer.transaction-history') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i>
                <span>My Offers & History</span>
            </a>

            <a href="{{ route('buyer.saved-items') }}" class="buyer-nav-item {{ request()->routeIs('buyer.saved-items') ? 'active' : '' }}">
                <i class="fas fa-bookmark"></i>
                <span>Saved Items</span>
                @php
                    $savedCountNav = auth()->check() && auth()->user()->isBuyer() ? auth()->user()->savedListings()->count() : 0;
                @endphp
                @if($savedCountNav > 0)
                    <span class="buyer-nav-badge" style="background: rgba(13, 148, 136, 0.15); color: #0d9488;">{{ $savedCountNav }}</span>
                @endif
            </a>
            
            <a href="{{ route('addresses.index') }}" class="buyer-nav-item {{ request()->routeIs('addresses.*') ? 'active' : '' }}">
                <i class="fas fa-map-location-dot"></i>
                <span>Shipping Addresses</span>
            </a>

            <p class="buyer-nav-section-title">Marketplace</p>
            
            <a href="{{ route('listings.index') }}" class="buyer-nav-item {{ request()->routeIs('listings.index') || request()->routeIs('listings.search') ? 'active' : '' }}">
                <i class="fas fa-store"></i>
                <span>Browse Items</span>
            </a>

            <p class="buyer-nav-section-title">Account Settings</p>
            
            <a href="{{ route('settings') }}" class="buyer-nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                <i class="fas fa-gear"></i>
                <span>Settings</span>
            </a>
            
            <a href="{{ route('profile') }}" class="buyer-nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                <i class="fas fa-user-gear"></i>
                <span>My Profile</span>
            </a>
        </nav>

        <!-- Footer / Sign Out -->
        <div class="buyer-nav-footer">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.6rem; background: rgba(239, 68, 68, 0.08); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 0.65rem; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(239,68,68,0.15)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleBuyerMobileNav() {
        const menu = document.getElementById('buyerNavMenuCollapse');
        const chevron = document.getElementById('buyerMobileNavChevron');
        if (menu) {
            menu.classList.toggle('show');
            if (chevron) {
                chevron.style.transform = menu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        }
    }
</script>

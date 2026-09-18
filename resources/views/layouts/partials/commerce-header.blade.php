{{-- Full E-Commerce Master Header (Public / Buyer layout) --}}
{{-- Expects: $globalDeviceTypes, $activeListingCount, $savedCount, $unreadMsgCount --}}
<style>
    :root {
        --primary-green: #0d9488;
        --emerald-accent: #059669;
        --accent-green: #06b6d4;
        --muted-label: #64748b;
    }

    body { padding-top: 0; }

    .commerce-master-header {
        position: sticky;
        top: 0;
        z-index: 1020;
        background: linear-gradient(135deg, #1e293b 0%, #233651 100%);
        border-bottom: 2px solid transparent;
        border-image: linear-gradient(90deg, #0d9488 0%, #06b6d4 50%, #0d9488 100%);
        border-image-slice: 1;
        box-shadow: 0 8px 30px rgba(13, 148, 136, 0.2);
    }

    .commerce-topbar {
        background: rgba(0, 0, 0, 0.25);
        border-bottom: 1px solid rgba(13, 148, 136, 0.15);
        padding: 0.35rem 0;
        font-size: 0.82rem;
        color: #94a3b8;
    }
    .commerce-topbar a {
        color: #94a3b8;
        text-decoration: none;
        transition: color 0.2s ease;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .commerce-topbar a:hover { color: #2dd4bf; }
    .commerce-topbar-pill {
        background: rgba(13, 148, 136, 0.12);
        border: 1px solid rgba(13, 148, 136, 0.25);
        color: #5eead4;
        padding: 0.2rem 0.65rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .commerce-main-nav { padding: 0.6rem 0; }

    .commerce-brand-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        display: flex; align-items: center; justify-content: center;
        color: #ffffff; font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.4);
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }
    .commerce-brand-icon:hover { transform: rotate(-5deg) scale(1.1); }
    .commerce-brand-name {
        font-family: 'Outfit', sans-serif;
        font-size: 1.45rem; font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #a5f3fc 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        letter-spacing: -0.5px;
    }
    .commerce-brand-tag {
        font-size: 0.6rem; font-weight: 800; color: #5eead4;
        letter-spacing: 1.5px; text-transform: uppercase;
    }

    .commerce-search-form {
        display: flex; align-items: stretch; gap: 0;
        background: rgba(255,255,255,0.08);
        border: 1.5px solid rgba(13,148,136,0.35);
        border-radius: 0.75rem;
        overflow: hidden;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .commerce-search-form:focus-within {
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13,148,136,0.15);
    }
    .commerce-search-category {
        background: rgba(0,0,0,0.2); border: none; border-right: 1.5px solid rgba(13,148,136,0.3);
        color: #cbd5e1; font-size: 0.82rem; font-weight: 700; padding: 0 1rem;
        cursor: pointer; outline: none; min-width: 130px; max-width: 160px;
    }
    .commerce-search-category option { background: #1e293b; }
    .commerce-search-input {
        flex: 1; background: transparent; border: none; color: #ffffff;
        font-size: 0.9rem; padding: 0.65rem 1rem; outline: none;
    }
    .commerce-search-input::placeholder { color: #64748b; }
    .commerce-search-btn {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        border: none; color: #ffffff; font-weight: 800; font-size: 0.88rem;
        padding: 0 1.25rem; cursor: pointer; transition: opacity 0.2s ease;
        display: flex; align-items: center; gap: 0.4rem;
    }
    .commerce-search-btn:hover { opacity: 0.88; }

    .commerce-action-item {
        display: flex; align-items: center; gap: 0.45rem;
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);
        color: #cbd5e1; padding: 0.45rem 0.75rem; border-radius: 0.6rem;
        text-decoration: none; transition: all 0.2s ease; position: relative;
        cursor: pointer;
    }
    .commerce-action-item:hover { background: rgba(13,148,136,0.15); border-color: rgba(13,148,136,0.35); color: #ffffff; }

    .commerce-badge {
        position: absolute; top: -6px; right: -6px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white; font-size: 0.65rem; font-weight: 800;
        padding: 0.15rem 0.4rem; border-radius: 50%; min-width: 18px;
        text-align: center; display: inline-flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 8px rgba(239,68,68,0.4);
    }

    .commerce-sell-btn {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff !important; font-weight: 800; border: none;
        padding: 0.55rem 1.35rem; border-radius: 0.65rem;
        text-decoration: none; transition: all 0.3s ease;
        display: flex; align-items: center; gap: 0.5rem; font-size: 0.88rem;
        box-shadow: 0 4px 15px rgba(13,148,136,0.3);
    }
    .commerce-sell-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(13,148,136,0.5); }

    .commerce-user-btn {
        cursor: pointer; transition: all 0.2s ease;
    }
    .commerce-user-btn:hover { background: rgba(255,255,255,0.1) !important; border-color: rgba(13,148,136,0.4) !important; }

    .dropdown-menu {
        background: linear-gradient(135deg, #1e293b 0%, #0f172e 100%) !important;
        border: 2px solid rgba(13,148,136,0.5) !important;
        border-radius: 1rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4), inset 0 1px 1px rgba(255,255,255,0.08) !important;
        padding: 0.8rem 0;
    }
    .dropdown-item { color: #cbd5e1 !important; font-weight: 600; transition: all 0.3s ease; padding: 0.9rem 1.5rem; font-size: 0.95rem; position: relative; margin: 0.3rem 0.5rem; border-radius: 0.5rem; }
    .dropdown-item:hover { background: linear-gradient(135deg, rgba(13,148,136,0.4) 0%, rgba(6,182,212,0.3) 100%) !important; color: #ffffff !important; padding-left: 2rem; }
    .dropdown-divider { border-color: rgba(13,148,136,0.4) !important; margin: 0.8rem 0; }

    .commerce-category-strip {
        background: rgba(0,0,0,0.2); border-top: 1px solid rgba(13,148,136,0.15);
        padding: 0.5rem 0; overflow-x: auto; -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .commerce-category-strip::-webkit-scrollbar { display: none; }
    .commerce-category-strip .container-fluid { flex-wrap: nowrap; white-space: nowrap; }
    .commerce-cat-link {
        display: inline-flex; align-items: center; gap: 0.4rem;
        color: #94a3b8; text-decoration: none; font-size: 0.82rem; font-weight: 700;
        padding: 0.4rem 0.9rem; border-radius: 1.5rem; white-space: nowrap;
        transition: all 0.2s ease; border: 1px solid transparent; flex-shrink: 0;
    }
    .commerce-cat-link:hover { color: #ffffff; background: rgba(13,148,136,0.15); border-color: rgba(13,148,136,0.3); }
    .commerce-cat-link.active { color: #2dd4bf; background: rgba(13,148,136,0.2); border-color: rgba(13,148,136,0.4); font-weight: 800; }

    /* Mobile padding for sticky header */
    @media (max-width: 767.98px) {
        body { padding-bottom: 70px; }
    }
</style>

<header class="commerce-master-header">
    {{-- Top Utility Strip (Desktop only) --}}
    <div class="commerce-topbar d-none d-md-block">
        <div class="container-fluid px-3 px-lg-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2 gap-md-3">
                @auth
                    @php
                        $userDeliverCity = auth()->user()->addresses()->where('is_primary', true)->first()?->city ?? auth()->user()->address_city;
                    @endphp
                    @if($userDeliverCity)
                        <span class="commerce-topbar-pill">
                            <i class="fas fa-location-dot"></i> Deliver to: <strong>{{ $userDeliverCity }}</strong>
                        </span>
                        <span class="d-none d-md-inline" style="color: rgba(255,255,255,0.2);">|</span>
                    @endif
                @endauth
                @php $totalCo2Header = \App\Models\ImpactLog::sum('co2_saved') + \App\Models\Listing::sum('carbon_footprint'); @endphp
                @if($totalCo2Header > 0)
                    <span class="d-none d-md-inline" style="font-size: 0.75rem; color: #94a3b8;">
                        <i class="fas fa-leaf me-1" style="color: #10b981;"></i> <strong>{{ number_format($totalCo2Header, 1) }} kg</strong> CO₂ Diverted
                    </span>
                @endif
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}#process" class="d-none d-md-inline">How It Works</a>
                <a href="{{ route('home') }}#faq" class="d-none d-lg-inline">Help & FAQ</a>
            </div>
        </div>
    </div>

    {{-- Main Search & Action Row (Desktop) --}}
    <div class="commerce-main-nav">
        <div class="container-fluid px-3 px-lg-4 d-none d-md-flex align-items-center justify-content-between gap-3">
            {{-- Brand --}}
            <a class="d-flex align-items-center gap-2 text-decoration-none flex-shrink-0" href="/">
                <div class="commerce-brand-icon"><i class="fas fa-leaf"></i></div>
                <div class="d-flex flex-column">
                    <span class="commerce-brand-name">E-Benta</span>
                    <span class="commerce-brand-tag">Circular Marketplace</span>
                </div>
            </a>

            {{-- Search --}}
            <div class="flex-grow-1 mx-1 mx-md-3" style="max-width: 650px;">
                <form action="{{ route('listings.index') }}" method="GET" class="commerce-search-form">
                    <select name="category" class="commerce-search-category d-none d-md-block">
                        <option value="">All Categories</option>
                        @foreach($globalDeviceTypes as $gType)
                            <option value="{{ $gType->name }}" {{ request('category') == $gType->name ? 'selected' : '' }}>{{ $gType->name }}</option>
                        @endforeach
                    </select>
                    <div class="position-relative flex-grow-1">
                        <input type="text" name="search" value="{{ request('search') }}" class="commerce-search-input"
                            placeholder="Search {{ $activeListingCount > 0 ? $activeListingCount . ' available' : 'verified' }} tech listings, brands, scrap..."
                            autocomplete="off">
                    </div>
                    <button type="submit" class="commerce-search-btn">
                        <i class="fas fa-magnifying-glass"></i>
                        <span class="d-none d-sm-inline">Search</span>
                    </button>
                </form>
            </div>

            {{-- Right Actions --}}
            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                {{-- Wishlist (buyer/guest only) --}}
                @if(!auth()->check() || auth()->user()->isBuyer())
                    <a href="{{ auth()->check() ? route('buyer.saved-items') : route('login') }}" class="commerce-action-item" title="Saved Items">
                        <i class="fas fa-heart" style="font-size: 1.05rem; color: #f43f5e !important;"></i>
                        <div class="d-none d-xl-flex flex-column text-start" style="line-height: 1.1;">
                            <span style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Wishlist</span>
                            <span style="font-size: 0.8rem; font-weight: 800; color: #ffffff;">Saved</span>
                        </div>
                        @if(auth()->check() && $savedCount > 0)
                            <span class="commerce-badge">{{ $savedCount }}</span>
                        @endif
                    </a>
                @endif

                @auth
                    {{-- Messages --}}
                    <a href="{{ route('messages.index') }}" class="commerce-action-item" title="Messages & Offers">
                        <i class="fas fa-comment-dots" style="font-size: 1.05rem; color: #38bdf8 !important;"></i>
                        <div class="d-none d-xl-flex flex-column text-start" style="line-height: 1.1;">
                            <span style="font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Offers</span>
                            <span style="font-size: 0.8rem; font-weight: 800; color: #ffffff;">Messages</span>
                        </div>
                        @if($unreadMsgCount > 0)
                            <span class="commerce-badge bg-info text-white">{{ $unreadMsgCount }}</span>
                        @endif
                    </a>

                    {{-- Notifications --}}
                    <div class="dropdown">
                        <button class="commerce-action-item border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                            <i class="fas fa-bell" style="font-size: 1.05rem; color: #fbbf24 !important;"></i>
                            @php $userUnreadNotifCount = auth()->user()->notifications()->where('is_read', false)->count(); @endphp
                            @if($userUnreadNotifCount > 0)
                                <span class="commerce-badge bg-warning text-dark">{{ $userUnreadNotifCount }}</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg py-2" style="width: 320px; max-height: 400px; overflow-y: auto; background: #0f172a; border: 1px solid rgba(13,148,136,0.3); border-radius: 0.8rem;">
                            <li class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center" style="border-color: rgba(255,255,255,0.1) !important;">
                                <strong style="color: #ffffff; font-size: 0.88rem;">Notifications</strong>
                                <a href="{{ route('notifications.index') }}" style="font-size: 0.75rem; color: #2dd4bf; text-decoration: none;">View All</a>
                            </li>
                            @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notif)
                                <li>
                                    <a class="dropdown-item py-2 px-3 text-wrap" href="{{ route('notifications.open', $notif) }}" style="color: #cbd5e1; font-size: 0.82rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                        <div class="fw-bold text-white mb-1">{{ $notif->title }}</div>
                                        <div class="small opacity-75">{{ Str::limit($notif->message, 60) }}</div>
                                        <small class="text-muted d-block mt-1">{{ $notif->created_at->diffForHumans() }}</small>
                                    </a>
                                </li>
                            @empty
                                <li class="px-3 py-4 text-center text-muted" style="font-size: 0.85rem;">
                                    <i class="fas fa-bell-slash fa-2x mb-2 opacity-50 d-block"></i>No new notifications
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- User Account Capsule --}}
                    <div class="dropdown">
                        <button class="commerce-user-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="display: flex; align-items: center; gap: 0.55rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); padding: 0.32rem 0.75rem 0.32rem 0.4rem; border-radius: 2rem;">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #0d9488 0%, #10b981 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 0.75rem;">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="d-none d-lg-flex flex-column text-start" style="line-height: 1.1;">
                                <span style="font-size: 0.65rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">{{ auth()->user()->role }}</span>
                                <span style="font-size: 0.82rem; font-weight: 800; color: #ffffff;">{{ Str::limit(auth()->user()->name, 12) }}</span>
                            </div>
                            <i class="fas fa-chevron-down" style="font-size: 0.65rem; color: #94a3b8;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="background: #0f172a; border: 1px solid rgba(13,148,136,0.3); border-radius: 0.8rem; min-width: 220px;">
                            @if(auth()->user()->isAdmin())
                                <li><div class="px-3 py-1 text-uppercase fw-bold text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">Administration</div></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line me-2" style="color: #2dd4bf;"></i>Admin Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.listings') }}"><i class="fas fa-boxes-stacked me-2" style="color: #38bdf8;"></i>Manage Listings</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.pending-verifications') }}"><i class="fas fa-user-check me-2" style="color: #fbbf24;"></i>Verifications</a></li>
                                <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                            @elseif(auth()->user()->isSeller())
                                <li><div class="px-3 py-1 text-uppercase fw-bold text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">Seller Hub</div></li>
                                <li><a class="dropdown-item" href="{{ route('seller.dashboard') }}"><i class="fas fa-store me-2" style="color: #2dd4bf;"></i>Seller Centre</a></li>
                                <li><a class="dropdown-item" href="{{ route('seller.listings') }}"><i class="fas fa-boxes-stacked me-2" style="color: #38bdf8;"></i>My Inventory</a></li>
                                <li><a class="dropdown-item" href="{{ route('listings.create') }}"><i class="fas fa-plus-circle me-2" style="color: #34d399;"></i>List New Tech</a></li>
                                <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                            @elseif(auth()->user()->isBuyer())
                                <li><div class="px-3 py-1 text-uppercase fw-bold text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">Buyer Account</div></li>
                                <li><a class="dropdown-item" href="{{ route('buyer.dashboard') }}"><i class="fas fa-bag-shopping me-2" style="color: #2dd4bf;"></i>My Purchases & Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('buyer.transaction-history') }}"><i class="fas fa-clock-rotate-left me-2" style="color: #38bdf8;"></i>Order History</a></li>
                                <li><a class="dropdown-item" href="{{ route('buyer.saved-items') }}"><i class="fas fa-heart me-2" style="color: #f43f5e;"></i>Saved Wishlist</a></li>
                                <li><a class="dropdown-item" href="{{ route('addresses.index') }}"><i class="fas fa-map-location-dot me-2" style="color: #fbbf24;"></i>Shipping Addresses</a></li>
                                <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                            @endif
                            <li><div class="px-3 py-1 text-uppercase fw-bold text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">Account & Settings</div></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2" style="color: #2dd4bf;"></i>Profile Info</a></li>
                            <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2" style="color: #94a3b8;"></i>Preferences & Security</a></li>
                            <li><a class="dropdown-item" href="{{ route('password.change') }}"><i class="fas fa-lock me-2" style="color: #94a3b8;"></i>Change Password</a></li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline; width: 100%;">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-100 text-start" style="color: #fca5a5 !important;"><i class="fas fa-sign-out-alt me-2" style="color: #ef4444;"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="commerce-action-item text-white" style="font-weight: 700; font-size: 0.84rem;">
                        <i class="fas fa-arrow-right-to-bracket" style="color: #2dd4bf;"></i>
                        <span>Sign In</span>
                    </a>
                @endauth

                {{-- Primary CTA Button --}}
                @if(auth()->check() && auth()->user()->isBuyer())
                    <a href="{{ route('buyer.dashboard') }}" class="commerce-sell-btn">
                        <i class="fas fa-bag-shopping"></i><span>My Orders</span>
                    </a>
                @elseif(!auth()->check() || auth()->user()->isSeller())
                    <a href="{{ auth()->check() ? route('listings.create') : route('register') }}" class="commerce-sell-btn">
                        <i class="fas fa-plus-circle"></i><span>Sell Tech</span>
                    </a>
                @endif
            </div>
        </div>

        {{-- Mobile Header --}}
        <div class="d-flex d-md-none flex-column gap-2 px-3">
            <div class="d-flex align-items-center justify-content-between">
                <a class="d-flex align-items-center gap-2 text-decoration-none" href="/">
                    <div class="commerce-brand-icon" style="width: 32px; height: 32px; font-size: 1rem; border-radius: 0.5rem;"><i class="fas fa-leaf"></i></div>
                    <span class="commerce-brand-name" style="font-size: 1.22rem;">E-Benta</span>
                </a>
                <div class="d-flex align-items-center gap-2">
                    @if(!auth()->check() || auth()->user()->isBuyer())
                        <a href="{{ auth()->check() ? route('buyer.saved-items') : route('login') }}" class="commerce-action-item p-2" title="Wishlist">
                            <i class="fas fa-heart" style="font-size: 1rem; color: #f43f5e;"></i>
                            @if(auth()->check() && $savedCount > 0)
                                <span class="commerce-badge" style="top: -4px; right: -4px;">{{ $savedCount }}</span>
                            @endif
                        </a>
                    @endif
                    @auth
                        <a href="{{ route('messages.index') }}" class="commerce-action-item p-2" title="Messages">
                            <i class="fas fa-comment-dots" style="font-size: 1rem; color: #38bdf8;"></i>
                            @if($unreadMsgCount > 0)
                                <span class="commerce-badge bg-info text-white" style="top: -4px; right: -4px;">{{ $unreadMsgCount }}</span>
                            @endif
                        </a>
                        <div class="dropdown">
                            <button class="border-0 bg-transparent p-0" type="button" data-bs-toggle="dropdown">
                                <div style="width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #0d9488 0%, #10b981 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 0.75rem; border: 1.5px solid #2dd4bf;">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ auth()->user()->avatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    @endif
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="background: #0f172a; border: 1px solid rgba(13,148,136,0.3); border-radius: 0.8rem; min-width: 200px;">
                                <li class="px-3 py-2 border-bottom text-white fw-bold" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.08) !important;">
                                    {{ auth()->user()->name }}
                                    <small class="d-block text-muted text-capitalize" style="font-size: 0.72rem;">{{ auth()->user()->role }}</small>
                                </li>
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line me-2"></i>Dashboard</a></li>
                                @elseif(auth()->user()->isSeller())
                                    <li><a class="dropdown-item" href="{{ route('seller.dashboard') }}"><i class="fas fa-store me-2"></i>Seller Hub</a></li>
                                    <li><a class="dropdown-item" href="{{ route('listings.create') }}"><i class="fas fa-plus-circle me-2"></i>List Tech</a></li>
                                @elseif(auth()->user()->isBuyer())
                                    <li><a class="dropdown-item" href="{{ route('buyer.dashboard') }}"><i class="fas fa-bag-shopping me-2"></i>Purchases</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.08);"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline; width: 100%;">
                                        @csrf
                                        <button type="submit" class="dropdown-item w-100 text-start text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm text-white px-2 py-1" style="background: rgba(13,148,136,0.3); border: 1px solid rgba(13,148,136,0.4); font-size: 0.78rem; font-weight: 700; border-radius: 0.5rem;">Sign In</a>
                    @endauth
                </div>
            </div>
            {{-- Mobile Search --}}
            <div>
                <form action="{{ route('listings.index') }}" method="GET" class="commerce-search-form w-100">
                    <div class="position-relative flex-grow-1">
                        <input type="text" name="search" value="{{ request('search') }}" class="commerce-search-input py-2 ps-3 pe-2"
                            placeholder="Search {{ $activeListingCount > 0 ? $activeListingCount . ' items' : 'tech' }}, scrap, brands..." autocomplete="off">
                    </div>
                    <button type="submit" class="commerce-search-btn px-3 py-2"><i class="fas fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
    </div>

    {{-- Category Strip --}}
    <div class="commerce-category-strip">
        <div class="container-fluid px-3 px-lg-4 d-flex align-items-center gap-2">
            <a href="{{ route('listings.index') }}" class="commerce-cat-link {{ !request('category') && !request('condition') && !request('sort') ? 'active' : '' }}">
                <i class="fas fa-border-all" style="color: #2dd4bf;"></i> All Tech
            </a>
            @foreach($globalDeviceTypes->take(8) as $dType)
                <a href="{{ route('listings.index', ['category' => $dType->name]) }}" class="commerce-cat-link {{ request('category') == $dType->name ? 'active' : '' }}">
                    {{ $dType->name }}
                </a>
            @endforeach
            <a href="{{ route('listings.index', ['condition' => 'functional']) }}" class="commerce-cat-link {{ request('condition') == 'functional' ? 'active' : '' }}">
                <i class="fas fa-certificate" style="color: #10b981;"></i> Working
            </a>
            <a href="{{ route('listings.index', ['condition' => 'repairable']) }}" class="commerce-cat-link {{ request('condition') == 'repairable' ? 'active' : '' }}">
                <i class="fas fa-wrench"></i> Repairable
            </a>
            <a href="{{ route('listings.index', ['condition' => 'for_parts']) }}" class="commerce-cat-link {{ request('condition') == 'for_parts' ? 'active' : '' }}">
                <i class="fas fa-microchip"></i> Parts
            </a>
        </div>
    </div>
</header>

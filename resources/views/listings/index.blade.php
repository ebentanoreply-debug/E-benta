@extends('layouts.app')

@section('title', 'Browse Tech & E-Waste Marketplace - E-Benta')

@section('content')
<style>
    /* === MODERN E-COMMERCE CATALOG STYLES === */
    .catalog-wrapper {
        background-color: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    /* Breadcrumbs Bar */
    .catalog-breadcrumb-bar {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.85rem 0;
        font-size: 0.84rem;
    }
    .catalog-breadcrumb-bar a {
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    .catalog-breadcrumb-bar a:hover {
        color: #0d9488;
    }

    /* Faceted Filter Sidebar */
    .filter-sidebar {
        background: #ffffff;
        border-radius: 1.15rem;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        position: sticky;
        top: 145px;
    }
    .filter-sidebar-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .filter-group {
        margin-bottom: 1.5rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .filter-group:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .filter-group-title {
        font-size: 0.86rem;
        font-weight: 800;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .filter-link-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.45rem 0.5rem;
        border-radius: 0.5rem;
        color: #475569;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .filter-link-item:hover, .filter-link-item.active {
        background: #f0fdfa;
        color: #0d9488;
        font-weight: 700;
    }
    .filter-count-badge {
        font-size: 0.72rem;
        font-weight: 700;
        background: #f1f5f9;
        color: #64748b;
        padding: 0.15rem 0.45rem;
        border-radius: 1rem;
    }
    .filter-link-item.active .filter-count-badge {
        background: rgba(13, 148, 136, 0.2);
        color: #0d9488;
    }

    /* Catalog Toolbar */
    .catalog-toolbar {
        background: #ffffff;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    .catalog-sort-select {
        border: 1px solid #cbd5e1;
        border-radius: 0.6rem;
        padding: 0.45rem 0.85rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: #1e293b;
        outline: none;
        background-color: #ffffff;
        cursor: pointer;
    }
    .catalog-sort-select:focus {
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
    }

    /* View Switcher */
    .view-switch-btn {
        width: 36px;
        height: 36px;
        border-radius: 0.55rem;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .view-switch-btn:hover, .view-switch-btn.active {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    /* Active Filter Pills */
    .active-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #f0fdfa;
        border: 1px solid rgba(13, 148, 136, 0.3);
        color: #0d9488;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 2rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .active-pill:hover {
        background: #ccfbf1;
        color: #0f766e;
    }

    /* E-Commerce Product Card */
    .m-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.15rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        position: relative;
    }
    .m-card:hover {
        transform: translateY(-5px);
        border-color: #0d9488;
        box-shadow: 0 16px 35px rgba(13, 148, 136, 0.16);
    }
    .m-card-media {
        height: 200px;
        background: #f8fafc;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .m-card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .m-card:hover .m-card-media img {
        transform: scale(1.07);
    }
    .m-card-wishlist {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 5;
    }
    .m-card-wishlist:hover, .m-card-wishlist.active {
        color: #f43f5e;
        transform: scale(1.12);
        background: #ffffff;
    }
    .m-card-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 0.25rem 0.65rem;
        border-radius: 2rem;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        backdrop-filter: blur(8px);
        z-index: 2;
    }
    .badge-functional {
        background: rgba(16, 185, 129, 0.92);
        color: #ffffff;
    }
    .badge-repairable {
        background: rgba(245, 158, 11, 0.92);
        color: #ffffff;
    }
    .badge-for_parts {
        background: rgba(100, 116, 139, 0.92);
        color: #ffffff;
    }
    .m-card-body {
        padding: 1.15rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .m-card-price {
        font-size: 1.25rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
    }
    .m-card-co2 {
        font-size: 0.72rem;
        font-weight: 700;
        color: #10b981;
    }

    /* List View Format */
    .catalog-list-view .m-card {
        flex-direction: row;
        height: auto;
    }
    .catalog-list-view .m-card-media {
        width: 240px;
        height: 100%;
        min-height: 190px;
        flex-shrink: 0;
    }
    .catalog-list-view .col-6,
    .catalog-list-view .col-md-4,
    .catalog-list-view .col-lg-4 {
        width: 100% !important;
    }

    /* Dark Mode Adjustments */
    body.dark-mode .catalog-wrapper {
        background-color: #09171f;
    }
    body.dark-mode .catalog-breadcrumb-bar,
    body.dark-mode .filter-sidebar,
    body.dark-mode .catalog-toolbar,
    body.dark-mode .m-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
        color: #e2e8f0;
    }
    body.dark-mode .filter-sidebar-title,
    body.dark-mode .filter-group-title,
    body.dark-mode .m-card-price {
        color: #ffffff;
    }
    body.dark-mode .filter-link-item {
        color: #cbd5e1;
    }
    body.dark-mode .catalog-sort-select {
        background: #1e293b;
        border-color: rgba(13, 148, 136, 0.4);
        color: #f1f5f9;
    }
</style>

<div class="catalog-wrapper">
    <!-- Breadcrumb Bar -->
    <div class="catalog-breadcrumb-bar">
        <div class="container-fluid px-3 px-lg-4 d-flex align-items-center justify-content-between">
            <nav style="display: flex; align-items: center; gap: 0.5rem;">
                <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
                <span class="text-muted">/</span>
                <span class="text-dark fw-bold">Marketplace Catalog</span>
                @if(request('category'))
                    <span class="text-muted">/</span>
                    <span class="text-teal-600 fw-bold" style="color: #0d9488;">{{ request('category') }}</span>
                @endif
            </nav>
            <div class="d-none d-md-flex align-items-center gap-2 text-muted" style="font-size: 0.8rem;">
                <i class="fas fa-shield-halved text-success"></i>
                <span>All listings protected by E-Benta Safe Trade Guarantee</span>
            </div>
        </div>
    </div>

    <!-- Main Catalog Container -->
    <div class="container-fluid px-3 px-lg-4 py-4">
        <!-- Active Filter Chips (if any) -->
        @if(request('category') || request('condition') || request('brand') || request('search') || request('min_price') || request('max_price') || request('listing_type'))
            <div class="d-flex align-items-center gap-2 flex-wrap mb-3 p-2 bg-white rounded-3 border">
                <span style="font-size: 0.78rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Active Filters:</span>
                
                @if(request('search'))
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="active-pill">
                        Search: "{{ request('search') }}" <i class="fas fa-times ms-1"></i>
                    </a>
                @endif

                @if(request('category'))
                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="active-pill">
                        Category: {{ request('category') }} <i class="fas fa-times ms-1"></i>
                    </a>
                @endif

                @if(request('condition'))
                    <a href="{{ request()->fullUrlWithQuery(['condition' => null]) }}" class="active-pill">
                        Condition: {{ str_replace('_', ' ', ucfirst(request('condition'))) }} <i class="fas fa-times ms-1"></i>
                    </a>
                @endif

                @if(request('brand'))
                    <a href="{{ request()->fullUrlWithQuery(['brand' => null]) }}" class="active-pill">
                        Brand: {{ request('brand') }} <i class="fas fa-times ms-1"></i>
                    </a>
                @endif

                @if(request('min_price') || request('max_price'))
                    <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="active-pill">
                        Price: ₱{{ request('min_price', 0) }} - ₱{{ request('max_price', 'Any') }} <i class="fas fa-times ms-1"></i>
                    </a>
                @endif

                @if(request('listing_type'))
                    <a href="{{ request()->fullUrlWithQuery(['listing_type' => null]) }}" class="active-pill">
                        Type: {{ request('listing_type') == 'bulk_lot' ? 'Bulk Lots' : 'Single Items' }} <i class="fas fa-times ms-1"></i>
                    </a>
                @endif

                <a href="{{ route('listings.index') }}" class="btn btn-sm btn-link text-danger text-decoration-none fw-bold p-0 ms-auto" style="font-size: 0.8rem;">
                    <i class="fas fa-rotate-left me-1"></i>Clear All
                </a>
            </div>
        @endif

        <div class="row g-4">
            <!-- 1. LEFT COLUMN: FACETED FILTER SIDEBAR (Desktop) -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="filter-sidebar">
                    <div class="filter-sidebar-title">
                        <span><i class="fas fa-filter me-2 text-teal-600" style="color: #0d9488;"></i>Filters</span>
                        @if(request()->hasAny(['category', 'condition', 'brand', 'search', 'min_price', 'max_price', 'listing_type']))
                            <a href="{{ route('listings.index') }}" class="text-danger text-decoration-none fw-bold" style="font-size: 0.78rem;">Reset</a>
                        @endif
                    </div>

                    <!-- Category Hierarchy Filter -->
                    <div class="filter-group">
                        <span class="filter-group-title">Device Category</span>
                        <div class="d-flex flex-column gap-1">
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="filter-link-item {{ !request('category') ? 'active' : '' }}">
                                <span><i class="fas fa-border-all me-2"></i>All Categories</span>
                                <span class="filter-count-badge">{{ $listings->total() }}</span>
                            </a>
                            @foreach($categoriesWithCount as $cat)
                                <a href="{{ request()->fullUrlWithQuery(['category' => $cat->name]) }}" class="filter-link-item {{ request('category') == $cat->name ? 'active' : '' }}">
                                    <span>
                                        @if($cat->name == 'Smartphone') 📱
                                        @elseif($cat->name == 'Laptop') 💻
                                        @elseif($cat->name == 'Desktop') 🖥️
                                        @elseif($cat->name == 'Tablet') 📟
                                        @elseif($cat->name == 'Monitor') 📺
                                        @elseif($cat->name == 'Battery') 🔋
                                        @else 🔌
                                        @endif
                                        {{ $cat->name }}
                                    </span>
                                    <span class="filter-count-badge">{{ $cat->listings_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Condition Grading Filter -->
                    <div class="filter-group">
                        <span class="filter-group-title">Condition Grading</span>
                        <div class="d-flex flex-column gap-1">
                            <a href="{{ request()->fullUrlWithQuery(['condition' => null]) }}" class="filter-link-item {{ !request('condition') ? 'active' : '' }}">
                                <span>All Conditions</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['condition' => 'functional']) }}" class="filter-link-item {{ request('condition') == 'functional' ? 'active' : '' }}">
                                <span><i class="fas fa-check-circle text-success me-2"></i>Certified Working</span>
                                <span class="filter-count-badge">{{ $conditionCounts['functional'] ?? 0 }}</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['condition' => 'repairable']) }}" class="filter-link-item {{ request('condition') == 'repairable' ? 'active' : '' }}">
                                <span><i class="fas fa-wrench text-warning me-2"></i>Repairable Deals</span>
                                <span class="filter-count-badge">{{ $conditionCounts['repairable'] ?? 0 }}</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['condition' => 'for_parts']) }}" class="filter-link-item {{ request('condition') == 'for_parts' ? 'active' : '' }}">
                                <span><i class="fas fa-microchip text-secondary me-2"></i>For Parts / Scrap</span>
                                <span class="filter-count-badge">{{ $conditionCounts['for_parts'] ?? 0 }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Price Range Slider / Inputs -->
                    <div class="filter-group">
                        <span class="filter-group-title">Price Range (₱)</span>
                        <form method="GET" action="{{ route('listings.index') }}" class="d-flex flex-column gap-2">
                            @foreach(request()->except(['min_price', 'max_price', 'page']) as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <div class="d-flex align-items-center gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control form-control-sm" placeholder="Min ₱" style="font-size: 0.82rem; border-radius: 0.5rem;">
                                <span class="text-muted">-</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control form-control-sm" placeholder="Max ₱" style="font-size: 0.82rem; border-radius: 0.5rem;">
                            </div>
                            <button type="submit" class="btn btn-sm btn-dark w-100 fw-bold" style="border-radius: 0.5rem; font-size: 0.8rem; padding: 0.45rem;">
                                Apply Price
                            </button>
                        </form>
                    </div>

                    <!-- Brand Filter -->
                    @if(isset($brandsWithCount) && $brandsWithCount->count() > 0)
                        <div class="filter-group">
                            <span class="filter-group-title">Top Brands</span>
                            <div class="d-flex flex-column gap-1" style="max-height: 200px; overflow-y: auto;">
                                <a href="{{ request()->fullUrlWithQuery(['brand' => null]) }}" class="filter-link-item {{ !request('brand') ? 'active' : '' }}">
                                    <span>All Brands</span>
                                </a>
                                @foreach($brandsWithCount as $brand)
                                    <a href="{{ request()->fullUrlWithQuery(['brand' => $brand->name]) }}" class="filter-link-item {{ request('brand') == $brand->name ? 'active' : '' }}">
                                        <span>{{ $brand->name }}</span>
                                        <span class="filter-count-badge">{{ $brand->listings_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Listing Type Filter -->
                    <div class="filter-group">
                        <span class="filter-group-title">Offer Format</span>
                        <div class="d-flex flex-column gap-1">
                            <a href="{{ request()->fullUrlWithQuery(['listing_type' => null]) }}" class="filter-link-item {{ !request('listing_type') ? 'active' : '' }}">
                                <span>All Listings</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['listing_type' => 'individual']) }}" class="filter-link-item {{ request('listing_type') == 'individual' ? 'active' : '' }}">
                                <span><i class="fas fa-box me-2 text-teal-600"></i>Single Device</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['listing_type' => 'bulk_lot']) }}" class="filter-link-item {{ request('listing_type') == 'bulk_lot' ? 'active' : '' }}">
                                <span><i class="fas fa-boxes-stacked me-2 text-amber-500" style="color: #f59e0b;"></i>Bulk Scrap Lots</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. RIGHT COLUMN: CATALOG TOOLBAR & PRODUCTS GRID -->
            <div class="col-lg-9">
                <!-- Toolbar Bar -->
                <div class="catalog-toolbar d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <!-- Mobile Filter Drawer Trigger -->
                        <button class="btn btn-sm btn-outline-dark d-lg-none fw-bold" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilterDrawer">
                            <i class="fas fa-filter me-1"></i>Filters
                        </button>
                        <span style="font-size: 0.9rem; color: #475569; font-weight: 600;">
                            Showing <strong class="text-dark">{{ $listings->firstItem() ?? 0 }}–{{ $listings->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $listings->total() }}</strong> devices
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <!-- Sort Control Form -->
                        <form method="GET" action="{{ route('listings.index') }}" class="d-flex align-items-center gap-2 m-0" id="sortForm">
                            @foreach(request()->except(['sort', 'page']) as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <label for="catalog-sort" class="d-none d-sm-inline" style="font-size: 0.85rem; font-weight: 700; color: #64748b;">Sort:</label>
                            <select name="sort" id="catalog-sort" class="catalog-sort-select" onchange="document.getElementById('sortForm').submit()">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Arrivals</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="co2_high" {{ request('sort') == 'co2_high' ? 'selected' : '' }}>Highest CO₂ Saved</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            </select>
                        </form>

                        <!-- View Switcher -->
                        <div class="d-none d-sm-flex align-items-center gap-1">
                            <button type="button" class="view-switch-btn active" id="btn-grid-view" onclick="setCatalogView('grid')" title="Grid View">
                                <i class="fas fa-grid-2"></i>
                            </button>
                            <button type="button" class="view-switch-btn" id="btn-list-view" onclick="setCatalogView('list')" title="List View">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid Container -->
                <div class="row g-3 g-md-4" id="catalogContainer">
                    @forelse($listings as $listing)
                        @php
                            $photos = is_array($listing->photos) ? $listing->photos : json_decode($listing->photos, true) ?? [];
                            $primaryPhoto = count($photos) > 0 ? $photos[0] : null;
                            $isSaved = isset($savedListingIds) && $savedListingIds->contains($listing->id);
                        @endphp
                        <div class="col-6 col-md-4 col-lg-4">
                            <div class="m-card">
                                <!-- Card Media -->
                                <div class="m-card-media">
                                    @if($primaryPhoto)
                                        <img src="{{ $primaryPhoto }}" alt="{{ $listing->category ?: 'Listing' }}">
                                    @else
                                        <div style="color: #94a3b8; font-size: 3rem;"><i class="fas fa-microchip"></i></div>
                                    @endif

                                    <!-- Condition Badge -->
                                    <span class="m-card-badge {{ $listing->condition === 'functional' ? 'badge-functional' : ($listing->condition === 'repairable' ? 'badge-repairable' : 'badge-for_parts') }}">
                                        {{ str_replace('_', ' ', ucfirst($listing->condition ?? 'working')) }}
                                    </span>

                                    <!-- Wishlist Heart Button -->
                                    @auth
                                        @if(auth()->user()->isBuyer())
                                            <form method="POST" action="{{ $isSaved ? route('buyer.saved-items.destroy', $listing) : route('buyer.saved-items.store', $listing) }}" style="display: inline;">
                                                @csrf
                                                @if($isSaved)
                                                    @method('DELETE')
                                                @endif
                                                <button type="submit" class="m-card-wishlist {{ $isSaved ? 'active' : '' }}" title="{{ $isSaved ? 'Remove from Saved' : 'Save to Wishlist' }}">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="m-card-wishlist" title="Sign in to save">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    @endauth
                                </div>

                                <!-- Card Body -->
                                <div class="m-card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span style="font-size: 0.74rem; font-weight: 800; color: #0d9488; text-transform: uppercase;">
                                            {{ $listing->category ?: ($listing->deviceType?->name ?: 'Hardware') }}
                                        </span>
                                        @if($listing->carbon_footprint)
                                            <span class="m-card-co2">
                                                <i class="fas fa-leaf me-1"></i>-{{ $listing->carbon_footprint }}kg CO₂
                                            </span>
                                        @endif
                                    </div>

                                    <h6 style="font-weight: 800; font-size: 0.98rem; color: #0f172a; margin-bottom: 0.5rem; line-height: 1.35; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        <a href="{{ route('listings.show', $listing) }}" class="text-decoration-none text-dark">
                                            @if($listing->device_details)
                                                {{ $listing->device_details }}
                                            @elseif($listing->deviceModel)
                                                {{ $listing->deviceModel->model_name }} {{ $listing->deviceBrand ? '('.$listing->deviceBrand->name.')' : '' }}
                                            @else
                                                {{ $listing->description ? Str::limit($listing->description, 50) : 'Electronic Device' }}
                                            @endif
                                        </a>
                                    </h6>

                                    <!-- Seller Snippet -->
                                    <div class="d-flex align-items-center gap-1 mb-3" style="font-size: 0.78rem; color: #64748b;">
                                        <i class="fas fa-circle-check text-teal-600" style="color: #0d9488;"></i>
                                        <span class="text-truncate">{{ $listing->seller?->name ?? 'Verified Seller' }}</span>
                                    </div>

                                    <!-- Price & Actions Footer -->
                                    <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                        <div>
                                            <small style="color: #64748b; font-size: 0.7rem; display: block; font-weight: 700;">PRICE</small>
                                            <span class="m-card-price">
                                                @if($listing->suggested_price > 0)
                                                    ₱{{ number_format($listing->suggested_price, 2) }}
                                                @else
                                                    <span class="text-success" style="font-size: 0.92rem;">Free / Scrap</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            @auth
                                                @if(auth()->user()->isBuyer() && auth()->user()->is_verified)
                                                    <a href="{{ route('offers.create', $listing) }}" class="btn btn-sm btn-outline-success fw-bold px-2 py-1" style="font-size: 0.78rem; border-radius: 0.5rem;" title="Make an Offer">
                                                        Offer
                                                    </a>
                                                @endif
                                            @endauth
                                            <a href="{{ route('listings.show', $listing) }}" class="btn btn-sm btn-primary fw-bold px-3 py-1" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); border: none; font-size: 0.78rem; border-radius: 0.5rem;">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 bg-white rounded-4 border">
                            <i class="fas fa-inbox text-muted" style="font-size: 3.5rem; margin-bottom: 1rem;"></i>
                            <h4 class="fw-bold text-dark mb-2">No Devices Match Your Filter</h4>
                            <p class="text-muted mb-4">Try removing some filter attributes or search for broader keywords.</p>
                            <a href="{{ route('listings.index') }}" class="btn btn-dark fw-bold px-4 py-2" style="border-radius: 0.75rem;">
                                <i class="fas fa-rotate-left me-1"></i>Reset All Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Modern Pagination -->
                @if($listings->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $listings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Mobile Filter Offcanvas Drawer -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileFilterDrawer" aria-labelledby="mobileFilterDrawerLabel" style="width: 320px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="mobileFilterDrawerLabel">
            <i class="fas fa-filter me-2 text-teal-600" style="color: #0d9488;"></i>Filter Catalog
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3">
        <!-- Categories -->
        <div class="mb-4">
            <h6 class="fw-bold text-uppercase text-muted" style="font-size: 0.8rem;">Category</h6>
            <div class="d-flex flex-column gap-1">
                <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="filter-link-item {{ !request('category') ? 'active' : '' }}">
                    All Categories
                </a>
                @foreach($categoriesWithCount as $cat)
                    <a href="{{ request()->fullUrlWithQuery(['category' => $cat->name]) }}" class="filter-link-item {{ request('category') == $cat->name ? 'active' : '' }}">
                        {{ $cat->name }} ({{ $cat->listings_count }})
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Condition -->
        <div class="mb-4">
            <h6 class="fw-bold text-uppercase text-muted" style="font-size: 0.8rem;">Condition</h6>
            <div class="d-flex flex-column gap-1">
                <a href="{{ request()->fullUrlWithQuery(['condition' => null]) }}" class="filter-link-item {{ !request('condition') ? 'active' : '' }}">
                    All Conditions
                </a>
                <a href="{{ request()->fullUrlWithQuery(['condition' => 'functional']) }}" class="filter-link-item {{ request('condition') == 'functional' ? 'active' : '' }}">
                    Certified Working
                </a>
                <a href="{{ request()->fullUrlWithQuery(['condition' => 'repairable']) }}" class="filter-link-item {{ request('condition') == 'repairable' ? 'active' : '' }}">
                    Repairable Deals
                </a>
                <a href="{{ request()->fullUrlWithQuery(['condition' => 'for_parts']) }}" class="filter-link-item {{ request('condition') == 'for_parts' ? 'active' : '' }}">
                    For Parts / Scrap
                </a>
            </div>
        </div>

        <a href="{{ route('listings.index') }}" class="btn btn-outline-danger w-100 fw-bold mt-3">
            Reset All Filters
        </a>
    </div>
</div>

<script>
    // Grid vs List View toggle
    function setCatalogView(mode) {
        const container = document.getElementById('catalogContainer');
        const btnGrid = document.getElementById('btn-grid-view');
        const btnList = document.getElementById('btn-list-view');

        if (mode === 'list') {
            container.classList.add('catalog-list-view');
            btnList.classList.add('active');
            btnGrid.classList.remove('active');
            localStorage.setItem('catalog_view_mode', 'list');
        } else {
            container.classList.remove('catalog-list-view');
            btnGrid.classList.add('active');
            btnList.classList.remove('active');
            localStorage.setItem('catalog_view_mode', 'grid');
        }
    }

    // Initialize saved view preference
    document.addEventListener('DOMContentLoaded', () => {
        const savedView = localStorage.getItem('catalog_view_mode');
        if (savedView === 'list') {
            setCatalogView('list');
        }
    });
</script>
@endsection

@extends('layouts.app')

@section('title', ($listing->deviceBrand?->name ? $listing->deviceBrand->name . ' ' : '') . ($listing->deviceModel?->model_name ?: ($listing->category ?: ($listing->deviceType?->name ?: 'Hardware'))) . ' - E-Benta Marketplace')

@section('styles')
<style>
    .pdp-gallery-main {
        position: relative;
        width: 100%;
        height: 480px;
        background: #0f172a;
        border-radius: 1.25rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    .pdp-gallery-main img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.35s ease;
    }
    .pdp-gallery-main:hover img {
        transform: scale(1.04);
    }
    .pdp-thumb-item {
        width: 80px;
        height: 80px;
        border-radius: 0.75rem;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        background: #1e293b;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .pdp-thumb-item.active {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
    }
    .pdp-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .pdp-buy-box {
        position: sticky;
        top: 110px;
        background: var(--card-bg, #ffffff);
        border: 1px solid rgba(13, 148, 136, 0.18);
        border-radius: 1.25rem;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
        padding: 1.75rem;
    }
    .pdp-badge-overlay {
        position: absolute;
        top: 1rem;
        left: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        z-index: 2;
    }
    .pdp-badge-pill {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        backdrop-filter: blur(6px);
    }
    .pdp-nav-tab {
        border: none;
        background: transparent;
        padding: 0.85rem 1.25rem;
        font-weight: 700;
        font-size: 0.95rem;
        color: #64748b;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease;
    }
    .pdp-nav-tab.active {
        color: #10b981;
        border-bottom-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .pdp-spec-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        font-size: 0.92rem;
    }
    .pdp-spec-row:last-child {
        border-bottom: none;
    }
    .pdp-spec-label {
        color: #64748b;
        font-weight: 600;
    }
    .pdp-spec-value {
        color: var(--text-color, #1e293b);
        font-weight: 700;
        text-align: right;
    }
    .pdp-trust-item {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        padding: 0.75rem 0;
        border-bottom: 1px dashed rgba(13, 148, 136, 0.2);
    }
    .pdp-trust-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .pdp-card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1rem;
        background: var(--card-bg, #ffffff);
    }
    .pdp-card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.15);
    }
    @media (max-width: 991px) {
        .pdp-gallery-main {
            height: 360px;
        }
        .pdp-buy-box {
            position: static;
            margin-top: 2rem;
        }
    }
    @media (max-width: 576px) {
        .pdp-gallery-main {
            height: 280px;
        }
        .pdp-thumb-item {
            width: 64px;
            height: 64px;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-3">
    <!-- Breadcrumb Bar -->
    <nav aria-label="breadcrumb" class="mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 py-2 px-3 rounded-3" style="background: rgba(13, 148, 136, 0.05); border: 1px solid rgba(13, 148, 136, 0.12);">
            <ol class="breadcrumb mb-0 align-items-center" style="font-size: 0.88rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none fw-semibold" style="color: #0d9488;">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('listings.index') }}" class="text-decoration-none fw-semibold" style="color: #0d9488;">
                        Marketplace
                    </a>
                </li>
                @if($listing->deviceType)
                    <li class="breadcrumb-item">
                        <a href="{{ route('listings.index', ['category' => $listing->deviceType->name]) }}" class="text-decoration-none fw-semibold" style="color: #0d9488;">
                            {{ $listing->deviceType->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active text-truncate fw-bold" aria-current="page" style="max-width: 260px; color: #475569;">
                    {{ $listing->deviceBrand?->name ? $listing->deviceBrand->name . ' ' : '' }}{{ $listing->deviceModel?->model_name ?: ($listing->category ?: ($listing->deviceType?->name ?: 'Hardware')) }}
                </li>
            </ol>

            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="navigator.clipboard.writeText(window.location.href); alert('Listing link copied to clipboard!');" title="Share hardware listing">
                    <i class="fas fa-share-alt me-1"></i>Share
                </button>
                @auth
                    @if(auth()->user()->isBuyer())
                        <form action="{{ route('buyer.saved-items.store', $listing) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm rounded-pill px-3 {{ $isSaved ? 'btn-danger' : 'btn-outline-danger' }}" title="{{ $isSaved ? 'Saved in Wishlist' : 'Add to Wishlist' }}">
                                <i class="{{ $isSaved ? 'fas' : 'far' }} fa-heart me-1"></i>{{ $isSaved ? 'Saved' : 'Wishlist' }}
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main PDP Row -->
    <div class="row g-4">
        <!-- LEFT COLUMN: Gallery & Diagnostic Assessment -->
        <div class="col-lg-7">
            <!-- Gallery Card -->
            <div class="card border-0 rounded-4 shadow-sm p-3 mb-4" style="background: var(--card-bg, #ffffff); border: 1px solid rgba(13, 148, 136, 0.18) !important;">
                @php
                    $photosList = $listing->listingPhotos->pluck('photo_url')->toArray();
                    if (empty($photosList) && !empty($listing->photos)) {
                        $photosList = is_array($listing->photos) ? $listing->photos : [];
                    }
                @endphp

                <!-- Main Gallery Viewport -->
                <div class="pdp-gallery-main">
                    <!-- Overlay Badges -->
                    <div class="pdp-badge-overlay">
                        @if($listing->condition === 'functional')
                            <span class="pdp-badge-pill" style="background: rgba(16, 185, 129, 0.92); color: #fff;">
                                <i class="fas fa-check-circle me-1"></i>GRADE A • CERTIFIED WORKING
                            </span>
                        @elseif($listing->condition === 'repairable')
                            <span class="pdp-badge-pill" style="background: rgba(245, 158, 11, 0.92); color: #fff;">
                                <i class="fas fa-tools me-1"></i>GRADE B • REPAIRABLE / DEFECT
                            </span>
                        @else
                            <span class="pdp-badge-pill" style="background: rgba(100, 116, 139, 0.92); color: #fff;">
                                <i class="fas fa-recycle me-1"></i>GRADE C • SALVAGE / FOR PARTS
                            </span>
                        @endif

                        @if($listing->isBulkLot())
                            <span class="pdp-badge-pill" style="background: rgba(139, 92, 246, 0.92); color: #fff;">
                                <i class="fas fa-boxes me-1"></i>BULK LOT ({{ $listing->lot_item_count ?? 'Multiple' }} Items)
                            </span>
                        @endif

                        @if($listing->carbon_footprint > 0)
                            <span class="pdp-badge-pill" style="background: rgba(13, 148, 136, 0.92); color: #fff;">
                                <i class="fas fa-leaf me-1"></i>-{{ $listing->carbon_footprint }} kg CO₂ Impact
                            </span>
                        @endif
                    </div>

                    @if(!empty($photosList))
                        <img id="mainListingImage" src="{{ $photosList[0] }}" alt="{{ $listing->category ?: 'Listing Image' }}">
                    @else
                        <div class="text-center py-5 text-white">
                            <i class="fas fa-microchip fa-4x mb-3 text-emerald" style="color: #10b981; opacity: 0.6;"></i>
                            <p class="mb-0 fw-semibold text-muted">No visual hardware photo attached</p>
                        </div>
                    @endif
                </div>

                <!-- Thumbnails Strip -->
                @if(count($photosList) > 1)
                    <div class="d-flex gap-2 overflow-auto pt-3 pb-1" id="thumbStrip">
                        @foreach($photosList as $idx => $photoUrl)
                            <div class="pdp-thumb-item {{ $idx === 0 ? 'active' : '' }}" onclick="changeMainImage('{{ $photoUrl }}', this)">
                                <img src="{{ $photoUrl }}" alt="Thumb {{ $idx + 1 }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Detailed Specifications & Tabs Card -->
            <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden" style="background: var(--card-bg, #ffffff); border: 1px solid rgba(13, 148, 136, 0.18) !important;">
                <div class="border-bottom px-3 pt-2 d-flex flex-wrap gap-2" style="background: rgba(13, 148, 136, 0.03);">
                    <button class="pdp-nav-tab active" onclick="switchPdpTab('specs', this)">
                        <i class="fas fa-list-ul me-1"></i>Specifications
                    </button>
                    <button class="pdp-nav-tab" onclick="switchPdpTab('diagnostic', this)">
                        <i class="fas fa-stethoscope me-1"></i>Diagnostic Assessment
                    </button>
                    <button class="pdp-nav-tab" onclick="switchPdpTab('description', this)">
                        <i class="fas fa-align-left me-1"></i>Full Description
                    </button>
                    <button class="pdp-nav-tab" onclick="switchPdpTab('esg', this)">
                        <i class="fas fa-seedling me-1"></i>Circular Impact
                    </button>
                </div>

                <div class="card-body p-4">
                    <!-- Tab 1: Specifications -->
                    <div id="tab-specs" class="pdp-tab-pane">
                        <h6 class="fw-bold mb-3" style="color: #0f172a;">
                            <i class="fas fa-microchip me-2 text-emerald" style="color: #10b981;"></i>Technical Hardware Matrix
                        </h6>
                        <div class="rounded-3 overflow-hidden" style="border: 1px solid rgba(13, 148, 136, 0.15); background: rgba(13, 148, 136, 0.015);">
                            <div class="pdp-spec-row">
                                <span class="pdp-spec-label"><i class="fas fa-laptop me-2"></i>Device Category</span>
                                <span class="pdp-spec-value">{{ $listing->deviceType?->name ?: ($listing->category ?: 'Electronics') }}</span>
                            </div>
                            <div class="pdp-spec-row">
                                <span class="pdp-spec-label"><i class="fas fa-tag me-2"></i>Manufacturer / Brand</span>
                                <span class="pdp-spec-value">{{ $listing->deviceBrand?->name ?: 'OEM / Unbranded' }}</span>
                            </div>
                            <div class="pdp-spec-row">
                                <span class="pdp-spec-label"><i class="fas fa-barcode me-2"></i>Model Name / Series</span>
                                <span class="pdp-spec-value">{{ $listing->deviceModel?->model_name ?: ($listing->device_details ?: 'Standard Model') }}</span>
                            </div>
                            <div class="pdp-spec-row">
                                <span class="pdp-spec-label"><i class="fas fa-shield-alt me-2"></i>Grading Condition</span>
                                <span class="pdp-spec-value text-capitalize">{{ str_replace('_', ' ', $listing->condition) }}</span>
                            </div>
                            <div class="pdp-spec-row">
                                <span class="pdp-spec-label"><i class="fas fa-weight-hanging me-2"></i>Gross Hardware Weight</span>
                                <span class="pdp-spec-value">{{ $listing->estimated_weight ? $listing->estimated_weight . ' kg' : 'Standard Estimate' }}</span>
                            </div>
                            <div class="pdp-spec-row">
                                <span class="pdp-spec-label"><i class="fas fa-bullseye me-2"></i>Intended Action</span>
                                <span class="pdp-spec-value text-capitalize">{{ $listing->intended_action ?: 'Direct Resale' }}</span>
                            </div>
                            <div class="pdp-spec-row">
                                <span class="pdp-spec-label"><i class="fas fa-shipping-fast me-2"></i>Handover Fulfillment</span>
                                <span class="pdp-spec-value">
                                    @if(($listing->handover_preference ?? 'both') === 'pickup_only')
                                        Doorstep Pickup Only
                                    @elseif(($listing->handover_preference ?? 'both') === 'meetup_only')
                                        Public Meetup Only
                                    @else
                                        Pickup & Meetup Supported
                                    @endif
                                </span>
                            </div>
                            @if($listing->pickup_address)
                                <div class="pdp-spec-row">
                                    <span class="pdp-spec-label"><i class="fas fa-map-marker-alt me-2"></i>Dispatch Location</span>
                                    <span class="pdp-spec-value text-truncate" style="max-width: 300px;">{{ $listing->pickup_address }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tab 2: Diagnostic Assessment -->
                    <div id="tab-diagnostic" class="pdp-tab-pane d-none">
                        <h6 class="fw-bold mb-3" style="color: #0f172a;">
                            <i class="fas fa-clipboard-check me-2 text-emerald" style="color: #10b981;"></i>Hardware Operational Evaluation
                        </h6>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 border" style="background: rgba(16, 185, 129, 0.04); border-color: rgba(16, 185, 129, 0.2) !important;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-bold fs-6"><i class="fas fa-tv me-2 text-emerald" style="color: #10b981;"></i>Display & Glass</span>
                                        @if($listing->condition === 'functional')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="fas fa-check me-1"></i>No Cracks</span>
                                        @elseif($listing->condition === 'repairable')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle"><i class="fas fa-exclamation me-1"></i>Minor Scratches</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border"><i class="fas fa-times me-1"></i>Check Parts</span>
                                        @endif
                                    </div>
                                    <small class="text-muted d-block">Screen matrix integrity, backlight bleed test, touch digitization response.</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 border" style="background: rgba(16, 185, 129, 0.04); border-color: rgba(16, 185, 129, 0.2) !important;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-bold fs-6"><i class="fas fa-battery-half me-2 text-warning" style="color: #f59e0b;"></i>Power & Battery</span>
                                        @if($listing->condition === 'functional')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="fas fa-check me-1"></i>Powers On</span>
                                        @elseif($listing->condition === 'repairable')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle"><i class="fas fa-plug me-1"></i>Degraded / Plug In</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border"><i class="fas fa-times me-1"></i>Untested / Depleted</span>
                                        @endif
                                    </div>
                                    <small class="text-muted d-block">Charging port pins, cell voltage stability, power IC retention.</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 border" style="background: rgba(16, 185, 129, 0.04); border-color: rgba(16, 185, 129, 0.2) !important;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-bold fs-6"><i class="fas fa-hdd me-2 text-info" style="color: #0284c7;"></i>Motherboard / IC</span>
                                        @if($listing->condition === 'functional')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="fas fa-check me-1"></i>BOOTS OS</span>
                                        @elseif($listing->condition === 'repairable')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle"><i class="fas fa-wrench me-1"></i>Needs Service</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border"><i class="fas fa-microchip me-1"></i>Raw Donor Board</span>
                                        @endif
                                    </div>
                                    <small class="text-muted d-block">BIOS post status, logic traces, memory controller bus.</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 border" style="background: rgba(16, 185, 129, 0.04); border-color: rgba(16, 185, 129, 0.2) !important;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-bold fs-6"><i class="fas fa-shield-alt me-2 text-primary" style="color: #6366f1;"></i>Physical Enclosure</span>
                                        <span class="badge bg-light text-dark border">
                                            {{ ucfirst(str_replace('_', ' ', $listing->condition)) }}
                                        </span>
                                    </div>
                                    <small class="text-muted d-block">Hinges, casing screws, chassis alignment and exterior wear.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Description -->
                    <div id="tab-description" class="pdp-tab-pane d-none">
                        <h6 class="fw-bold mb-3" style="color: #0f172a;">
                            <i class="fas fa-comment-dots me-2 text-emerald" style="color: #10b981;"></i>Seller's Item Narrative
                        </h6>
                        <div class="p-3 rounded-3" style="background: rgba(241, 245, 249, 0.6); border: 1px solid #e2e8f0; font-size: 0.96rem; line-height: 1.7; color: #334155; white-space: pre-line;">
                            {{ $listing->description ?: 'No detailed written description provided by the seller. Please consult the specifications matrix and photos or message the merchant directly.' }}
                        </div>
                    </div>

                    <!-- Tab 4: Circular ESG Impact -->
                    <div id="tab-esg" class="pdp-tab-pane d-none">
                        <div class="p-4 rounded-4" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(13, 148, 136, 0.03) 100%); border: 1.5px solid rgba(16, 185, 129, 0.25);">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 1.5rem;">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0" style="color: #065f46;">Circular Economy Contribution</h5>
                                    <small class="text-muted">By purchasing refurbished or salvage gear, you keep toxic heavy metals out of landfills.</small>
                                </div>
                            </div>

                            <div class="row g-3 text-center">
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3 bg-white shadow-sm border border-success-subtle">
                                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.75rem;">CO₂ Footprint Avoided</small>
                                        <span class="fs-2 fw-bolder text-emerald" style="color: #10b981;">
                                            {{ number_format($listing->carbon_footprint ?? 0, 1) }} <span class="fs-6 text-muted">kg</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 rounded-3 bg-white shadow-sm border border-info-subtle">
                                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.75rem;">E-Scrap Mass Rescued</small>
                                        <span class="fs-2 fw-bolder text-info" style="color: #0284c7;">
                                            {{ number_format($listing->estimated_weight ?? 0, 1) }} <span class="fs-6 text-muted">kg</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seller Feedback Preview -->
            @php
                $avgRating = $listing->seller->getAverageRating();
                $totalReviews = $listing->seller->getTotalReviews();
            @endphp
            <div class="card border-0 rounded-4 shadow-sm p-4 mb-4" style="background: var(--card-bg, #ffffff); border: 1px solid rgba(13, 148, 136, 0.18) !important;">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <h6 class="fw-bold mb-0" style="color: #0f172a;">
                        <i class="fas fa-star me-2 text-warning"></i>Merchant Rating & Feedback
                    </h6>
                    <a href="{{ route('users.show', $listing->seller) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        View Seller Profile <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>

                @if($totalReviews > 0)
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3" style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.2);">
                        <div class="fs-1 fw-bold text-warning lh-1">{{ number_format($avgRating, 1) }}</div>
                        <div>
                            <div class="text-warning mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= round($avgRating) ? '' : '-half-alt' }} {{ $i > ceil($avgRating) ? 'text-muted' : '' }}"></i>
                                @endfor
                            </div>
                            <small class="text-muted fw-semibold">Based on {{ $totalReviews }} verified transaction review{{ $totalReviews == 1 ? '' : 's' }}</small>
                        </div>
                    </div>
                @else
                    <div class="p-3 rounded-3 text-center text-muted" style="background: rgba(241, 245, 249, 0.6); border: 1px dashed #cbd5e1;">
                        <i class="fas fa-shield-alt fa-2x mb-2 text-secondary"></i>
                        <p class="mb-0 fw-semibold">New verified hardware merchant. First reviews appear after successful handover.</p>
                    </div>
                @endif
            </div>

            <!-- Similar Hardware Listings -->
            @if(isset($relatedListings) && $relatedListings->count() > 0)
                <div class="mt-4">
                    <h5 class="fw-bold mb-3" style="color: #0f172a;">
                        <i class="fas fa-stream me-2 text-emerald" style="color: #10b981;"></i>Similar Hardware Finds
                    </h5>
                    <div class="row g-3">
                        @foreach($relatedListings as $rel)
                            @php
                                $relThumb = $rel->listingPhotos->first()?->photo_url;
                            @endphp
                            <div class="col-sm-6">
                                <a href="{{ route('listings.show', $rel) }}" class="text-decoration-none text-dark">
                                    <div class="p-3 rounded-4 pdp-card-hover h-100 d-flex gap-3 align-items-center">
                                        <div class="rounded-3 overflow-hidden flex-shrink-0" style="width: 75px; height: 75px; background: #0f172a;">
                                            @if($relThumb)
                                                <img src="{{ $relThumb }}" alt="{{ $rel->category }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                                    <i class="fas fa-microchip text-emerald"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="overflow-hidden flex-grow-1">
                                            <span class="badge bg-light text-secondary border mb-1" style="font-size: 0.7rem;">
                                                {{ $rel->deviceType?->name ?: 'Hardware' }}
                                            </span>
                                            <h6 class="fw-bold mb-1 text-truncate" style="font-size: 0.9rem;">
                                                {{ $rel->deviceBrand?->name ? $rel->deviceBrand->name . ' ' : '' }}{{ $rel->deviceModel?->model_name ?: ($rel->category ?: 'Item') }}
                                            </h6>
                                            <span class="fw-bolder" style="color: #10b981; font-size: 0.95rem;">
                                                @if($rel->suggested_price > 0)
                                                    ₱{{ number_format($rel->suggested_price, 2) }}
                                                @else
                                                    FREE
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Sticky E-Commerce Buy Box -->
        <div class="col-lg-5">
            <div class="pdp-buy-box">
                <!-- Device Header & Brand Tag -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge text-uppercase px-2.5 py-1.5" style="background: rgba(13, 148, 136, 0.1); color: #0d9488; font-weight: 700; font-size: 0.75rem; border: 1px solid rgba(13, 148, 136, 0.25);">
                            <i class="fas fa-tag me-1"></i>{{ $listing->deviceBrand?->name ?: ($listing->deviceType?->name ?: 'Hardware') }}
                        </span>
                        <span class="badge rounded-pill {{ $listing->status === 'available' ? 'bg-success' : 'bg-secondary' }} px-3 py-1.5" style="font-weight: 700; font-size: 0.75rem;">
                            {{ strtoupper($listing->status) }}
                        </span>
                    </div>

                    <h1 class="h3 fw-bolder mb-1" style="color: #0f172a; line-height: 1.3;">
                        {{ $listing->deviceBrand?->name ? $listing->deviceBrand->name . ' ' : '' }}{{ $listing->deviceModel?->model_name ?: ($listing->category ?: ($listing->deviceType?->name ?: 'Hardware Component')) }}
                    </h1>
                    @if($listing->device_details)
                        <p class="text-muted small mb-0">{{ $listing->device_details }}</p>
                    @endif
                </div>

                <!-- Price Box -->
                <div class="p-3 rounded-3 mb-3" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(13, 148, 136, 0.04) 100%); border: 1.5px solid rgba(16, 185, 129, 0.25);">
                    <div class="d-flex align-items-baseline justify-content-between">
                        <div>
                            <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                {{ $listing->isBulkLot() ? 'Bulk Lot Value' : 'Listing Asking Price' }}
                            </small>
                            <div class="fs-1 fw-bolder" style="color: #059669; letter-spacing: -0.5px;">
                                @if($listing->suggested_price > 0)
                                    ₱{{ number_format($listing->suggested_price, 2) }}
                                @else
                                    <span class="badge bg-success">FREE (Eco-Recycle)</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-white text-dark border shadow-2xs px-2.5 py-1.5" style="font-size: 0.78rem;">
                                <i class="fas fa-handshake text-emerald me-1" style="color: #10b981;"></i>Offers Welcome
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Inventory & Logistics Summary -->
                <div class="p-3 rounded-3 mb-3 border" style="background: rgba(248, 250, 252, 0.8); border-color: rgba(226, 232, 240, 0.8) !important;">
                    <div class="d-flex align-items-center gap-2 mb-2 text-emerald fw-bold" style="color: #10b981; font-size: 0.88rem;">
                        <i class="fas fa-check-circle"></i>
                        @if($listing->isBulkLot())
                            <span>Bundle In Stock ({{ $listing->lot_item_count }} units packed together)</span>
                        @else
                            <span>1 Unit In Stock (Unique Serial / Tested Item)</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-start gap-2 mb-2" style="font-size: 0.86rem; color: #475569;">
                        <i class="fas fa-map-pin mt-1 text-danger"></i>
                        <div>
                            <strong>Pickup / Inspection Location:</strong><br>
                            {{ $listing->pickup_address ?: 'Contact seller for designated meetup point' }}
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2" style="font-size: 0.86rem; color: #475569;">
                        <i class="fas fa-truck text-primary"></i>
                        <span>
                            <strong>Handover Mode:</strong>
                            @if(($listing->handover_preference ?? 'both') === 'pickup_only')
                                Seller Doorstep Collection
                            @elseif(($listing->handover_preference ?? 'both') === 'meetup_only')
                                Public Spot Meetup
                            @else
                                Flexible: Doorstep or Safe Meetup
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Merchant Profile Capsule -->
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3 mb-4 border" style="background: rgba(13, 148, 136, 0.03); border-color: rgba(13, 148, 136, 0.18) !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 44px; height: 44px; background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);">
                            {{ strtoupper(substr($listing->seller->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="fw-bold" style="color: #0f172a; font-size: 0.95rem;">
                                {{ $listing->seller->name }}
                            </div>
                            <div class="d-flex align-items-center gap-1" style="font-size: 0.8rem; color: #64748b;">
                                <i class="fas fa-shield-alt text-emerald" style="color: #10b981;"></i>
                                <span>Verified Member</span>
                                <span>•</span>
                                <span>{{ $listing->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('users.show', $listing->seller) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size: 0.8rem;">
                        Profile
                    </a>
                </div>

                <!-- PRIMARY COMMERCE ACTIONS -->
                @if($listing->isAvailable())
                    @auth
                        @if(auth()->user()->isBuyer() && auth()->id() !== $listing->user_id)
                            <div class="d-grid gap-2 mb-3">
                                <a href="{{ route('offers.create', $listing) }}" class="btn btn-lg py-3 rounded-3 fw-bold text-white shadow-md d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #10b981 0%, #0d9488 100%); border: none; font-size: 1.05rem;">
                                    <i class="fas fa-shopping-bag"></i> Make an Offer / Buy Now
                                </a>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary rounded-3 py-2 flex-grow-1 fw-bold">
                                        <i class="fas fa-comment-dots me-1"></i>Chat with Seller
                                    </a>
                                    <form action="{{ route('buyer.saved-items.store', $listing) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger rounded-3 py-2 px-3" title="Save to Wishlist">
                                            <i class="{{ $isSaved ? 'fas' : 'far' }} fa-heart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @elseif(auth()->user()->isSeller() && auth()->id() === $listing->user_id)
                            <div class="d-grid gap-2 mb-3">
                                <div class="alert alert-info py-2 px-3 mb-2 rounded-3 small">
                                    <i class="fas fa-info-circle me-1"></i>You are managing this active marketplace listing.
                                </div>
                                <a href="{{ route('listings.edit', $listing) }}" class="btn btn-warning rounded-3 py-2 fw-bold text-white shadow-sm">
                                    <i class="fas fa-edit me-1"></i>Edit Listing Details
                                </a>
                                @if($listing->status !== 'withdrawn')
                                    <button type="button" class="btn btn-outline-danger rounded-3 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                        <i class="fas fa-ban me-1"></i>Cancel / Withdraw Listing
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-secondary py-2 px-3 mb-3 rounded-3 small">
                                <i class="fas fa-user-lock me-1"></i>Logged in as non-buyer account. Log in with a buyer profile to submit purchase offers.
                            </div>
                        @endif
                    @else
                        <div class="d-grid gap-2 mb-3">
                            <a href="{{ route('login') }}" class="btn btn-lg py-3 rounded-3 fw-bold text-white shadow-sm d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #10b981 0%, #0d9488 100%); border: none;">
                                <i class="fas fa-sign-in-alt"></i> Login to Buy / Make Offer
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary rounded-3 py-2 fw-bold">
                                Create Free Buyer Account
                            </a>
                        </div>
                    @endauth
                @else
                    <!-- Inactive / Matched / Withdrawn Banner -->
                    <div class="alert {{ $listing->status === 'withdrawn' ? 'alert-danger' : ($listing->isMatched() ? 'alert-warning' : 'alert-success') }} rounded-3 p-3 mb-3">
                        <div class="fw-bold mb-1">
                            @if($listing->status === 'withdrawn')
                                <i class="fas fa-ban me-1"></i>Listing Withdrawn
                            @elseif($listing->isMatched())
                                <i class="fas fa-handshake me-1"></i>Item Matched & Under Contract
                            @else
                                <i class="fas fa-check-double me-1"></i>Transaction Completed
                            @endif
                        </div>
                        <small class="d-block opacity-75">
                            @if($listing->status === 'withdrawn')
                                This item has been taken off the market and is no longer available.
                            @elseif($listing->isMatched())
                                A buyer's offer was accepted. Transaction is currently in fulfillment or inspection.
                            @else
                                This item was successfully delivered and e-waste diversion logged.
                            @endif
                        </small>
                    </div>
                @endif

                <!-- Safe Trade Guarantee & Trust Badges -->
                <div class="pt-3 border-top" style="border-color: rgba(226, 232, 240, 0.8) !important;">
                    <div class="pdp-trust-item">
                        <i class="fas fa-shield-alt text-emerald fs-5 mt-1" style="color: #10b981;"></i>
                        <div>
                            <span class="fw-bold d-block" style="font-size: 0.88rem; color: #0f172a;">E-Benta Safe Trade Guarantee</span>
                            <small class="text-muted">Inspect hardware condition in person before confirming release of payment.</small>
                        </div>
                    </div>
                    <div class="pdp-trust-item">
                        <i class="fas fa-certificate text-primary fs-5 mt-1" style="color: #6366f1;"></i>
                        <div>
                            <span class="fw-bold d-block" style="font-size: 0.88rem; color: #0f172a;">Certified Carbon Credits</span>
                            <small class="text-muted">Receive verifiable ESG e-waste diversion certificate upon completion.</small>
                        </div>
                    </div>
                    <div class="pdp-trust-item">
                        <i class="fas fa-headset text-warning fs-5 mt-1" style="color: #f59e0b;"></i>
                        <div>
                            <span class="fw-bold d-block" style="font-size: 0.88rem; color: #0f172a;">Community Moderation</span>
                            <small class="text-muted">Every serial number & listing undergoes automated duplicate & fraud filtering.</small>
                        </div>
                    </div>
                </div>

                <!-- Report Flag -->
                @auth
                    @if(auth()->id() !== $listing->user_id && $listing->status !== 'withdrawn')
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-link text-muted text-decoration-none btn-sm" data-bs-toggle="modal" data-bs-target="#reportListingModal" style="font-size: 0.8rem;">
                                <i class="fas fa-flag me-1 text-danger"></i>Report suspicious listing or misrepresentation
                            </button>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Cancel / Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" style="backdrop-filter: blur(8px);">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header px-4 pt-4 pb-2 border-bottom-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle text-danger" style="width: 44px; height: 44px; font-size: 1.3rem;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Withdraw Listing</h5>
                        <small class="text-muted">Remove hardware from active marketplace</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 py-3">
                <p class="text-secondary mb-3">
                    Are you sure you want to withdraw <strong>{{ $listing->category ?: ($listing->deviceType?->name ?: 'this listing') }}</strong>?
                </p>
                <div class="alert alert-warning rounded-3 small mb-0">
                    <i class="fas fa-info-circle me-1"></i>This listing will no longer accept buyer bids or appear in search results. Environmental impact statistics will remain preserved.
                </div>
            </div>

            <div class="modal-footer px-4 pb-4 pt-2 border-top-0 gap-2">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Keep Active</button>
                <form method="POST" action="{{ route('listings.withdraw', $listing) }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Confirm Withdrawal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Report Listing Modal -->
<div class="modal fade" id="reportListingModal" tabindex="-1" style="backdrop-filter: blur(8px);">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header px-4 pt-4 pb-2 border-bottom-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger-subtle text-danger" style="width: 44px; height: 44px; font-size: 1.3rem;">
                        <i class="fas fa-flag"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Report Listing</h5>
                        <small class="text-muted">Flag incorrect specs or suspicious behavior</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('reports.store') }}">
                @csrf
                <input type="hidden" name="type" value="listing">
                <input type="hidden" name="id" value="{{ $listing->id }}">
                
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Reason for Report <span class="text-danger">*</span></label>
                        <select name="reason" class="form-select rounded-3" required>
                            <option value="">-- Choose an issue --</option>
                            <option value="false_information">Misleading Specs / Wrong Device Model</option>
                            <option value="broken_item_misrepresentation">Condition Worse Than Described</option>
                            <option value="suspicious_behavior">Potential Counterfeit / Fraud</option>
                            <option value="inappropriate_content">Inappropriate Content or Photos</option>
                            <option value="other">Other Violation</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Explanation & Evidence <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control rounded-3" rows="3" required minlength="10" maxlength="1000" placeholder="Please describe the violation in detail so our moderation team can inspect it..."></textarea>
                    </div>

                    <div class="p-2.5 rounded-3 small" style="background: rgba(13, 148, 136, 0.08); border: 1px solid rgba(13, 148, 136, 0.2);">
                        <i class="fas fa-shield-alt text-emerald me-1" style="color: #10b981;"></i>
                        Reports are prioritized and investigated within 24 hours.
                    </div>
                </div>

                <div class="modal-footer px-4 pb-4 pt-2 border-top-0 gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Submit Flag</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function changeMainImage(url, el) {
        const mainImg = document.getElementById('mainListingImage');
        if (mainImg) {
            mainImg.src = url;
        }
        document.querySelectorAll('#thumbStrip .pdp-thumb-item').forEach(item => {
            item.classList.remove('active');
        });
        if (el) {
            el.classList.add('active');
        }
    }

    function switchPdpTab(tabName, el) {
        document.querySelectorAll('.pdp-tab-pane').forEach(pane => pane.classList.add('d-none'));
        document.querySelectorAll('.pdp-nav-tab').forEach(tab => tab.classList.remove('active'));

        const target = document.getElementById('tab-' + tabName);
        if (target) {
            target.classList.remove('d-none');
        }
        if (el) {
            el.classList.add('active');
        }
    }
</script>
@endpush

@extends('layouts.buyer')

@section('title', 'Saved Items - Buyer Hub - E-Benta')

@section('styles')
<style>
    .saved-page-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    .saved-hero-header {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 1.25rem;
        color: #ffffff;
        padding: 2.25rem 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(13, 148, 136, 0.15);
    }

    .saved-hero-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 450px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.25) 0%, rgba(6, 182, 212, 0.12) 50%, transparent 70%);
        pointer-events: none;
    }

    .saved-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
        border-radius: 1.1rem;
        overflow: hidden;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    }

    .saved-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 30px rgba(13, 148, 136, 0.12);
        border-color: rgba(13, 148, 136, 0.35);
    }

    .saved-image-wrapper {
        position: relative;
        width: 100%;
        height: 190px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        overflow: hidden;
    }

    .saved-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .saved-card:hover .saved-image-wrapper img {
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')

<div class="saved-page-wrapper py-4">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row g-4">
            
            <!-- LEFT COLUMN: INTEGRATED BUYER ACCOUNT NAVIGATION -->
            <aside class="col-lg-3 col-xl-3">
                @include('buyer.sidebar')
            </aside>

            <!-- RIGHT COLUMN: SAVED ITEMS CONTENT -->
            <main class="col-lg-9 col-xl-9">
                <!-- HERO HEADER -->
                <div class="saved-hero-header mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative" style="z-index: 1;">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge" style="background: rgba(13, 148, 136, 0.2); color: #2dd4bf; border: 1px solid rgba(13, 148, 136, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                    <i class="fas fa-bookmark me-1"></i>Saved Watchlist
                                </span>
                                <span style="color: #cbd5e1; font-size: 0.85rem;">• {{ $savedListings->total() }} Bookmarked Items</span>
                            </div>
                            <h1 style="font-size: clamp(1.6rem, 2.3vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px; color: #ffffff;">
                                Saved Items & Watchlist
                            </h1>
                            <p style="color: #cbd5e1; font-size: 0.95rem; margin: 0.4rem 0 0;">
                                Quick access to devices and lots you bookmarked for review and bidding.
                            </p>
                        </div>

                        <a href="{{ route('listings.index') }}" class="btn d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.75rem; font-weight: 800; padding: 0.65rem 1.25rem; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);">
                            <i class="fas fa-search"></i>
                            <span>Browse Catalog</span>
                        </a>
                    </div>
                </div>

                <!-- MAIN LISTINGS GRID -->
                <div>
                    @if($savedListings->count() > 0)
                        <div class="row g-3 g-md-4">
                            @foreach($savedListings as $listing)
                                <div class="col-sm-6 col-lg-6 col-xl-4">
                                    <article class="saved-card">
                                        <!-- Image Box -->
                                        <div class="saved-image-wrapper">
                                            @php
                                                $primaryPhoto = $listing->listingPhotos->first()?->photo_url;
                                                if (!$primaryPhoto && !empty($listing->photos)) {
                                                    $decodedPhotos = is_array($listing->photos) ? $listing->photos : (json_decode($listing->photos, true) ?? []);
                                                    $primaryPhoto = !empty($decodedPhotos) ? $decodedPhotos[0] : null;
                                                }
                                                $deviceName = ($listing->deviceBrand?->name ? $listing->deviceBrand->name . ' ' : '') . ($listing->deviceModel?->model_name ?: ($listing->category ?: ($listing->deviceType?->name ?: 'Hardware Item')));
                                            @endphp
                                            @if($primaryPhoto)
                                                <img src="{{ $primaryPhoto }}" alt="{{ $deviceName }}" loading="lazy">
                                            @else
                                                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8;">
                                                    <i class="fas fa-microchip" style="font-size: 2.5rem; opacity: 0.6; margin-bottom: 0.4rem; color: #0d9488;"></i>
                                                    <span style="font-size: 0.75rem; font-weight: 700;">E-Waste Device</span>
                                                </div>
                                            @endif

                                            <!-- Condition Tag -->
                                            <div style="position: absolute; top: 0.75rem; left: 0.75rem;">
                                                @if($listing->condition === 'functional')
                                                    <span class="badge" style="background: rgba(16, 185, 129, 0.9); backdrop-filter: blur(4px); color: #ffffff; font-weight: 800; font-size: 0.68rem; padding: 0.3rem 0.6rem; border-radius: 0.45rem;">
                                                        <i class="fas fa-check-circle me-1"></i>Working
                                                    </span>
                                                @elseif($listing->condition === 'repairable')
                                                    <span class="badge" style="background: rgba(245, 158, 11, 0.9); backdrop-filter: blur(4px); color: #ffffff; font-weight: 800; font-size: 0.68rem; padding: 0.3rem 0.6rem; border-radius: 0.45rem;">
                                                        <i class="fas fa-tools me-1"></i>Repairable
                                                    </span>
                                                @else
                                                    <span class="badge" style="background: rgba(100, 116, 139, 0.9); backdrop-filter: blur(4px); color: #ffffff; font-weight: 800; font-size: 0.68rem; padding: 0.3rem 0.6rem; border-radius: 0.45rem;">
                                                        <i class="fas fa-puzzle-piece me-1"></i>Parts
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Unsave Button Overlay -->
                                            <form action="{{ route('buyer.saved-items.destroy', $listing) }}" method="POST" style="position: absolute; top: 0.75rem; right: 0.75rem; z-index: 2;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="width: 32px; height: 32px; border-radius: 50%; background: rgba(239, 68, 68, 0.9); border: none; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; cursor: pointer; transition: transform 0.2s ease, background 0.2s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.2);" title="Remove from Watchlist" onmouseover="this.style.background='#dc2626'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(239,68,68,0.9)'; this.style.transform='scale(1)';">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="p-3 d-flex flex-column flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between gap-1 mb-1">
                                                <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #0d9488; letter-spacing: 0.5px;">
                                                    {{ $listing->deviceType->name ?? ($listing->category ?? 'Tech') }}
                                                </span>
                                                <span style="font-size: 0.72rem; color: #94a3b8;">
                                                    <i class="fas fa-location-dot me-1"></i>{{ Str::limit($listing->pickup_address ?: 'Local pickup', 15) }}
                                                </span>
                                            </div>

                                            <h6 style="font-weight: 800; font-size: 0.95rem; margin-bottom: 0.4rem; color: #0f172a; line-height: 1.35;" class="text-heading">
                                                <a href="{{ route('listings.show', $listing) }}" style="color: inherit; text-decoration: none;">
                                                    {{ Str::limit($deviceName, 40) }}
                                                </a>
                                            </h6>

                                            <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 1rem; line-height: 1.4; flex-grow: 1;">
                                                {{ Str::limit($listing->description ?? 'No extra specifications provided.', 65) }}
                                            </p>

                                            <!-- Price and Action -->
                                            <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-auto" style="border-top-color: #f1f5f9 !important;">
                                                <div>
                                                    <small style="color: #94a3b8; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; display: block;">Suggested</small>
                                                    <strong style="color: #0d9488; font-size: 1.1rem; font-weight: 900;">
                                                        @if($listing->suggested_price > 0)
                                                            ₱{{ number_format($listing->suggested_price, 2) }}
                                                        @else
                                                            <span style="color: #10b981;">Free Claim</span>
                                                        @endif
                                                    </strong>
                                                </div>

                                                <div class="d-flex align-items-center gap-1">
                                                    <a href="{{ route('listings.show', $listing) }}" class="btn btn-sm d-inline-flex align-items-center gap-1" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; font-weight: 800; border-radius: 0.6rem; padding: 0.45rem 0.85rem; transition: all 0.2s ease;" onmouseover="this.style.background='#0d9488'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(13, 148, 136, 0.12)'; this.style.color='#0d9488';">
                                                        <span>View</span>
                                                        <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>

                        @if($savedListings->hasPages())
                            <div class="mt-4 pt-3 border-top d-flex justify-content-center">
                                {{ $savedListings->links() }}
                            </div>
                        @endif
                    @else
                        <div class="p-5 text-center bg-white rounded-4 border" style="border-color: rgba(13, 148, 136, 0.15) !important;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1rem;">
                                <i class="fas fa-bookmark"></i>
                            </div>
                            <h4 style="font-weight: 800; color: #0f172a;" class="text-heading">No Saved Items Yet</h4>
                            <p style="color: #64748b; font-size: 0.9rem; max-width: 420px; margin: 0.35rem auto 1.5rem;">
                                Explore marketplace devices and click the bookmark button to keep track of items you want to buy later.
                            </p>
                            <a href="{{ route('listings.index') }}" class="btn d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.65rem; font-weight: 800; padding: 0.55rem 1.25rem;">
                                <i class="fas fa-search"></i>
                                <span>Explore Marketplace</span>
                            </a>
                        </div>
                    @endif
                </div>

            </main>
        </div>
    </div>
</div>

@endsection

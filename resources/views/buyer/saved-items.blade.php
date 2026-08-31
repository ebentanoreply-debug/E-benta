@extends('layouts.app')

@section('title', 'Saved Items - Buyer Hub - E-Benta')

@section('styles')
<style>
    .saved-page-container {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    body.dark-mode .saved-page-container {
        background: #09171f;
    }

    .saved-hero-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.25rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    .saved-hero-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 450px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.2) 0%, rgba(6, 182, 212, 0.08) 50%, transparent 70%);
        pointer-events: none;
    }

    .saved-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
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

    body.dark-mode .saved-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.2);
    }

    body.dark-mode .saved-card:hover {
        border-color: rgba(13, 148, 136, 0.45);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.4);
    }

    .saved-image-wrapper {
        position: relative;
        width: 100%;
        height: 190px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        overflow: hidden;
    }

    body.dark-mode .saved-image-wrapper {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
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

@include('buyer.sidebar')

<div class="main-content-wrapper">
    <div class="saved-page-container">
        
        <!-- HERO HEADER -->
        <div class="saved-hero-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: rgba(13, 148, 136, 0.2); color: #2dd4bf; border: 1px solid rgba(13, 148, 136, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-bookmark me-1"></i>Saved Watchlist
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $savedListings->total() }} Bookmarked Items</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            Saved Items & Watchlist
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Quick access to devices and lots you bookmarked for review and bidding.
                        </p>
                    </div>

                    <a href="{{ route('listings.index') }}" class="btn d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.75rem; font-weight: 800; padding: 0.65rem 1.25rem; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);">
                        <i class="fas fa-search"></i>
                        <span>Browse Catalog</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="container-fluid px-3 px-md-4 mt-4">
            @if($savedListings->count() > 0)
                <div class="row g-3 g-md-4">
                    @foreach($savedListings as $listing)
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <article class="saved-card">
                                <!-- Image Box -->
                                <div class="saved-image-wrapper">
                                    @php
                                        $photos = is_array($listing->photos) ? $listing->photos : (json_decode($listing->photos, true) ?? []);
                                        $firstPhoto = count($photos) > 0 ? $photos[0] : null;
                                    @endphp
                                    @if($firstPhoto)
                                        <img src="{{ $firstPhoto }}" alt="{{ $listing->title }}" loading="lazy">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8;">
                                            <i class="fas fa-microchip" style="font-size: 2.5rem; opacity: 0.6; margin-bottom: 0.4rem; color: #0d9488;"></i>
                                            <span style="font-size: 0.75rem; font-weight: 700;">E-Waste Device</span>
                                        </div>
                                    @endif

                                    <!-- Condition Tag -->
                                    <div style="position: absolute; top: 0.75rem; left: 0.75rem;">
                                        <span class="badge" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(4px); color: #ffffff; font-weight: 800; font-size: 0.7rem; padding: 0.3rem 0.6rem; border-radius: 0.45rem; text-transform: uppercase;">
                                            {{ str_replace('_', ' ', $listing->condition ?? 'Good') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between gap-1 mb-1">
                                        <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #0d9488; letter-spacing: 0.5px;">
                                            {{ $listing->deviceType->name ?? ($listing->category ?? 'Electronics') }}
                                        </span>
                                        <span style="font-size: 0.72rem; color: #94a3b8;">
                                            <i class="fas fa-store me-1"></i>{{ Str::limit($listing->seller?->name ?? 'Verified Seller', 14) }}
                                        </span>
                                    </div>

                                    <h6 style="font-weight: 800; font-size: 0.95rem; margin-bottom: 0.4rem; color: #0f172a; line-height: 1.35;" class="text-heading">
                                        {{ Str::limit($listing->title ?: 'Electronic Lot', 40) }}
                                    </h6>

                                    <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 1rem; line-height: 1.4; flex-grow: 1;">
                                        {{ Str::limit($listing->description ?? 'No extra specifications provided.', 65) }}
                                    </p>

                                    <!-- Price -->
                                    <div class="d-flex align-items-center justify-content-between pt-2 border-top mb-3" style="border-top-color: #f1f5f9 !important;">
                                        <div>
                                            <small style="color: #94a3b8; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; display: block;">Price</small>
                                            <strong style="color: #0d9488; font-size: 1.1rem; font-weight: 900;">
                                                @if($listing->suggested_price > 0)
                                                    ₱{{ number_format($listing->suggested_price, 2) }}
                                                @else
                                                    <span style="color: #10b981;">Free Claim</span>
                                                @endif
                                            </strong>
                                        </div>
                                    </div>

                                    <!-- Actions Row -->
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('listings.show', $listing) }}" class="btn btn-sm btn-outline-dark flex-grow-1" style="border-radius: 0.55rem; font-weight: 700; font-size: 0.8rem; padding: 0.45rem;">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>

                                        @if(auth()->user()->is_verified)
                                            <a href="{{ route('offers.create', $listing) }}" class="btn btn-sm btn-dark flex-grow-1" style="border-radius: 0.55rem; font-weight: 700; font-size: 0.8rem; padding: 0.45rem; background: #0d9488; border-color: #0d9488;">
                                                <i class="fas fa-handshake me-1"></i>Offer
                                            </a>
                                        @endif

                                        <form method="POST" action="{{ route('buyer.saved-items.destroy', $listing) }}" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove from saved" style="border-radius: 0.55rem; padding: 0.45rem 0.65rem;">
                                                <i class="fas fa-trash-can"></i>
                                            </button>
                                        </form>
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
    </div>
</div>

@endsection

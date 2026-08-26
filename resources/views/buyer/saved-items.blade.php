@extends('layouts.app')

@section('title', 'Saved Items - E-Benta')

@section('content')
<style>
    .si-wrapper {
        background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 35%, #f0f9ff 100%);
        min-height: 100vh;
        padding: 2rem 0;
        position: relative;
    }

    .si-wrapper::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 700px 450px at 15% 20%, rgba(16, 185, 129, 0.08) 0%, transparent 55%),
            radial-gradient(ellipse 560px 420px at 90% 85%, rgba(59, 130, 246, 0.07) 0%, transparent 55%);
        pointer-events: none;
        z-index: 0;
    }

    .si-header {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 55%, #be185d 100%);
        color: #ffffff;
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(190, 24, 93, 0.2);
        position: relative;
        overflow: hidden;
    }

    .si-header::after {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        top: -110px;
        right: -70px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.18) 0%, transparent 70%);
    }

    .si-header h1 {
        font-size: 2rem;
        font-weight: 900;
        margin: 0 0 0.4rem;
        position: relative;
        z-index: 1;
    }

    .si-header p {
        margin: 0;
        opacity: 0.95;
        position: relative;
        z-index: 1;
    }

    .si-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        position: relative;
        z-index: 1;
    }

    .si-card {
        background: #ffffff;
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 0.9rem;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
    }

    .si-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
    }

    .si-image {
        height: 170px;
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.08), rgba(16, 185, 129, 0.08));
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .si-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .si-image i {
        font-size: 2rem;
        color: #db2777;
        opacity: 0.65;
    }

    .si-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        flex: 1;
    }

    .si-title {
        margin: 0;
        font-weight: 800;
        color: #1e293b;
        font-size: 1rem;
    }

    .si-desc {
        margin: 0;
        color: #64748b;
        font-size: 0.85rem;
        line-height: 1.45;
    }

    .si-price {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #0f766e;
    }

    .si-meta {
        margin: 0;
        color: #64748b;
        font-size: 0.75rem;
    }

    .si-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
    }

    .si-btn {
        flex: 1;
        border: none;
        border-radius: 0.55rem;
        padding: 0.6rem 0.7rem;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s ease;
    }

    .si-btn-view {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        color: #ffffff;
    }

    .si-btn-offer {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
    }

    .si-btn-remove {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        color: #ffffff;
        cursor: pointer;
    }

    .si-empty {
        background: #ffffff;
        border: 2px dashed rgba(236, 72, 153, 0.3);
        border-radius: 1rem;
        padding: 3rem 1.5rem;
        text-align: center;
        color: #475569;
        position: relative;
        z-index: 1;
    }

    .si-empty i {
        font-size: 2.5rem;
        color: #db2777;
        margin-bottom: 0.75rem;
        display: block;
    }

    .si-pagination {
        margin-top: 1.5rem;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .si-header h1 {
            font-size: 1.5rem;
        }

        .si-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@include('buyer.sidebar')
<div class="main-content-wrapper">
    <div class="si-wrapper">
        <div class="container-fluid px-3 px-md-4 py-3 py-md-4" style="position: relative; z-index: 1;">
            <div class="si-header">
                <h1><i class="fas fa-heart me-2"></i>Saved Items</h1>
                <p>Quick access to listings you bookmarked for later.</p>
            </div>

            @if($savedListings->count() > 0)
                <div class="si-grid">
                    @foreach($savedListings as $listing)
                        <article class="si-card">
                            <div class="si-image">
                                @if($listing->photos && count(is_array($listing->photos) ? $listing->photos : json_decode($listing->photos, true) ?? []) > 0)
                                    @php
                                        $photos = is_array($listing->photos) ? $listing->photos : json_decode($listing->photos, true) ?? [];
                                    @endphp
                                    <img src="{{ $photos[0] }}" alt="Listing image">
                                @else
                                    <i class="fas fa-image"></i>
                                @endif
                            </div>

                            <div class="si-body">
                                <h3 class="si-title">{{ $listing->category ?: ($listing->deviceType->name ?: 'Uncategorized') }}</h3>
                                <p class="si-desc">{{ Str::limit($listing->description, 80) }}</p>
                                <p class="si-price">
                                    @if($listing->suggested_price > 0)
                                        ₱{{ number_format($listing->suggested_price, 2) }}
                                    @else
                                        <i class="fas fa-gift me-1"></i>Free
                                    @endif
                                </p>
                                <p class="si-meta"><i class="fas fa-store me-1"></i>{{ $listing->seller->name }}</p>

                                <div class="si-actions">
                                    <a href="{{ route('listings.show', $listing) }}" class="si-btn si-btn-view">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>

                                    @if(auth()->user()->is_verified)
                                        <a href="{{ route('offers.create', $listing) }}" class="si-btn si-btn-offer">
                                            <i class="fas fa-handshake me-1"></i>Offer
                                        </a>
                                    @endif

                                    <form method="POST" action="{{ route('buyer.saved-items.destroy', $listing) }}" style="margin: 0; flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="si-btn si-btn-remove" style="width: 100%;">
                                            <i class="fas fa-heart-broken me-1"></i>Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($savedListings->hasPages())
                    <div class="si-pagination">
                        {{ $savedListings->links() }}
                    </div>
                @endif
            @else
                <div class="si-empty">
                    <i class="fas fa-heart"></i>
                    <h4 style="margin: 0 0 0.5rem; font-weight: 800; color: #1e293b;">No saved items yet</h4>
                    <p style="margin: 0 0 1.1rem;">Browse listings and tap the heart button to save items here.</p>
                    <a href="{{ route('listings.index') }}" class="si-btn si-btn-view" style="display: inline-block; width: auto; padding-inline: 1rem;">
                        <i class="fas fa-search me-1"></i>Browse Listings
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', ($listing->category ?: ($listing->deviceType?->name ?: 'Device') ) . ' - E-Benta')

@section('styles')
<style>
    .listing-hero-img {
        height: 480px;
        object-fit: cover;
        width: 100%;
        display: block;
    }
    @media (max-width: 768px) {
        .listing-hero-img {
            height: 300px !important;
        }
        .listing-header-wrap {
            padding: 1.25rem 1rem !important;
            margin-bottom: 1.5rem !important;
        }
        .listing-header-wrap h1 {
            font-size: 1.6rem !important;
        }
    }
    @media (max-width: 480px) {
        .listing-hero-img {
            height: 240px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid" style="padding: 0;">
    <!-- Enhanced Breadcrumb Header -->
    <div class="listing-header-wrap" style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(13, 148, 136, 0.05) 100%); border-bottom: 1px solid rgba(13, 148, 136, 0.2); padding: 2rem; margin-bottom: 3rem;">
        <div class="container">
            <nav style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <a href="{{ route('listings.index') }}" style="color: var(--light-green); text-decoration: none; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.color='#0d9488';" onmouseout="this.style.color='var(--light-green)';">
                    <i class="fas fa-arrow-left me-1"></i>Back to Listings
                </a>
                <span style="color: #64748b;">/</span>
                <span style="color: var(--text-light); font-weight: 600;">{{ $listing->category ?: ($listing->deviceType?->name ?: 'Device') }}</span>
            </nav>
            
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div style="background: rgba(46, 204, 113, 0.2); padding: 0.75rem 1rem; border-radius: 0.8rem;">
                    <i class="fas fa-microchip" style="color: var(--light-green); font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h1 style="color: var(--text-light); font-weight: 800; margin: 0; font-size: 2.2rem; letter-spacing: -0.5px;">
                        {{ $listing->category ?: ($listing->deviceType?->name ?: 'Device') }}
                    </h1>
                    @if($listing->device_details || $listing->deviceBrand || $listing->deviceModel)
                        <p style="color: #64748b; margin: 0.5rem 0 0; font-size: 1rem;">
                            @if($listing->device_details)
                                {{ $listing->device_details }}
                            @elseif($listing->deviceModel)
                                {{ $listing->deviceModel->model_name }}
                                @if($listing->deviceBrand)
                                    ({{ $listing->deviceBrand->name }})
                                @endif
                            @elseif($listing->deviceBrand)
                                {{ $listing->deviceBrand->name }}
                            @endif
                        </p>
                    @endif
                </div>
            </div>
            
            <p style="color: #64748b; margin: 0; font-size: 0.95rem;">
                Listed by <a href="{{ route('users.show', $listing->seller) }}" style="color: var(--light-green); text-decoration: none; font-weight: 800; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.8';" onmouseout="this.style.opacity='1';">{{ $listing->seller->name }}</a> • Posted {{ $listing->created_at->diffForHumans() }}
            </p>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <!-- Photo Gallery Section -->
            <div class="col-lg-6">
                <div style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.4) 100%); border: 1px solid rgba(13, 148, 136, 0.2); border-radius: 1rem; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08); padding: 1rem;">
                    @php
                        $photosList = $listing->listingPhotos->pluck('photo_url')->toArray();
                        if (empty($photosList) && !empty($listing->photos)) {
                            $photosList = is_array($listing->photos) ? $listing->photos : [];
                        }
                    @endphp

                    @if(!empty($photosList))
                        <!-- Main Preview Image -->
                        <div style="width: 100%; height: 380px; border-radius: 0.75rem; overflow: hidden; background: #000; margin-bottom: 0.75rem; display: flex; align-items: center; justify-content: center;">
                            <img id="mainListingImage" src="{{ $photosList[0] }}" alt="Listing Image" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>

                        <!-- Thumbnails Row -->
                        @if(count($photosList) > 1)
                            <div style="display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 0.25rem;">
                                @foreach($photosList as $idx => $photoUrl)
                                    <div style="width: 70px; height: 70px; flex-shrink: 0; border-radius: 0.5rem; overflow: hidden; cursor: pointer; border: 2px solid {{ $idx === 0 ? 'var(--light-green)' : 'rgba(0,0,0,0.1)' }};" 
                                         onclick="document.getElementById('mainListingImage').src='{{ $photoUrl }}'; this.parentElement.querySelectorAll('div').forEach(d => d.style.borderColor='rgba(0,0,0,0.1)'); this.style.borderColor='var(--light-green)';">
                                        <img src="{{ $photoUrl }}" alt="thumb" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="d-flex align-items-center justify-content-center" style="height: 380px; background: linear-gradient(135deg, rgba(13, 148, 136, 0.05), rgba(52, 152, 219, 0.05)); border-radius: 0.75rem;">
                            <div style="text-align: center; color: #64748b;">
                                <i class="fas fa-image" style="font-size: 3.5rem; color: rgba(13, 148, 136, 0.3); margin-bottom: 1rem; display: block;"></i>
                                <span style="font-weight: 600; font-size: 1.1rem;">No photos available</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Details Section -->
            <div class="col-lg-6">
                <!-- Status & Badges Row -->
                <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; align-items: center;">
                    <!-- Listing Type Badge -->
                    @if($listing->isBulkLot())
                        <span class="badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 700; padding: 0.6rem 0.9rem; font-size: 0.8rem; border-radius: 0.5rem;">
                            <i class="fas fa-boxes me-1"></i>BULK LOT ({{ $listing->lot_item_count ?? 'Multiple' }} Items)
                        </span>
                    @else
                        <span class="badge" style="background: rgba(13, 148, 136, 0.1); color: #0d9488; font-weight: 700; padding: 0.6rem 0.9rem; font-size: 0.8rem; border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 0.5rem;">
                            <i class="fas fa-mobile-alt me-1"></i>Single Item
                        </span>
                    @endif

                    <!-- Condition Badge -->
                    <span class="badge" style="background: rgba(13, 148, 136, 0.1); color: #0d9488; font-weight: 700; padding: 0.6rem 0.9rem; font-size: 0.8rem; border: 1px solid rgba(13, 148, 136, 0.3); border-radius: 0.5rem; text-transform: uppercase;">
                        <i class="fas fa-check-circle me-1"></i>{{ ucfirst(str_replace('_', ' ', $listing->condition)) }}
                    </span>
                    
                    <!-- Handover Badge -->
                    @php
                        $handover = $listing->handover_preference ?? 'both';
                    @endphp
                    @if($handover === 'pickup_only')
                        <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #b45309; font-weight: 700; padding: 0.6rem 0.9rem; font-size: 0.8rem; border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 0.5rem;">
                            <i class="fas fa-truck-loading me-1"></i>Pickup Only
                        </span>
                    @elseif($handover === 'meetup_only')
                        <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #1d4ed8; font-weight: 700; padding: 0.6rem 0.9rem; font-size: 0.8rem; border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 0.5rem;">
                            <i class="fas fa-handshake me-1"></i>Meetup Only
                        </span>
                    @else
                        <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #047857; font-weight: 700; padding: 0.6rem 0.9rem; font-size: 0.8rem; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 0.5rem;">
                            <i class="fas fa-exchange-alt me-1"></i>Pickup / Meetup
                        </span>
                    @endif
                    
                    <!-- Status Badge -->
                    @if($listing->status == 'available')
                        <span class="badge" style="background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); color: white; font-weight: 700; padding: 0.6rem 0.9rem; font-size: 0.8rem; border-radius: 0.5rem;">
                            <i class="fas fa-check me-1"></i>Available
                        </span>
                    @else
                        <span class="badge" style="background: #64748b; color: white; font-weight: 700; padding: 0.6rem 0.9rem; font-size: 0.8rem; border-radius: 0.5rem;">
                            <i class="fas fa-lock me-1"></i>{{ ucfirst($listing->status) }}
                        </span>
                    @endif
                </div>

                <!-- Price Display -->
                <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(13, 148, 136, 0.05) 100%); border: 1px solid rgba(13, 148, 136, 0.2); padding: 1.5rem 1.75rem; border-radius: 1rem; margin-bottom: 1.5rem;">
                    <small style="color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.35rem;">
                        <i class="fas fa-tag me-1" style="color: var(--light-green);"></i>{{ $listing->isBulkLot() ? 'Bulk Lot Price' : 'Asking Price' }}
                    </small>
                    <h2 style="color: var(--light-green); font-weight: 800; margin: 0; font-size: 2.5rem; letter-spacing: -0.5px;">
                        @if($listing->suggested_price > 0)
                            ₱{{ number_format($listing->suggested_price, 2) }}
                        @else
                            FREE (Recycle)
                        @endif
                    </h2>
                </div>

                <!-- Seller Information Card -->
                <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(13, 148, 136, 0.05) 100%); border: 1px solid rgba(13, 148, 136, 0.2); padding: 1.75rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                    <h6 style="color: var(--text-light); font-weight: 800; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.9rem;">
                        <i class="fas fa-user-circle me-2" style="color: var(--light-green);"></i>Seller Information
                    </h6>
                    <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 0.5rem; font-size: 1.2rem;">
                        {{ $listing->seller->name }}
                    </h5>
                    @if($listing->seller->business_name)
                        <p style="color: #64748b; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-building" style="color: var(--light-green);"></i>{{ $listing->seller->business_name }}
                        </p>
                    @endif
                    @if($listing->pickup_address && in_array($listing->handover_preference ?? 'both', ['pickup_only', 'both']))
                        <p style="color: #64748b; margin-bottom: 0.75rem; display: flex; align-items: flex-start; gap: 0.5rem; font-size: 0.9rem;">
                            <i class="fas fa-map-marker-alt" style="color: var(--light-green); margin-top: 0.2rem;"></i>
                            <span><strong>Pickup Location:</strong> {{ $listing->pickup_address }}</span>
                        </p>
                    @endif
                    <div style="background: rgba(13, 148, 136, 0.1); padding: 1rem; border-radius: 0.6rem; border-left: 3px solid var(--light-green);">
                        <small style="color: #64748b; display: block;">✓ Verified Seller</small>
                    </div>
                </div>

                <!-- Seller Reviews Card -->
                <div style="background: linear-gradient(135deg, rgba(241, 196, 15, 0.1) 0%, rgba(241, 196, 15, 0.05) 100%); border: 1px solid rgba(241, 196, 15, 0.2); padding: 1.75rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                    <h6 style="color: var(--text-light); font-weight: 800; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.9rem;">
                        <i class="fas fa-star me-2" style="color: #f1c40f;"></i>Seller Rating
                    </h6>
                    
                    @php
                        $avgRating = $listing->seller->getAverageRating();
                        $totalReviews = $listing->seller->getTotalReviews();
                    @endphp

                    @if($totalReviews > 0)
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                            <div style="display: flex; gap: 0.25rem; font-size: 1.5rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="color: {{ $i <= round($avgRating) ? '#f1c40f' : 'rgba(241, 196, 15, 0.3)' }};"></i>
                                @endfor
                            </div>
                            <div>
                                <span style="color: var(--text-light); font-weight: 800; font-size: 1.3rem;">{{ number_format($avgRating, 1) }}</span>
                                <small style="color: #64748b; margin-left: 0.5rem;">{{ $totalReviews }} {{ $totalReviews == 1 ? 'review' : 'reviews' }}</small>
                            </div>
                        </div>

                        <!-- Recent Reviews Preview -->
                        @php
                            $recentReviews = $listing->seller->reviewsReceived()
                                ->where('review_type', 'buyer')
                                ->latest()
                                ->take(2)
                                ->get();
                        @endphp

                        @if($recentReviews->count() > 0)
                            <div style="border-top: 1px solid rgba(241, 196, 15, 0.2); padding-top: 1rem;">
                                <small style="color: #64748b; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 0.75rem; letter-spacing: 0.5px;">Recent Reviews:</small>
                                @foreach($recentReviews as $review)
                                    <div style="background: rgba(255, 255, 255, 0.3); padding: 0.75rem; border-radius: 0.6rem; margin-bottom: 0.75rem; border-left: 2px solid #f1c40f;">
                                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                            <div style="flex-grow: 1;">
                                                <small style="color: #64748b; font-weight: 600; display: block;">{{ $review->reviewer->name }}</small>
                                                <small style="color: #64748b; font-size: 0.85rem;">{{ $review->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div style="display: flex; gap: 0.1rem; font-size: 0.9rem;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#f1c40f' : 'rgba(241, 196, 15, 0.3)' }};"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        @if($review->title)
                                            <p style="color: var(--text-light); font-weight: 600; margin: 0.5rem 0 0.25rem 0; font-size: 0.9rem;">{{ $review->title }}</p>
                                        @endif
                                        @if($review->comment)
                                            <p style="color: #64748b; margin: 0.25rem 0; font-size: 0.85rem; line-height: 1.4;">{{ Str::limit($review->comment, 100) }}</p>
                                        @endif
                                    </div>
                                @endforeach
                                @if($totalReviews > 2)
                                    <a href="{{ route('users.show', $listing->seller) }}#reviews" style="color: #f1c40f; text-decoration: none; font-weight: 700; font-size: 0.85rem; display: inline-block; margin-top: 0.5rem;">
                                        View all {{ $totalReviews }} reviews <i class="fas fa-arrow-right ms-1" style="font-size: 0.75rem;"></i>
                                    </a>
                                @endif
                            </div>
                        @else
                            <small style="color: #64748b; display: block;">No reviews yet. Be the first to review this seller!</small>
                        @endif
                    @else
                        <div style="background: rgba(241, 196, 15, 0.2); padding: 1rem; border-radius: 0.6rem; border-left: 3px solid #f1c40f;">
                            <small style="color: #64748b; display: block;">
                                <i class="fas fa-info-circle me-1" style="color: #f1c40f;"></i>No reviews yet. Complete your first transaction to see this seller's feedback!
                            </small>
                        </div>
                    @endif
                </div>

                <!-- Environmental Impact Card -->
                <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(52, 152, 219, 0.05) 100%); border: 1px solid rgba(13, 148, 136, 0.2); padding: 1.75rem; border-radius: 1rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                    <h6 style="color: var(--text-light); font-weight: 800; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.9rem;">
                        <i class="fas fa-leaf me-2" style="color: #3498db;"></i>Environmental Impact
                    </h6>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div style="background: rgba(13, 148, 136, 0.1); padding: 1rem; border-radius: 0.6rem; border-left: 3px solid var(--light-green); text-align: center;">
                            <small style="color: #64748b; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 0.5rem; letter-spacing: 0.5px;">Carbon Saved</small>
                            <h4 style="color: var(--light-green); font-weight: 800; margin: 0; font-size: 1.8rem;">{{ $listing->carbon_footprint }}<small style="font-size: 0.6em; margin-left: 0.25rem;">kg</small></h4>
                        </div>
                        <div style="background: rgba(52, 152, 219, 0.1); padding: 1rem; border-radius: 0.6rem; border-left: 3px solid #3498db; text-align: center;">
                            <small style="color: #64748b; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 0.5rem; letter-spacing: 0.5px;">Device Weight</small>
                            <h4 style="color: #3498db; font-weight: 800; margin: 0; font-size: 1.8rem;">{{ $listing->estimated_weight }}<small style="font-size: 0.6em; margin-left: 0.25rem;">kg</small></h4>
                        </div>
                    </div>
                    <div style="background: rgba(13, 148, 136, 0.2); padding: 1rem; border-radius: 0.6rem; border-left: 3px solid var(--light-green); margin-top: 1rem;">
                        <small style="color: #64748b; display: block; line-height: 1.5;">
                            <i class="fas fa-check me-1" style="color: var(--light-green);"></i>By responsibly disposing of this device, you'll help reduce environmental impact and support circular economy!
                        </small>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($listing->isAvailable())
                    @auth
                        @if(auth()->user()->isBuyer() && auth()->user()->is_verified && auth()->id() !== $listing->user_id)
                            <a href="{{ route('offers.create', $listing) }}" class="btn w-100 mb-3" style="background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); color: var(--dark-bg); border: none; padding: 1.1rem 2rem; font-weight: 800; font-size: 1.05rem; border-radius: 0.8rem; box-shadow: 0 8px 20px rgba(13, 148, 136, 0.35); transition: all 0.3s ease; cursor: pointer; text-decoration: none; display: inline-block;" onmouseover="this.style.boxShadow='0 12px 30px rgba(13, 148, 136, 0.45)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 8px 20px rgba(13, 148, 136, 0.35)'; this.style.transform='translateY(0)';">
                                <i class="fas fa-handshake me-2"></i>Submit an Offer
                            </a>
                        @elseif(auth()->user()->isSeller() && auth()->id() === $listing->user_id)
                            <div class="d-flex gap-2 mb-3">
                                <a href="{{ route('listings.edit', $listing) }}" class="btn flex-grow-1" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border: none; font-weight: 700; padding: 1rem 1.5rem; border-radius: 0.8rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(243, 156, 18, 0.2);" onmouseover="this.style.boxShadow='0 8px 20px rgba(243, 156, 18, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(243, 156, 18, 0.2)'; this.style.transform='translateY(0)';">
                                    <i class="fas fa-edit me-2"></i>Edit Listing
                                </a>
                                @if($listing->status !== 'withdrawn')
                                    <button type="button" class="btn flex-grow-1" data-bs-toggle="modal" data-bs-target="#withdrawModal" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none; font-weight: 700; padding: 1rem 1.5rem; border-radius: 0.8rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);" onmouseover="this.style.boxShadow='0 8px 20px rgba(231, 76, 60, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(231, 76, 60, 0.2)'; this.style.transform='translateY(0)';">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </button>
                                @endif
                            </div>
                        @endif
                    @else
                        <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(13, 148, 136, 0.05) 100%); border: 1px solid rgba(13, 148, 136, 0.2); border-left: 4px solid #0d9488; color: var(--text-light); padding: 1.5rem; border-radius: 0.8rem; margin-bottom: 2rem;">
                            <p style="margin: 0; font-weight: 600;">
                                Please <a href="{{ route('login') }}" style="color: #0d9488; text-decoration: none; font-weight: 800;">login</a> to submit an offer
                            </p>
                        </div>
                    @endauth
                @endif

                <!-- Report Listing Button -->
                @auth
                    @if(auth()->id() !== $listing->user_id && $listing->status !== 'withdrawn')
                        <button type="button" class="btn w-100 mb-3" data-bs-toggle="modal" data-bs-target="#reportListingModal" style="background: rgba(231, 76, 60, 0.15); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.3); padding: 0.9rem 1.5rem; font-weight: 600; border-radius: 0.8rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(231, 76, 60, 0.25)';" onmouseout="this.style.background='rgba(231, 76, 60, 0.15)';">
                            <i class="fas fa-flag me-2"></i>Report Listing
                        </button>
                    @endif
                @endauth

                <!-- Status Alerts -->
                @if($listing->status === 'withdrawn')
                    <div style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.15) 0%, rgba(231, 76, 60, 0.05) 100%); border: 1px solid rgba(231, 76, 60, 0.2); border-left: 4px solid #e74c3c; color: var(--text-light); padding: 1.5rem; border-radius: 0.8rem; margin-bottom: 1rem;">
                        <strong style="color: #e74c3c; font-size: 1.05rem;"><i class="fas fa-ban me-2"></i>Listing Withdrawn</strong><br>
                        <small style="color: #64748b; display: block; margin-top: 0.5rem; line-height: 1.5;">This listing has been withdrawn (by administrator moderation or seller cancellation) and is no longer active. Interactions, editing, and offer actions are disabled. You may still view its details and environmental history.</small>
                    </div>
                @elseif($listing->isMatched())
                    <div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.15) 0%, rgba(243, 156, 18, 0.05) 100%); border: 1px solid rgba(243, 156, 18, 0.2); border-left: 4px solid #f39c12; color: var(--text-light); padding: 1.5rem; border-radius: 0.8rem; margin-bottom: 1rem;">
                        <strong><i class="fas fa-check-circle me-2" style="color: #f39c12;"></i>Item Matched!</strong><br>
                        <small style="color: #64748b; display: block; margin-top: 0.5rem;">This item has been matched with a buyer and is no longer available.</small>
                    </div>
                @elseif($listing->status === 'completed' || $listing->status === 'processed')
                    <div style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.15) 0%, rgba(46, 204, 113, 0.05) 100%); border: 1px solid rgba(46, 204, 113, 0.2); border-left: 4px solid #2ecc71; color: var(--text-light); padding: 1.5rem; border-radius: 0.8rem; margin-bottom: 1rem;">
                        <strong><i class="fas fa-award me-2" style="color: #2ecc71;"></i>Transaction Completed!</strong><br>
                        <small style="color: #64748b; display: block; margin-top: 0.5rem;">This item has been successfully transacted and processed.</small>
                    </div>
                @endif
    </div>
</div>

<!-- Enhanced Cancel Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" style="backdrop-filter: blur(8px);">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%); border: 2px solid rgba(13, 148, 136, 0.15); border-radius: 1.2rem; box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15); overflow: hidden;">
            
            <!-- Modal Header -->
            <div class="modal-header" style="border-bottom: 1px solid rgba(13, 148, 136, 0.1); padding: 2.5rem 2.5rem 1.5rem; background: linear-gradient(135deg, rgba(13, 148, 136, 0.03) 0%, rgba(46, 204, 113, 0.02) 100%);">
                <div style="display: flex; align-items: center; gap: 1rem; flex: 1;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); border-radius: 0.8rem; color: white;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem;"></i>
                    </div>
                    <h5 class="modal-title" style="color: var(--text-light); font-weight: 800; font-size: 1.4rem; margin: 0;">
                        Cancel Listing
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0.6); opacity: 0.8; transition: all 0.2s ease;" onmouseover="this.style.opacity='1'; this.style.filter='brightness(0.4)'" onmouseout="this.style.opacity='0.8'; this.style.filter='brightness(0.6)'"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 2.5rem;">
                <p style="color: var(--text-light); font-size: 1.05rem; margin-bottom: 1.5rem; font-weight: 500;">
                    Are you sure you want to cancel this listing?
                </p>
                
                <div style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.08) 0%, rgba(192, 57, 43, 0.05) 100%); border-left: 4px solid #e74c3c; padding: 1.25rem; border-radius: 0.8rem; margin-bottom: 1.5rem;">
                    <div style="color: #64748b; display: flex; gap: 0.75rem; line-height: 1.6;">
                        <i class="fas fa-info-circle" style="color: #e74c3c; margin-top: 0.25rem; flex-shrink: 0;"></i>
                        <div>
                            <p style="margin: 0; font-size: 0.95rem;">
                                The listing will be marked as <strong>unavailable</strong> but the history will be preserved for environmental impact tracking.
                            </p>
                        </div>
                    </div>
                </div>

                <div style="background: rgba(13, 148, 136, 0.05); border: 1px solid rgba(13, 148, 136, 0.1); padding: 1rem; border-radius: 0.8rem;">
                    <p style="color: #64748b; margin: 0; font-size: 0.9rem;">
                        <i class="fas fa-check" style="color: var(--light-green); margin-right: 0.5rem;"></i>You can still view this listing in your history
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="border-top: 1px solid rgba(13, 148, 136, 0.1); padding: 2rem 2.5rem; gap: 1rem; background: rgba(13, 148, 136, 0.02);">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: rgba(13, 148, 136, 0.08); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.2); font-weight: 700; padding: 0.85rem 1.75rem; border-radius: 0.8rem; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='rgba(13, 148, 136, 0.15)'; this.style.borderColor='rgba(13, 148, 136, 0.4)'; this.style.transform='scale(1.02)'" onmouseout="this.style.backgroundColor='rgba(13, 148, 136, 0.08)'; this.style.borderColor='rgba(13, 148, 136, 0.2)'; this.style.transform='scale(1)'">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form method="POST" action="{{ route('listings.withdraw', $listing) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; font-weight: 700; padding: 0.85rem 1.75rem; border: none; border-radius: 0.8rem; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(231, 76, 60, 0.3);" onmouseover="this.style.boxShadow='0 10px 30px rgba(231, 76, 60, 0.45)'; this.style.transform='scale(1.02)'" onmouseout="this.style.boxShadow='0 6px 20px rgba(231, 76, 60, 0.3)'; this.style.transform='scale(1)'">
                        <i class="fas fa-check me-2"></i>Confirm Cancellation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Report Listing Modal -->
<div class="modal fade" id="reportListingModal" tabindex="-1" style="backdrop-filter: blur(8px);">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%); border: 2px solid rgba(13, 148, 136, 0.15); border-radius: 1.2rem; box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15); overflow: hidden;">
            
            <!-- Modal Header -->
            <div class="modal-header" style="border-bottom: 1px solid rgba(13, 148, 136, 0.1); padding: 2.5rem 2.5rem 1.5rem; background: linear-gradient(135deg, rgba(13, 148, 136, 0.03) 0%, rgba(46, 204, 113, 0.02) 100%);">
                <div style="display: flex; align-items: center; gap: 1rem; flex: 1;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); border-radius: 0.8rem; color: white;">
                        <i class="fas fa-flag" style="font-size: 1.5rem;"></i>
                    </div>
                    <h5 class="modal-title" style="color: var(--text-light); font-weight: 800; font-size: 1.4rem; margin: 0;">
                        Report This Listing
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0.6); opacity: 0.8; transition: all 0.2s ease;" onmouseover="this.style.opacity='1'; this.style.filter='brightness(0.4)'" onmouseout="this.style.opacity='0.8'; this.style.filter='brightness(0.6)'"></button>
            </div>

            <!-- Modal Body -->
            <form method="POST" action="{{ route('reports.store') }}">
                @csrf
                <input type="hidden" name="type" value="listing">
                <input type="hidden" name="id" value="{{ $listing->id }}">
                
                <div class="modal-body" style="padding: 2.5rem;">
                    <div class="mb-4">
                        <label style="color: var(--text-light); font-weight: 700; font-size: 0.95rem; margin-bottom: 0.75rem; display: block;">
                            <i class="fas fa-exclamation-circle me-2" style="color: #e74c3c;"></i>Report Reason <span style="color: #e74c3c;">*</span>
                        </label>
                        <select name="reason" class="form-select" required style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); color: var(--text-light); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s ease;" onchange="this.style.borderColor='rgba(13, 148, 136, 0.6)'" onblur="this.style.borderColor='rgba(13, 148, 136, 0.3)'">
                            <option value="" style="background: rgba(255, 255, 255, 1); color: #64748b;">-- Select a reason --</option>
                            <option value="inappropriate_content" style="background: rgba(255, 255, 255, 1); color: var(--text-light);">Inappropriate Content</option>
                            <option value="false_information" style="background: rgba(255, 255, 255, 1); color: var(--text-light);">Misleading Description</option>
                            <option value="broken_item_misrepresentation" style="background: rgba(255, 255, 255, 1); color: var(--text-light);">Not As Described</option>
                            <option value="suspicious_behavior" style="background: rgba(255, 255, 255, 1); color: var(--text-light);">Suspicious Activity</option>
                            <option value="fake_listing" style="background: rgba(255, 255, 255, 1); color: var(--text-light);">Fake Listing</option>
                            <option value="other" style="background: rgba(255, 255, 255, 1); color: var(--text-light);">Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label style="color: var(--text-light); font-weight: 700; font-size: 0.95rem; margin-bottom: 0.75rem; display: block;">
                            <i class="fas fa-pen me-2" style="color: var(--light-green);"></i>Details <span style="color: #e74c3c;">*</span>
                        </label>
                        <textarea name="description" class="form-control" rows="4" required minlength="10" maxlength="1000" placeholder="Please provide details about your report..." style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); color: var(--text-light); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s ease; resize: vertical;" onfocus="this.style.borderColor='rgba(13, 148, 136, 0.6)'" onblur="this.style.borderColor='rgba(13, 148, 136, 0.3)'"></textarea>
                        <small style="color: #64748b; display: block; margin-top: 0.5rem; font-size: 0.85rem;">Minimum 10 characters required</small>
                    </div>

                    <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(46, 204, 113, 0.05) 100%); border-left: 4px solid var(--light-green); padding: 1.25rem; border-radius: 0.8rem;">
                        <div style="color: #64748b; display: flex; gap: 0.75rem; line-height: 1.6;">
                            <i class="fas fa-shield-alt" style="color: var(--light-green); margin-top: 0.25rem; flex-shrink: 0;"></i>
                            <div>
                                <p style="margin: 0; font-size: 0.9rem;">
                                    Your report will be reviewed by our moderation team. We take all reports seriously and will take appropriate action.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer" style="border-top: 1px solid rgba(13, 148, 136, 0.1); padding: 2rem 2.5rem; gap: 1rem; background: rgba(13, 148, 136, 0.02);">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: rgba(13, 148, 136, 0.08); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.2); font-weight: 700; padding: 0.85rem 1.75rem; border-radius: 0.8rem; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='rgba(13, 148, 136, 0.15)'; this.style.borderColor='rgba(13, 148, 136, 0.4)'; this.style.transform='scale(1.02)'" onmouseout="this.style.backgroundColor='rgba(13, 148, 136, 0.08)'; this.style.borderColor='rgba(13, 148, 136, 0.2)'; this.style.transform='scale(1)'">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; font-weight: 700; padding: 0.85rem 1.75rem; border: none; border-radius: 0.8rem; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(231, 76, 60, 0.3);" onmouseover="this.style.boxShadow='0 10px 30px rgba(231, 76, 60, 0.45)'; this.style.transform='scale(1.02)'" onmouseout="this.style.boxShadow='0 6px 20px rgba(231, 76, 60, 0.3)'; this.style.transform='scale(1)'">
                        <i class="fas fa-flag me-2"></i>Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

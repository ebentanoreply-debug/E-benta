@extends(auth()->check() && auth()->user()->isAdmin() ? 'layouts.admin' : (auth()->check() && auth()->user()->isSeller() ? 'layouts.seller' : (auth()->check() && auth()->user()->isBuyer() ? 'layouts.buyer' : 'layouts.public')))

@section('title', $user->name . ' - Seller Profile')

@section('content')
<div class="container-fluid" style="padding: 0;">
    <!-- Profile Header -->
    <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(13, 148, 136, 0.05) 100%); border-bottom: 1px solid rgba(13, 148, 136, 0.2); padding: 3rem 2rem;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto" style="margin-bottom: 1rem;">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--light-green); box-shadow: 0 8px 25px rgba(13, 148, 136, 0.3);">
                    @else
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--light-green), #0d9488); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--dark-bg); font-weight: 800; box-shadow: 0 8px 25px rgba(13, 148, 136, 0.3);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="col">
                    <h1 style="color: var(--text-light); font-weight: 800; margin: 0; font-size: 2.5rem;">{{ $user->name }}</h1>
                    @if($user->business_name)
                        <p style="color: #64748b; margin: 0.5rem 0 0 0; font-size: 1.1rem;">
                            <i class="fas fa-building" style="color: var(--light-green); margin-right: 0.5rem;"></i>{{ $user->business_name }}
                        </p>
                    @endif
                    <p style="color: #64748b; margin: 0.5rem 0 0 0; font-size: 0.95rem;">
                        <i class="fas fa-check-circle" style="color: var(--light-green); margin-right: 0.5rem;"></i>Verified Seller
                    </p>
                </div>
                <div class="col-auto">
                    @auth
                        @if(auth()->id() !== $user->id)
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#reportUserModal" style="background: rgba(231, 76, 60, 0.15); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.3); padding: 0.75rem 1.25rem; font-weight: 600; border-radius: 0.6rem; transition: all 0.3s ease; font-size: 0.9rem;" onmouseover="this.style.background='rgba(231, 76, 60, 0.25)';" onmouseout="this.style.background='rgba(231, 76, 60, 0.15)';">
                                <i class="fas fa-flag me-2"></i>Report
                            </button>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-4">
            <!-- Stats Cards -->
            <div class="col-md-4">
                <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.1) 0%, rgba(13, 148, 136, 0.05) 100%); border: 1px solid rgba(13, 148, 136, 0.2); padding: 2rem; border-radius: 1rem; text-align: center;">
                    <small style="color: #64748b; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 1rem; letter-spacing: 0.5px;">Rating</small>
                    <div style="display: flex; justify-content: center; gap: 0.25rem; margin-bottom: 1rem; font-size: 1.8rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star" style="color: {{ $i <= round($avgRating) ? '#f1c40f' : 'rgba(241, 196, 15, 0.3)' }};"></i>
                        @endfor
                    </div>
                    <h3 style="color: var(--light-green); font-weight: 800; margin: 0 0 0.5rem 0; font-size: 2.2rem;">{{ number_format($avgRating, 1) }}</h3>
                    <small style="color: #64748b;">Based on {{ $totalReviews }} {{ $totalReviews == 1 ? 'review' : 'reviews' }}</small>
                </div>
            </div>

            <div class="col-md-4">
                <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(52, 152, 219, 0.05) 100%); border: 1px solid rgba(52, 152, 219, 0.2); padding: 2rem; border-radius: 1rem; text-align: center;">
                    <small style="color: #64748b; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 1rem; letter-spacing: 0.5px;">Active Listings</small>
                    <h3 style="color: #3498db; font-weight: 800; margin: 0 0 0.5rem 0; font-size: 2.5rem;">{{ $listingsCount }}</h3>
                    <small style="color: #64748b;">Items for sale</small>
                </div>
            </div>

            <div class="col-md-4">
                <div style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.1) 0%, rgba(155, 89, 182, 0.05) 100%); border: 1px solid rgba(155, 89, 182, 0.2); padding: 2rem; border-radius: 1rem; text-align: center;">
                    <small style="color: #64748b; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 1rem; letter-spacing: 0.5px;">Transactions</small>
                    <h3 style="color: #9b59b6; font-weight: 800; margin: 0 0 0.5rem 0; font-size: 2.5rem;">{{ $successfulTransactions }}</h3>
                    <small style="color: #64748b;">Completed sales</small>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row mt-5">
            <div class="col-12">
                <h2 id="reviews" style="color: var(--text-light); font-weight: 800; margin-bottom: 2rem; font-size: 2rem;">
                    <i class="fas fa-comments me-2" style="color: var(--light-green);"></i>Customer Reviews
                </h2>

                @if($totalReviews > 0)
                    <!-- Review Summary Stats -->
                    @php
                        $ratingDistribution = [
                            5 => $user->reviewsReceived()->where('rating', 5)->count(),
                            4 => $user->reviewsReceived()->where('rating', 4)->count(),
                            3 => $user->reviewsReceived()->where('rating', 3)->count(),
                            2 => $user->reviewsReceived()->where('rating', 2)->count(),
                            1 => $user->reviewsReceived()->where('rating', 1)->count(),
                        ];
                    @endphp

                    <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 1.25rem; margin-bottom: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9;">
                            <h5 style="color: #0f172a; font-weight: 800; margin: 0; font-size: 1.15rem; display: flex; align-items: center; gap: 0.6rem;">
                                <i class="fas fa-chart-bar" style="color: #0d9488;"></i>Rating Distribution
                            </h5>
                            <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">{{ $totalReviews }} {{ $totalReviews == 1 ? 'total review' : 'total reviews' }}</span>
                        </div>
                        @foreach([5, 4, 3, 2, 1] as $rating)
                            @php
                                $count = $ratingDistribution[$rating];
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.85rem;">
                                <div style="width: 55px; font-size: 0.95rem; display: flex; align-items: center; gap: 0.3rem;">
                                    <span style="color: #1e293b; font-weight: 700;">{{ $rating }}</span>
                                    <i class="fas fa-star" style="color: #f59e0b; font-size: 0.85rem;"></i>
                                </div>
                                <div style="flex-grow: 1; background: #f1f5f9; border-radius: 9999px; height: 18px; position: relative; overflow: hidden; border: 1px solid #e2e8f0;">
                                    <div style="height: 100%; background: linear-gradient(90deg, #10b981 0%, #0d9488 100%); border-radius: 9999px; width: {{ $percentage }}%; transition: width 0.4s ease;"></div>
                                    @if($percentage >= 15)
                                        <span style="position: absolute; left: 0.65rem; top: 50%; transform: translateY(-50%); color: #ffffff; font-weight: 700; font-size: 0.75rem; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">{{ round($percentage) }}%</span>
                                    @endif
                                </div>
                                <div style="min-width: 65px; text-align: right;">
                                    <span style="color: #334155; font-weight: 700; font-size: 0.9rem;">{{ $count }}</span>
                                    @if($percentage < 15 && $percentage > 0)
                                        <span style="color: #94a3b8; font-size: 0.8rem; font-weight: 500; margin-left: 0.25rem;">({{ round($percentage) }}%)</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Individual Reviews -->
                    <div>
                        @forelse($reviewsReceived as $review)
                            <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 1rem; margin-bottom: 1.5rem; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);" onmouseover="this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.08)'; this.style.borderColor='rgba(13, 148, 136, 0.4)';" onmouseout="this.style.boxShadow='0 2px 10px rgba(0, 0, 0, 0.03)'; this.style.borderColor='#e2e8f0';">
                                
                                <!-- Review Header -->
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                            <h5 style="color: #0f172a; font-weight: 700; margin: 0; font-size: 1.1rem;">{{ $review->reviewer->name }}</h5>
                                            @if($review->is_verified)
                                                <div style="background: rgba(16, 185, 129, 0.1); color: #059669; padding: 0.25rem 0.6rem; border-radius: 0.4rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; border: 1px solid rgba(16, 185, 129, 0.25);">
                                                    <i class="fas fa-check-circle me-1"></i>Verified Purchase
                                                </div>
                                            @endif
                                        </div>
                                        <small style="color: #64748b; display: block;">{{ $review->created_at->format('F j, Y') }}</small>
                                    </div>
                                    <div style="display: flex; gap: 0.1rem; font-size: 1.1rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#f59e0b' : 'rgba(203, 213, 225, 0.8)' }};"></i>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Review Title and Comment -->
                                @if($review->title)
                                    <h6 style="color: #0f172a; font-weight: 800; margin: 0 0 0.75rem 0; font-size: 1rem;">{{ $review->title }}</h6>
                                @endif
                                @if($review->comment)
                                    <p style="color: #334155; margin: 0 0 1.5rem 0; line-height: 1.6; font-size: 0.95rem;">{{ $review->comment }}</p>
                                @endif

                                <!-- Review Attributes -->
                                @if($review->attributes && count($review->attributes) > 0)
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 1.5rem; border-radius: 0.8rem; border-left: 4px solid var(--light-green);">
                                        <small style="color: #475569; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 1rem; letter-spacing: 0.5px;">Detailed Feedback</small>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                                            @php
                                                $attributeColors = [
                                                    'Communication' => '#f39c12',
                                                    'Professionalism' => '#3498db',
                                                    'Item Condition/Cleanliness' => '#27ae60',
                                                    'Description Accuracy' => '#9b59b6',
                                                    'Promptness' => '#e67e22',
                                                    'Honesty & Integrity' => '#e74c3c',
                                                ];
                                            @endphp
                                            @foreach($review->attributes as $attribute => $rating)
                                                @php
                                                    $color = $attributeColors[$attribute] ?? '#2980b9';
                                                @endphp
                                                <div>
                                                    <small style="color: #475569; font-weight: 600; display: block; margin-bottom: 0.5rem;">{{ $attribute }}</small>
                                                    <div style="display: flex; gap: 0.2rem;">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star" style="color: {{ $i <= $rating ? $color : 'rgba(203, 213, 225, 0.8)' }}; font-size: 0.85rem;"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @empty
                            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-left: 4px solid #3498db; color: #0f172a; padding: 2rem; border-radius: 1rem; text-align: center; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);">
                                <i class="fas fa-comments" style="font-size: 2.5rem; color: #3498db; margin-bottom: 1rem; display: block; opacity: 0.7;"></i>
                                <p style="margin: 0; font-weight: 600;">No reviews yet. Complete a transaction to be the first to review!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($reviewsReceived->hasPages())
                        <div style="margin-top: 2rem;">
                            {{ $reviewsReceived->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                @else
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-left: 4px solid #3498db; color: #0f172a; padding: 2rem; border-radius: 1rem; text-align: center; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);">
                        <i class="fas fa-star" style="font-size: 2.5rem; color: #3498db; margin-bottom: 1rem; display: block; opacity: 0.7;"></i>
                        <p style="margin: 0; font-weight: 600;">Start a transaction with this seller and leave your feedback!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Seller's Listings - Optional Section -->
        <div class="row mt-5">
            <div class="col-12">
                <h2 style="color: var(--text-light); font-weight: 800; margin-bottom: 2rem; font-size: 2rem;">
                    <i class="fas fa-list me-2" style="color: var(--light-green);"></i>{{ $user->name }}'s Listings
                </h2>
                @if($listingsCount > 0)
                    <a href="{{ route('listings.index', ['seller_id' => $user->id]) }}" class="btn" style="display: inline-flex; align-items: center; text-decoration: none; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); color: #ffffff; border: none; padding: 0.75rem 1.75rem; font-weight: 700; border-radius: 0.6rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2); cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 20px rgba(13, 148, 136, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(13, 148, 136, 0.2)'; this.style.transform='translateY(0)';">
                        <i class="fas fa-eye me-2"></i>View all {{ $listingsCount }} listings
                    </a>
                @else
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-left: 4px solid #3498db; color: #0f172a; padding: 1.5rem; border-radius: 0.8rem;">
                        <p style="margin: 0; font-weight: 600;">
                            <i class="fas fa-info-circle me-2" style="color: #3498db;"></i>No active listings currently.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Report User Modal -->
<div class="modal fade" id="reportUserModal" tabindex="-1" style="backdrop-filter: blur(5px);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 1rem; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);">
            <div class="modal-header" style="border-bottom: 1px solid #e2e8f0; padding: 1.5rem 2rem;">
                <h5 class="modal-title" style="color: #0f172a; font-weight: 800; font-size: 1.3rem;">
                    <i class="fas fa-flag me-2" style="color: #e74c3c;"></i>Report {{ $user->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('reports.store') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <input type="hidden" name="type" value="user">
                <div class="modal-body" style="padding: 2rem; color: #334155;">
                    <div class="mb-3">
                        <label style="color: #0f172a; font-weight: 700; font-size: 1rem; margin-bottom: 0.75rem; display: block;">Report Reason</label>
                        <select name="reason" class="form-select" required style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; padding: 0.75rem 1rem; border-radius: 0.6rem;">
                            <option value="">Select a reason...</option>
                            <option value="scam_fraud">Scam/Fraud</option>
                            <option value="harassment_abuse">Abusive Behavior</option>
                            <option value="inappropriate_content">Inappropriate Content</option>
                            <option value="false_information">Fake Profile</option>
                            <option value="suspicious_behavior">Attempting Off-Platform Contact</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label style="color: #0f172a; font-weight: 700; font-size: 1rem; margin-bottom: 0.75rem; display: block;">Details</label>
                        <textarea name="description" class="form-control" rows="4" required placeholder="Please provide details about your report..." style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; padding: 0.75rem 1rem; border-radius: 0.6rem; resize: vertical;"></textarea>
                    </div>
                    <div style="background: rgba(13, 148, 136, 0.08); border-left: 3px solid var(--light-green); padding: 1rem; border-radius: 0.6rem;">
                        <small style="color: #475569; display: block; line-height: 1.6;">
                            <i class="fas fa-info-circle me-1" style="color: var(--light-green);"></i>Your report will be reviewed by our moderation team. Please provide detailed information to help us address the issue quickly.
                        </small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 1.25rem 2rem; gap: 1rem;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="font-weight: 700; padding: 0.75rem 1.5rem; border-radius: 0.6rem;">Cancel</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; font-weight: 700; padding: 0.75rem 1.5rem; border: none; border-radius: 0.6rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);" onmouseover="this.style.boxShadow='0 8px 20px rgba(231, 76, 60, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(231, 76, 60, 0.2)'; this.style.transform='translateY(0)';">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

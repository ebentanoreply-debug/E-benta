@extends('layouts.admin')

@section('title', 'ID & Location Verifications - E-Benta Admin')

@section('styles')
<style>
    .admin-page-container {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    body.dark-mode .admin-page-container {
        background: #09171f;
    }

    .admin-module-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.25rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    .admin-module-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 400px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    .admin-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    body.dark-mode .admin-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }

    .admin-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.12);
        border-color: #0d9488;
    }

    .user-doc-preview {
        border: 1.5px solid rgba(13, 148, 136, 0.25);
        border-radius: 0.75rem;
        overflow: hidden;
        background: #09171f;
        position: relative;
        cursor: pointer;
        transition: all 0.2s ease;
        aspect-ratio: 16/10;
    }

    .user-doc-preview:hover {
        border-color: #0d9488;
        transform: scale(1.02);
    }

    .user-doc-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .doc-badge-overlay {
        position: absolute;
        bottom: 6px;
        left: 6px;
        background: rgba(9, 23, 31, 0.85);
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }

    .admin-filter-pill-group {
        display: inline-flex;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 0.75rem;
        padding: 0.3rem;
        gap: 0.3rem;
    }

    .admin-filter-pill {
        color: #94a3b8;
        padding: 0.45rem 0.95rem;
        border-radius: 0.55rem;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .admin-filter-pill:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.08);
    }

    .admin-filter-pill.active {
        background: #0d9488;
        color: #ffffff;
        box-shadow: 0 2px 10px rgba(13, 148, 136, 0.4);
    }

    .quick-reason-chip {
        display: inline-block;
        padding: 0.3rem 0.65rem;
        border-radius: 2rem;
        font-size: 0.78rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        margin-right: 0.35rem;
        margin-bottom: 0.4rem;
        transition: all 0.15s ease;
    }

    .quick-reason-chip:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }
</style>
@endsection

@section('content')


<div class="main-content-wrapper">
    <div class="admin-page-container">
        
        <!-- HEADER -->
        <div class="admin-module-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-id-card me-1"></i>KYC, Identity & Location Verification Queue
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $totalCount ?? $pendingUsers->total() }} Pending Submissions</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            Seller Location & Government ID Verifications
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Inspect government IDs, back address cards, and registered physical pickup locations to verify legitimate sellers & recyclers.
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="admin-filter-pill-group">
                            <a href="{{ route('admin.pending-verifications') }}" class="admin-filter-pill {{ !request('role') ? 'active' : '' }}">
                                <i class="fas fa-list"></i> All ({{ $totalCount ?? 0 }})
                            </a>
                            <a href="{{ route('admin.pending-verifications', ['role' => 'seller']) }}" class="admin-filter-pill {{ request('role') === 'seller' ? 'active' : '' }}">
                                <i class="fas fa-store"></i> Sellers & Location ({{ $sellerCount ?? 0 }})
                            </a>
                            <a href="{{ route('admin.pending-verifications', ['role' => 'buyer']) }}" class="admin-filter-pill {{ request('role') === 'buyer' ? 'active' : '' }}">
                                <i class="fas fa-shopping-bag"></i> Buyers ({{ $buyerCount ?? 0 }})
                            </a>
                        </div>

                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2" style="border-radius: 0.75rem; font-weight: 700; border-color: rgba(255,255,255,0.2);">
                            <i class="fas fa-arrow-left"></i>
                            <span>Dashboard Overview</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="container-fluid px-3 px-md-4 mt-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($pendingUsers->count() > 0)
                <div class="row g-4">
                    @foreach($pendingUsers as $user)
                        <div class="col-lg-6 col-xl-4">
                            <div class="admin-card h-100 d-flex flex-column">
                                <div class="p-3 p-md-4 border-bottom d-flex justify-content-between align-items-start gap-2" style="background: rgba(13, 148, 136, 0.04);">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($user->avatar_url)
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #0d9488;">
                                        @else
                                            <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #0d9488, #06b6d4); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h6 style="font-weight: 800; font-size: 1.05rem; margin: 0; color: #0f172a;" class="dark:text-white">
                                                {{ $user->name }}
                                            </h6>
                                            <small style="color: #64748b; font-size: 0.8rem;">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        @if($user->isSeller())
                                            <span class="badge" style="background: rgba(13, 148, 136, 0.15); color: #0d9488; font-weight: 800; font-size: 0.75rem; border-radius: 2rem; padding: 0.35rem 0.7rem;">
                                                <i class="fas fa-store me-1"></i>Seller Account
                                            </span>
                                        @else
                                            <span class="badge" style="background: rgba(2, 132, 199, 0.15); color: #0284c7; font-weight: 800; font-size: 0.75rem; border-radius: 2rem; padding: 0.35rem 0.7rem;">
                                                <i class="fas fa-shopping-bag me-1"></i>Buyer/Recycler
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-3 p-md-4 flex-grow-1">
                                    <!-- ID Document Info -->
                                    <div class="mb-3">
                                        <small style="color: #64748b; font-weight: 800; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">SUBMITTED ID DETAILS</small>
                                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                            <span class="badge bg-dark" style="font-size: 0.8rem; font-weight: 700; padding: 0.35rem 0.75rem;">
                                                <i class="fas fa-address-card text-emerald me-1"></i>{{ $user->id_type ?? 'Government ID' }}
                                            </span>
                                            @if($user->id_number)
                                                <span style="color: #475569; font-weight: 700; font-size: 0.85rem;" class="dark:text-slate-300"># {{ $user->id_number }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- REGISTERED PHYSICAL LOCATION (Crucial for Sellers) -->
                                    <div class="mb-3 p-3 rounded-3" style="background: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.2);">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <small style="color: #0d9488; font-weight: 800; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                                <i class="fas fa-location-dot me-1"></i>REGISTERED PICKUP LOCATION
                                            </small>
                                            @php
                                                $locQuery = $user->getFormattedLocation();
                                            @endphp
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($locQuery) }}" target="_blank"
                                               class="btn btn-xs btn-outline-primary" style="font-size: 0.72rem; font-weight: 700; border-radius: 0.4rem; padding: 0.15rem 0.45rem;">
                                                <i class="fas fa-map me-1"></i>View on Map
                                            </a>
                                        </div>
                                        <div style="font-size: 0.88rem; font-weight: 700; color: #0f172a;" class="dark:text-white">
                                            {{ $user->getFormattedLocation() }}
                                        </div>
                                        @if($user->location_notes)
                                            <div class="mt-1" style="font-size: 0.78rem; color: #64748b;">
                                                <strong>Landmark:</strong> {{ $user->location_notes }}
                                            </div>
                                        @endif
                                        @if($user->proof_of_address_type)
                                            <div class="mt-1">
                                                <span class="badge" style="background: rgba(147, 51, 234, 0.12); color: #9333ea; font-size: 0.72rem; font-weight: 700;">
                                                    <i class="fas fa-file-check me-1"></i>Proof: {{ ucwords(str_replace('_', ' ', $user->proof_of_address_type)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    @if($user->phone || $user->business_name)
                                        <div class="mb-3 p-2 rounded" style="background: #f8fafc; font-size: 0.85rem;" class="dark:bg-slate-800">
                                            @if($user->business_name)
                                                <div><strong style="color: #0f172a;" class="dark:text-white">Store/Entity:</strong> {{ $user->business_name }}</div>
                                            @endif
                                            @if($user->phone)
                                                <div><strong style="color: #0f172a;" class="dark:text-white">Contact:</strong> {{ $user->phone }}</div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Document Attachments Grid -->
                                    <div class="mb-3">
                                        <small style="color: #64748b; font-weight: 800; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">ATTACHED VERIFICATION DOCUMENTS</small>
                                        <div class="row g-2 mt-1">
                                            <!-- Front ID -->
                                            @if($user->id_photo_url)
                                                <div class="col-6">
                                                    <div class="user-doc-preview" data-bs-toggle="modal" data-bs-target="#docModal{{ $user->id }}id">
                                                        <img src="{{ $user->id_photo_url }}" alt="Primary ID Front">
                                                        <span class="doc-badge-overlay"><i class="fas fa-magnifying-glass me-1"></i>Front ID</span>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Back ID (Address Side) -->
                                            @if($user->id_back_photo_url)
                                                <div class="col-6">
                                                    <div class="user-doc-preview" data-bs-toggle="modal" data-bs-target="#docModal{{ $user->id }}back">
                                                        <img src="{{ $user->id_back_photo_url }}" alt="ID Back Address">
                                                        <span class="doc-badge-overlay" style="background: rgba(13, 148, 136, 0.85);"><i class="fas fa-location-dot me-1"></i>Back / Address</span>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Selfie with ID -->
                                            @if($user->id_selfie_url)
                                                <div class="col-6">
                                                    <div class="user-doc-preview" data-bs-toggle="modal" data-bs-target="#docModal{{ $user->id }}selfie">
                                                        <img src="{{ $user->id_selfie_url }}" alt="Selfie with ID">
                                                        <span class="doc-badge-overlay"><i class="fas fa-user-check me-1"></i>Selfie Match</span>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Proof of Address / Barangay Cert -->
                                            @if($user->proof_of_address_url)
                                                <div class="col-6">
                                                    <div class="user-doc-preview" data-bs-toggle="modal" data-bs-target="#docModal{{ $user->id }}proof">
                                                        @if(Str::endsWith(strtolower($user->proof_of_address_url), ['.pdf']))
                                                            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-white p-2 text-center" style="background: #1e293b;">
                                                                <i class="fas fa-file-pdf fa-2x text-danger mb-1"></i>
                                                                <span style="font-size: 0.72rem;">PDF Document</span>
                                                            </div>
                                                        @else
                                                            <img src="{{ $user->proof_of_address_url }}" alt="Proof of Address">
                                                        @endif
                                                        <span class="doc-badge-overlay" style="background: rgba(147, 51, 234, 0.85);"><i class="fas fa-file-invoice me-1"></i>Proof of Location</span>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(!$user->id_photo_url && !$user->id_back_photo_url && !$user->id_selfie_url && !$user->proof_of_address_url)
                                                <div class="col-12 text-muted" style="font-size: 0.85rem; font-style: italic;">
                                                    No direct photo uploaded (Manual verification required).
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <small style="color: #94a3b8; font-size: 0.75rem;">
                                        Submitted: {{ $user->id_submitted_at ? $user->id_submitted_at->format('M d, Y • h:i A') : $user->created_at->format('M d, Y') }} 
                                        ({{ ($user->id_submitted_at ?? $user->created_at)->diffForHumans() }})
                                    </small>
                                </div>

                                <!-- Action Buttons -->
                                <div class="p-3 border-top d-flex gap-2" style="background: rgba(0,0,0,0.02);">
                                    <form method="POST" action="{{ route('admin.verify-user', $user) }}" style="flex: 1;">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100" style="font-weight: 800; border-radius: 0.65rem; font-size: 0.88rem; padding: 0.6rem;">
                                            <i class="fas fa-check-circle me-1"></i>Approve ID & Location
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $user->id }}" style="font-weight: 700; border-radius: 0.65rem; font-size: 0.88rem; padding: 0.6rem 1rem;">
                                        <i class="fas fa-times-circle me-1"></i>Reject
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 1. Front ID Zoom Modal -->
                        @if($user->id_photo_url)
                            <div class="modal fade" id="docModal{{ $user->id }}id" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-dark text-white">
                                            <h6 class="modal-title font-weight-bold"><i class="fas fa-id-card me-2"></i>{{ $user->name }} - Front ID Document</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-0 bg-dark text-center">
                                            <img src="{{ $user->id_photo_url }}" style="max-height: 80vh; max-width: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- 2. Back ID (Address Side) Zoom Modal -->
                        @if($user->id_back_photo_url)
                            <div class="modal fade" id="docModal{{ $user->id }}back" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-dark text-white">
                                            <h6 class="modal-title font-weight-bold"><i class="fas fa-map-location-dot me-2 text-emerald"></i>{{ $user->name }} - Back of ID (Address Verification)</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-0 bg-dark text-center">
                                            <img src="{{ $user->id_back_photo_url }}" style="max-height: 80vh; max-width: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- 3. Selfie Zoom Modal -->
                        @if($user->id_selfie_url)
                            <div class="modal fade" id="docModal{{ $user->id }}selfie" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-dark text-white">
                                            <h6 class="modal-title font-weight-bold"><i class="fas fa-user-check me-2"></i>{{ $user->name }} - Selfie with ID</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-0 bg-dark text-center">
                                            <img src="{{ $user->id_selfie_url }}" style="max-height: 80vh; max-width: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- 4. Proof of Address Zoom Modal -->
                        @if($user->proof_of_address_url)
                            <div class="modal fade" id="docModal{{ $user->id }}proof" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-dark text-white">
                                            <h6 class="modal-title font-weight-bold"><i class="fas fa-file-invoice me-2 text-purple"></i>{{ $user->name }} - Proof of Location Document</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-0 bg-dark text-center">
                                            @if(Str::endsWith(strtolower($user->proof_of_address_url), ['.pdf']))
                                                <div class="p-4 text-white">
                                                    <p class="mb-3">This document was uploaded as a PDF file.</p>
                                                    <a href="{{ $user->proof_of_address_url }}" target="_blank" class="btn btn-primary">
                                                        <i class="fas fa-external-link-alt me-1"></i>Open PDF in New Window
                                                    </a>
                                                </div>
                                            @else
                                                <img src="{{ $user->proof_of_address_url }}" style="max-height: 80vh; max-width: 100%; object-fit: contain;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Reject Modal with Reason & Quick Chips -->
                        <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header bg-danger text-white">
                                        <h6 class="modal-title font-weight-bold"><i class="fas fa-triangle-exclamation me-2"></i>Reject Verification Application</h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.reject-user', $user) }}">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <label class="form-label font-weight-bold">Rejection Reason</label>
                                            
                                            <!-- Quick Reason Chips -->
                                            <div class="mb-2">
                                                <small class="text-muted d-block mb-1">Quick Suggestions:</small>
                                                <span class="quick-reason-chip" onclick="document.getElementById('reason{{ $user->id }}').value = 'The address on your ID does not match the registered pickup location.'">
                                                    Address Mismatch
                                                </span>
                                                <span class="quick-reason-chip" onclick="document.getElementById('reason{{ $user->id }}').value = 'Back of ID photo showing your address is missing or unreadable.'">
                                                    Back ID Missing/Blurry
                                                </span>
                                                <span class="quick-reason-chip" onclick="document.getElementById('reason{{ $user->id }}').value = 'Please provide a Barangay Certificate of Residency or utility bill to verify this location.'">
                                                    Barangay Cert Needed
                                                </span>
                                                <span class="quick-reason-chip" onclick="document.getElementById('reason{{ $user->id }}').value = 'The uploaded government ID has expired. Please provide a valid, active ID.'">
                                                    Expired ID
                                                </span>
                                                <span class="quick-reason-chip" onclick="document.getElementById('reason{{ $user->id }}').value = 'The photo of your ID is blurry or cut off. Please re-take a clear photo.'">
                                                    Blurry Photo
                                                </span>
                                            </div>

                                            <textarea class="form-control" id="reason{{ $user->id }}" name="reason" rows="4" required placeholder="State why ID or location was rejected..."></textarea>
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>The user will receive this exact explanation so they can correct their documents in Settings.
                                            </small>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger font-weight-bold">Confirm Rejection</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $pendingUsers->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem;">
                        <i class="fas fa-circle-check"></i>
                    </div>
                    <h4 style="font-weight: 900; color: #0f172a;" class="dark:text-white">All Caught Up!</h4>
                    <p style="color: #64748b; font-size: 0.95rem; max-width: 450px; margin: 0 auto;">
                        There are no pending verification submissions matching this criteria. All seller locations and buyer IDs are processed.
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection

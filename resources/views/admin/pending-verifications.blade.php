@extends('layouts.app')

@section('title', 'ID & Recycler Verifications - E-Benta Admin')

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
</style>
@endsection

@section('content')

@include('admin.sidebar')

<div class="main-content-wrapper">
    <div class="admin-page-container">
        
        <!-- HEADER -->
        <div class="admin-module-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-id-card me-1"></i>KYC & ID Verification Queue
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $pendingUsers->total() }} Submissions Pending</span>
                        </div>
                        <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px;">
                            Government ID Verifications
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Inspect PhilSys, Driver's Licenses, and Passports to verify legitimate buyers & recyclers.
                        </p>
                    </div>

                    <div>
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
                                    <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706; font-weight: 800; font-size: 0.75rem; border-radius: 2rem; padding: 0.35rem 0.7rem;">
                                        <i class="fas fa-hourglass-half me-1"></i>Review
                                    </span>
                                </div>

                                <div class="p-3 p-md-4 flex-grow-1">
                                    <div class="mb-3">
                                        <small style="color: #64748b; font-weight: 800; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">SUBMITTED ID TYPE</small>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <span class="badge bg-dark" style="font-size: 0.8rem; font-weight: 700; padding: 0.35rem 0.75rem;">
                                                <i class="fas fa-address-card text-emerald me-1"></i>{{ $user->id_type ?? 'Government ID' }}
                                            </span>
                                            @if($user->id_number)
                                                <small style="color: #475569; font-weight: 700;"># {{ $user->id_number }}</small>
                                            @endif
                                        </div>
                                    </div>

                                    @if($user->phone || $user->business_name)
                                        <div class="mb-3 p-2 rounded" style="background: #f8fafc; font-size: 0.85rem;">
                                            @if($user->business_name)
                                                <div><strong style="color: #0f172a;">Company:</strong> {{ $user->business_name }}</div>
                                            @endif
                                            @if($user->phone)
                                                <div><strong style="color: #0f172a;">Phone:</strong> {{ $user->phone }}</div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Document Attachments -->
                                    <div class="mb-3">
                                        <small style="color: #64748b; font-weight: 800; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">ATTACHED DOCUMENTS</small>
                                        <div class="row g-2 mt-1">
                                            @if($user->id_photo_url)
                                                <div class="col-6">
                                                    <div class="user-doc-preview" data-bs-toggle="modal" data-bs-target="#docModal{{ $user->id }}id">
                                                        <img src="{{ $user->id_photo_url }}" alt="Primary ID">
                                                        <span class="doc-badge-overlay"><i class="fas fa-magnifying-glass me-1"></i>Front ID</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->id_selfie_url)
                                                <div class="col-6">
                                                    <div class="user-doc-preview" data-bs-toggle="modal" data-bs-target="#docModal{{ $user->id }}selfie">
                                                        <img src="{{ $user->id_selfie_url }}" alt="Selfie with ID">
                                                        <span class="doc-badge-overlay"><i class="fas fa-magnifying-glass me-1"></i>Selfie Match</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(!$user->id_photo_url && !$user->id_selfie_url)
                                                <div class="col-12 text-muted" style="font-size: 0.85rem; font-style: italic;">
                                                    No direct photo uploaded (Manual verification required).
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <small style="color: #94a3b8; font-size: 0.75rem;">
                                        Applied: {{ $user->created_at->format('M d, Y • h:i A') }} ({{ $user->created_at->diffForHumans() }})
                                    </small>
                                </div>

                                <!-- Action Buttons -->
                                <div class="p-3 border-top d-flex gap-2" style="background: rgba(0,0,0,0.02);">
                                    <form method="POST" action="{{ route('admin.verify-user', $user) }}" style="flex: 1;">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100" style="font-weight: 800; border-radius: 0.65rem; font-size: 0.88rem; padding: 0.6rem;">
                                            <i class="fas fa-check-circle me-1"></i>Approve ID
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $user->id }}" style="font-weight: 700; border-radius: 0.65rem; font-size: 0.88rem; padding: 0.6rem 1rem;">
                                        <i class="fas fa-times-circle me-1"></i>Reject
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ID Photo Zoom Modal -->
                        @if($user->id_photo_url)
                            <div class="modal fade" id="docModal{{ $user->id }}id" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-dark text-white">
                                            <h6 class="modal-title font-weight-bold"><i class="fas fa-id-card me-2"></i>{{ $user->name }} - Primary ID Document</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-0 bg-dark text-center">
                                            <img src="{{ $user->id_photo_url }}" style="max-height: 80vh; max-width: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Selfie Zoom Modal -->
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

                        <!-- Reject Modal with Reason -->
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
                                            <textarea class="form-control" name="reason" rows="4" required placeholder="State why ID was rejected (e.g. Blurry photo, Expired document, Mismatched name)..."></textarea>
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>The user will receive this explanation to allow re-submission.
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
                    <h4 style="font-weight: 900; color: #0f172a;">All Caught Up!</h4>
                    <p style="color: #64748b; font-size: 0.95rem; max-width: 450px; margin: 0 auto;">
                        There are no pending ID submissions awaiting verification. All buyer accounts are currently processed.
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection

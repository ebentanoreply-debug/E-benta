@extends('layouts.app')

@section('title', 'Investigate Incident Report #' . $report->id . ' - E-Benta Admin')

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

    .admin-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    body.dark-mode .admin-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
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
                            <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                Incident Investigation #{{ $report->id }}
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• Submitted {{ $report->created_at->diffForHumans() }}</span>
                        </div>
                        <h1 style="font-size: clamp(1.5rem, 2.2vw, 2rem); font-weight: 900; margin: 0;">
                            {{ $report->getReasonLabel() }}
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Status: <strong class="text-warning text-capitalize">{{ str_replace('_', ' ', $report->status) }}</strong>
                        </p>
                    </div>

                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2" style="border-radius: 0.75rem; font-weight: 700; border-color: rgba(255,255,255,0.2);">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Reports</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- MAIN INVESTIGATION LAYOUT -->
        <div class="container-fluid px-3 px-md-4 mt-4">
            <div class="row g-4">
                
                <!-- Left: Incident Case File -->
                <div class="col-lg-7">
                    <div class="admin-card p-4 mb-4">
                        <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 1.25rem; font-family: 'Outfit', sans-serif;">
                            <i class="fas fa-file-invoice text-emerald me-2"></i>Incident Information
                        </h5>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="text-muted font-weight-bold text-uppercase" style="font-size: 0.72rem;">REPORTED BY</label>
                                <div class="p-3 bg-light rounded-3 mt-1">
                                    <strong style="display: block; color: #0f172a;">{{ $report->reporter?->name ?? 'Unknown User' }}</strong>
                                    <small class="text-muted">{{ $report->reporter?->email }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="text-muted font-weight-bold text-uppercase" style="font-size: 0.72rem;">TARGET OBJECT</label>
                                <div class="p-3 bg-light rounded-3 mt-1">
                                    @php $type = class_basename($report->reportable_type); @endphp
                                    <strong style="display: block; color: #0f172a;">{{ $type }} #{{ $report->reportable_id }}</strong>
                                    @if($type === 'Listing' && $report->reportable)
                                        <small class="text-muted">Item: {{ $report->reportable->category }} (Listed by {{ $report->reportable->seller?->name }})</small>
                                    @elseif($type === 'Offer' && $report->reportable)
                                        <small class="text-muted">Buyer: {{ $report->reportable->buyer?->name }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="text-muted font-weight-bold text-uppercase" style="font-size: 0.72rem;">REPORTER'S STATEMENT</label>
                                <div class="p-3 bg-light rounded-3 mt-1" style="font-size: 0.95rem; line-height: 1.6; color: #334155;">
                                    {{ $report->description ?: 'No detailed written statement provided.' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="text-muted font-weight-bold text-uppercase" style="font-size: 0.72rem;">NETWORK IP ADDRESS</label>
                                <div class="p-2 bg-light rounded-3 mt-1" style="font-family: monospace; font-size: 0.85rem;">
                                    {{ $report->ip_address ?? '127.0.0.1' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="text-muted font-weight-bold text-uppercase" style="font-size: 0.72rem;">TIMESTAMP</label>
                                <div class="p-2 bg-light rounded-3 mt-1" style="font-size: 0.85rem;">
                                    {{ $report->created_at->format('M d, Y • h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($report->admin_notes)
                        <div class="admin-card p-4">
                            <h6 style="font-weight: 800; color: #0f172a; margin-bottom: 0.75rem;">
                                <i class="fas fa-sticky-note text-warning me-2"></i>Investigation Resolution Notes
                            </h6>
                            <div class="p-3 rounded-3" style="background: rgba(245, 158, 11, 0.08); border-left: 4px solid #f59e0b; color: #78350f;">
                                {{ $report->admin_notes }}
                            </div>
                            @if($report->reviewer)
                                <small class="text-muted d-block mt-2">
                                    Resolved by <strong>{{ $report->reviewer->name }}</strong> on {{ $report->reviewed_at?->format('M d, Y') }}
                                </small>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Right: Moderation Actions & Strike Meter -->
                <div class="col-lg-5">
                    @php
                        $targetUser = null;
                        if ($report->reportable instanceof \App\Models\User) $targetUser = $report->reportable;
                        elseif ($report->reportable instanceof \App\Models\Listing) $targetUser = $report->reportable->seller;
                        elseif ($report->reportable instanceof \App\Models\Offer) $targetUser = $report->reportable->buyer;
                        $currentWarnings = $targetUser ? ($targetUser->warning_count ?? 0) : 0;
                    @endphp

                    @if($targetUser)
                        <!-- 3-Strike Warning Meter -->
                        <div class="admin-card p-4 mb-4" style="border-left: 4px solid #f59e0b;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 style="font-weight: 800; margin: 0; color: #0f172a;">Target User Strike Meter</h6>
                                <span class="badge {{ $currentWarnings >= 2 ? 'bg-danger' : 'bg-warning text-dark' }} font-weight-bold">
                                    {{ $currentWarnings }} / 3 Strikes
                                </span>
                            </div>
                            <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.75rem;">
                                Target: <strong>{{ $targetUser->name }}</strong> ({{ $targetUser->email }})
                            </p>
                            <div class="progress" style="height: 10px; border-radius: 1rem;">
                                <div class="progress-bar {{ $currentWarnings >= 2 ? 'bg-danger' : 'bg-warning' }}" role="progressbar" style="width: {{ ($currentWarnings / 3) * 100 }}%"></div>
                            </div>
                            @if($currentWarnings >= 2)
                                <small class="text-danger font-weight-bold d-block mt-2">
                                    ⚠️ Caution: Next warning will trigger an AUTOMATIC BAN.
                                </small>
                            @endif
                        </div>
                    @endif

                    <!-- Moderation Resolution Form -->
                    <div class="admin-card p-4">
                        <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 1.25rem; font-family: 'Outfit', sans-serif;">
                            <i class="fas fa-gavel text-danger me-2"></i>Take Moderation Action
                        </h5>

                        @if($report->status === 'pending')
                            <form method="POST" action="{{ route('admin.reports.under-review', $report) }}" class="mb-3">
                                @csrf
                                <button type="submit" class="btn btn-outline-info w-100 font-weight-bold" style="border-radius: 0.65rem; padding: 0.55rem;">
                                    <i class="fas fa-magnifying-glass me-1"></i>Mark as Under Investigation
                                </button>
                            </form>
                        @endif

                        @if($report->status !== 'resolved' && $report->status !== 'dismissed')
                            <form method="POST" action="{{ route('admin.reports.resolve', $report) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold" style="font-size: 0.82rem;">Select Action</label>
                                    <select name="action_taken" id="actionTakenSelect" required class="form-select" onchange="toggleSuspensionFields(this.value)" style="border-radius: 0.65rem; font-weight: 600;">
                                        <option value="">-- Choose Resolution Action --</option>
                                        <option value="none">No Action Required (Dismiss as Invalid)</option>
                                        <option value="warning_sent">Issue Official Warning / Strike (+1 Strike)</option>
                                        <option value="user_suspended">Suspend User Account (Temporary Lock)</option>
                                        <option value="user_banned">Ban User Account Permanently</option>
                                        <option value="listing_removed">Remove / Delete Reported Listing</option>
                                    </select>
                                </div>

                                <!-- Dynamic Suspension Duration -->
                                <div id="suspensionDurationWrapper" style="display: none;" class="mb-3">
                                    <label class="form-label font-weight-bold" style="font-size: 0.82rem;">Suspension Length</label>
                                    <select name="suspension_days" class="form-select" style="border-radius: 0.65rem; font-weight: 600;">
                                        <option value="3">3 Days Suspension</option>
                                        <option value="7" selected>7 Days Suspension (1 Week)</option>
                                        <option value="14">14 Days Suspension (2 Weeks)</option>
                                        <option value="30">30 Days Suspension (1 Month)</option>
                                        <option value="">Indefinite</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label font-weight-bold" style="font-size: 0.82rem;">Resolution Notes</label>
                                    <textarea name="admin_notes" rows="3" class="form-control" placeholder="Explain the investigation findings and reasoning..." required style="border-radius: 0.65rem;"></textarea>
                                </div>

                                <button type="submit" class="btn btn-danger w-100 font-weight-bold" style="border-radius: 0.65rem; padding: 0.65rem;">
                                    <i class="fas fa-check-double me-1"></i>Execute Moderation Action
                                </button>
                            </form>

                            <hr class="my-3">

                            <form method="POST" action="{{ route('admin.reports.dismiss', $report) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary w-100 btn-sm" onclick="return confirm('Dismiss this report as false or resolved?')" style="border-radius: 0.65rem;">
                                    <i class="fas fa-ban me-1"></i>Dismiss Incident
                                </button>
                            </form>
                        @else
                            <div class="p-3 bg-light rounded text-center text-muted">
                                <i class="fas fa-lock me-1"></i>This incident has been finalized and closed.
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function toggleSuspensionFields(action) {
        const suspWrap = document.getElementById('suspensionDurationWrapper');
        if (suspWrap) {
            suspWrap.style.display = (action === 'user_suspended') ? 'block' : 'none';
        }
    }
</script>
@endsection

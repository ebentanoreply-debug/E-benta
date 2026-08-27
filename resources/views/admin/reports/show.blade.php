@extends('layouts.app')

@section('title', 'Report Details - E-Benta Admin')

@section('content')
<style>
    /* === REPORT DETAIL WRAPPER === */
    .report-detail-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .report-detail-header {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.12) 0%, rgba(220, 38, 38, 0.06) 100%);
        border-left: 4px solid #dc2626;
        padding: 2rem;
        margin-bottom: 2rem;
        border-radius: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border: 1px solid rgba(220, 38, 38, 0.1);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.08);
        transition: all 0.3s ease;
    }

    .report-detail-header:hover {
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.12);
    }

    .report-detail-header-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .report-detail-icon-box {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.3) 0%, rgba(220, 38, 38, 0.15) 100%);
        padding: 1.2rem;
        border-radius: 0.8rem;
        font-size: 1.8rem;
        color: #dc2626;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
    }

    .report-detail-header h1 {
        color: #1e293b;
        font-weight: 800;
        margin: 0;
        font-size: 2rem;
    }

    .report-detail-header p {
        color: #64748b;
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    .report-detail-meta {
        color: #64748b;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 0.8rem;
        background: rgba(255, 255, 255, 0.5);
        padding: 0.75rem 1.25rem;
        border-radius: 0.6rem;
    }

    .report-detail-meta strong {
        color: #dc2626;
    }

    /* === BACK LINK === */
    .back-link {
        color: #dc2626;
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        background: rgba(220, 38, 38, 0.05);
        border-radius: 0.6rem;
    }

    .back-link:hover {
        background: rgba(220, 38, 38, 0.1);
        transform: translateX(-4px);
    }

    /* === DETAIL CARD === */
    .detail-card {
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(220, 38, 38, 0.08);
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .detail-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .detail-card h5 {
        color: #dc2626;
        font-weight: 800;
        margin-bottom: 2rem;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-bottom: 2px solid rgba(220, 38, 38, 0.1);
        padding-bottom: 1rem;
    }

    .detail-card h5 i {
        font-size: 1.5rem;
    }

    .detail-grid {
        display: grid;
        gap: 2rem;
    }

    .detail-item-label {
        color: #64748b;
        text-transform: uppercase;
        font-weight: 800;
        font-size: 0.75rem;
        letter-spacing: 1.2px;
        display: block;
        margin-bottom: 0.75rem;
    }

    .detail-item-box {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.05) 0%, rgba(220, 38, 38, 0.02) 100%);
        padding: 1.25rem;
        border-radius: 0.8rem;
        border-left: 4px solid #dc2626;
        transition: all 0.3s ease;
    }

    .detail-item-box:hover {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.08) 0%, rgba(220, 38, 38, 0.04) 100%);
        border-left-color: #b91c1c;
    }

    .detail-item-text {
        color: #1e293b;
        margin: 0;
        font-weight: 600;
        word-break: break-word;
        white-space: pre-wrap;
        line-height: 1.6;
    }

    .detail-item-sub {
        color: #64748b;
        display: block;
        margin-top: 0.75rem;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .detail-item-sub a {
        color: #dc2626;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .detail-item-sub a:hover {
        text-decoration: underline;
        opacity: 0.8;
    }

    /* === METADATA GRID === */
    .metadata-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    /* === ACTION SIDEBAR === */
    .action-sidebar {
        position: sticky;
        top: 120px;
        background: white;
        border-radius: 1.2rem;
        border: 1px solid rgba(220, 38, 38, 0.08);
        padding: 2.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .action-sidebar:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .action-sidebar h5 {
        color: #dc2626;
        font-weight: 800;
        margin-bottom: 2rem;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-bottom: 2px solid rgba(220, 38, 38, 0.1);
        padding-bottom: 1rem;
    }

    .action-form {
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        background: rgba(220, 38, 38, 0.02);
        border-radius: 0.8rem;
        border: 1px solid rgba(220, 38, 38, 0.08);
        transition: all 0.3s ease;
    }

    .action-form:hover {
        background: rgba(220, 38, 38, 0.04);
        border-color: rgba(220, 38, 38, 0.15);
    }

    .action-form-label {
        color: #1e293b;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.75rem;
        display: block;
        margin-bottom: 0.75rem;
        letter-spacing: 0.5px;
    }

    .action-form-select,
    .action-form-textarea {
        width: 100%;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1.5px solid rgba(220, 38, 38, 0.2);
        color: #1e293b;
        padding: 0.85rem;
        border-radius: 0.6rem;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .action-form-select:focus,
    .action-form-textarea:focus {
        border-color: rgba(220, 38, 38, 0.5);
        box-shadow: 0 0 12px rgba(220, 38, 38, 0.15);
        outline: none;
        background: white;
    }

    .action-form-textarea {
        resize: vertical;
        min-height: 100px;
        font-family: inherit;
    }

    .action-btn {
        width: 100%;
        border: none;
        font-weight: 800;
        padding: 1rem;
        border-radius: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .action-btn:active {
        transform: scale(0.98);
    }

    .action-btn-resolve {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
    }

    .action-btn-resolve:hover {
        box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
        transform: translateY(-3px);
    }

    .action-btn-review {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .action-btn-review:hover {
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        transform: translateY(-3px);
    }

    .action-btn-dismiss {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1.5px solid rgba(107, 114, 128, 0.2);
        font-weight: 700;
    }

    .action-btn-dismiss:hover {
        background: rgba(107, 114, 128, 0.15);
        border-color: rgba(107, 114, 128, 0.3);
    }

    .status-display {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.08) 100%);
        padding: 1.5rem;
        border-radius: 0.8rem;
        border-left: 4px solid #22c55e;
        margin-top: 1.5rem;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.1);
    }

    .status-display-label {
        color: #64748b;
        margin: 0;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 800;
        margin-bottom: 0.75rem;
        letter-spacing: 0.5px;
    }

    .status-display-value {
        color: #22c55e;
        margin: 0;
        font-weight: 800;
        font-size: 1.1rem;
        text-transform: uppercase;
    }

    /* === DARK MODE === */
    body.dark-mode .report-detail-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .report-detail-header,
    body.dark-mode .detail-card,
    body.dark-mode .action-sidebar {
        background: #2a2a2a;
        border-color: rgba(220, 38, 38, 0.2);
    }

    body.dark-mode .detail-item-label,
    body.dark-mode .report-detail-header h1,
    body.dark-mode .detail-card h5,
    body.dark-mode .action-sidebar h5,
    body.dark-mode .action-form-label,
    body.dark-mode .detail-item-text {
        color: #e0e0e0;
    }

    body.dark-mode .detail-item-box {
        background: rgba(220, 38, 38, 0.08);
    }

    body.dark-mode .action-form {
        background: rgba(220, 38, 38, 0.05);
    }

    body.dark-mode .action-form-select,
    body.dark-mode .action-form-textarea {
        background: #333333;
        border-color: rgba(220, 38, 38, 0.3);
        color: #e0e0e0;
    }

    body.dark-mode .action-form-select:focus,
    body.dark-mode .action-form-textarea:focus {
        background: #3a3a3a;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .report-detail-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .report-detail-header h1 {
            font-size: 1.5rem;
        }

        .metadata-grid {
            grid-template-columns: 1fr;
        }

        .action-sidebar {
            position: relative;
            top: auto;
        }

        .report-detail-header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .main-card {
            padding: 1.25rem 1rem;
        }

        .action-sidebar {
            padding: 1.25rem 1rem;
        }
    }

    @media (max-width: 480px) {
        .report-detail-wrapper {
            padding: 0;
        }

        .report-detail-header {
            padding: 1.25rem 1rem;
            border-radius: 1rem;
        }

        .report-detail-header h1 {
            font-size: 1.45rem;
        }
    }
</style>

<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper">
    <div class="report-detail-wrapper p-3 p-md-4">
        <!-- Back Link -->
        <a href="{{ route('admin.reports.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>Back to Reports
        </a>

        <!-- Header -->
        <div class="report-detail-header">
            <div class="report-detail-header-content">
                <div class="report-detail-icon-box">
                    <i class="fas fa-flag"></i>
                </div>
                <div>
                    <h1>Report #{{ $report->id }}</h1>
                    <p>
                        Status: <strong style="color: #dc2626;">{{ ucfirst(str_replace('_', ' ', $report->status)) }}</strong>
                    </p>
                </div>
            </div>
            <div>
                <div class="report-detail-meta">
                    Submitted {{ $report->created_at->diffForHumans() }}
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Report Details -->
                <div class="detail-card">
                    <h5><i class="fas fa-info-circle"></i>Report Information</h5>

                    <div class="detail-grid">
                        <!-- Reporter Info -->
                        <div>
                            <span class="detail-item-label"><i class="fas fa-user-circle" style="margin-right: 0.5rem; color: #dc2626;"></i>Reported By</span>
                            <div class="detail-item-box">
                                <p class="detail-item-text">
                                    <i class="fas fa-user-shield" style="color: #dc2626; margin-right: 0.75rem;"></i><strong>{{ $report->reporter->name }}</strong>
                                </p>
                                <span class="detail-item-sub">
                                    <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i>{{ $report->reporter->email }}
                                </span>
                            </div>
                        </div>

                        <!-- Reported Item -->
                        <div>
                            <span class="detail-item-label"><i class="fas fa-flag" style="margin-right: 0.5rem; color: #dc2626;"></i>Reported Item</span>
                            <div class="detail-item-box">
                                @php
                                    $type = class_basename($report->reportable_type);
                                @endphp
                                <p class="detail-item-text">
                                    <i class="fas fa-link" style="color: #3b82f6; margin-right: 0.75rem;"></i><strong>{{ $type }} #{{ $report->reportable_id }}</strong>
                                </p>
                                @if($type === 'Listing')
                                    <span class="detail-item-sub">
                                        <i class="fas fa-tag" style="margin-right: 0.5rem;"></i><strong>{{ $report->reportable->category }}</strong><br>
                                        <i class="fas fa-user-tie" style="margin-right: 0.5rem;"></i>Listed by: <a href="{{ route('users.show', $report->reportable->seller) }}">{{ $report->reportable->seller->name }}</a><br>
                                        <i class="fas fa-circle" style="margin-right: 0.5rem; color: #3b82f6;"></i>Status: <strong>{{ ucfirst($report->reportable->status) }}</strong>
                                    </span>
                                @elseif($type === 'Offer')
                                    <span class="detail-item-sub">
                                        <i class="fas fa-shopping-bag" style="margin-right: 0.5rem;"></i><strong>Offer for: {{ $report->reportable->listing->category }}</strong><br>
                                        <i class="fas fa-user" style="margin-right: 0.5rem;"></i>From: <a href="{{ route('users.show', $report->reportable->buyer) }}">{{ $report->reportable->buyer->name }}</a><br>
                                        <i class="fas fa-circle" style="margin-right: 0.5rem; color: #3b82f6;"></i>Status: <strong>{{ ucfirst($report->reportable->status) }}</strong>
                                    </span>
                                @else
                                    <span class="detail-item-sub">
                                        <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i><strong>{{ $report->reportable->email }}</strong><br>
                                        <i class="fas fa-clock" style="margin-right: 0.5rem;"></i>Member since: <strong>{{ $report->reportable->created_at->format('M d, Y') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Reason -->
                        <div>
                            <span class="detail-item-label"><i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem; color: #ef4444;"></i>Report Reason</span>
                            <div class="detail-item-box" style="border-left-color: #ef4444; background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(239, 68, 68, 0.03) 100%);">
                                <p class="detail-item-text" style="color: #dc2626;">
                                    <i class="fas fa-exclamation-circle" style="margin-right: 0.75rem;"></i><strong>{{ $report->getReasonLabel() }}</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <span class="detail-item-label"><i class="fas fa-comment-dots" style="margin-right: 0.5rem; color: #dc2626;"></i>Report Details</span>
                            <div class="detail-item-box">
                                <p class="detail-item-text">{{ $report->description }}</p>
                            </div>
                        </div>

                        <!-- Metadata -->
                        <div class="metadata-grid">
                            <div>
                                <span class="detail-item-label"><i class="fas fa-network-wired" style="margin-right: 0.5rem; color: #dc2626;"></i>IP Address</span>
                                <div class="detail-item-box">
                                    <p class="detail-item-text" style="font-family: 'Monaco', 'Courier New', monospace; font-size: 0.9rem; color: #0f766e; background: rgba(15, 118, 110, 0.05); padding: 0.75rem; border-radius: 0.6rem; border-left-color: #0f766e;">
                                        {{ $report->ip_address ?? 'Not recorded' }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <span class="detail-item-label"><i class="fas fa-calendar-alt" style="margin-right: 0.5rem; color: #dc2626;"></i>Submitted</span>
                                <div class="detail-item-box">
                                    <p class="detail-item-text">
                                        <i class="fas fa-clock" style="margin-right: 0.5rem;"></i>{{ $report->created_at->format('M d, Y') }}<br>
                                        <span style="color: #64748b; font-size: 0.9rem;"><i class="fas fa-hourglass-end" style="margin-right: 0.5rem;"></i>{{ $report->created_at->format('g:i A') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes -->
                @if($report->admin_notes)
                    <div class="detail-card">
                        <h5 style="color: #3b82f6; border-bottom-color: rgba(59, 130, 246, 0.1);"><i class="fas fa-sticky-note"></i>Admin Notes</h5>
                        <div class="detail-item-box" style="border-left-color: #3b82f6; background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0.03) 100%);">
                            <p class="detail-item-text">{{ $report->admin_notes }}</p>
                        </div>
                        @if($report->reviewer)
                            <p style="color: #64748b; margin-top: 1.5rem; font-size: 0.85rem; padding: 1rem; background: rgba(59, 130, 246, 0.03); border-radius: 0.6rem; border-left: 3px solid #3b82f6;">
                                <i class="fas fa-user-shield" style="margin-right: 0.75rem; color: #3b82f6;"></i><strong>Reviewed by</strong> {{ $report->reviewer->name }} on <strong>{{ $report->reviewed_at->format('M d, Y g:i A') }}</strong>
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar Actions -->
            <div class="col-lg-4">
                <div class="action-sidebar">
                    <h5><i class="fas fa-bolt"></i>Quick Actions</h5>

                    @if($report->status === 'pending')
                        <form method="POST" action="{{ route('admin.reports.under-review', $report) }}" class="action-form">
                            @csrf
                            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; background: rgba(59, 130, 246, 0.08); border-radius: 0.6rem; margin-bottom: 1rem;">
                                <i class="fas fa-hourglass-half" style="color: #3b82f6; font-size: 1.2rem;"></i>
                                <div>
                                    <p style="margin: 0; color: #1e293b; font-weight: 700; font-size: 0.9rem;">Start Review</p>
                                    <p style="margin: 0; color: #64748b; font-size: 0.8rem;">Mark report as under review</p>
                                </div>
                            </div>
                            <button type="submit" class="action-btn action-btn-review">
                                <i class="fas fa-magnifying-glass"></i>Mark as Reviewing
                            </button>
                        </form>
                    @endif

                    @if($report->status !== 'resolved' && $report->status !== 'dismissed')
                        @php
                            $targetUser = null;
                            if ($report->reportable instanceof \App\Models\User) $targetUser = $report->reportable;
                            elseif ($report->reportable instanceof \App\Models\Listing) $targetUser = $report->reportable->seller;
                            elseif ($report->reportable instanceof \App\Models\Offer) $targetUser = $report->reportable->buyer;
                            elseif ($report->reportable instanceof \App\Models\Review) $targetUser = $report->reportable->reviewer;
                            $currentWarnings = $targetUser ? ($targetUser->warning_count ?? 0) : 0;
                        @endphp

                        <!-- Resolve Form -->
                        <form method="POST" action="{{ route('admin.reports.resolve', $report) }}" class="action-form">
                            @csrf
                            <div>
                                <label class="action-form-label"><i class="fas fa-gavel" style="margin-right: 0.5rem;"></i>Resolution Action</label>
                                <select name="action_taken" id="actionTakenSelect" required class="action-form-select" onchange="updateActionDetails(this.value)">
                                    <option value="">-- Select Action --</option>
                                    <option value="none">No Action Required</option>
                                    <option value="warning_sent">Send Warning to User (3 Strikes = Auto Ban)</option>
                                    <option value="content_removed">Remove / Withdraw Reported Content</option>
                                    <option value="user_suspended">Suspend User Account</option>
                                    <option value="user_banned">Ban User Permanently</option>
                                    <option value="listing_removed">Remove Listing</option>
                                </select>
                            </div>

                            <!-- Dynamic Suspension Duration -->
                            <div id="suspensionDurationWrapper" style="display: none; margin-top: 1rem;">
                                <label class="action-form-label"><i class="fas fa-calendar-alt" style="margin-right: 0.5rem;"></i>Suspension Duration</label>
                                <select name="suspension_days" class="action-form-select">
                                    <option value="3">3 Days Suspension</option>
                                    <option value="7" selected>7 Days Suspension (1 Week)</option>
                                    <option value="14">14 Days Suspension (2 Weeks)</option>
                                    <option value="30">30 Days Suspension (1 Month)</option>
                                    <option value="">Indefinite / Until manually lifted</option>
                                </select>
                            </div>

                            <!-- Dynamic Warning Strike Alert -->
                            <div id="warningStrikeWrapper" style="display: none; margin-top: 1rem; padding: 0.85rem 1rem; background: rgba(245, 158, 11, 0.1); border-left: 3px solid #f59e0b; border-radius: 0.5rem; font-size: 0.85rem; color: #92400e;">
                                <strong>User Warning History: {{ $currentWarnings }} / 3 Strikes</strong>
                                @if($currentWarnings >= 2)
                                    <p style="margin: 0.25rem 0 0; color: #dc2626; font-weight: 700;">
                                        ⚠️ WARNING: This will be the 3rd strike! The account will be AUTOMATICALLY BANNED permanently upon submission.
                                    </p>
                                @else
                                    <p style="margin: 0.25rem 0 0;">
                                        This action will issue Warning #{{ $currentWarnings + 1 }} to {{ $targetUser?->name ?? 'the user' }}.
                                    </p>
                                @endif
                            </div>

                            <div style="margin-top: 1rem;">
                                <label class="action-form-label"><i class="fas fa-file-alt" style="margin-right: 0.5rem;"></i>Resolution Notes & Notification Message</label>
                                <textarea name="admin_notes" placeholder="Document your resolution decision and instructions to user..." class="action-form-textarea"></textarea>
                            </div>

                            <button type="submit" class="action-btn action-btn-resolve">
                                <i class="fas fa-check-circle"></i>Resolve Report
                            </button>
                        </form>

                        <script>
                            function updateActionDetails(val) {
                                const suspDiv = document.getElementById('suspensionDurationWrapper');
                                const warnDiv = document.getElementById('warningStrikeWrapper');
                                if (suspDiv) suspDiv.style.display = (val === 'user_suspended') ? 'block' : 'none';
                                if (warnDiv) warnDiv.style.display = (val === 'warning_sent') ? 'block' : 'none';
                            }
                        </script>

                        <!-- Dismiss Form -->
                        <form method="POST" action="{{ route('admin.reports.dismiss', $report) }}" class="action-form">
                            @csrf
                            <div>
                                <label class="action-form-label"><i class="fas fa-times-circle" style="margin-right: 0.5rem;"></i>Dismissal Reason</label>
                                <textarea name="admin_notes" placeholder="Explain why this report is being dismissed..." class="action-form-textarea"></textarea>
                            </div>

                            <button type="submit" class="action-btn action-btn-dismiss">
                                <i class="fas fa-ban"></i>Dismiss Report
                            </button>
                        </form>
                    @endif

                    <!-- Status Badge -->
                    <div class="status-display">
                        <p class="status-display-label"><i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Current Status</p>
                        <p class="status-display-value">
                            <i class="fas" style="margin-right: 0.75rem;" @class([
                                'fa-hourglass-half' => $report->status === 'pending',
                                'fa-magnifying-glass' => $report->status === 'under_review',
                                'fa-check-circle' => $report->status === 'resolved',
                                'fa-trash' => $report->status === 'dismissed',
                            ])></i>
                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

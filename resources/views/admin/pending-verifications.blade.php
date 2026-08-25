@extends('layouts.app')

@section('title', 'Pending Verifications - E-Benta Admin')

@section('content')
<style>
    /* === VERIFICATIONS WRAPPER === */
    .verifications-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* === HEADER SECTION === */
    .verifications-header {
        background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
        color: white;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .verifications-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: 0;
    }

    .verifications-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        z-index: 0;
    }

    .verifications-header-content {
        position: relative;
        z-index: 1;
    }

    .verifications-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
    }

    .verifications-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.95rem;
    }

    /* === USER CARDS GRID === */
    .verifications-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .user-card {
        background: white;
        border-radius: 1.2rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(245, 158, 11, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .user-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f59e0b, #f97316);
    }

    .user-card:hover {
        box-shadow: 0 12px 32px rgba(245, 158, 11, 0.15);
        transform: translateY(-6px);
    }

    .user-card-header {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(245, 158, 11, 0.04) 100%);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(245, 158, 11, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.1) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #f59e0b;
    }

    .user-card-title {
        color: #1e293b;
        font-weight: 700;
        margin: 0 0 0 1rem;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
    }

    .status-badge {
        background: rgba(245, 158, 11, 0.15);
        color: #a16207;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border: 1px solid rgba(245, 158, 11, 0.25);
        display: flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
    }

    .user-card-body {
        padding: 1.8rem;
    }

    .info-group {
        margin-bottom: 1.2rem;
    }

    .info-group:last-of-type {
        margin-bottom: 0;
    }

    .info-label {
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .info-label i {
        color: #f59e0b;
    }

    .info-value {
        color: #1e293b;
        font-weight: 500;
        font-size: 0.95rem;
        margin: 0;
    }

    .info-meta {
        color: #94a3b8;
        font-size: 0.8rem;
        margin: 0.3rem 0 0 0;
    }

    .info-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.15), transparent);
        margin: 1.5rem 0;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
    }

    .action-btn {
        flex: 1;
        padding: 0.85rem 1rem;
        border: none;
        border-radius: 0.8rem;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        color: white;
    }

    .btn-approve {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
    }

    .btn-approve:hover {
        box-shadow: 0 6px 20px rgba(13, 148, 136, 0.35);
        transform: translateY(-2px);
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }

    .btn-reject:hover {
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
        transform: translateY(-2px);
    }

    /* === MODAL STYLES === */
    .modal-content {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(239, 68, 68, 0.15);
        border-radius: 1.2rem;
        box-shadow: 0 20px 50px rgba(239, 68, 68, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
        border-bottom: 1px solid rgba(239, 68, 68, 0.15);
        border-radius: 1rem 1rem 0 0;
        padding: 1.5rem;
    }

    .modal-title {
        color: #1e293b;
        font-weight: 800;
        font-size: 1.2rem;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.08) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #ef4444;
    }

    .modal-body {
        padding: 2rem;
    }

    .form-label {
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .form-control {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #1e293b;
        font-weight: 500;
        border-radius: 0.6rem;
        padding: 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: rgba(239, 68, 68, 0.5);
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.15);
        background: white;
        outline: none;
    }

    .form-helper {
        color: #64748b;
        display: block;
        margin-top: 0.75rem;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modal-footer {
        border-top: 1px solid rgba(239, 68, 68, 0.1);
        padding: 1.5rem;
        background: rgba(239, 68, 68, 0.02);
        gap: 1rem;
    }

    .btn-cancel {
        background: rgba(100, 116, 139, 0.1);
        color: #475569;
        border: 1px solid rgba(100, 116, 139, 0.2);
        font-weight: 600;
        border-radius: 0.6rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: rgba(100, 116, 139, 0.15);
        transform: translateY(-2px);
    }

    .btn-confirm {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        font-weight: 700;
        border-radius: 0.6rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        text-decoration: none;
    }

    .btn-confirm:hover {
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
        transform: translateY(-2px);
    }

    /* === EMPTY STATE === */
    .empty-state {
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
        border: 2px solid rgba(13, 148, 136, 0.15);
        border-left: 5px solid #0d9488;
        color: #1e293b;
        padding: 3rem 2rem;
        border-radius: 1.2rem;
        box-shadow: 0 8px 25px rgba(13, 148, 136, 0.08);
        text-align: center;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(13, 148, 136, 0.08) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
        color: #0d9488;
    }

    .empty-title {
        color: #0d9488;
        margin-bottom: 0.75rem;
        font-weight: 800;
        font-size: 1.3rem;
        letter-spacing: -0.5px;
    }

    .empty-message {
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    /* === PAGINATION === */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* === DARK MODE === */
    body.dark-mode .verifications-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
    }

    body.dark-mode .user-card,
    body.dark-mode .empty-state {
        background: #2a2a2a;
        border-color: rgba(245, 158, 11, 0.2);
    }

    body.dark-mode .user-card:hover {
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
    }

    body.dark-mode .user-card-header {
        background: rgba(245, 158, 11, 0.08);
        border-color: rgba(245, 158, 11, 0.2);
    }

    body.dark-mode .user-card-title,
    body.dark-mode .info-value,
    body.dark-mode .modal-title,
    body.dark-mode .empty-state {
        color: #e0e0e0;
    }

    body.dark-mode .form-control {
        background: #333333;
        border-color: rgba(239, 68, 68, 0.3);
        color: #e0e0e0;
    }

    body.dark-mode .form-control:focus {
        background: #3a3a3a;
    }

    body.dark-mode .modal-content {
        background: linear-gradient(135deg, #2a2a2a 0%, #333333 100%);
        border-color: rgba(239, 68, 68, 0.2);
    }

    body.dark-mode .modal-header {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.2);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .verifications-header {
            padding: 1.75rem 1rem;
        }

        .verifications-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .verifications-header h1 {
            font-size: 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .verifications-wrapper {
            padding: 1rem 0;
        }

        .user-card {
            padding: 1.25rem 1rem;
            border-radius: 1rem;
        }

        .user-info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }
</style>

<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper">
    <div class="verifications-wrapper">
        <!-- Header -->
        <div class="verifications-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="verifications-header-content">
                    <h1><i class="fas fa-user-check me-2"></i>Pending Verifications</h1>
                    <p>Review and approve buyer applications ({{ count($pendingUsers) }} pending)</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid px-3 px-md-4">
            @if(count($pendingUsers) > 0)
                <div class="verifications-grid">
                    @forelse($pendingUsers as $user)
                        <div class="user-card">
                            <div class="user-card-header">
                                <div style="display: flex; align-items: center;">
                                    <div class="user-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <h5 class="user-card-title">{{ $user->name }}</h5>
                                </div>
                                <span class="status-badge">
                                    <i class="fas fa-hourglass-half"></i>Pending
                                </span>
                            </div>

                            <div class="user-card-body">
                                <!-- Email -->
                                <div class="info-group">
                                    <label class="info-label">
                                        <i class="fas fa-envelope"></i>Email Address
                                    </label>
                                    <p class="info-value">{{ $user->email }}</p>
                                </div>

                                <!-- Organization Name -->
                                @if($user->business_name)
                                    <div class="info-group">
                                        <label class="info-label">
                                            <i class="fas fa-building"></i>Organization Name
                                        </label>
                                        <p class="info-value">{{ $user->business_name }}</p>
                                    </div>
                                @endif

                                <!-- Phone -->
                                @if($user->phone)
                                    <div class="info-group">
                                        <label class="info-label">
                                            <i class="fas fa-phone"></i>Phone Number
                                        </label>
                                        <p class="info-value">{{ $user->phone }}</p>
                                    </div>
                                @endif

                                <!-- Registration Date -->
                                <div class="info-group">
                                    <label class="info-label">
                                        <i class="fas fa-calendar"></i>Applied On
                                    </label>
                                    <p class="info-value">{{ $user->created_at->format('M d, Y') }}</p>
                                    <p class="info-meta">{{ $user->created_at->diffForHumans() }}</p>
                                </div>

                                <div class="info-divider"></div>

                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    <form method="POST" action="{{ route('admin.verify-user', $user) }}" style="flex: 1;">
                                        @csrf
                                        <button type="submit" class="action-btn btn-approve">
                                            <i class="fas fa-check"></i>Approve
                                        </button>
                                    </form>
                                    <button type="button" class="action-btn btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $user->id }}">
                                        <i class="fas fa-times"></i>Reject
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1" aria-labelledby="rejectLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectLabel{{ $user->id }}">
                                            <div class="modal-icon">
                                                <i class="fas fa-ban"></i>
                                            </div>
                                            Reject Application
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.reject-user', $user) }}">
                                        @csrf
                                        <div class="modal-body">
                                            <label for="reason{{ $user->id }}" class="form-label">
                                                <i class="fas fa-comment"></i>Rejection Reason
                                            </label>
                                            <textarea class="form-control" id="reason{{ $user->id }}" name="reason" rows="4" required placeholder="Provide a clear reason for rejection..."></textarea>
                                            <small class="form-helper">
                                                <i class="fas fa-info-circle"></i>The applicant will receive this reason via email
                                            </small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-2"></i>Cancel
                                            </button>
                                            <button type="submit" class="btn-confirm">
                                                <i class="fas fa-check me-2"></i>Confirm Rejection
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($pendingUsers->count() > 0)
                    <div class="pagination-wrapper">
                        {{ $pendingUsers->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h5 class="empty-title">No Pending Verifications</h5>
                    <p class="empty-message">All buyer applications have been reviewed and processed.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

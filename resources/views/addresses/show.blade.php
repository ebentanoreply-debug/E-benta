@extends(auth()->check() && auth()->user()->isSeller() ? 'layouts.seller' : 'layouts.buyer')

@section('title', $address->label . ' - Address Details')

@section('content')
<style>
    .address-show-page {
        background-color: #f8fafc;
        min-height: calc(100vh - 60px);
        padding-bottom: 4rem;
    }

    .address-show-hero {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 1.25rem;
        color: #ffffff;
        padding: 2rem 2.25rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(13, 148, 136, 0.15);
        margin-bottom: 1.75rem;
    }

    .address-show-hero::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 380px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.03) 60%, transparent 80%);
        pointer-events: none;
    }

    .address-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #0d9488;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
        border-radius: 0.65rem;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-bottom: 1.25rem;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }

    .address-back-btn:hover {
        background: #f0fdfa;
        color: #0f766e;
        border-color: #99f6e4;
        transform: translateX(-2px);
    }

    .details-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.15rem;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        margin-bottom: 1.5rem;
    }

    .section-divider-title {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 1.25rem;
    }

    .section-divider-title .icon-wrap {
        width: 34px;
        height: 34px;
        border-radius: 0.6rem;
        background: #f0fdfa;
        color: #0d9488;
        border: 1px solid #ccfbf1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .section-divider-title h4 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-box {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 0.75rem;
        padding: 0.9rem 1.1rem;
    }

    .info-box-label {
        font-size: 0.75rem;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-box-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .address-highlight-box {
        background: #f0fdfa;
        border: 1.5px solid #ccfbf1;
        border-left: 4px solid #0d9488;
        border-radius: 0.85rem;
        padding: 1.25rem 1.4rem;
        margin-bottom: 1.5rem;
    }

    .address-main-text {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.25rem;
    }

    .address-sub-text {
        font-size: 0.92rem;
        color: #475569;
        margin: 0;
    }

    .instructions-box {
        background: #fffbeb;
        border: 1px solid #fef3c7;
        border-left: 4px solid #f59e0b;
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        color: #92400e;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1.5rem;
    }

    .action-row {
        display: flex;
        gap: 0.85rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .btn-edit-link {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        color: #ffffff;
        padding: 0.7rem 1.4rem;
        border-radius: 0.65rem;
        font-weight: 800;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
    }

    .btn-edit-link:hover {
        background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-primary-set {
        background: #f59e0b;
        color: #ffffff;
        border: none;
        padding: 0.7rem 1.4rem;
        border-radius: 0.65rem;
        font-weight: 800;
        font-size: 0.9rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
    }

    .btn-primary-set:hover {
        background: #d97706;
        transform: translateY(-1px);
    }

    .badge-primary-active {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        padding: 0.7rem 1.2rem;
        border-radius: 0.65rem;
        font-weight: 800;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .danger-zone-card {
        background: #ffffff;
        border: 1px solid #fecaca;
        border-left: 4px solid #ef4444;
        border-radius: 1.15rem;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.05);
    }

    .btn-delete-address {
        background: #ef4444;
        color: #ffffff;
        border: none;
        border-radius: 0.65rem;
        padding: 0.65rem 1.25rem;
        font-weight: 800;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-delete-address:hover {
        background: #dc2626;
        color: #ffffff;
        transform: translateY(-1px);
    }
</style>

<div class="address-show-page py-4">
    <div class="container-fluid px-3 px-lg-4" style="max-width: 950px;">
        
        <!-- Back Navigation -->
        <div>
            <a href="{{ route('addresses.index') }}" class="address-back-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Saved Addresses</span>
            </a>
        </div>

        <!-- Hero Header -->
        <div class="address-show-hero">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative" style="z-index: 1;">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                            <i class="fas fa-location-dot me-1"></i>{{ ucfirst($address->type) }}
                        </span>
                        @if($address->is_primary)
                            <span class="badge" style="background: #f59e0b; color: #ffffff; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                <i class="fas fa-star me-1"></i>Primary Address
                            </span>
                        @endif
                    </div>
                    <h1 style="font-size: clamp(1.6rem, 2.3vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px; color: #ffffff;">
                        {{ $address->label }}
                    </h1>
                    <p style="color: #ccfbf1; font-size: 0.95rem; margin: 0.4rem 0 0;">
                        Saved location details for logistics and transactions.
                    </p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('addresses.edit', $address) }}" class="btn d-inline-flex align-items-center gap-2" style="background: #ffffff; color: #0d9488; border: none; border-radius: 0.65rem; font-weight: 800; padding: 0.6rem 1.25rem; box-shadow: 0 4px 14px rgba(0,0,0,0.1); transition: all 0.2s ease;">
                        <i class="fas fa-edit"></i>
                        <span>Edit Address</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="details-card">
            <!-- Section: Street Address -->
            <div class="section-divider-title">
                <div class="icon-wrap">
                    <i class="fas fa-map-location-dot"></i>
                </div>
                <h4>Full Street Address</h4>
            </div>

            <div class="address-highlight-box">
                <div class="address-main-text">{{ $address->address_line_1 }}</div>
                @if($address->address_line_2)
                    <div class="address-sub-text">{{ $address->address_line_2 }}</div>
                @endif
                <div class="mt-2 text-muted small">
                    <i class="fas fa-city me-1"></i>{{ $address->city }}@if($address->state), {{ $address->state }}@endif, {{ $address->postal_code }} • {{ $address->country }}
                </div>
            </div>

            <!-- Section: Breakdown Grid -->
            <div class="section-divider-title">
                <div class="icon-wrap">
                    <i class="fas fa-globe"></i>
                </div>
                <h4>Location Specifics</h4>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <div class="info-box-label">City / Municipality</div>
                    <p class="info-box-value">{{ $address->city }}</p>
                </div>
                <div class="info-box">
                    <div class="info-box-label">State / Province</div>
                    <p class="info-box-value">{{ $address->state ?? 'N/A' }}</p>
                </div>
                <div class="info-box">
                    <div class="info-box-label">Postal / Zip Code</div>
                    <p class="info-box-value">{{ $address->postal_code }}</p>
                </div>
                <div class="info-box">
                    <div class="info-box-label">Country</div>
                    <p class="info-box-value">{{ $address->country }}</p>
                </div>
            </div>

            @if($address->special_instructions)
                <div class="section-divider-title">
                    <div class="icon-wrap">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4>Delivery / Courier Notes</h4>
                </div>

                <div class="instructions-box">
                    <strong><i class="fas fa-info-circle me-1"></i>Special Instructions:</strong>
                    <div class="mt-1" style="white-space: pre-wrap;">{{ $address->special_instructions }}</div>
                </div>
            @endif

            <div class="action-row mt-4">
                <a href="{{ route('addresses.edit', $address) }}" class="btn-edit-link">
                    <i class="fas fa-pen-to-square"></i>
                    <span>Edit Location Details</span>
                </a>

                @if(!$address->is_primary)
                    <form method="POST" action="{{ route('addresses.mark-primary', $address) }}">
                        @csrf
                        <button type="submit" class="btn-primary-set">
                            <i class="fas fa-star"></i>
                            <span>Make This Primary</span>
                        </button>
                    </form>
                @else
                    <div class="badge-primary-active">
                        <i class="fas fa-circle-check"></i>
                        <span>Default Primary Address</span>
                    </div>
                @endif
            </div>

            <div class="pt-3 border-top text-muted small d-flex justify-content-between flex-wrap gap-2">
                <span><i class="fas fa-clock me-1"></i>Saved {{ $address->created_at->format('M d, Y h:i A') }}</span>
                @if($address->updated_at != $address->created_at)
                    <span><i class="fas fa-rotate me-1"></i>Updated {{ $address->updated_at->format('M d, Y h:i A') }}</span>
                @endif
            </div>
        </div>

        <!-- Danger Zone Card -->
        <div class="danger-zone-card">
            <h5 style="color: #b91c1c; font-weight: 800; font-size: 1rem; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-trash-alt"></i>
                <span>Delete Address</span>
            </h5>
            <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 1.15rem; line-height: 1.45;">
                Permanently delete this location from your account. Active orders that already reference this address will not be affected.
            </p>
            <form method="POST" action="{{ route('addresses.destroy', $address) }}" onsubmit="return confirm('Are you sure you want to delete this address? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-address">
                    <i class="fas fa-trash-can"></i>
                    <span>Delete This Address</span>
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

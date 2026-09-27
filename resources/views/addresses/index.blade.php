@extends(auth()->check() && auth()->user()->isSeller() ? 'layouts.seller' : 'layouts.buyer')

@section('title', 'My Addresses - Buyer Hub - E-Benta')

@section('styles')
<style>
    .addresses-page-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    /* === HERO HEADER === */
    .addresses-hero-header {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 1.25rem;
        color: #ffffff;
        padding: 2.25rem 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(13, 148, 136, 0.15);
    }

    .addresses-hero-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 450px;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(13, 148, 136, 0.25) 0%, rgba(6, 182, 212, 0.12) 50%, transparent 70%);
        pointer-events: none;
    }

    /* === ADDRESS CARDS === */
    .address-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 1.15rem;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .address-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(13, 148, 136, 0.12);
        border-color: rgba(13, 148, 136, 0.35);
    }

    .address-card.is-primary-card {
        border-color: rgba(245, 158, 11, 0.4);
    }

    .address-card.is-primary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }

    .address-card-header {
        padding: 1.35rem 1.35rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .address-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .address-card-icon.primary {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
    }

    .address-card-icon.default {
        background: rgba(13, 148, 136, 0.1);
        color: #0d9488;
    }

    .address-card-body {
        padding: 0 1.35rem 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .address-label {
        font-weight: 800;
        font-size: 1.1rem;
        color: #0f172a;
        margin: 0;
        line-height: 1.3;
    }

    .address-text {
        color: #475569;
        font-size: 0.9rem;
        line-height: 1.5;
        margin: 0.65rem 0 1rem;
    }

    .address-note {
        background: rgba(245, 158, 11, 0.08);
        border: 1px solid rgba(245, 158, 11, 0.25);
        border-radius: 0.65rem;
        padding: 0.6rem 0.85rem;
        color: #92400e;
        font-size: 0.82rem;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .address-meta-grid {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        margin-top: auto;
        margin-bottom: 1rem;
    }

    .address-meta-grid small {
        display: block;
        color: #94a3b8;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.15rem;
    }

    .address-meta-grid span {
        display: block;
        color: #1e293b;
        font-size: 0.85rem;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .address-card-footer {
        padding: 0.9rem 1.35rem 1.25rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-action {
        border-radius: 0.55rem;
        font-weight: 700;
        font-size: 0.82rem;
        padding: 0.45rem 0.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .btn-action-view {
        background: rgba(13, 148, 136, 0.1);
        color: #0d9488;
        border-color: rgba(13, 148, 136, 0.2);
    }
    .btn-action-view:hover {
        background: #0d9488;
        color: #ffffff;
    }

    .btn-action-edit {
        background: #f8fafc;
        color: #475569;
        border-color: #e2e8f0;
    }
    .btn-action-edit:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .btn-action-primary {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border-color: rgba(245, 158, 11, 0.25);
    }
    .btn-action-primary:hover {
        background: #f59e0b;
        color: #ffffff;
    }

    .btn-action-delete {
        background: rgba(239, 68, 68, 0.08);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.2);
    }
    .btn-action-delete:hover {
        background: #ef4444;
        color: #ffffff;
    }

    .badge-primary-pill {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
        font-weight: 800;
        font-size: 0.72rem;
        padding: 0.3rem 0.65rem;
        border-radius: 2rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-type-pill {
        font-weight: 800;
        font-size: 0.72rem;
        padding: 0.3rem 0.65rem;
        border-radius: 2rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
</style>
@endsection

@section('content')

<div class="addresses-page-wrapper py-4">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row g-4">
            
            @if(auth()->check() && !auth()->user()->isAdmin() && !auth()->user()->isSeller())
                <!-- LEFT COLUMN: INTEGRATED BUYER ACCOUNT NAVIGATION -->
                <aside class="col-lg-3 col-xl-3">
                    @include('buyer.sidebar')
                </aside>

                <!-- RIGHT COLUMN: MAIN ADDRESS CONTENT -->
                <main class="col-lg-9 col-xl-9">
            @else
                <!-- FULL WIDTH MAIN FOR SELLER/ADMIN WORKSPACES -->
                <main class="col-12">
            @endif

                <!-- HERO HEADER -->
                <div class="addresses-hero-header mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative" style="z-index: 1;">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge" style="background: rgba(13, 148, 136, 0.2); color: #2dd4bf; border: 1px solid rgba(13, 148, 136, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                    <i class="fas fa-map-location-dot me-1"></i>Shipping & Pickups
                                </span>
                                <span style="color: #cbd5e1; font-size: 0.85rem;">• {{ $addresses->total() }} Saved {{ Str::plural('Location', $addresses->total()) }}</span>
                            </div>
                            <h1 style="font-size: clamp(1.6rem, 2.3vw, 2.1rem); font-weight: 900; margin: 0; letter-spacing: -0.5px; color: #ffffff;">
                                My Addresses
                            </h1>
                            <p style="color: #cbd5e1; font-size: 0.95rem; margin: 0.4rem 0 0;">
                                Manage pickup, dropoff, and delivery destinations for faster offers and transactions.
                            </p>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('addresses.create') }}" class="btn d-inline-flex align-items-center gap-2" style="background: #ffffff; color: #0d9488; border: none; border-radius: 0.65rem; font-weight: 800; padding: 0.6rem 1.25rem; box-shadow: 0 4px 14px rgba(0,0,0,0.1); transition: all 0.2s ease;">
                                <i class="fas fa-plus"></i>
                                <span>Add New Address</span>
                            </a>
                        </div>
                    </div>
                </div>

                @if($addresses->count() > 0)
                    <div class="row g-3 g-md-4">
                        @foreach($addresses as $address)
                            <div class="col-md-6 col-xxl-4">
                                <article class="address-card {{ $address->is_primary ? 'is-primary-card' : '' }}">
                                    <!-- Card Header -->
                                    <div class="address-card-header">
                                        <div class="d-flex align-items-center gap-2 overflow-hidden">
                                            <div class="address-card-icon {{ $address->is_primary ? 'primary' : 'default' }}">
                                                <i class="fas {{ $address->is_primary ? 'fa-star' : 'fa-location-dot' }}"></i>
                                            </div>
                                            <div class="overflow-hidden">
                                                <h3 class="address-label text-truncate" title="{{ $address->label }}">{{ $address->label }}</h3>
                                                <small style="color: #64748b; font-size: 0.78rem;">{{ $address->city }}, {{ $address->country }}</small>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-end gap-1 flex-shrink-0">
                                            @if($address->is_primary)
                                                <span class="badge-primary-pill">
                                                    <i class="fas fa-star"></i>Primary
                                                </span>
                                            @endif

                                            @if($address->type === 'pickup')
                                                <span class="badge-type-pill" style="background: rgba(13, 148, 136, 0.12); color: #0d9488; border: 1px solid rgba(13, 148, 136, 0.25);">
                                                    <i class="fas fa-box"></i>Pickup
                                                </span>
                                            @elseif($address->type === 'dropoff')
                                                <span class="badge-type-pill" style="background: rgba(59, 130, 246, 0.12); color: #2563eb; border: 1px solid rgba(59, 130, 246, 0.25);">
                                                    <i class="fas fa-truck-ramp-box"></i>Dropoff
                                                </span>
                                            @else
                                                <span class="badge-type-pill" style="background: rgba(147, 51, 234, 0.12); color: #9333ea; border: 1px solid rgba(147, 51, 234, 0.25);">
                                                    <i class="fas fa-arrows-split-up-and-left"></i>Both
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="address-card-body">
                                        <p class="address-text">
                                            <i class="fas fa-map-pin me-1 text-muted"></i>{{ $address->getFullAddress() }}
                                        </p>

                                        @if($address->special_instructions)
                                            <div class="address-note">
                                                <i class="fas fa-info-circle mt-1 flex-shrink-0" style="color: #d97706;"></i>
                                                <span>{{ $address->special_instructions }}</span>
                                            </div>
                                        @endif

                                        <div class="address-meta-grid">
                                            <div>
                                                <small>City</small>
                                                <span title="{{ $address->city }}">{{ $address->city }}</span>
                                            </div>
                                            <div>
                                                <small>Postal Code</small>
                                                <span>{{ $address->postal_code }}</span>
                                            </div>
                                            <div>
                                                <small>Country</small>
                                                <span title="{{ $address->country }}">{{ $address->country }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Footer Actions -->
                                    <div class="address-card-footer">
                                        <a href="{{ route('addresses.show', $address) }}" class="btn-action btn-action-view" title="View address details">
                                            <i class="fas fa-eye"></i>
                                            <span>View</span>
                                        </a>

                                        <a href="{{ route('addresses.edit', $address) }}" class="btn-action btn-action-edit" title="Edit address details">
                                            <i class="fas fa-pencil"></i>
                                            <span>Edit</span>
                                        </a>

                                        @if(!$address->is_primary)
                                            <form method="POST" action="{{ route('addresses.mark-primary', $address) }}" class="d-inline m-0">
                                                @csrf
                                                <button type="submit" class="btn-action btn-action-primary" title="Set as primary address">
                                                    <i class="fas fa-star"></i>
                                                    <span>Set Primary</span>
                                                </button>
                                            </form>
                                        @endif

                                        <div class="ms-auto">
                                            <form method="POST" action="{{ route('addresses.destroy', $address) }}" class="d-inline m-0" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-delete" title="Delete address">
                                                    <i class="fas fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    @if($addresses->hasPages())
                        <div class="mt-4 pt-3 border-top d-flex justify-content-center">
                            {{ $addresses->links() }}
                        </div>
                    @endif
                @else
                    <!-- EMPTY STATE -->
                    <div class="p-5 text-center bg-white rounded-4 border" style="border-color: rgba(13, 148, 136, 0.15) !important; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);">
                        <div style="width: 76px; height: 76px; border-radius: 50%; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: inline-flex; align-items: center; justify-content: center; font-size: 2.2rem; margin-bottom: 1.25rem;">
                            <i class="fas fa-map-location-dot"></i>
                        </div>
                        <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;">No Addresses Saved Yet</h4>
                        <p style="color: #64748b; font-size: 0.92rem; max-width: 440px; margin: 0 auto 1.75rem; line-height: 1.5;">
                            Save your pickup, delivery, or dropoff address to speed up device offers, orders, and logistics tracking.
                        </p>
                        <a href="{{ route('addresses.create') }}" class="btn d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); color: #ffffff; border: none; border-radius: 0.65rem; font-weight: 800; padding: 0.65rem 1.4rem; box-shadow: 0 4px 14px rgba(13, 148, 136, 0.25);">
                            <i class="fas fa-plus"></i>
                            <span>Add Your First Address</span>
                        </a>
                    </div>
                @endif

            </main>
        </div>
    </div>
</div>
@endsection

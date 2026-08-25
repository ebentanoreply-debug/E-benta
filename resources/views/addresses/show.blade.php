@extends('layouts.app')

@section('title', $address->label . ' - Address Details')

@section('content')
<style>
    .av-page {
        padding: 1.5rem 0 2.5rem;
    }

    .av-wrap {
        max-width: 900px;
        margin: 0 auto;
    }

    .av-back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: var(--light-green);
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .av-back-link:hover {
        color: #10b981;
    }

    .av-hero {
        background: linear-gradient(130deg, rgba(13, 148, 136, 0.18) 0%, rgba(6, 182, 212, 0.1) 55%, rgba(13, 148, 136, 0.04) 100%);
        border: 1px solid rgba(13, 148, 136, 0.24);
        border-left: 4px solid var(--light-green);
        border-radius: 1rem;
        padding: 1.55rem;
        margin-bottom: 1.15rem;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .av-hero-head {
        display: flex;
        align-items: center;
        gap: 0.95rem;
    }

    .av-hero-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--light-green);
        background: rgba(13, 148, 136, 0.22);
        border: 1px solid rgba(13, 148, 136, 0.35);
    }

    .av-hero h1 {
        margin: 0;
        color: var(--text-light);
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.35px;
    }

    .av-hero p {
        margin: 0.2rem 0 0;
        color: #93b9b2;
        font-weight: 500;
    }

    .av-badges {
        display: flex;
        gap: 0.45rem;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: flex-end;
    }

    .av-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        border-radius: 999px;
        padding: 0.32rem 0.76rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.45px;
        text-transform: uppercase;
    }

    .av-badge-primary {
        color: #f7d354;
        background: rgba(241, 196, 15, 0.18);
        border: 1px solid rgba(241, 196, 15, 0.35);
    }

    .av-badge-type {
        color: #93c5fd;
        background: rgba(52, 152, 219, 0.18);
        border: 1px solid rgba(52, 152, 219, 0.35);
    }

    .av-card {
        background: linear-gradient(135deg, rgba(15, 40, 24, 0.88) 0%, rgba(15, 40, 24, 0.55) 100%);
        border: 1px solid rgba(13, 148, 136, 0.22);
        border-radius: 1rem;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.14);
        padding: 1.25rem;
        margin-bottom: 1rem;
    }

    .av-section + .av-section {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(13, 148, 136, 0.12);
    }

    .av-heading {
        color: #8de0d7;
        margin: 0 0 0.58rem;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.55px;
        font-weight: 700;
    }

    .av-address-box {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-left: 3px solid var(--light-green);
        border-radius: 0.65rem;
        padding: 0.8rem 0.9rem;
    }

    .av-address-main {
        color: var(--text-light);
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
    }

    .av-address-sub {
        color: #9cbcc8;
        margin: 0.32rem 0 0;
        font-size: 0.9rem;
    }

    .av-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .av-mini {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 0.65rem;
        padding: 0.7rem;
    }

    .av-mini small {
        display: block;
        color: #99b6b0;
        text-transform: uppercase;
        letter-spacing: 0.45px;
        font-size: 0.68rem;
        margin-bottom: 0.18rem;
        font-weight: 700;
    }

    .av-mini p {
        margin: 0;
        color: var(--text-light);
        font-size: 0.9rem;
        font-weight: 600;
    }

    .av-note {
        background: rgba(243, 156, 18, 0.12);
        border: 1px solid rgba(243, 156, 18, 0.3);
        border-radius: 0.65rem;
        padding: 0.72rem 0.82rem;
        color: #f6c56f;
        font-size: 0.86rem;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .av-time {
        color: #8aa39d;
        margin: 0;
        font-size: 0.82rem;
    }

    .av-actions {
        display: flex;
        gap: 0.7rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .av-form-inline {
        flex: 1;
        min-width: 180px;
    }

    .av-btn {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        border: none;
        border-radius: 0.6rem;
        padding: 0.75rem 0.9rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease;
    }

    .av-btn:hover {
        transform: translateY(-1px);
    }

    .av-btn-edit {
        color: #ffffff;
        background: linear-gradient(135deg, #3498db 0%, #2563eb 100%);
    }

    .av-btn-primary {
        color: #073632;
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
    }

    .av-btn-current {
        color: #8de0d7;
        background: rgba(13, 148, 136, 0.2);
        border: 1px solid rgba(13, 148, 136, 0.35);
        cursor: default;
    }

    .av-danger {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.14) 0%, rgba(231, 76, 60, 0.08) 100%);
        border: 1px solid rgba(231, 76, 60, 0.34);
        border-radius: 1rem;
        padding: 1rem;
    }

    .av-danger h5 {
        margin: 0 0 0.4rem;
        color: #ef4444;
        font-weight: 800;
    }

    .av-danger p {
        margin: 0 0 0.7rem;
        color: #cbb5b5;
        font-size: 0.9rem;
    }

    .av-btn-delete {
        width: auto;
        color: #ffffff;
        background: #ef4444;
        padding: 0.65rem 1rem;
    }

    .av-btn-delete:hover {
        background: #dc2626;
        color: #ffffff;
    }

    @media (max-width: 767px) {
        .av-page {
            padding-top: 1rem;
        }

        .av-hero {
            padding: 1.3rem;
        }

        .av-hero h1 {
            font-size: 1.5rem;
        }

        .av-grid {
            grid-template-columns: 1fr;
        }

        .av-badges {
            justify-content: flex-start;
        }

        .av-actions {
            flex-direction: column;
        }

        .av-form-inline {
            min-width: 100%;
        }
    }
</style>

<div class="av-page">
    <div class="container">
        <div class="av-wrap">
            <a href="{{ route('addresses.index') }}" class="av-back-link">
                <i class="fas fa-arrow-left"></i>
                Back to Addresses
            </a>

            <div class="av-hero">
                <div class="av-hero-head">
                    <div class="av-hero-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h1>{{ $address->label }}</h1>
                        <p>Saved Address Details</p>
                    </div>
                </div>

                <div class="av-badges">
                    @if($address->is_primary)
                        <span class="av-badge av-badge-primary">
                            <i class="fas fa-star"></i>
                            Primary
                        </span>
                    @endif
                    <span class="av-badge av-badge-type">{{ ucfirst($address->type) }}</span>
                </div>
            </div>

            <div class="av-card">
                <section class="av-section">
                    <h6 class="av-heading"><i class="fas fa-road me-1"></i> Street Address</h6>
                    <div class="av-address-box">
                        <p class="av-address-main">{{ $address->address_line_1 }}</p>
                        @if($address->address_line_2)
                            <p class="av-address-sub">{{ $address->address_line_2 }}</p>
                        @endif
                    </div>
                </section>

                <section class="av-section">
                    <h6 class="av-heading"><i class="fas fa-map me-1"></i> Location Information</h6>
                    <div class="av-grid">
                        <div class="av-mini">
                            <small>City</small>
                            <p>{{ $address->city }}</p>
                        </div>
                        <div class="av-mini">
                            <small>State or Province</small>
                            <p>{{ $address->state ?? 'Not specified' }}</p>
                        </div>
                        <div class="av-mini">
                            <small>Postal Code</small>
                            <p>{{ $address->postal_code }}</p>
                        </div>
                        <div class="av-mini">
                            <small>Country</small>
                            <p>{{ $address->country }}</p>
                        </div>
                    </div>
                </section>

                @if($address->special_instructions)
                    <section class="av-section">
                        <h6 class="av-heading"><i class="fas fa-sticky-note me-1"></i> Special Instructions</h6>
                        <div class="av-note">{{ $address->special_instructions }}</div>
                    </section>
                @endif

                @if($address->latitude && $address->longitude)
                    <section class="av-section">
                        <h6 class="av-heading"><i class="fas fa-map-marker-alt me-1"></i> GPS Coordinates</h6>
                        <div class="av-grid">
                            <div class="av-mini">
                                <small>Latitude</small>
                                <p>{{ $address->latitude }}</p>
                            </div>
                            <div class="av-mini">
                                <small>Longitude</small>
                                <p>{{ $address->longitude }}</p>
                            </div>
                        </div>
                    </section>
                @endif

                <section class="av-section">
                    <p class="av-time">
                        <i class="fas fa-clock me-1"></i>
                        Created on {{ $address->created_at->format('M d, Y at g:i A') }}
                        @if($address->updated_at != $address->created_at)
                            | Last updated {{ $address->updated_at->format('M d, Y at g:i A') }}
                        @endif
                    </p>
                </section>
            </div>

            <div class="av-actions">
                <a href="{{ route('addresses.edit', $address) }}" class="av-btn av-btn-edit av-form-inline">
                    <i class="fas fa-edit"></i>
                    Edit Address
                </a>

                @if(!$address->is_primary)
                    <form method="POST" action="{{ route('addresses.mark-primary', $address) }}" class="av-form-inline">
                        @csrf
                        @method('POST')
                        <button type="submit" class="av-btn av-btn-primary">
                            <i class="fas fa-star"></i>
                            Set as Primary
                        </button>
                    </form>
                @else
                    <span class="av-btn av-btn-current av-form-inline">
                        <i class="fas fa-check-circle"></i>
                        Primary Address
                    </span>
                @endif
            </div>

            <div class="av-danger">
                <h5><i class="fas fa-trash-alt me-2"></i>Delete Address</h5>
                <p>Once deleted, this address cannot be recovered.</p>
                <form method="POST" action="{{ route('addresses.destroy', $address) }}" onsubmit="return confirm('Are you sure you want to delete this address? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="av-btn av-btn-delete">
                        <i class="fas fa-trash-alt"></i>
                        Delete Address
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

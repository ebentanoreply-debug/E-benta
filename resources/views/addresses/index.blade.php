@extends('layouts.app')

@section('title', 'My Addresses - E-Benta')

@section('content')
<style>
    .al-page {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(46, 204, 113, 0.05) 100%);
        min-height: 100vh;
        padding: 3rem 0;
    }

    .al-hero {
        text-align: center;
        margin-bottom: 3rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .al-hero-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        padding: 1rem;
        border-radius: 1rem;
        margin-bottom: 0.5rem;
        color: white;
        font-size: 2rem;
        width: 72px;
        height: 72px;
    }

    .al-hero h1 {
        color: var(--text-light);
        font-weight: 800;
        margin-bottom: 0.5rem;
        font-size: 2.2rem;
    }

    .al-hero p {
        color: #64748b;
        margin: 0 0 1.5rem 0;
        font-size: 1rem;
    }

    .al-add-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.85rem 1.5rem;
        border-radius: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 0.95rem;
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        color: white;
        box-shadow: 0 8px 18px rgba(13, 148, 136, 0.22);
    }

    .al-add-btn:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.3);
    }

    .al-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.5rem;
    }

    .al-card {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .al-card:hover {
        transform: translateY(-5px);
        border-color: rgba(13, 148, 136, 0.35);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }

    .al-card-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .al-card h3 {
        margin: 0;
        color: var(--text-light);
        font-size: 1.25rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .al-card h3 i {
        color: var(--light-green);
        font-size: 1rem;
    }

    .al-address {
        margin: 0.5rem 0 0;
        color: #475569;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .al-badges {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        align-items: flex-end;
    }

    .al-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        border-radius: 999px;
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .al-badge-primary {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .al-badge-type {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .al-note {
        background: rgba(245, 158, 11, 0.08);
        border: 1px solid rgba(245, 158, 11, 0.2);
        border-radius: 0.8rem;
        padding: 0.85rem 1rem;
        color: #b45309;
        font-size: 0.85rem;
        margin-bottom: 1.25rem;
        display: flex;
        gap: 0.5rem;
    }

    .al-meta {
        background: rgba(13, 148, 136, 0.04);
        border: 1.5px solid rgba(13, 148, 136, 0.15);
        border-radius: 0.8rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: auto;
    }

    .al-meta small {
        display: block;
        color: var(--light-green);
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
        font-weight: 800;
    }

    .al-meta p {
        margin: 0;
        color: var(--text-light);
        font-size: 0.95rem;
        font-weight: 700;
    }

    .al-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .al-form-inline {
        flex: 1;
        min-width: 140px;
    }

    .al-btn {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        border: none;
        border-radius: 0.6rem;
        padding: 0.65rem 0.85rem;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        transition: transform 0.2s ease;
    }

    .al-btn:hover {
        transform: translateY(-1px);
    }

    .al-btn-edit {
        color: #ffffff;
        background: linear-gradient(135deg, #3498db 0%, #2563eb 100%);
    }

    .al-btn-primary {
        transition: all 0.2s ease;
    }

    .al-btn:hover {
        transform: translateY(-2px);
    }

    .al-btn-view {
        color: #ffffff;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .al-btn-edit {
        color: #ffffff;
        background: linear-gradient(135deg, #f59e0b 0%, #e67e22 100%);
    }

    .al-btn-delete {
        color: #ffffff;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .al-btn-current {
        color: var(--light-green);
        background: rgba(13, 148, 136, 0.05);
        border: 1.5px solid rgba(13, 148, 136, 0.25);
        cursor: default;
    }

    .al-btn-current:hover {
        transform: none;
    }

    .al-empty {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(10px);
        border: 2px dashed rgba(13, 148, 136, 0.3);
        border-radius: 1.2rem;
        padding: 4rem 2rem;
        text-align: center;
        color: var(--text-light);
    }

    .al-empty i {
        display: block;
        font-size: 3rem;
        color: var(--light-green);
        opacity: 0.8;
        margin-bottom: 1rem;
    }

    .al-empty h4 {
        margin: 0;
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--text-light);
    }

    .al-empty p {
        margin: 0.5rem 0 1.5rem;
        color: #64748b;
    }

    .al-pagination {
        margin-top: 2rem;
    }

    @media (max-width: 991px) {
        .al-page {
            padding: 2rem 0;
        }
    }

    @media (max-width: 767px) {
        .al-hero h1 {
            font-size: 1.75rem;
        }

        .al-meta {
            grid-template-columns: 1fr;
        }

        .al-card-head {
            flex-direction: column;
        }

        .al-badges {
            justify-content: flex-start;
        }

        .al-actions {
            flex-direction: column;
        }

        .al-form-inline {
            min-width: 100%;
        }
    }
</style>

@if(auth()->check() && auth()->user()->isAdmin())
    @include('admin.sidebar')
@elseif(auth()->check() && auth()->user()->isSeller())
    @include('seller.sidebar')
@elseif(auth()->check())
    @include('buyer.sidebar')
@endif

<div class="main-content-wrapper">
    <div class="al-page">
        <div class="container">
        <div class="al-hero">
            <div class="al-hero-icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <h1>My Addresses</h1>
            <p>Manage pickup and dropoff locations for faster transactions.</p>
            <a href="{{ route('addresses.create') }}" class="al-add-btn">
                <i class="fas fa-plus"></i>
                Add New Address
            </a>
        </div>

        @if($addresses->count() > 0)
            <div class="al-grid">
                @foreach($addresses as $address)
                    <article class="al-card">
                        <div class="al-card-head">
                            <div>
                                <h3><i class="fas fa-tag"></i>{{ $address->label }}</h3>
                                <p class="al-address">{{ $address->getFullAddress() }}</p>
                            </div>

                            <div class="al-badges">
                                @if($address->is_primary)
                                    <span class="al-badge al-badge-primary">
                                        <i class="fas fa-star"></i>
                                        Primary
                                    </span>
                                @endif
                                <span class="al-badge al-badge-type">{{ ucfirst($address->type) }}</span>
                            </div>
                        </div>

                        @if($address->special_instructions)
                            <div class="al-note">
                                <i class="fas fa-sticky-note me-1"></i>
                                {{ $address->special_instructions }}
                            </div>
                        @endif

                        <div class="al-meta">
                            <div>
                                <small>City</small>
                                <p>{{ $address->city }}</p>
                            </div>
                            <div>
                                <small>Postal Code</small>
                                <p>{{ $address->postal_code }}</p>
                            </div>
                            <div>
                                <small>Country</small>
                                <p>{{ $address->country }}</p>
                            </div>
                        </div>

                        <div class="al-actions">
                            <a href="{{ route('addresses.show', $address) }}" class="al-btn al-btn-edit al-form-inline">
                                <i class="fas fa-eye"></i>
                                View
                            </a>

                            <a href="{{ route('addresses.edit', $address) }}" class="al-btn al-btn-edit al-form-inline">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>

                            @if(!$address->is_primary)
                                <form method="POST" action="{{ route('addresses.mark-primary', $address) }}" class="al-form-inline">
                                    @csrf
                                    <button type="submit" class="al-btn al-btn-primary">
                                        <i class="fas fa-star"></i>
                                        Set Primary
                                    </button>
                                </form>
                            @else
                                <span class="al-btn al-btn-current al-form-inline">
                                    <i class="fas fa-check-circle"></i>
                                    Primary Address
                                </span>
                            @endif

                            <form method="POST" action="{{ route('addresses.destroy', $address) }}" class="al-form-inline" onsubmit="return confirm('Delete this address?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="al-btn al-btn-delete">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($addresses->hasPages())
                <div class="al-pagination">
                    {{ $addresses->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="al-empty">
                <i class="fas fa-map-marker-alt"></i>
                <h4>No addresses saved yet</h4>
                <p>Add your first address to speed up future offers and transactions.</p>
                <a href="{{ route('addresses.create') }}" class="al-add-btn">
                    <i class="fas fa-plus"></i>
                    Add Your First Address
                </a>
            </div>
        @endif
    </div>
</div>
</div>
@endsection

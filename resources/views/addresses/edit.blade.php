@extends('layouts.app')

@section('title', 'Edit Address - E-Benta')

@section('content')
<style>
    .ae-page {
        padding: 1.5rem 0 2.5rem;
    }

    .ae-back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: #60a5fa;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .ae-back-link:hover {
        color: #93c5fd;
    }

    .ae-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(130deg, rgba(52, 152, 219, 0.18) 0%, rgba(14, 165, 233, 0.12) 48%, rgba(52, 152, 219, 0.05) 100%);
        border: 1px solid rgba(52, 152, 219, 0.25);
        border-left: 4px solid #3498db;
        border-radius: 1rem;
        padding: 1.8rem;
        margin-bottom: 1.5rem;
    }

    .ae-hero::after {
        content: '';
        position: absolute;
        right: -35px;
        top: -35px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: radial-gradient(circle at center, rgba(52, 152, 219, 0.25) 0%, rgba(52, 152, 219, 0) 70%);
        pointer-events: none;
    }

    .ae-hero-head {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .ae-hero-icon {
        width: 52px;
        height: 52px;
        border-radius: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        color: #93c5fd;
        background: rgba(52, 152, 219, 0.25);
        border: 1px solid rgba(52, 152, 219, 0.35);
    }

    .ae-hero h1 {
        margin: 0;
        color: var(--text-light);
        font-size: 1.95rem;
        font-weight: 800;
        letter-spacing: -0.4px;
    }

    .ae-hero p {
        margin: 0.2rem 0 0;
        color: #9cbcc8;
        font-weight: 500;
    }

    .ae-side-card,
    .ae-form-card,
    .ae-danger-card {
        background: linear-gradient(135deg, rgba(15, 40, 24, 0.88) 0%, rgba(15, 40, 24, 0.56) 100%);
        border-radius: 1rem;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.14);
    }

    .ae-side-card,
    .ae-form-card {
        border: 1px solid rgba(52, 152, 219, 0.22);
    }

    .ae-side-card {
        padding: 1.3rem;
        height: 100%;
    }

    .ae-side-card h5 {
        color: var(--text-light);
        font-weight: 800;
        margin-bottom: 0.9rem;
    }

    .ae-tip {
        background: rgba(52, 152, 219, 0.12);
        border: 1px solid rgba(52, 152, 219, 0.24);
        border-radius: 0.7rem;
        padding: 0.8rem 0.9rem;
        margin-bottom: 0.75rem;
    }

    .ae-tip strong {
        display: block;
        color: #dceffd;
        margin-bottom: 0.15rem;
        font-size: 0.9rem;
    }

    .ae-tip span {
        color: #a4c2ce;
        font-size: 0.82rem;
        line-height: 1.45;
    }

    .ae-form-card {
        padding: 1.45rem;
    }

    .ae-section {
        margin-bottom: 1.35rem;
    }

    .ae-section-head {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 0.8rem;
    }

    .ae-section-head i {
        color: #60a5fa;
    }

    .ae-section-head h4 {
        margin: 0;
        color: var(--text-light);
        font-size: 1rem;
        font-weight: 800;
    }

    .ae-field-group {
        margin-bottom: 1rem;
    }

    .ae-label {
        display: block;
        margin-bottom: 0.45rem;
        color: #d9ebe8;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .ae-control {
        width: 100%;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(52, 152, 219, 0.26);
        color: var(--text-light);
        border-radius: 0.65rem;
        padding: 0.72rem 0.95rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .ae-control:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.14);
        border-color: rgba(96, 165, 250, 0.45);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.14);
        color: var(--text-light);
    }

    .ae-control::placeholder {
        color: #7f9e9a;
    }

    .ae-control option {
        color: #0f172a;
    }

    .ae-error {
        display: block;
        margin-top: 0.4rem;
        color: #ef4444;
        font-size: 0.82rem;
        font-weight: 600;
    }

    .ae-primary-box {
        background: rgba(52, 152, 219, 0.1);
        border: 1px solid rgba(52, 152, 219, 0.25);
        border-left: 3px solid #3498db;
        border-radius: 0.7rem;
        padding: 0.85rem 0.95rem;
    }

    .ae-primary-label {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        color: var(--text-light);
        font-weight: 700;
        margin: 0;
        cursor: pointer;
    }

    .ae-primary-label input[type='checkbox'] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #3498db;
    }

    .ae-primary-hint {
        display: block;
        color: #9cbcc8;
        margin-top: 0.45rem;
        font-size: 0.82rem;
    }

    .ae-note-primary {
        margin-top: 0.8rem;
        background: rgba(241, 196, 15, 0.14);
        border: 1px solid rgba(241, 196, 15, 0.38);
        border-radius: 0.65rem;
        padding: 0.72rem 0.85rem;
        color: #f4d03f;
        font-size: 0.83rem;
        font-weight: 600;
    }

    .ae-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.9rem;
        margin-top: 1.5rem;
    }

    .ae-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.85rem 1.2rem;
        border-radius: 0.65rem;
        border: 1px solid transparent;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .ae-btn-secondary {
        background: rgba(255, 255, 255, 0.08);
        color: var(--text-light);
        border-color: rgba(52, 152, 219, 0.3);
    }

    .ae-btn-secondary:hover {
        color: #ffffff;
        background: rgba(52, 152, 219, 0.14);
        border-color: rgba(52, 152, 219, 0.45);
    }

    .ae-btn-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: #ffffff;
        border: none;
    }

    .ae-btn-primary:hover {
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(52, 152, 219, 0.28);
    }

    .ae-danger-card {
        margin-top: 1rem;
        border: 1px solid rgba(231, 76, 60, 0.35);
        padding: 1.2rem;
    }

    .ae-danger-card h5 {
        margin: 0 0 0.45rem;
        color: #ef4444;
        font-weight: 800;
    }

    .ae-danger-card p {
        margin: 0 0 0.9rem;
        color: #cbb5b5;
        font-size: 0.9rem;
    }

    .ae-btn-danger {
        background: #e74c3c;
        color: #ffffff;
        border: none;
    }

    .ae-btn-danger:hover {
        color: #ffffff;
        background: #dc2626;
    }

    @media (max-width: 991px) {
        .ae-page {
            padding-top: 1rem;
        }

        .ae-side-card {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 767px) {
        .ae-hero {
            padding: 1.35rem;
        }

        .ae-hero h1 {
            font-size: 1.45rem;
        }

        .ae-hero-head {
            align-items: flex-start;
        }

        .ae-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="ae-page">
    <div class="container">
        <a href="{{ route('addresses.index') }}" class="ae-back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Addresses
        </a>

        <div class="ae-hero">
            <div class="ae-hero-head">
                <div class="ae-hero-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h1>Edit Address</h1>
                    <p>Update this location details and keep your logistics accurate.</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <aside class="ae-side-card">
                    <h5><i class="fas fa-compass me-2" style="color: #60a5fa;"></i>Quick Notes</h5>

                    <div class="ae-tip">
                        <strong>Keep Labels Clear</strong>
                        <span>Use names like Home Pickup, Warehouse Dropoff, or Office.</span>
                    </div>

                    <div class="ae-tip">
                        <strong>Update Access Notes</strong>
                        <span>Add gate codes, landmark details, or floor numbers.</span>
                    </div>

                    <div class="ae-tip">
                        <strong>Primary Address</strong>
                        <span>Primary location is used as default in forms and transactions.</span>
                    </div>
                </aside>
            </div>

            <div class="col-lg-8">
                <div class="ae-form-card">
                    <form method="POST" action="{{ route('addresses.update', $address) }}">
                        @csrf
                        @method('PUT')

                        <section class="ae-section">
                            <div class="ae-section-head">
                                <i class="fas fa-id-card"></i>
                                <h4>Address Identity</h4>
                            </div>

                            <div class="ae-field-group">
                                <label class="ae-label" for="label">Address Label *</label>
                                <input id="label" class="ae-control" type="text" name="label" value="{{ old('label', $address->label) }}" placeholder="Home, Office, Warehouse" required>
                                @error('label')
                                    <small class="ae-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="ae-field-group mb-0">
                                <label class="ae-label" for="type">Address Type *</label>
                                <select id="type" class="ae-control" name="type" required>
                                    <option value="both" {{ old('type', $address->type) == 'both' ? 'selected' : '' }}>Both (Pickup and Dropoff)</option>
                                    <option value="pickup" {{ old('type', $address->type) == 'pickup' ? 'selected' : '' }}>Pickup Only</option>
                                    <option value="dropoff" {{ old('type', $address->type) == 'dropoff' ? 'selected' : '' }}>Dropoff Only</option>
                                </select>
                                @error('type')
                                    <small class="ae-error">{{ $message }}</small>
                                @enderror
                            </div>
                        </section>

                        <section class="ae-section">
                            <div class="ae-section-head">
                                <i class="fas fa-map-marker-alt"></i>
                                <h4>Location Details</h4>
                            </div>

                            <div class="ae-field-group">
                                <label class="ae-label" for="address_line_1">Street Address *</label>
                                <input id="address_line_1" class="ae-control" type="text" name="address_line_1" value="{{ old('address_line_1', $address->address_line_1) }}" placeholder="123 Main Street" required>
                                @error('address_line_1')
                                    <small class="ae-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="ae-field-group">
                                <label class="ae-label" for="address_line_2">Apartment or Suite</label>
                                <input id="address_line_2" class="ae-control" type="text" name="address_line_2" value="{{ old('address_line_2', $address->address_line_2) }}" placeholder="Unit, floor, building, landmark">
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="ae-field-group mb-md-0">
                                        <label class="ae-label" for="city">City *</label>
                                        <input id="city" class="ae-control" type="text" name="city" value="{{ old('city', $address->city) }}" placeholder="Manila" required>
                                        @error('city')
                                            <small class="ae-error">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ae-field-group mb-0">
                                        <label class="ae-label" for="state">State or Province</label>
                                        <input id="state" class="ae-control" type="text" name="state" value="{{ old('state', $address->state) }}" placeholder="NCR">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <div class="ae-field-group mb-md-0">
                                        <label class="ae-label" for="postal_code">Postal Code *</label>
                                        <input id="postal_code" class="ae-control" type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}" placeholder="1000" required>
                                        @error('postal_code')
                                            <small class="ae-error">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ae-field-group mb-0">
                                        <label class="ae-label" for="country">Country *</label>
                                        <input id="country" class="ae-control" type="text" name="country" value="{{ old('country', $address->country) }}" required>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="ae-section">
                            <div class="ae-section-head">
                                <i class="fas fa-sticky-note"></i>
                                <h4>Delivery Notes</h4>
                            </div>

                            <div class="ae-field-group mb-0">
                                <label class="ae-label" for="special_instructions">Special Instructions</label>
                                <textarea id="special_instructions" class="ae-control" name="special_instructions" rows="4" placeholder="Gate code, nearest landmark, building entrance notes">{{ old('special_instructions', $address->special_instructions) }}</textarea>
                                @error('special_instructions')
                                    <small class="ae-error">{{ $message }}</small>
                                @enderror
                            </div>
                        </section>

                        <div class="ae-primary-box">
                            <label class="ae-primary-label" for="is_primary">
                                <input id="is_primary" type="checkbox" name="is_primary" {{ old('is_primary', $address->is_primary) ? 'checked' : '' }}>
                                <i class="fas fa-star" style="color: #f1c40f;"></i>
                                Set as my primary address
                            </label>
                            <small class="ae-primary-hint">Primary address will be prefilled when creating offers and transactions.</small>

                            @if($address->is_primary)
                                <div class="ae-note-primary">
                                    <i class="fas fa-info-circle me-1"></i>
                                    This address is currently primary. If you uncheck it, set another address as primary.
                                </div>
                            @endif
                        </div>

                        <div class="ae-actions">
                            <a href="{{ route('addresses.index') }}" class="ae-btn ae-btn-secondary">Cancel</a>
                            <button type="submit" class="ae-btn ae-btn-primary">
                                <i class="fas fa-save"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <div class="ae-danger-card">
                    <h5><i class="fas fa-trash-alt me-2"></i>Delete Address</h5>
                    <p>This action cannot be undone and may affect existing references using this location.</p>
                    <form method="POST" action="{{ route('addresses.destroy', $address) }}" onsubmit="return confirm('Are you sure you want to delete this address?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ae-btn ae-btn-danger">
                            <i class="fas fa-trash-alt"></i>
                            Delete Address
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

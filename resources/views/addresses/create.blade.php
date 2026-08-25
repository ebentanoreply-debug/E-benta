@extends('layouts.app')

@section('title', 'Add New Address - E-Benta')

@section('content')
<style>
    .ac-page {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(46, 204, 113, 0.05) 100%);
        min-height: 100vh;
        padding: 3rem 0;
    }

    .ac-back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        color: var(--light-green);
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .ac-back-link:hover {
        color: #0f766e;
    }

    .ac-hero {
        text-align: center;
        margin-bottom: 3rem;
    }

    .ac-hero-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        padding: 1rem;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        color: white;
        font-size: 2rem;
        width: 72px;
        height: 72px;
    }

    .ac-hero h1 {
        color: var(--text-light);
        font-weight: 800;
        margin-bottom: 0.5rem;
        font-size: 2.2rem;
    }

    .ac-hero p {
        color: #64748b;
        margin: 0;
        font-size: 1rem;
    }

    .ac-side-card,
    .ac-form-card {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .ac-side-card {
        padding: 1.25rem 1.5rem;
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .ac-side-card h5 {
        color: var(--text-light);
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        font-size: 1.1rem;
    }

    .ac-tip {
        background: rgba(13, 148, 136, 0.05);
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 0.8rem;
        padding: 0.75rem 1rem;
        margin-bottom: 0.75rem;
    }

    .ac-tip strong {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        color: var(--primary-green);
        margin-bottom: 0.15rem;
        font-size: 0.9rem;
        font-weight: 700;
    }

    .ac-tip span {
        color: #475569;
        font-size: 0.8rem;
        line-height: 1.4;
    }

    .ac-form-card {
        padding: 3rem;
    }

    .ac-section-head {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .ac-section-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        border-radius: 0.8rem;
        color: white;
        font-weight: 700;
    }

    .ac-section-head h4 {
        margin: 0;
        color: var(--text-light);
        font-size: 1.15rem;
        font-weight: 700;
    }

    .ac-field-group {
        margin-bottom: 1.5rem;
    }

    .ac-label {
        display: block;
        color: var(--text-light);
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .ac-label i {
        color: var(--light-green);
        margin-right: 0.5rem;
        width: 16px;
        text-align: center;
    }

    .ac-control {
        width: 100%;
        background-color: rgba(13, 148, 136, 0.05);
        color: var(--text-light);
        border: 1.5px solid rgba(13, 148, 136, 0.3);
        padding: 0.85rem 1rem;
        border-radius: 0.8rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .ac-control:focus {
        outline: none;
        background-color: rgba(13, 148, 136, 0.08);
        border-color: rgba(13, 148, 136, 0.6);
        box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.15);
    }

    .ac-control::placeholder {
        color: #94a3b8;
    }

    .ac-error {
        display: block;
        margin-top: 0.5rem;
        color: #e74c3c;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .ac-primary-box {
        background: rgba(13, 148, 136, 0.05);
        border: 1.5px solid rgba(13, 148, 136, 0.2);
        border-left: 4px solid var(--light-green);
        border-radius: 0.8rem;
        padding: 1rem 1.2rem;
        margin-top: 0.5rem;
    }

    .ac-primary-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-light);
        font-weight: 700;
        margin: 0;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .ac-primary-label input[type='checkbox'] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #0d9488;
        border: 1.5px solid rgba(13, 148, 136, 0.4);
        border-radius: 4px;
    }

    .ac-primary-hint {
        display: block;
        color: #64748b;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        margin-left: 2rem;
    }

    .ac-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 2.5rem;
    }

    .ac-btn {
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
    }

    .ac-btn-secondary {
        background: white;
        color: var(--text-light);
        border: 1.5px solid rgba(13, 148, 136, 0.3);
    }

    .ac-btn-secondary:hover {
        background: rgba(13, 148, 136, 0.05);
        border-color: rgba(13, 148, 136, 0.5);
    }

    .ac-btn-primary {
        background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%);
        color: white;
        border: none;
    }

    .ac-btn-primary:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 148, 136, 0.3);
    }

    @media (max-width: 991px) {
        .ac-page {
            padding: 2rem 0;
        }

        .ac-side-card {
            margin-bottom: 2rem;
        }
        
        .ac-form-card {
            padding: 2rem;
        }
    }

    @media (max-width: 767px) {
        .ac-hero h1 {
            font-size: 1.75rem;
        }

        .ac-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="ac-page">
    <div class="container">
        <a href="{{ route('addresses.index') }}" class="ac-back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Addresses
        </a>

        <div class="ac-hero">
            <div class="ac-hero-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h1>Add New Address</h1>
            <p>Save a reliable location for pickups, dropoffs, or both.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <aside class="ac-side-card">
                    <h5><i class="fas fa-compass me-2" style="color: var(--light-green);"></i>Address Guide</h5>

                    <div class="ac-tip">
                        <strong>Pickup</strong>
                        <span>Use for locations where buyers can collect listed items.</span>
                    </div>

                    <div class="ac-tip">
                        <strong>Dropoff</strong>
                        <span>Use for places where e-waste can be brought for processing.</span>
                    </div>

                    <div class="ac-tip">
                        <strong>Primary Address</strong>
                        <span>Mark one location as default so forms fill faster.</span>
                    </div>
                </aside>
            </div>

            <div class="col-lg-8">
                <div class="ac-form-card">
                    <form method="POST" action="{{ route('addresses.store') }}">
                        @csrf

                        <section class="ac-section">
                            <div class="ac-section-head">
                                <span class="ac-section-number">1</span>
                                <h4>Address Identity</h4>
                            </div>

                            <div class="ac-field-group">
                                <label class="ac-label" for="label"><i class="fas fa-tag"></i>Address Label *</label>
                                <input id="label" class="ac-control" type="text" name="label" value="{{ old('label') }}" placeholder="Home, Office, Warehouse" required>
                                @error('label')
                                    <small class="ac-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="ac-field-group mb-0">
                                <label class="ac-label" for="type"><i class="fas fa-building"></i>Address Type *</label>
                                <select id="type" class="ac-control" name="type" required>
                                    <option value="both" {{ old('type') == 'both' ? 'selected' : '' }}>Both (Pickup and Dropoff)</option>
                                    <option value="pickup" {{ old('type') == 'pickup' ? 'selected' : '' }}>Pickup Only</option>
                                    <option value="dropoff" {{ old('type') == 'dropoff' ? 'selected' : '' }}>Dropoff Only</option>
                                </select>
                                @error('type')
                                    <small class="ac-error">{{ $message }}</small>
                                @enderror
                            </div>
                        </section>

                        <section class="ac-section" style="margin-top: 2.5rem;">
                            <div class="ac-section-head">
                                <span class="ac-section-number">2</span>
                                <h4>Location Details</h4>
                            </div>

                            <div class="ac-field-group">
                                <label class="ac-label" for="address_line_1"><i class="fas fa-map-marker-alt"></i>Street Address *</label>
                                <input id="address_line_1" class="ac-control" type="text" name="address_line_1" value="{{ old('address_line_1') }}" placeholder="123 Main Street" required>
                                @error('address_line_1')
                                    <small class="ac-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="ac-field-group">
                                <label class="ac-label" for="address_line_2"><i class="fas fa-door-open"></i>Apartment or Suite</label>
                                <input id="address_line_2" class="ac-control" type="text" name="address_line_2" value="{{ old('address_line_2') }}" placeholder="Unit, floor, building, landmark">
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="ac-field-group mb-md-0">
                                        <label class="ac-label" for="city"><i class="fas fa-city"></i>City *</label>
                                        <input id="city" class="ac-control" type="text" name="city" value="{{ old('city') }}" placeholder="Manila" required>
                                        @error('city')
                                            <small class="ac-error">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ac-field-group mb-0">
                                        <label class="ac-label" for="state"><i class="fas fa-map"></i>State or Province</label>
                                        <input id="state" class="ac-control" type="text" name="state" value="{{ old('state') }}" placeholder="NCR">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <div class="ac-field-group mb-md-0">
                                        <label class="ac-label" for="postal_code"><i class="fas fa-mail-bulk"></i>Postal Code *</label>
                                        <input id="postal_code" class="ac-control" type="text" name="postal_code" value="{{ old('postal_code') }}" placeholder="1000" required>
                                        @error('postal_code')
                                            <small class="ac-error">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="ac-field-group mb-0">
                                        <label class="ac-label" for="country"><i class="fas fa-globe"></i>Country *</label>
                                        <input id="country" class="ac-control" type="text" name="country" value="{{ old('country', 'Philippines') }}" required>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="ac-section" style="margin-top: 2.5rem;">
                            <div class="ac-section-head">
                                <span class="ac-section-number">3</span>
                                <h4>Delivery Notes</h4>
                            </div>

                            <div class="ac-field-group mb-0">
                                <label class="ac-label" for="special_instructions"><i class="fas fa-comment-alt"></i>Special Instructions</label>
                                <textarea id="special_instructions" class="ac-control" name="special_instructions" rows="4" placeholder="Gate code, nearest landmark, building entrance notes">{{ old('special_instructions') }}</textarea>
                                @error('special_instructions')
                                    <small class="ac-error">{{ $message }}</small>
                                @enderror
                            </div>
                        </section>

                        <div class="ac-primary-box">
                            <label class="ac-primary-label" for="is_primary">
                                <input id="is_primary" type="checkbox" name="is_primary" {{ old('is_primary') ? 'checked' : '' }}>
                                <i class="fas fa-star" style="color: #f1c40f;"></i>
                                Set as my primary address
                            </label>
                            <small class="ac-primary-hint">Primary address will be prefilled when creating offers and transactions.</small>
                        </div>

                        <div class="ac-actions">
                            <a href="{{ route('addresses.index') }}" class="ac-btn ac-btn-secondary">Cancel</a>
                            <button type="submit" class="ac-btn ac-btn-primary">
                                <i class="fas fa-save"></i>
                                Save Address
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

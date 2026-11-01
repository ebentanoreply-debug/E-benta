@extends(auth()->check() && auth()->user()->isSeller() ? 'layouts.seller' : 'layouts.buyer')

@section('title', 'Add New Address - E-Benta')

@section('content')
<style>
    .address-create-page {
        background-color: #f8fafc;
        min-height: calc(100vh - 60px);
        padding-bottom: 4rem;
    }

    .address-create-hero {
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

    .address-create-hero::after {
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

    .form-panel-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.15rem;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        margin-bottom: 1.5rem;
    }

    .side-info-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.15rem;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        margin-bottom: 1.5rem;
    }

    .section-divider-title {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 1.35rem;
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
        letter-spacing: -0.2px;
    }

    .form-field-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.45rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .form-field-label span.req {
        color: #ef4444;
        margin-left: 0.2rem;
    }

    .custom-input {
        width: 100%;
        background-color: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #0f172a;
        border-radius: 0.65rem;
        padding: 0.7rem 0.95rem;
        font-size: 0.92rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .custom-input:focus {
        outline: none;
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
        background-color: #ffffff;
        color: #0f172a;
    }

    .custom-input::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    .input-error-msg {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        color: #ef4444;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 0.4rem;
    }

    .primary-toggle-box {
        background: #f0fdfa;
        border: 1.5px solid #99f6e4;
        border-left: 4px solid #0d9488;
        border-radius: 0.85rem;
        padding: 1.15rem 1.25rem;
        margin-top: 1.5rem;
    }

    .primary-checkbox-label {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        cursor: pointer;
        user-select: none;
        margin: 0;
    }

    .primary-checkbox-label input[type='checkbox'] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #0d9488;
        border-radius: 4px;
        margin-top: 0.15rem;
        flex-shrink: 0;
    }

    .primary-title {
        font-weight: 800;
        color: #0f172a;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .primary-desc {
        color: #64748b;
        font-size: 0.83rem;
        margin-top: 0.25rem;
        line-height: 1.45;
    }

    .action-button-row {
        display: flex;
        gap: 0.85rem;
        margin-top: 2rem;
        align-items: center;
    }

    .btn-save-address {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        color: #ffffff;
        border: none;
        border-radius: 0.65rem;
        padding: 0.75rem 1.5rem;
        font-weight: 800;
        font-size: 0.92rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
    }

    .btn-save-address:hover {
        background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(13, 148, 136, 0.35);
        color: #ffffff;
    }

    .btn-cancel-action {
        background: #f8fafc;
        color: #475569;
        border: 1.5px solid #e2e8f0;
        border-radius: 0.65rem;
        padding: 0.75rem 1.35rem;
        font-weight: 700;
        font-size: 0.92rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: all 0.2s ease;
    }

    .btn-cancel-action:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .tip-item {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 0.75rem;
        padding: 0.85rem 1rem;
        margin-bottom: 0.75rem;
    }

    .tip-item:last-child {
        margin-bottom: 0;
    }

    .tip-item-title {
        font-size: 0.88rem;
        font-weight: 800;
        color: #0d9488;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.2rem;
    }

    .tip-item-body {
        font-size: 0.81rem;
        color: #64748b;
        line-height: 1.45;
        margin: 0;
    }
</style>

<div class="address-create-page py-4">
    <div class="container-fluid px-3 px-lg-4" style="max-width: 1200px;">
        
        <!-- Back Navigation -->
        <div>
            <a href="{{ route('addresses.index') }}" class="address-back-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Saved Addresses</span>
            </a>
        </div>

        <!-- Hero Header -->
        <div class="address-create-hero">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative" style="z-index: 1;">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                            <i class="fas fa-plus-circle me-1"></i>New Location
                        </span>
                    </div>
                    <h1 style="font-size: clamp(1.5rem, 2.2vw, 1.95rem); font-weight: 900; margin: 0; letter-spacing: -0.5px; color: #ffffff;">
                        Add New Address
                    </h1>
                    <p style="color: #ccfbf1; font-size: 0.92rem; margin: 0.35rem 0 0;">
                        Add a new pickup, dropoff, or dispatch point to streamline your logistics.
                    </p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; padding: 0.5rem 0.95rem; border-radius: 0.65rem; font-size: 0.82rem; font-weight: 700;">
                        <i class="fas fa-shield-halved me-1"></i> Verified & Encrypted
                    </span>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- LEFT COLUMN: Helpful Quick Notes -->
            <div class="col-lg-4 col-xl-4 order-lg-2">
                <div class="side-info-card">
                    <h5 style="color: #0f172a; font-weight: 800; font-size: 1rem; margin-bottom: 1.15rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-circle-info" style="color: #0d9488;"></i>
                        Address Tips
                    </h5>

                    <div class="tip-item">
                        <div class="tip-item-title">
                            <i class="fas fa-tag"></i> Clear Labels
                        </div>
                        <p class="tip-item-body">
                            Use recognizable labels like <strong>Main Warehouse</strong>, <strong>Home Pickup</strong>, or <strong>Branch Office</strong>.
                        </p>
                    </div>

                    <div class="tip-item">
                        <div class="tip-item-title">
                            <i class="fas fa-arrows-split-up-and-left"></i> Address Purpose
                        </div>
                        <p class="tip-item-body">
                            Specify whether this address is used for item pickups, dropoffs, or both.
                        </p>
                    </div>

                    <div class="tip-item">
                        <div class="tip-item-title">
                            <i class="fas fa-star" style="color: #f59e0b;"></i> Primary Location
                        </div>
                        <p class="tip-item-body">
                            Setting this as your primary address will make it the default for new listings and transactions.
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Main Address Create Form -->
            <div class="col-lg-8 col-xl-8 order-lg-1">
                <div class="form-panel-card">
                    <form method="POST" action="{{ route('addresses.store') }}" id="createAddressForm">
                        @csrf

                        <!-- Section 1: Address Identity -->
                        <div class="section-divider-title">
                            <div class="icon-wrap">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <h4>Address Identity</h4>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-7">
                                <label class="form-field-label" for="label">
                                    Address Label <span class="req">*</span>
                                </label>
                                <input id="label"
                                       class="custom-input @error('label') is-invalid @enderror"
                                       type="text"
                                       name="label"
                                       value="{{ old('label') }}"
                                       placeholder="e.g. Home, Warehouse, Central Hub"
                                       required>
                                @error('label')
                                    <div class="input-error-msg">
                                        <i class="fas fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <label class="form-field-label" for="type">
                                    Address Purpose <span class="req">*</span>
                                </label>
                                <select id="type"
                                        class="custom-input @error('type') is-invalid @enderror"
                                        name="type"
                                        required>
                                    <option value="both" {{ old('type') === 'both' ? 'selected' : '' }}>Both (Pickup & Dropoff)</option>
                                    <option value="pickup" {{ old('type') === 'pickup' ? 'selected' : '' }}>Pickup Only</option>
                                    <option value="dropoff" {{ old('type') === 'dropoff' ? 'selected' : '' }}>Dropoff Only</option>
                                </select>
                                @error('type')
                                    <div class="input-error-msg">
                                        <i class="fas fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 2: Location Details -->
                        <div class="section-divider-title">
                            <div class="icon-wrap">
                                <i class="fas fa-map-location-dot"></i>
                            </div>
                            <h4>Location Details</h4>
                        </div>

                        <div class="mb-3">
                            <label class="form-field-label" for="address_line_1">
                                Street Address / Purok / Building <span class="req">*</span>
                            </label>
                            <input id="address_line_1"
                                   class="custom-input @error('address_line_1') is-invalid @enderror"
                                   type="text"
                                   name="address_line_1"
                                   value="{{ old('address_line_1') }}"
                                   placeholder="e.g. Purok 3, 124 Rizal Avenue"
                                   required>
                            @error('address_line_1')
                                <div class="input-error-msg">
                                    <i class="fas fa-circle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-field-label" for="address_line_2">
                                Barangay / Suite / Floor / Landmark <small style="color: #94a3b8; text-transform: none; font-weight: 500;">(Optional)</small>
                            </label>
                            <input id="address_line_2"
                                   class="custom-input @error('address_line_2') is-invalid @enderror"
                                   type="text"
                                   name="address_line_2"
                                   value="{{ old('address_line_2') }}"
                                   placeholder="e.g. Brgy. Turac, Near Elementary School">
                            @error('address_line_2')
                                <div class="input-error-msg">
                                    <i class="fas fa-circle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-field-label" for="city">
                                    City / Municipality <span class="req">*</span>
                                </label>
                                <input id="city"
                                       class="custom-input @error('city') is-invalid @enderror"
                                       type="text"
                                       name="city"
                                       value="{{ old('city') }}"
                                       placeholder="e.g. San Carlos City"
                                       required>
                                @error('city')
                                    <div class="input-error-msg">
                                        <i class="fas fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-field-label" for="state">
                                    State / Province
                                </label>
                                <input id="state"
                                       class="custom-input @error('state') is-invalid @enderror"
                                       type="text"
                                       name="state"
                                       value="{{ old('state') }}"
                                       placeholder="e.g. Pangasinan">
                                @error('state')
                                    <div class="input-error-msg">
                                        <i class="fas fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-field-label" for="postal_code">
                                    Postal / ZIP Code <span class="req">*</span>
                                </label>
                                <input id="postal_code"
                                       class="custom-input @error('postal_code') is-invalid @enderror"
                                       type="text"
                                       name="postal_code"
                                       value="{{ old('postal_code') }}"
                                       placeholder="e.g. 2420"
                                       required>
                                @error('postal_code')
                                    <div class="input-error-msg">
                                        <i class="fas fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-field-label" for="country">
                                    Country <span class="req">*</span>
                                </label>
                                <input id="country"
                                       class="custom-input @error('country') is-invalid @enderror"
                                       type="text"
                                       name="country"
                                       value="{{ old('country', 'Philippines') }}"
                                       required>
                                @error('country')
                                    <div class="input-error-msg">
                                        <i class="fas fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 3: Delivery / Access Notes -->
                        <div class="section-divider-title">
                            <div class="icon-wrap">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h4>Delivery & Pickup Instructions</h4>
                        </div>

                        <div class="mb-3">
                            <label class="form-field-label" for="special_instructions">
                                Special Notes / Courier Guidelines <small style="color: #94a3b8; text-transform: none; font-weight: 500;">(Optional)</small>
                            </label>
                            <textarea id="special_instructions"
                                      class="custom-input @error('special_instructions') is-invalid @enderror"
                                      name="special_instructions"
                                      rows="3"
                                      placeholder="e.g. Gate code, call upon arrival, landmark details, office hours...">{{ old('special_instructions') }}</textarea>
                            @error('special_instructions')
                                <div class="input-error-msg">
                                    <i class="fas fa-circle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Section 4: Primary Address Checkbox -->
                        <div class="primary-toggle-box">
                            <label class="primary-checkbox-label" for="is_primary">
                                <input id="is_primary"
                                       type="checkbox"
                                       name="is_primary"
                                       value="1"
                                       {{ old('is_primary') ? 'checked' : '' }}>
                                <div>
                                    <div class="primary-title">
                                        <i class="fas fa-star" style="color: #f59e0b;"></i>
                                        Set as Primary Address
                                    </div>
                                    <div class="primary-desc">
                                        Primary address is preselected automatically for new listings, incoming offers, and transactions.
                                    </div>
                                </div>
                            </label>
                            @error('is_primary')
                                <div class="input-error-msg mt-2">
                                    <i class="fas fa-circle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-button-row">
                            <a href="{{ route('addresses.index') }}" class="btn-cancel-action">
                                <i class="fas fa-xmark"></i>
                                <span>Cancel</span>
                            </a>
                            <button type="submit" class="btn-save-address">
                                <i class="fas fa-floppy-disk"></i>
                                <span>Save Address</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

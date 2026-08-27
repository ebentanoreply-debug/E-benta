@extends('layouts.app')

@section('title', 'Edit Listing - E-Benta')

@section('content')
<div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(46, 204, 113, 0.05) 100%); min-height: 100vh; padding: 3rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <!-- Header Section -->
                <div style="margin-bottom: 2.5rem; text-align: center;">
                    <div style="display: inline-block; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; box-shadow: 0 4px 20px rgba(13, 148, 136, 0.3);">
                        <i class="fas fa-edit" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <h1 style="color: var(--text-light); font-weight: 800; margin-bottom: 0.5rem; font-size: 2.2rem;">
                        Edit Listing #{{ $listing->id }}
                    </h1>
                    <p style="color: #64748b; margin: 0; font-size: 1rem;">Update your listing details, photos, and handover preferences</p>
                </div>

                <!-- Form Card -->
                <div class="card" style="border: 2px solid rgba(13, 148, 136, 0.15); background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08); border-radius: 1.25rem; overflow: hidden;">
                    <div class="card-body" style="padding: 2.5rem 3rem;">
                    <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Listing Mode / Type Selector -->
                        <div style="margin-bottom: 2.5rem; background: rgba(13, 148, 136, 0.04); border: 1.5px solid rgba(13, 148, 136, 0.2); border-radius: 1rem; padding: 1.5rem;">
                            <label class="form-label" style="color: var(--text-light); font-weight: 700; margin-bottom: 1rem; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-layer-group" style="color: var(--light-green);"></i>Listing Mode / Type
                            </label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="listing-type-card" style="display: block; border: 2px solid rgba(13, 148, 136, 0.3); border-radius: 0.85rem; padding: 1.25rem; cursor: pointer; transition: all 0.25s ease; background: white;" id="typeCardSingle">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="radio" name="listing_type" id="type_single" value="single" {{ old('listing_type', $listing->listing_type ?? 'single') === 'single' ? 'checked' : '' }} onchange="updateListingTypeView()">
                                            <label class="form-check-label ms-2" for="type_single" style="font-weight: 700; color: #1e293b; cursor: pointer;">
                                                <i class="fas fa-mobile-alt me-1" style="color: #0d9488;"></i> Single Device / Item
                                            </label>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="listing-type-card" style="display: block; border: 2px solid rgba(13, 148, 136, 0.3); border-radius: 0.85rem; padding: 1.25rem; cursor: pointer; transition: all 0.25s ease; background: white;" id="typeCardBulk">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="radio" name="listing_type" id="type_bulk" value="bulk_lot" {{ old('listing_type', $listing->listing_type) === 'bulk_lot' ? 'checked' : '' }} onchange="updateListingTypeView()">
                                            <label class="form-check-label ms-2" for="type_bulk" style="font-weight: 700; color: #1e293b; cursor: pointer;">
                                                <i class="fas fa-boxes me-1" style="color: #f59e0b;"></i> Bulk / E-Waste Scrap Lot (Bundle)
                                            </label>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- 1. Device Information Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.7rem; color: white; font-weight: 700; font-size: 0.95rem;">1</span>
                                Device Information
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="device_type_id" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-microchip me-1" style="color: var(--light-green);"></i>Primary Category <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select class="form-select @error('device_type_id') is-invalid @enderror" 
                                           id="device_type_id" name="device_type_id" required
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                        <option value="">Select category</option>
                                        @foreach($deviceTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('device_type_id', $listing->device_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('device_type_id')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6" id="bulkCountWrapper" style="display: none;">
                                    <label for="lot_item_count" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-calculator me-1" style="color: #f59e0b;"></i>Est. Device Count in Lot <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="number" min="2" max="1000" class="form-control @error('lot_item_count') is-invalid @enderror" 
                                           id="lot_item_count" name="lot_item_count" value="{{ old('lot_item_count', $listing->lot_item_count ?? 5) }}"
                                           placeholder="e.g. 5, 10, 20 devices"
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                    @error('lot_item_count')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="device_details" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-tag me-1" style="color: var(--light-green);"></i>Item Title / Specific Details
                                    </label>
                                    <input type="text" class="form-control @error('device_details') is-invalid @enderror" 
                                           id="device_details" name="device_details" value="{{ old('device_details', $listing->device_details) }}" 
                                           placeholder="e.g. Apple MacBook, older Android phone, or scrap bundle title"
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                    @error('device_details')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 2. Condition & Handover Options -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.7rem; color: white; font-weight: 700; font-size: 0.95rem;">2</span>
                                Condition & Handover Options
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="condition" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-heartbeat me-1" style="color: var(--light-green);"></i>Device / Lot Condition <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select class="form-select @error('condition') is-invalid @enderror" 
                                           id="condition" name="condition" required
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                        <option value="">Select condition</option>
                                        <option value="working" {{ old('condition', $listing->condition) == 'working' ? 'selected' : '' }}>Working</option>
                                        <option value="minor_damage" {{ old('condition', $listing->condition) == 'minor_damage' ? 'selected' : '' }}>Minor Damage</option>
                                        <option value="major_damage" {{ old('condition', $listing->condition) == 'major_damage' ? 'selected' : '' }}>Major Damage</option>
                                        <option value="non_functional" {{ old('condition', $listing->condition) == 'non_functional' ? 'selected' : '' }}>Non-functional</option>
                                    </select>
                                    @error('condition')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="handover_preference" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-truck-loading me-1" style="color: var(--light-green);"></i>Handover Option <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select class="form-select @error('handover_preference') is-invalid @enderror" 
                                           id="handover_preference" name="handover_preference" required
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                        <option value="both" {{ old('handover_preference', $listing->handover_preference ?? 'both') == 'both' ? 'selected' : '' }}>🔄 Both Pickup & Meetup Available</option>
                                        <option value="pickup_only" {{ old('handover_preference', $listing->handover_preference) == 'pickup_only' ? 'selected' : '' }}>🚚 Doorstep / Location Pickup Only</option>
                                        <option value="meetup_only" {{ old('handover_preference', $listing->handover_preference) == 'meetup_only' ? 'selected' : '' }}>🤝 Safe Public Meetup Only</option>
                                    </select>
                                    @error('handover_preference')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 3. Details & Pricing Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.7rem; color: white; font-weight: 700; font-size: 0.95rem;">3</span>
                                Item Details & Pricing
                            </h5>

                            <div class="mb-4">
                                <label for="description" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                    <i class="fas fa-align-left me-1" style="color: var(--light-green);"></i>Description <span style="color: #e74c3c;">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                         id="description" name="description" rows="4" required
                                         style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">{{ old('description', $listing->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="intended_action" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-bullseye me-1" style="color: var(--light-green);"></i>Listing Goal <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select class="form-select @error('intended_action') is-invalid @enderror" 
                                           id="intended_action" name="intended_action" required
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                        <option value="sell" {{ old('intended_action', $listing->intended_action) == 'sell' ? 'selected' : '' }}>💰 Sell (Set Selling Price / Accept Offers)</option>
                                        <option value="recycle" {{ old('intended_action', $listing->intended_action) == 'recycle' ? 'selected' : '' }}>♻️ Recycle (Certified Scrap Disposal)</option>
                                    </select>
                                    @error('intended_action')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6" id="seller-price-field">
                                    <label for="suggested_price" class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.95rem;">
                                        <i class="fas fa-tags me-1" style="color: var(--light-green);"></i>Target Price (₱) <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="number" step="0.01" min="0" class="form-control @error('suggested_price') is-invalid @enderror" 
                                           id="suggested_price" name="suggested_price" value="{{ old('suggested_price', $listing->suggested_price) }}"
                                           placeholder="Enter selling price (₱)"
                                           style="background-color: rgba(13, 148, 136, 0.05); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem;">
                                    @error('suggested_price')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 4. Photos Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.7rem; color: white; font-weight: 700; font-size: 0.95rem;">4</span>
                                Photos
                            </h5>

                            <!-- Existing Photos -->
                            @if($listing->listingPhotos && $listing->listingPhotos->count() > 0)
                                <label class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.9rem;">
                                    <i class="fas fa-images me-1" style="color: var(--light-green);"></i>Current Photos (Select to delete)
                                </label>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                                    @foreach($listing->listingPhotos as $index => $photo)
                                        <div style="position: relative; border-radius: 0.75rem; overflow: hidden; aspect-ratio: 1; border: 2px solid rgba(0,0,0,0.1); background: #000;">
                                            <img src="{{ $photo->photo_url }}" alt="Photo" style="width: 100%; height: 100%; object-fit: cover;">
                                            <label style="position: absolute; top: 6px; right: 6px; cursor: pointer; margin: 0;">
                                                <input type="checkbox" name="delete_photos[]" value="{{ $index }}" style="display: none;" onchange="togglePhotoMark(this)">
                                                <span class="delete-badge" style="background: rgba(239, 68, 68, 0.9); color: white; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; box-shadow: 0 2px 6px rgba(0,0,0,0.3); transition: all 0.2s ease;">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Upload Additional Photos Dropzone -->
                            <label class="form-label" style="color: var(--text-light); font-weight: 600; font-size: 0.9rem;">
                                <i class="fas fa-plus-circle me-1" style="color: var(--light-green);"></i>Add More Photos (Up to 8 total)
                            </label>
                            <div id="dropZoneWrapper" style="border: 2px dashed rgba(13, 148, 136, 0.4); border-radius: 1rem; padding: 1.5rem; background: rgba(13, 148, 136, 0.02); text-align: center; cursor: pointer;" onclick="document.getElementById('photosInput').click()">
                                <input type="file" id="photosInput" name="photos[]" multiple accept="image/*" style="display: none;">
                                <i class="fas fa-cloud-upload-alt" style="color: var(--light-green); font-size: 1.8rem; margin-bottom: 0.5rem; display: block;"></i>
                                <span style="font-weight: 600; color: #1e293b; font-size: 0.9rem;">Click to upload additional photos</span>
                                <div id="previewGrid" style="display: none; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 0.75rem; margin-top: 1rem;" onclick="event.stopPropagation()"></div>
                            </div>
                            @if($errors->has('photos.*'))
                                <span class="invalid-feedback d-block mt-2">{{ $errors->first('photos.*') }}</span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('listings.show', $listing) }}" class="btn" style="background: #f1f5f9; color: #475569; font-weight: 600; border-radius: 0.8rem; padding: 0.85rem 2rem;">
                                Cancel
                            </a>
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); color: white; border: none; padding: 0.85rem 2.5rem; font-weight: 700; border-radius: 0.8rem; box-shadow: 0 4px 15px rgba(13, 148, 136, 0.35);">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function updateListingTypeView() {
        const isBulk = document.getElementById('type_bulk').checked;
        const bulkWrapper = document.getElementById('bulkCountWrapper');
        const cardSingle = document.getElementById('typeCardSingle');
        const cardBulk = document.getElementById('typeCardBulk');

        if (isBulk) {
            bulkWrapper.style.display = 'block';
            cardBulk.style.borderColor = '#0d9488';
            cardBulk.style.background = 'rgba(13, 148, 136, 0.05)';
            cardSingle.style.borderColor = 'rgba(13, 148, 136, 0.2)';
            cardSingle.style.background = 'white';
        } else {
            bulkWrapper.style.display = 'none';
            cardSingle.style.borderColor = '#0d9488';
            cardSingle.style.background = 'rgba(13, 148, 136, 0.05)';
            cardBulk.style.borderColor = 'rgba(13, 148, 136, 0.2)';
            cardBulk.style.background = 'white';
        }
    }

    function toggleSellerPriceField() {
        const intendedAction = document.getElementById('intended_action');
        const priceField = document.getElementById('seller-price-field');
        const priceInput = document.getElementById('suggested_price');

        if (!intendedAction || !priceField || !priceInput) return;

        const isSell = intendedAction.value === 'sell';
        priceField.style.display = isSell ? 'block' : 'none';
        priceInput.required = isSell;
        if (!isSell) {
            priceInput.value = '';
        }
    }

    function togglePhotoMark(checkbox) {
        const badge = checkbox.nextElementSibling;
        const parent = checkbox.closest('div');
        if (checkbox.checked) {
            badge.style.background = '#dc2626';
            parent.style.opacity = '0.4';
            parent.style.border = '2px dashed #dc2626';
        } else {
            badge.style.background = 'rgba(239, 68, 68, 0.9)';
            parent.style.opacity = '1';
            parent.style.border = '2px solid rgba(0,0,0,0.1)';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateListingTypeView();
        toggleSellerPriceField();

        const intendedAction = document.getElementById('intended_action');
        if (intendedAction) {
            intendedAction.addEventListener('change', toggleSellerPriceField);
        }
    });

    const fileInput = document.getElementById('photosInput');
    const previewGrid = document.getElementById('previewGrid');

    if (fileInput) {
        fileInput.addEventListener('change', () => {
            previewGrid.innerHTML = '';
            if (fileInput.files.length > 0) {
                previewGrid.style.display = 'grid';
                Array.from(fileInput.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.style.cssText = 'width: 100%; height: 100px; object-fit: cover; border-radius: 0.5rem; border: 1.5px solid var(--light-green);';
                        previewGrid.appendChild(img);
                    }
                });
            } else {
                previewGrid.style.display = 'none';
            }
        });
    }
</script>
@endsection

@endsection

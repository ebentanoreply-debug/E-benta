@extends('layouts.app')

@section('title', 'Edit Listing - E-Benta')

@section('content')
<div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(46, 204, 113, 0.05) 100%); min-height: 100vh; padding: 3rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header Section -->
                <div style="margin-bottom: 3rem; text-align: center;">
                    <div style="display: inline-block; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); padding: 1rem; border-radius: 1rem; margin-bottom: 1.5rem;">
                        <i class="fas fa-edit" style="color: white; font-size: 2rem;"></i>
                    </div>
                    <h1 style="color: var(--text-light); font-weight: 800; margin-bottom: 0.5rem; font-size: 2.2rem;">
                        Edit Listing
                    </h1>
                    <p style="color: #64748b; margin: 0; font-size: 1rem;">Update your e-waste item details</p>
                </div>

                <!-- Form Card -->
                <div class="card" style="border: 2px solid rgba(13, 148, 136, 0.15); background: rgba(255, 255, 255, 0.65); backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); border-radius: 1.2rem; overflow: hidden;">
                    <div class="card-body" style="padding: 3rem;">
                    <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Device Information Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.8rem; color: white; font-weight: 700;">1</span>
                                Device Information
                            </h5>

                            <div class="mb-4">
                                <label for="device_type_id" class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-microchip me-2" style="color: var(--light-green);"></i>Device Type <span style="color: #e74c3c;">*</span>
                                </label>
                                <select class="form-select @error('device_type_id') is-invalid @enderror" 
                                       id="device_type_id" name="device_type_id" required
                                       style="background-color: rgba(13, 148, 136, 0.05); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s ease;" onchange="this.style.borderColor='rgba(13, 148, 136, 0.6)'" onblur="this.style.borderColor='rgba(13, 148, 136, 0.3)'">
                                    <option value="">Select a device type</option>
                                    @foreach($deviceTypes as $type)
                                        <option value="{{ $type->id }}" {{ $listing->device_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('device_type_id')
                                    <span class="invalid-feedback d-block" style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="device_brand_id" class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-building me-2" style="color: var(--light-green);"></i>Catalog Brand <span style="color: #64748b;">(Optional)</span>
                                </label>
                                <select class="form-select @error('device_brand_id') is-invalid @enderror"
                                       id="device_brand_id" name="device_brand_id"
                                       style="background-color: rgba(13, 148, 136, 0.05); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s ease;" onchange="this.style.borderColor='rgba(13, 148, 136, 0.6)'" onblur="this.style.borderColor='rgba(13, 148, 136, 0.3)'">
                                    <option value="">Select a brand</option>
                                    @foreach($deviceBrands as $brand)
                                        <option value="{{ $brand->id }}" {{ $listing->device_brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('device_brand_id')
                                    <span class="invalid-feedback d-block" style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="device_model_id" class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-cube me-2" style="color: var(--light-green);"></i>Catalog Model <span style="color: #64748b;">(Optional)</span>
                                </label>
                                <select class="form-select @error('device_model_id') is-invalid @enderror"
                                       id="device_model_id" name="device_model_id"
                                       style="background-color: rgba(13, 148, 136, 0.05); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s ease;" onchange="this.style.borderColor='rgba(13, 148, 136, 0.6)'" onblur="this.style.borderColor='rgba(13, 148, 136, 0.3)'">
                                    <option value="">Select a model</option>
                                    @foreach($deviceModels as $model)
                                        <option value="{{ $model->id }}" {{ $listing->device_model_id == $model->id ? 'selected' : '' }}>
                                            {{ $model->model_name }} ({{ $model->brand->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('device_model_id')
                                    <span class="invalid-feedback d-block" style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Category & Condition Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.8rem; color: white; font-weight: 700;">2</span>
                                Condition
                            </h5>

                            <div class="mb-4">
                                <label for="device_details" class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-tag me-2" style="color: var(--light-green);"></i>Brand or Model Details <span style="color: #64748b;">(Optional)</span>
                                </label>
                                <input type="text" class="form-control @error('device_details') is-invalid @enderror" id="device_details" name="device_details" value="{{ old('device_details', $listing->device_details) }}" placeholder="e.g. Apple MacBook, older Android phone, or leave blank">
                                <small style="color: #64748b; display: block; margin-top: 0.5rem; font-size: 0.85rem;">Add any identifying details if you know them. You do not need to choose a brand or model.</small>
                                @error('device_details')
                                    <span class="invalid-feedback d-block" style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="condition" class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-heartbeat me-2" style="color: var(--light-green);"></i>Device Condition <span style="color: #e74c3c;">*</span>
                                </label>
                                <select class="form-select @error('condition') is-invalid @enderror"
                                       id="condition" name="condition" required
                                       style="background-color: rgba(13, 148, 136, 0.05); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s ease;" onchange="this.style.borderColor='rgba(13, 148, 136, 0.6)'" onblur="this.style.borderColor='rgba(13, 148, 136, 0.3)'">
                                                                    Condition
                                    <option value="">Select condition</option>
                                    <option value="working" {{ $listing->condition == 'working' ? 'selected' : '' }}>Working</option>
                                    <option value="minor_damage" {{ $listing->condition == 'minor_damage' ? 'selected' : '' }}>Minor Damage</option>
                                    <option value="major_damage" {{ $listing->condition == 'major_damage' ? 'selected' : '' }}>Major Damage</option>
                                    <option value="non_functional" {{ $listing->condition == 'non_functional' ? 'selected' : '' }}>Non-functional</option>
                                </select>
                                @error('condition')
                                    <span class="invalid-feedback d-block" style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.8rem; color: white; font-weight: 700;">3</span>
                                Item Details
                            </h5>

                            <div class="mb-4">
                                <label for="description" class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-align-left me-2" style="color: var(--light-green);"></i>Description <span style="color: #e74c3c;">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                         id="description" name="description" rows="4" required placeholder="Describe the device, its features, and any issues..."
                                         style="background-color: rgba(13, 148, 136, 0.05); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s ease; resize: vertical;" onfocus="this.style.borderColor='rgba(13, 148, 136, 0.6)'" onblur="this.style.borderColor='rgba(13, 148, 136, 0.3)'">{{ $listing->description }}</textarea>
                                <small style="color: #64748b; display: block; margin-top: 0.5rem; font-size: 0.85rem;">Describe the device, its features, and any issues</small>
                                @error('description')
                                    <span class="invalid-feedback d-block" style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="intended_action" class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-target me-2" style="color: var(--light-green);"></i>Intended Action <span style="color: #e74c3c;">*</span>
                                </label>
                                <select class="form-select @error('intended_action') is-invalid @enderror" 
                                       id="intended_action" name="intended_action" required
                                       style="background-color: rgba(13, 148, 136, 0.05); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s ease;" onchange="this.style.borderColor='rgba(13, 148, 136, 0.6)'" onblur="this.style.borderColor='rgba(13, 148, 136, 0.3)'">
                                    <option value="">Select action</option>
                                    <option value="sell" {{ $listing->intended_action == 'sell' ? 'selected' : '' }}>Sell</option>
                                    <option value="donate" {{ $listing->intended_action == 'donate' ? 'selected' : '' }}>Donate</option>
                                    <option value="recycle" {{ $listing->intended_action == 'recycle' ? 'selected' : '' }}>Recycle</option>
                                </select>
                                @error('intended_action')
                                    <span class="invalid-feedback d-block" style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4" id="seller-price-field" style="display: none;">
                                <label for="suggested_price" class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-tags me-2" style="color: var(--light-green);"></i>Set Selling Price (₱) <span style="color: #e74c3c;">*</span>
                                </label>
                                <input type="number" step="0.01" min="0" class="form-control @error('suggested_price') is-invalid @enderror" 
                                       id="suggested_price" name="suggested_price" value="{{ old('suggested_price', $listing->suggested_price) }}"
                                       placeholder="Enter your selling price"
                                       style="background-color: rgba(13, 148, 136, 0.05); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 0.85rem 1rem; border-radius: 0.8rem; font-size: 0.95rem; transition: all 0.3s ease;" onfocus="this.style.borderColor='rgba(13, 148, 136, 0.6)'" onblur="this.style.borderColor='rgba(13, 148, 136, 0.3)'">
                                <small style="color: #64748b; display: block; margin-top: 0.5rem; font-size: 0.85rem;">You set the price when you are selling the item.</small>
                                @error('suggested_price')
                                    <span class="invalid-feedback d-block" style="color: #e74c3c; margin-top: 0.5rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Photos Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); border-radius: 0.8rem; color: white; font-weight: 700;">4</span>
                                Photos
                            </h5>


                            <div class="mb-4">
                                <label class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-image me-2" style="color: var(--light-green);"></i>Current Photos
                                </label>
                                @if($listing->photos && count($listing->photos) > 0)
                                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                                        @foreach($listing->photos as $index => $photo)
                                            <div style="position: relative; border-radius: 0.8rem; overflow: hidden; background: rgba(13, 148, 136, 0.1); aspect-ratio: 1;">
                                                <img src="{{ $photo }}" alt="Listing photo" style="width: 100%; height: 100%; object-fit: cover;">
                                                <label style="position: absolute; top: 0.5rem; right: 0.5rem; cursor: pointer;">
                                                    <input type="checkbox" name="delete_photos[]" value="{{ $index }}" style="display: none;">
                                                    <span style="background-color: rgba(231, 76, 60, 0.9); color: white; padding: 0.4rem 0.8rem; border-radius: 0.4rem; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 0.3rem; cursor: pointer; transition: all 0.2s ease; font-weight: 600;" onmouseover="this.style.backgroundColor='rgba(231, 76, 60, 1)'" onmouseout="this.style.backgroundColor='rgba(231, 76, 60, 0.9)'">
                                                        <i class="fas fa-trash"></i>Remove
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small style="color: #64748b; display: block; margin-bottom: 1.5rem; font-size: 0.85rem;">Check the checkboxes above to remove photos</small>
                                @else
                                    <p style="color: #64748b;">No photos uploaded yet</p>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="newPhotos" class="form-label" style="color: var(--text-light); font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">
                                    <i class="fas fa-camera me-2" style="color: var(--light-green);"></i>Upload New Photos
                                </label>
                                <div id="uploadDropZone" style="border: 2px dashed rgba(13, 148, 136, 0.4); border-radius: 0.8rem; padding: 2rem; text-align: center; background: rgba(13, 148, 136, 0.03); transition: all 0.3s ease; cursor: pointer; position: relative; overflow: hidden;" onmouseover="this.style.borderColor='rgba(13, 148, 136, 0.7)'; this.style.background='rgba(13, 148, 136, 0.08)'" onmouseout="this.style.borderColor='rgba(13, 148, 136, 0.4)'; this.style.background='rgba(13, 148, 136, 0.03)'">
                                    <input type="file" id="newPhotos" name="photos[]" multiple accept="image/*" 
                                           style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">
                                    <div id="uploadPlaceholder">
                                        <i class="fas fa-cloud-upload-alt" style="color: var(--light-green); font-size: 2rem; margin-bottom: 0.75rem; display: block; pointer-events: none;"></i>
                                        <p style="color: var(--text-light); font-weight: 600; margin-bottom: 0.5rem; pointer-events: none;">Click to upload or drag and drop</p>
                                        <small style="color: #64748b; display: block; pointer-events: none;">PNG, JPG, GIF up to 2MB each</small>
                                    </div>
                                    <div id="imagePreviewContainer" style="display: none; display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 1rem;"></div>
                                </div>
                                @if($errors->has('photos.*'))
                                    <span class="invalid-feedback d-block" style="color: #e74c3c; margin-top: 0.5rem;">{{ $errors->first('photos.*') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- System Information Section -->
                        <div style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.12) 0%, rgba(46, 204, 113, 0.06) 100%); border-left: 4px solid var(--light-green); padding: 1.75rem; border-radius: 0.8rem; margin-bottom: 2.5rem;">
                            <h5 style="color: var(--text-light); margin-bottom: 1rem; font-weight: 700; display: flex; align-items: center; gap: 0.75rem;">
                                <i class="fas fa-info-circle" style="color: var(--light-green);"></i>Editing Information
                            </h5>
                            <ul style="color: #64748b; margin: 0; padding-left: 1.5rem; list-style: none;">
                                <li style="margin-bottom: 0.75rem; position: relative; padding-left: 1.5rem;"><i class="fas fa-check" style="color: var(--light-green); position: absolute; left: 0;"></i> Update any details about your device</li>
                                <li style="margin-bottom: 0.75rem; position: relative; padding-left: 1.5rem;"><i class="fas fa-check" style="color: var(--light-green); position: absolute; left: 0;"></i> Your changes will be reflected immediately</li>
                                <li style="position: relative; padding-left: 1.5rem;"><i class="fas fa-check" style="color: var(--light-green); position: absolute; left: 0;"></i> You cannot edit matched listings</li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3" style="justify-content: flex-end;">
                            <a href="{{ route('listings.show', $listing) }}" class="btn" style="background-color: rgba(255, 255, 255, 0.05); color: var(--text-light); border: 1.5px solid rgba(13, 148, 136, 0.3); padding: 1rem 2rem; font-weight: 600; border-radius: 0.8rem; transition: all 0.35s ease; transform: scale(1); flex-grow: 0;" onmouseover="this.style.backgroundColor='rgba(13, 148, 136, 0.1)'; this.style.borderColor='rgba(13, 148, 136, 0.6)'; this.style.transform='scale(1.02)'" onmouseout="this.style.backgroundColor='rgba(255, 255, 255, 0.05)'; this.style.borderColor='rgba(13, 148, 136, 0.3)'; this.style.transform='scale(1)'">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn flex-grow-0" style="background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); color: white; border: none; padding: 1rem 2.5rem; font-weight: 700; border-radius: 0.8rem; box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4); transition: all 0.35s ease; transform: scale(1);" onmouseover="this.style.boxShadow='0 10px 30px rgba(13, 148, 136, 0.6)'; this.style.transform='scale(1.05)'" onmouseout="this.style.boxShadow='0 6px 20px rgba(13, 148, 136, 0.4)'; this.style.transform='scale(1)'">
                                <i class="fas fa-save me-2"></i>Update Listing
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function toggleSellerPriceField() {
        const intendedAction = document.getElementById('intended_action');
        const priceField = document.getElementById('seller-price-field');
        const priceInput = document.getElementById('suggested_price');

        if (!intendedAction || !priceField || !priceInput) {
            return;
        }

        const isSell = intendedAction.value === 'sell';
        priceField.style.display = isSell ? 'block' : 'none';
        priceInput.required = isSell;
        if (!isSell) {
            priceInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const intendedAction = document.getElementById('intended_action');
        if (intendedAction) {
            intendedAction.addEventListener('change', toggleSellerPriceField);
            toggleSellerPriceField();
        }
    });

    // Handle file upload area
    const uploadDropZone = document.getElementById('uploadDropZone');
    const fileInput = document.getElementById('newPhotos');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');

    function displayImagePreviews(files) {
        previewContainer.innerHTML = '';
        
        if (files.length === 0) {
            uploadPlaceholder.style.display = 'block';
            previewContainer.style.display = 'none';
            return;
        }

        uploadPlaceholder.style.display = 'none';
        previewContainer.style.display = 'grid';

        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.style.cssText = 'position: relative; border-radius: 0.6rem; overflow: hidden; background: rgba(13, 148, 136, 0.1); aspect-ratio: 1; cursor: pointer;';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.style.cssText = 'position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(231, 76, 60, 0.9); color: white; border: none; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; transition: all 0.2s ease;';
                    
                    removeBtn.addEventListener('mouseover', () => {
                        removeBtn.style.background = 'rgba(231, 76, 60, 1)';
                        removeBtn.style.transform = 'scale(1.1)';
                    });
                    removeBtn.addEventListener('mouseout', () => {
                        removeBtn.style.background = 'rgba(231, 76, 60, 0.9)';
                        removeBtn.style.transform = 'scale(1)';
                    });
                    
                    removeBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const dataTransfer = new DataTransfer();
                        Array.from(fileInput.files).forEach((f, i) => {
                            if (i !== index) {
                                dataTransfer.items.add(f);
                            }
                        });
                        fileInput.files = dataTransfer.files;
                        fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                    });
                    
                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Listen for file changes
    if (fileInput) {
        fileInput.addEventListener('change', () => {
            displayImagePreviews(fileInput.files);
        });
    }

    if (uploadDropZone && fileInput) {
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadDropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop zone when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadDropZone.addEventListener(eventName, () => {
                uploadDropZone.style.borderColor = 'rgba(13, 148, 136, 0.7)';
                uploadDropZone.style.background = 'rgba(13, 148, 136, 0.08)';
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadDropZone.addEventListener(eventName, () => {
                uploadDropZone.style.borderColor = 'rgba(13, 148, 136, 0.4)';
                uploadDropZone.style.background = 'rgba(13, 148, 136, 0.03)';
            }, false);
        });

        // Handle dropped files
        uploadDropZone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            // Trigger change event to update UI if needed
            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
        }, false);
    }

    // Handle device type change - fetch models via API
    document.getElementById('device_type_id').addEventListener('change', async function() {
        const typeId = this.value;
        const modelSelect = document.getElementById('device_model_id');

        if (!modelSelect) {
            return;
        }
        
        // Clear options
        modelSelect.innerHTML = '<option value="">Select a model</option>';
        
        if (!typeId) {
            return;
        }
        
        try {
            const response = await fetch(`/api/device-models/${typeId}`);
            const models = await response.json();
            
            models.forEach(model => {
                const option = document.createElement('option');
                option.value = model.id;
                option.textContent = model.display_name;
                modelSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading device models:', error);
            modelSelect.innerHTML = '<option value="">Error loading models</option>';
        }
    });

    // Trigger change event if device_type_id is pre-selected
    if (document.getElementById('device_type_id').value) {
        document.getElementById('device_type_id').dispatchEvent(new Event('change'));
    }
</script>
@endsection

@endsection

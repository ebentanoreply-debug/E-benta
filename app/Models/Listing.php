<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'listing_type',
        'lot_item_count',
        'device_type_id',
        'device_brand_id',
        'device_model_id',
        'device_details',
        'condition',
        'description',
        'estimated_weight',
        'intended_action',
        'handover_preference',
        'pickup_address',
        'suggested_price',
        'status',
        'matched_buyer_id',
        'matched_at',
        'pickup_scheduled_at',
        'picked_up_at',
        'delivered_at',
        'processed_at',
        'carbon_footprint',
    ];

    protected function casts(): array
    {
        return [
            'lot_item_count' => 'integer',
            'estimated_weight' => 'decimal:2',
            'suggested_price' => 'decimal:2',
            'carbon_footprint' => 'decimal:2',
            'matched_at' => 'datetime',
            'pickup_scheduled_at' => 'datetime',
            'picked_up_at' => 'datetime',
            'delivered_at' => 'datetime',
            'processed_at' => 'datetime',
        ];
    }

    /**
     * Get the device type for this listing.
     */
    public function deviceType(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }

    /**
     * Get the device brand for this listing.
     */
    public function deviceBrand(): BelongsTo
    {
        return $this->belongsTo(DeviceBrand::class);
    }

    /**
     * Get the device model for this listing.
     */
    public function deviceModel(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class);
    }

    /**
     * Get the seller (user) who listed this item.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the buyer who matched with this listing.
     */
    public function matchedBuyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'matched_buyer_id');
    }

    /**
     * Get users who saved this listing.
     */
    public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_items')->withTimestamps();
    }

    /**
     * Get all offers for this listing.
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * Get all normalized photo rows for this listing.
     */
    public function listingPhotos(): HasMany
    {
        return $this->hasMany(ListingPhoto::class)->orderBy('sort_order');
    }

    /**
     * Get the impact log for this listing.
     */
    public function impactLog(): HasOne
    {
        return $this->hasOne(ImpactLog::class);
    }

    /**
     * Get all reports about this listing.
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * Backward-compatible category accessor sourced from device type.
     */
    public function getCategoryAttribute(): ?string
    {
        if ($this->relationLoaded('deviceType')) {
            return $this->deviceType?->name;
        }

        return $this->deviceType()->value('name');
    }

    /**
     * Backward-compatible photos accessor sourced from listing_photos.
     *
     * @return array<int, string>
     */
    public function getPhotosAttribute(): array
    {
        $photos = $this->relationLoaded('listingPhotos')
            ? $this->listingPhotos->pluck('photo_url')
            : $this->listingPhotos()->pluck('photo_url');

        return $photos
            ->filter(fn ($url) => is_string($url) && $url !== '')
            ->map(fn ($url) => \App\Services\CloudflareStorageService::url($url))
            ->values()
            ->all();
    }

    /**
     * Get device weight category for carbon calculation.
     * Returns average weight in kg for the category.
     */
    public static function getDefaultWeight(?string $category): float
    {
        if ($category === null) {
            return 1.0; // Default weight for unknown/null category
        }

        $weights = [
            'Laptop' => 2.0,
            'Desktop' => 5.0,
            'Desktop Computer' => 5.0,
            'Smartphone' => 0.2,
            'Tablet' => 0.5,
            'Monitor' => 4.0,
            'Keyboard' => 0.5,
            'Mouse' => 0.1,
            'Printer' => 8.0,
            'Scanner' => 5.0,
            'Router' => 0.3,
            'Modem' => 0.5,
            'Motherboard' => 0.3,
            'Graphics Card' => 0.4,
            'RAM' => 0.05,
            'Hard Drive' => 0.6,
            'Power Supply' => 2.0,
            'Cooling Fan' => 0.2,
            'Case' => 3.0,
            'Cable' => 0.1,
            'Cables & Wires' => 0.1,
            'Cable / Wire' => 0.1,
            'Charger & Cable' => 0.2,
            'Charger' => 0.3,
            'Headphones' => 0.2,
            'Speaker' => 1.0,
            'Webcam' => 0.2,
        ];

        return $weights[$category] ?? $weights[ucfirst(strtolower($category))] ?? 1.0;
    }

    /**
     * Get carbon footprint factory value based on category.
     * Assumes typical electronic device carbon footprint.
     */
    public static function calculateCarbonFootprint(?string $category, float $weight): float
    {
        // Approximate CO2 emissions coefficient: 10-20 kg CO2 per kg of e-waste
        // Using 15 as average for calculation
        $coefficient = 15;

        return round($weight * $coefficient, 2);
    }

    /**
     * Check if listing is a bulk e-waste lot/bundle.
     */
    public function isBulkLot(): bool
    {
        return $this->listing_type === 'bulk_lot';
    }

    /**
     * Check if listing is available for offers.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Check if listing is already matched.
     */
    public function isMatched(): bool
    {
        return $this->status === 'matched';
    }

    /**
     * Check if listing is processed.
     */
    public function isProcessed(): bool
    {
        return $this->status === 'processed';
    }
}

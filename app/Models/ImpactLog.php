<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImpactLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'listing_id',
        'seller_id',
        'buyer_id',
        'offer_id',
        'device_category',
        'device_weight',
        'processing_method',
        'co2_saved',
        'landfill_diverted_weight',
        'materials_recovered_weight',
        'gold_recovered',
        'copper_recovered',
        'plastic_recovered',
        'aluminum_recovered',
        'rare_earth_recovered',
        'certificate_path',
        'certificate_token',
        'status',
        'certified_at',
    ];

    protected function casts(): array
    {
        return [
            'device_weight' => 'decimal:2',
            'co2_saved' => 'decimal:2',
            'landfill_diverted_weight' => 'decimal:2',
            'materials_recovered_weight' => 'decimal:2',
            'gold_recovered' => 'decimal:4',
            'copper_recovered' => 'decimal:2',
            'plastic_recovered' => 'decimal:2',
            'aluminum_recovered' => 'decimal:2',
            'rare_earth_recovered' => 'decimal:4',
            'certified_at' => 'datetime',
        ];
    }

    /**
     * Get the listing for this impact log.
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get the seller involved in this transaction.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the buyer involved in this transaction.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Get the offer related to this impact log.
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Backward-compatible device category accessor sourced from listing.
     */
    public function getDeviceCategoryAttribute(): ?string
    {
        if ($this->relationLoaded('listing')) {
            return $this->listing?->category;
        }

        return $this->listing()->with('deviceType')->first()?->category;
    }

    /**
     * Calculate total materials recovered.
     */
    public function getTotalMaterialsRecovered(): float
    {
        return (float) (
            ($this->gold_recovered ?? 0) +
            ($this->copper_recovered ?? 0) +
            ($this->plastic_recovered ?? 0) +
            ($this->aluminum_recovered ?? 0) +
            ($this->rare_earth_recovered ?? 0)
        );
    }

    /**
     * Get material breakdown as array.
     */
    public function getMaterialBreakdown(): array
    {
        return [
            'gold' => $this->gold_recovered ?? 0,
            'copper' => $this->copper_recovered ?? 0,
            'plastic' => $this->plastic_recovered ?? 0,
            'aluminum' => $this->aluminum_recovered ?? 0,
            'rare_earth' => $this->rare_earth_recovered ?? 0,
        ];
    }

    /**
     * Check if impact log is certified.
     */
    public function isCertified(): bool
    {
        return $this->status === 'certified' && $this->certificate_token !== null;
    }

    /**
     * Mark as certified.
     */
    public function certify(): bool
    {
        $this->status = 'certified';
        $this->certified_at = now();
        $this->certificate_token = \Str::random(64);

        return $this->save();
    }

    /**
     * Generate unique certificate URL token.
     */
    public static function generateCertificateToken(): string
    {
        return \Str::random(32) . '-' . time();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'listing_id',
        'buyer_id',
        'bid_amount',
        'proposed_method',
        'handover_method',
        'notes',
        'proposed_pickup_date',
        'pickup_location',
        'status',
        'cancellation_reason',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'bid_amount' => 'decimal:2',
            'proposed_pickup_date' => 'datetime',
            'responded_at' => 'datetime',
        ];
    }

    /**
     * Get the listing this offer is for.
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get the buyer who made this offer.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Get the impact log created from this offer.
     */
    public function impactLog(): HasOne
    {
        return $this->hasOne(ImpactLog::class);
    }

    /**
     * Get the reviews for this offer transaction.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all reports about this offer.
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * Get all messages for this offer conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Determine if buyer-seller chat is active for this offer.
     * Chat is ONLY active when the offer has been accepted by the seller
     * and the transaction is not yet completed/processed or cancelled.
     */
    public function isChatActive(): bool
    {
        return $this->status === 'accepted'
            && !in_array($this->listing?->status, ['processed', 'completed', 'cancelled']);
    }

    /**
     * Determine if chat is locked (read-only archive).
     * Chat is locked once transaction is finalized or cancelled.
     */
    public function isChatLocked(): bool
    {
        return $this->status === 'completed'
            || $this->status === 'cancelled'
            || in_array($this->listing?->status, ['processed', 'completed', 'cancelled']);
    }

    /**
     * Check if offer is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if offer is accepted.
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if offer is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if buyer can cancel this offer.
     */
    public function canBuyerCancel(): bool
    {
        if ($this->status === 'pending') {
            return true;
        }

        if ($this->status !== 'accepted') {
            return false;
        }

        $listing = $this->listing;
        $inProgressOrDone = $listing?->picked_up_at !== null
            || in_array($listing?->status, ['in_transit', 'delivered', 'processed', 'completed']);

        if ($inProgressOrDone) {
            return false;
        }

        return true;
    }

    /**
     * Accept this offer and update listing status.
     */
    public function accept(): bool
    {
        try {
            \DB::transaction(function () {
                $listing = Listing::whereKey($this->listing_id)->lockForUpdate()->firstOrFail();

                if ($this->status !== 'pending' || $listing->status !== 'available') {
                    throw new \RuntimeException('Offer or listing is no longer available');
                }

                // Update offer status
                $this->status = 'accepted';
                $this->responded_at = now();
                $this->save();

                // Update listing as matched
                $listing->update([
                    'status' => 'matched',
                    'matched_buyer_id' => $this->buyer_id,
                    'matched_at' => now(),
                ]);

                // Reject all other offers for this listing
                Offer::where('listing_id', $this->listing_id)
                    ->where('id', '!=', $this->id)
                    ->where('status', 'pending')
                    ->update([
                        'status' => 'rejected',
                        'responded_at' => now(),
                    ]);
            });

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Reject this offer.
     */
    public function reject(): bool
    {
        $this->status = 'rejected';
        $this->responded_at = now();
        return $this->save();
    }

    /**
     * Mark offer as completed (after processing).
     */
    public function complete(): bool
    {
        $this->status = 'completed';
        return $this->save();
    }
}

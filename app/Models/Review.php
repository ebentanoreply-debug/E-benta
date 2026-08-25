<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $fillable = [
        'reviewer_id',
        'reviewee_id',
        'offer_id',
        'rating',
        'title',
        'comment',
        'review_type',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who left the review
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Get the user being reviewed
     */
    public function reviewee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    /**
     * Get the offer associated with this review
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Get detailed attribute scores for this review (3NF normalized).
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(ReviewAttribute::class, 'review_id')->orderBy('attribute');
    }

    /**
     * Get detailed attribute scores for this review.
     */
    public function attributeScores(): HasMany
    {
        return $this->hasMany(ReviewAttribute::class, 'review_id')->orderBy('id');
    }

    /**
     * Backward-compatible attributes accessor built from normalized rows.
     *
     * @return array<string, int>
     */
    public function getAttributesAttribute(): array
    {
        if ($this->relationLoaded('attributeScores')) {
            return $this->attributeScores
                ->mapWithKeys(fn (ReviewAttribute $score) => [$score->attribute => (int) $score->score])
                ->all();
        }

        return $this->attributeScores()
            ->get()
            ->mapWithKeys(fn (ReviewAttribute $score) => [$score->attribute => (int) $score->score])
            ->all();
    }

    /**
     * Get rating stars (1-5)
     */
    public function getStarRating(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Get rating percentage (0-100)
     */
    public function getRatingPercentage(): float
    {
        return ($this->rating / 5) * 100;
    }

    /**
     * Get review type label
     */
    public function getReviewTypeLabel(): string
    {
        return $this->review_type === 'buyer' ? 'Buyer Review' : 'Seller Review';
    }

    /**
     * Get detailed attributes display
     */
    public function getAttributesDisplay(): array
    {
        $attributes = $this->getAttribute('attributes');
        if (!$attributes) {
            return [];
        }

        $labels = [
            'communication' => 'Communication',
            'professionalism' => 'Professionalism',
            'cleanliness' => 'Cleanliness/Condition',
            'accuracy' => 'Item Accuracy',
            'promptness' => 'Promptness',
            'honesty' => 'Honesty & Integrity',
        ];

        $display = [];
        foreach ($attributes as $key => $value) {
            if (isset($labels[$key])) {
                $display[$labels[$key]] = $value;
            }
        }

        return $display;
    }

    /**
     * Scope: get reviews for a user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('reviewee_id', $userId);
    }

    /**
     * Scope: get recent reviews
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
            ->orderBy('created_at', 'desc');
    }

    /**
     * Scope: get high-rated reviews
     */
    public function scopeHighRated($query)
    {
        return $query->where('rating', '>=', 4);
    }

    /**
     * Scope: get low-rated reviews
     */
    public function scopeLowRated($query)
    {
        return $query->where('rating', '<=', 2);
    }
}

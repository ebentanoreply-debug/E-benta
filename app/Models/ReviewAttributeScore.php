<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewAttributeScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'attribute_key',
        'rating',
    ];

    /**
     * Get the review this score belongs to.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}

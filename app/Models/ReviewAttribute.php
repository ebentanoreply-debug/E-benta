<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewAttribute extends Model
{
    protected $table = 'review_attributes';

    protected $fillable = ['review_id', 'attribute', 'score'];

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}

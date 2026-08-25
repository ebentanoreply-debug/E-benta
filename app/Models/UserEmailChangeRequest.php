<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEmailChangeRequest extends Model
{
    use HasFactory;

    protected $table = 'email_change_tokens';

    protected $fillable = [
        'user_id',
        'token',
        'new_email',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * Get the user for this email change request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

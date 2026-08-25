<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'special_instructions',
        'is_primary',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'is_primary' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns this address
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full address as a string
     */
    public function getFullAddress(): string
    {
        $parts = [
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ];
        
        return implode(', ', array_filter($parts));
    }

    /**
     * Get a shortened version of the address
     */
    public function getShortAddress(): string
    {
        return "{$this->address_line_1}, {$this->city}";
    }

    /**
     * Mark this address as primary
     */
    public function markAsPrimary(): void
    {
        // Unset all other addresses for this user
        $this->user->addresses()->update(['is_primary' => false]);
        
        // Set this one as primary
        $this->update(['is_primary' => true]);
    }

    /**
     * Scope: Get only pickup addresses
     */
    public function scopePickup($query)
    {
        return $query->whereIn('type', ['pickup', 'both']);
    }

    /**
     * Scope: Get only dropoff addresses
     */
    public function scopeDropoff($query)
    {
        return $query->whereIn('type', ['dropoff', 'both']);
    }

    /**
     * Scope: Get only primary addresses
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope: Get addresses for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Get addresses ordered by primary first, then label
     */
    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_primary')->orderBy('label');
    }
}

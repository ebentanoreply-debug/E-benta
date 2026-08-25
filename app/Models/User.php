<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_verified',
        'is_suspended',
        'is_banned',
        'business_name',
        'business_description',
        'phone',
        'email_notifications',
        'sms_notifications',
        'marketing_updates',
        'profile_visibility',
        'total_impact_score',
        'items_processed',
        'total_weight_diverted',
        'total_co2_saved',
        'google_id',
        'oauth_provider',
        'oauth_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'oauth_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_suspended' => 'boolean',
            'is_banned' => 'boolean',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'marketing_updates' => 'boolean',
            'profile_visibility' => 'string',
            'total_impact_score' => 'decimal:2',
            'total_weight_diverted' => 'decimal:2',
            'total_co2_saved' => 'decimal:2',
        ];
    }

    /**
     * Get the listings created by this user (as seller).
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'user_id');
    }

    /**
     * Get the offers made by this user (as buyer).
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'buyer_id');
    }

    /**
     * Get the impact logs where this user is the seller.
     */
    public function sellerImpactLogs(): HasMany
    {
        return $this->hasMany(ImpactLog::class, 'seller_id');
    }

    /**
     * Get the impact logs where this user is the buyer.
     */
    public function buyerImpactLogs(): HasMany
    {
        return $this->hasMany(ImpactLog::class, 'buyer_id');
    }

    /**
     * Get the notifications for this user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the messages sent by this user.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the messages received by this user.
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get unread messages count for this user.
     */
    public function unreadMessagesCount(): int
    {
        return $this->receivedMessages()->where('is_read', false)->count();
    }

    /**
     * Get the audit logs for this user.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Get the reviews left by this user.
     */
    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * Get the reviews received by this user.
     */
    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    /**
     * Get user's average rating
     */
    public function getAverageRating(): float
    {
        $average = $this->reviewsReceived()->avg('rating');
        return round($average ?? 0, 2);
    }

    /**
     * Get total reviews count for user
     */
    public function getTotalReviews(): int
    {
        return $this->reviewsReceived()->count();
    }

    /**
     * Get the addresses saved by this user.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class)->ordered();
    }

    /**
     * Get the primary address for this user
     */
    public function getPrimaryAddress()
    {
        return $this->addresses()->primary()->first();
    }

    /**
     * Get the listings matched to this user as buyer.
     */
    public function matchedListings(): HasMany
    {
        return $this->hasMany(Listing::class, 'matched_buyer_id');
    }

    /**
     * Get listings saved by this user.
     */
    public function savedListings(): BelongsToMany
    {
        return $this->belongsToMany(Listing::class, 'saved_items')->withTimestamps();
    }

    /**
     * Get all reports filed by this user.
     */
    public function reportsFiled(): HasMany
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    /**
     * Get all reports about this user.
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * Get email change requests for this user.
     */
    public function emailChangeRequests(): HasMany
    {
        return $this->hasMany(UserEmailChangeRequest::class);
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a buyer/recycler.
     */
    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }

    /**
     * Check if user is a seller.
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isSuspended(): bool
    {
        return (bool) $this->is_suspended;
    }

    public function isBanned(): bool
    {
        return (bool) $this->is_banned;
    }
}

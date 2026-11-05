<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    protected $appends = [
        'target_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get normalized notification data (3NF).
     */
    public function dataItems(): HasMany
    {
        return $this->hasMany(NotificationData::class, 'notification_id');
    }

    /**
     * Backward-compatible data accessor built from notification_data rows.
     *
     * @return array<string, string>
     */
    public function getDataAttribute(): array
    {
        if ($this->relationLoaded('dataItems')) {
            $items = $this->dataItems
                ->mapWithKeys(fn (NotificationData $item) => [$item->key => $item->value])
                ->all();
            if (!empty($items)) {
                return $items;
            }
        }

        $items = $this->dataItems()
            ->get()
            ->mapWithKeys(fn (NotificationData $item) => [$item->key => $item->value])
            ->all();

        if (!empty($items)) {
            return $items;
        }

        $raw = $this->attributes['data'] ?? null;
        if (is_string($raw)) {
            return json_decode($raw, true) ?: [];
        }
        if (is_array($raw)) {
            return $raw;
        }

        return [];
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Get the redirect target URL for this notification.
     */
    public function getTargetUrlAttribute(): string
    {
        $data = $this->data ?? [];

        switch ($this->type) {
            case 'new_message':
                if (!empty($data['offer_id'])) {
                    return route('messages.index', ['offer_id' => $data['offer_id']], false);
                }
                return route('messages.index', [], false);

            case 'offer_received':
            case 'offer_accepted':
            case 'offer_rejected':
            case 'offer_cancelled':
            case 'payment_received':
            case 'payment_confirmed':
            case 'cash_payment_confirmed':
            case 'payment_method_selected':
            case 'item_picked_up':
            case 'delivery_confirmed':
            case 'processing_completed':
                if (!empty($data['offer_id'])) {
                    return route('offers.show', $data['offer_id'], false);
                }
                if (!empty($data['listing_id'])) {
                    return route('listings.show', $data['listing_id'], false);
                }
                return $this->user?->isSeller() ? route('seller.transaction-history', [], false) : route('buyer.transaction-history', [], false);

            case 'listing_created':
                if (!empty($data['listing_id'])) {
                    return route('listings.show', $data['listing_id'], false);
                }
                return route('seller.dashboard', [], false);

            case 'new_buyer_registration':
            case 'new_seller_registration':
            case 'pending_verification':
                return route('admin.pending-verifications', [], false);

            case 'account_approved':
            case 'seller_registration_success':
                return $this->user?->isSeller() ? route('seller.dashboard', [], false) : route('buyer.dashboard', [], false);

            case 'account_rejected':
                return route('settings', ['tab' => 'id-verification'], false);

            default:
                if (!empty($data['offer_id'])) {
                    return route('offers.show', $data['offer_id'], false);
                }
                if (!empty($data['listing_id'])) {
                    return route('listings.show', $data['listing_id'], false);
                }
                return route('notifications.index', [], false);
        }
    }

    /**
     * Create a notification for a user
     */
    public static function notify(User $user, string $type, string $title, string $message, array $data = null)
    {
        $notification = self::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ]);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                NotificationData::create([
                    'notification_id' => $notification->id,
                    'key' => (string) $key,
                    'value' => is_scalar($value) ? (string) $value : json_encode($value),
                ]);
            }
        }

        return $notification;
    }
}


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
            return $this->dataItems
                ->mapWithKeys(fn (NotificationData $item) => [$item->key => $item->value])
                ->all();
        }

        return $this->dataItems()
            ->get()
            ->mapWithKeys(fn (NotificationData $item) => [$item->key => $item->value])
            ->all();
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Create a notification for a user
     */
    public static function notify(User $user, string $type, string $title, string $message, array $data = null)
    {
        return self::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

}


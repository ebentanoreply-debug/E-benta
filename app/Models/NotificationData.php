<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationData extends Model
{
    protected $table = 'notification_data';
    protected $fillable = ['notification_id', 'key', 'value'];

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}

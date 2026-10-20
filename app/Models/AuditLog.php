<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Unknown User',
            'email' => 'N/A',
        ]);
    }

    /**
     * Get clean actor display name, falling back to name in description or system.
     */
    public function getActorNameAttribute(): string
    {
        if ($this->relationLoaded('user') && $this->user && $this->user->name && $this->user->name !== 'Unknown User') {
            return $this->user->name;
        }

        if ($this->user_id && ($foundUser = User::find($this->user_id))) {
            return $foundUser->name;
        }

        // Check if description has "User [Name] logged..." or similar pattern
        if ($this->description && preg_match('/User\s+([^,]+?)\s+(?:logged|registered|verified|submitted|changed|updated|deleted)/i', $this->description, $m)) {
            return trim($m[1]);
        }

        if ($this->description && preg_match('/for\s+(?:seller|buyer|admin)\s+([^,]+)/i', $this->description, $m)) {
            return trim($m[1]);
        }

        if ($this->model_type === 'User' && $this->model_id && ($targetUser = User::find($this->model_id))) {
            return $targetUser->name;
        }

        return 'System Activity';
    }

    /**
     * Get clean actor display email, falling back to clean context or automated.
     */
    public function getActorEmailAttribute(): string
    {
        if ($this->relationLoaded('user') && $this->user && $this->user->email && $this->user->email !== 'N/A') {
            return $this->user->email;
        }

        if ($this->user_id && ($foundUser = User::find($this->user_id))) {
            return $foundUser->email;
        }

        if ($this->model_type === 'User' && $this->model_id && ($targetUser = User::find($this->model_id))) {
            return $targetUser->email;
        }

        if ($this->description && preg_match('/User\s+([^,]+?)\s+logged/i', $this->description)) {
            return 'Authenticated Session';
        }

        return 'Automated / System';
    }

    /**
     * Get normalized change records (3NF).
     */
    public function changes()
    {
        return $this->hasMany(AuditLogChange::class, 'audit_log_id');
    }

    /**
     * Backward-compatible old_values accessor built from audit_log_changes rows.
     *
     * @return array<string, mixed>
     */
    public function getOldValuesAttribute(): array
    {
        if ($this->relationLoaded('changes')) {
            return $this->changes
                ->where('change_type', 'old_value')
                ->mapWithKeys(fn (AuditLogChange $change) => [
                    $change->field_name => $this->unserializeValue($change->field_value)
                ])
                ->all();
        }

        return $this->changes()
            ->where('change_type', 'old_value')
            ->get()
            ->mapWithKeys(fn (AuditLogChange $change) => [
                $change->field_name => $this->unserializeValue($change->field_value)
            ])
            ->all();
    }

    /**
     * Backward-compatible new_values accessor built from audit_log_changes rows.
     *
     * @return array<string, mixed>
     */
    public function getNewValuesAttribute(): array
    {
        if ($this->relationLoaded('changes')) {
            return $this->changes
                ->where('change_type', 'new_value')
                ->mapWithKeys(fn (AuditLogChange $change) => [
                    $change->field_name => $this->unserializeValue($change->field_value)
                ])
                ->all();
        }

        return $this->changes()
            ->where('change_type', 'new_value')
            ->get()
            ->mapWithKeys(fn (AuditLogChange $change) => [
                $change->field_name => $this->unserializeValue($change->field_value)
            ])
            ->all();
    }

    /**
     * Helper to unserialize stored values (JSON or raw).
     */
    private function unserializeValue($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            return json_decode($value, true);
        } catch (\Exception $e) {
            return $value;
        }
    }

    /**
     * Get human-readable action display
     */
    public function getActionLabel(): string
    {
        $labels = [
            'login' => 'User Login',
            'logout' => 'User Logout',
            'register' => 'User Registration',
            'create_listing' => 'Created Listing',
            'update_listing' => 'Updated Listing',
            'delete_listing' => 'Deleted Listing',
            'withdraw_listing' => 'Withdrew Listing',
            'create_offer' => 'Created Offer',
            'accept_offer' => 'Accepted Offer',
            'reject_offer' => 'Rejected Offer',
            'approve_seller' => 'Approved Seller Account',
            'reject_seller' => 'Rejected Seller Account',
            'approve_buyer' => 'Approved Buyer Account',
            'reject_buyer' => 'Rejected Buyer Account',
            'update_profile' => 'Updated Profile',
            'change_password' => 'Changed Password',
            'reset_password' => 'Reset Password',
        ];

        return $labels[$this->action] ?? ucfirst(str_replace('_', ' ', $this->action));
    }

    /**
     * Get human-readable model type
     */
    public function getModelLabel(): string
    {
        $labels = [
            'Listing' => 'Listing',
            'Offer' => 'Offer',
            'User' => 'User Account',
            'Notification' => 'Notification',
        ];

        return $labels[$this->model_type] ?? $this->model_type;
    }

    /**
     * Scope to filter by action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by model type
     */
    public function scopeByModel($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope to get recent logs
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
            ->orderBy('created_at', 'desc');
    }
}

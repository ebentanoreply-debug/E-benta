<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'reportable_type',
        'reportable_id',
        'reason',
        'description',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who reported this.
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin who reviewed this report.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the reported item (polymorphic).
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get human-readable reason.
     */
    public function getReasonLabel(): string
    {
        return match($this->reason) {
            'inappropriate_content' => 'Inappropriate Content',
            'scam_fraud' => 'Scam or Fraud',
            'offensive_language' => 'Offensive Language',
            'harassment_abuse' => 'Harassment or Abuse',
            'spam' => 'Spam',
            'false_information' => 'False Information',
            'fake_listing' => 'Fake Listing',
            'broken_item_misrepresentation' => 'Broken Item/Misrepresentation',
            'seller_unresponsive' => 'Seller Unresponsive',
            'suspicious_behavior' => 'Suspicious Behavior',
            default => 'Other'
        };
    }

    /**
     * Get human-readable status.
     */
    public function getStatusLabel(): string
    {
        return match($this->status) {
            'pending' => 'Pending Review',
            'under_review' => 'Under Review',
            'resolved' => 'Resolved',
            'dismissed' => 'Dismissed',
            default => 'Unknown'
        };
    }

    /**
     * Get human-readable action taken.
     */
    public function getActionLabel(): string
    {
        return match($this->action_taken) {
            'none' => 'No Action',
            'warning_sent' => 'Warning Sent',
            'content_removed' => 'Content Removed',
            'user_suspended' => 'User Suspended',
            'user_banned' => 'User Banned',
            'listing_removed' => 'Listing Removed',
            default => 'Unknown'
        };
    }

    /**
     * Scope: Get pending reports.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get reports under review.
     */
    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    /**
     * Scope: Get resolved reports.
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /**
     * Scope: Get reports by specific reason.
     */
    public function scopeByReason($query, $reason)
    {
        return $query->where('reason', $reason);
    }

    /**
     * Scope: Get reports about specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('reportable_type', $type);
    }

    /**
     * Scope: Get reports from specific user.
     */
    public function scopeByReporter($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Get reports about specific reportable.
     */
    public function scopeAbout($query, $type, $id)
    {
        return $query->where('reportable_type', $type)->where('reportable_id', $id);
    }

    /**
     * Scope: Get recent reports.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope: Order by newest first.
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Mark report as under review.
     */
    public function markUnderReview($adminId)
    {
        $this->update([
            'status' => 'under_review',
            'reviewed_by' => $adminId,
            'reviewed_at' => now(),
        ]);
    }

    /**
     * Resolve the report.
     */
    public function resolve($adminId, $action = 'none', $notes = null)
    {
        $this->update([
            'status' => 'resolved',
            'reviewed_by' => $adminId,
            'action_taken' => $action,
            'admin_notes' => $notes,
            'reviewed_at' => now(),
        ]);
    }

    /**
     * Dismiss the report.
     */
    public function dismiss($adminId, $notes = null)
    {
        $this->update([
            'status' => 'dismissed',
            'reviewed_by' => $adminId,
            'admin_notes' => $notes,
            'reviewed_at' => now(),
        ]);
    }
}

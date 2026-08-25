<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Auth;

class AuditLogger
{
    /**
     * Log an action to the audit logs
     */
    public static function log(
        string $action,
        string $description,
        ?string $modelType = null,
        ?int $modelId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): AuditLog {
        $request = request();
        $userId = Auth::id();
        
        // Validate that the user exists in the database if we have an ID
        if ($userId !== null && !\Auth::check()) {
            $userId = null;
        }
        
        return AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Log a model creation
     */
    public static function logCreate(string $modelType, int $modelId, string $description, array $data): AuditLog
    {
        return self::log(
            action: 'create_' . strtolower(str_replace('_', '', $modelType)),
            description: $description,
            modelType: $modelType,
            modelId: $modelId,
            newValues: $data
        );
    }

    /**
     * Log a model update
     */
    public static function logUpdate(string $modelType, int $modelId, string $description, array $oldValues, array $newValues): AuditLog
    {
        return self::log(
            action: 'update_' . strtolower(str_replace('_', '', $modelType)),
            description: $description,
            modelType: $modelType,
            modelId: $modelId,
            oldValues: $oldValues,
            newValues: $newValues
        );
    }

    /**
     * Log a model deletion
     */
    public static function logDelete(string $modelType, int $modelId, string $description, array $data): AuditLog
    {
        return self::log(
            action: 'delete_' . strtolower(str_replace('_', '', $modelType)),
            description: $description,
            modelType: $modelType,
            modelId: $modelId,
            oldValues: $data
        );
    }

    /**
     * Log a user login
     */
    public static function logLogin(string $description = ''): AuditLog
    {
        return self::log(
            action: 'login',
            description: $description ?: 'User logged in',
            modelType: 'User',
            modelId: Auth::id()
        );
    }

    /**
     * Log a user logout
     */
    public static function logLogout(string $description = ''): AuditLog
    {
        return self::log(
            action: 'logout',
            description: $description ?: 'User logged out',
            modelType: 'User',
            modelId: Auth::id()
        );
    }

    /**
     * Log a password change
     */
    public static function logPasswordChange(int $userId, string $description = ''): AuditLog
    {
        return self::log(
            action: 'change_password',
            description: $description ?: 'Password changed',
            modelType: 'User',
            modelId: $userId
        );
    }

    /**
     * Log an account approval/rejection
     */
    public static function logAccountApproval(int $userId, string $status, string $reason = ''): AuditLog
    {
        $action = $status === 'approved' ? 'approve_seller' : 'reject_seller';
        $statusText = $status === 'approved' ? 'Approved' : 'Rejected';
        
        return self::log(
            action: $action,
            description: "$statusText account" . ($reason ? ": $reason" : ''),
            modelType: 'User',
            modelId: $userId,
            newValues: ['status' => $status]
        );
    }

    /**
     * Log an offer status change
     */
    public static function logOfferStatusChange(int $offerId, string $oldStatus, string $newStatus, string $reason = ''): AuditLog
    {
        $action = match($newStatus) {
            'accepted' => 'accept_offer',
            'rejected' => 'reject_offer',
            default => 'update_offer_status'
        };

        $description = "Offer status changed from $oldStatus to $newStatus";
        if ($reason) {
            $description .= ": $reason";
        }

        return self::log(
            action: $action,
            description: $description,
            modelType: 'Offer',
            modelId: $offerId,
            oldValues: ['status' => $oldStatus],
            newValues: ['status' => $newStatus]
        );
    }

    /**
     * Get audit logs for a specific model
     */
    public static function getModelLogs(string $modelType, int $modelId, int $limit = 50): \Illuminate\Pagination\LengthAwarePaginator
    {
        return AuditLog::where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    /**
     * Get recent audit logs
     */
    public static function getRecentLogs(int $days = 7, int $limit = 100): \Illuminate\Pagination\LengthAwarePaginator
    {
        return AuditLog::recent($days)
            ->paginate($limit);
    }

    /**
     * Get user activity
     */
    public static function getUserActivity(int $userId, int $limit = 50): \Illuminate\Pagination\LengthAwarePaginator
    {
        return AuditLog::byUser($userId)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }
}

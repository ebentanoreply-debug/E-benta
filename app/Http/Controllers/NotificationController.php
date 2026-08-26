<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount()
    {
        $count = Auth::user()->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }

    /**
     * Open a notification, mark as read, and redirect to target destination
     */
    public function open(Notification $notification)
    {
        if (Auth::id() !== $notification->user_id) {
            abort(403, 'Unauthorized');
        }

        $notification->markAsRead();

        return redirect($notification->target_url);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        if (Auth::id() !== $notification->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        // Get updated unread count
        $unreadCount = Auth::user()->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
            'notification_id' => $notification->id,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        // Get updated unread count
        $unreadCount = Auth::user()->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy(Notification $notification)
    {
        if (Auth::id() !== $notification->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->delete();

        // Get updated unread count
        $unreadCount = Auth::user()->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted',
            'notification_id' => $notification->id,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Get recent notifications (both read and unread, prioritize unread)
     */
    public function recent()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('is_read', 'asc') // Unread first (false = 0, true = 1)
            ->orderBy('created_at', 'desc') // Then by date (newest first)
            ->take(10)
            ->get();

        return response()->json($notifications);
    }
}

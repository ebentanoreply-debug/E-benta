<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

// Set up the application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

// Get the first user
$user = User::first();

if (!$user) {
    echo "No users found. Creating test user...\n";
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@test.com',
        'password' => bcrypt('password'),
        'role' => 'buyer',
        'email_verified_at' => now(),
    ]);
}

echo "User ID: " . $user->id . "\n";
echo "User Email: " . $user->email . "\n\n";

// Create test notifications
echo "Creating test notifications...\n";
for ($i = 1; $i <= 3; $i++) {
    Notification::create([
        'user_id' => $user->id,
        'type' => 'test_notification',
        'title' => 'Test Notification ' . $i,
        'message' => 'This is test notification ' . $i,
        'is_read' => false,
    ]);
}

echo "Notifications created.\n\n";

// Get all notifications
$notifications = $user->notifications()->get();
echo "Total notifications for user: " . $notifications->count() . "\n";
echo "Unread notifications: " . $notifications->where('is_read', false)->count() . "\n\n";

// Test marking all as read
echo "Marking all as read...\n";
$user->notifications()
    ->where('is_read', false)
    ->update([
        'is_read' => true,
        'read_at' => now(),
    ]);

// Verify
$notifications = $user->notifications()->get();
echo "After marking all as read:\n";
echo "Unread notifications: " . $notifications->where('is_read', false)->count() . "\n\n";

// Test recent endpoint
echo "Testing recent endpoint...\n";
$recentNotifications = $user->notifications()
    ->orderBy('is_read', 'asc')
    ->orderBy('created_at', 'desc')
    ->take(10)
    ->get();

echo "Recent notifications count: " . $recentNotifications->count() . "\n";
foreach ($recentNotifications as $notif) {
    echo "  - ID: " . $notif->id . " | is_read: " . ($notif->is_read ? 'true' : 'false') . " | Title: " . $notif->title . "\n";
}

echo "\n";
echo "JSON output:\n";
echo json_encode($recentNotifications, JSON_PRETTY_PRINT) . "\n";

// Count unread in JSON response
$unreadCount = collect($recentNotifications)->filter(function($n) {
    return !$n['is_read'];
})->count();
echo "\nUnread count from JSON-like array: " . $unreadCount . "\n";

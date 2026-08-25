<?php

// Load the application
$app = require __DIR__ . '/bootstrap/app.php';

// Bind the request to the application
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\DB;

// Get notifications from database
$notifications = DB::table('notifications')->limit(10)->get();

echo "=== NOTIFICATIONS TABLE DEBUG ===\n\n";
echo "Total notifications found: " . count($notifications) . "\n\n";

if (count($notifications) > 0) {
    echo "Sample notifications:\n";
    foreach ($notifications as $notif) {
        echo "  ID: " . $notif->id . "\n";
        echo "  User ID: " . $notif->user_id . "\n";
        echo "  Title: " . $notif->title . "\n";
        echo "  is_read: " . var_export($notif->is_read, true) . " (Type: " . gettype($notif->is_read) . ")\n";
        echo "  read_at: " . ($notif->read_at ?? 'NULL') . "\n";
        echo "  ---\n";
    }
} else {
    echo "No notifications in database.\n";
}

echo "\n=== CHECKING UNREAD COUNT ===\n";
$unreadCount = DB::table('notifications')->where('is_read', '=', 0)->count();
echo "Unread (is_read = 0): $unreadCount\n";

$unreadCountFalse = DB::table('notifications')->where('is_read', '=', false)->count();
echo "Unread (is_read = false): $unreadCountFalse\n";

$unreadCountNull = DB::table('notifications')->whereNull('is_read')->count();
echo "Unread (is_read = NULL): $unreadCountNull\n";

$allCount = DB::table('notifications')->count();
echo "Total count: $allCount\n";

echo "\n=== JSON OUTPUT ===\n";
echo json_encode($notifications, JSON_PRETTY_PRINT);

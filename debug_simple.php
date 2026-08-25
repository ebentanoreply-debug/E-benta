<?php

use Illuminate\Support\Facades\DB;

echo "Script started\n";

try {
    $app = require __DIR__ . '/bootstrap/app.php';
    echo "App loaded\n";
    
    $app->make('Illuminate\Contracts\Http\Kernel')->handle(
        Illuminate\Http\Request::capture()
    );
    echo "Kernel bootstrapped\n";
    
    $count = DB::table('notifications')->count();
    echo "Notifications count: " . $count . "\n";
    
    if ($count > 0) {
        $first = DB::table('notifications')->first();
        echo "First notification:\n";
        echo "  ID: " . $first->id . "\n";
        echo "  is_read type: " . gettype($first->is_read) . "\n";
        echo "  is_read value: " . var_export($first->is_read, true) . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

<?php

use Database\Seeders\ProductsAndTransactionsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Seeds product listings, chronological audit logs, transactions below 10, messages, and notifications.
     */
    public function up(): void
    {
        $seeder = new ProductsAndTransactionsSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op
    }
};

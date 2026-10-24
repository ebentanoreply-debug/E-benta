<?php

use Database\Seeders\ProductsAndTransactionsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Guarantees test seller account, products, and 5 buyer offers are seeded on deployment.
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

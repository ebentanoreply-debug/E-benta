<?php

use Database\Seeders\ContactResponsesUsersSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Automatically seeds the 99 authentic thesis survey respondents on deployed environment.
     */
    public function up(): void
    {
        $seeder = new ContactResponsesUsersSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op to preserve inserted users
    }
};

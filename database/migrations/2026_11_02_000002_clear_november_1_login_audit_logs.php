<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Clears all login and logout audit logs created on November 1, 2026.
     */
    public function up(): void
    {
        if (Schema::hasTable('audit_logs')) {
            DB::table('audit_logs')
                ->whereIn('action', ['login', 'logout'])
                ->whereDate('created_at', '2026-11-01')
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Login audit logs are ephemeral session traces; irreversible once purged.
    }
};

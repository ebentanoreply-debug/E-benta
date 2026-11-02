<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Shifts audit logs created between 2026-10-31 and 2026-11-02 from UTC to Philippine Time (UTC+8).
     */
    public function up(): void
    {
        if (Schema::hasTable('audit_logs')) {
            DB::statement("UPDATE audit_logs 
                           SET created_at = DATE_ADD(created_at, INTERVAL 8 HOUR), 
                               updated_at = DATE_ADD(updated_at, INTERVAL 8 HOUR) 
                           WHERE created_at >= '2026-10-31 00:00:00' 
                             AND created_at < '2026-11-02 08:00:00'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('audit_logs')) {
            DB::statement("UPDATE audit_logs 
                           SET created_at = DATE_SUB(created_at, INTERVAL 8 HOUR), 
                               updated_at = DATE_SUB(updated_at, INTERVAL 8 HOUR) 
                           WHERE created_at >= '2026-10-31 08:00:00' 
                             AND created_at < '2026-11-02 16:00:00'");
        }
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('impact_logs', function (Blueprint $table) {
            $table->unique('offer_id', 'impact_logs_offer_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('impact_logs', function (Blueprint $table) {
            $table->dropUnique('impact_logs_offer_id_unique');
        });
    }
};
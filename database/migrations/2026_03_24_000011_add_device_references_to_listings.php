<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->foreignId('device_type_id')->nullable()->after('category')->constrained('device_types')->onDelete('set null');
            $table->foreignId('device_brand_id')->nullable()->after('device_type_id')->constrained('device_brands')->onDelete('set null');
            $table->foreignId('device_model_id')->nullable()->after('device_brand_id')->constrained('device_models')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['device_type_id', 'device_brand_id', 'device_model_id']);
            $table->dropColumn(['device_type_id', 'device_brand_id', 'device_model_id']);
        });
    }
};

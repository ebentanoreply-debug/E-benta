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
        Schema::table('users', function (Blueprint $table) {
            // Add role field: 'seller', 'buyer', 'admin'
            $table->enum('role', ['seller', 'buyer', 'admin'])->default('seller')->after('email');
            
            // Verification status for buyers/recyclers
            $table->boolean('is_verified')->default(false)->after('role');
            
            // Business-related fields
            $table->string('business_name')->nullable()->after('name');
            $table->text('business_description')->nullable()->after('business_name');
            $table->string('phone')->nullable()->after('business_description');
            
            // Impact metrics
            $table->decimal('total_impact_score', 10, 2)->default(0)->after('phone');
            $table->integer('items_processed')->default(0)->after('total_impact_score');
            $table->decimal('total_weight_diverted', 10, 2)->default(0)->comment('in kg')->after('items_processed');
            $table->decimal('total_co2_saved', 10, 2)->default(0)->comment('in kg')->after('total_weight_diverted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'is_verified',
                'business_name',
                'business_description',
                'phone',
                'total_impact_score',
                'items_processed',
                'total_weight_diverted',
                'total_co2_saved',
            ]);
        });
    }
};

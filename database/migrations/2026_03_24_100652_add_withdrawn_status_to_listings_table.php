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
            $table->enum('status', [
                'pending',
                'available',
                'matched',
                'in_transit',
                'delivered',
                'processed',
                'withdrawn',
            ])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'available',
                'matched',
                'in_transit',
                'delivered',
                'processed',
            ])->default('pending')->change();
        });
    }
};

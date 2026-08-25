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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label')->comment('e.g., Home, Office, Warehouse'); // Pickup, Dropoff, etc.
            $table->string('address_line_1'); // Street address
            $table->string('address_line_2')->nullable(); // Apartment, suite, etc.
            $table->string('city');
            $table->string('state')->nullable(); // Province, region
            $table->string('postal_code');
            $table->string('country')->default('Philippines');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('special_instructions')->nullable(); // Gate code, buzzer, etc.
            $table->boolean('is_primary')->default(false)->index(); // Default address for this user
            $table->enum('type', ['pickup', 'dropoff', 'both'])->default('both')->comment('Type of address for transactions');
            $table->timestamps();
            
            // Foreign key index for faster queries
            $table->index('user_id');
            $table->index(['user_id', 'is_primary']);
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};

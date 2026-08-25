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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Item information
            $table->string('category'); // e.g., 'Laptop', 'Smartphone', 'Desktop'
            $table->enum('condition', ['working', 'minor_damage', 'major_damage', 'non_functional'])->default('working');
            $table->text('description');
            $table->decimal('estimated_weight', 5, 2)->nullable()->comment('in kg');
            
            // Listing details
            $table->enum('intended_action', ['sell', 'donate', 'recycle'])->default('sell');
            $table->decimal('suggested_price', 10, 2)->nullable();
            $table->json('photos')->nullable(); // Array of photo URLs
            
            // Status: pending, available, matched, in_transit, delivered, processed
            $table->enum('status', [
                'pending',
                'available',
                'matched',
                'in_transit',
                'delivered',
                'processed',
            ])->default('pending');
            
            // Matching information
            $table->foreignId('matched_buyer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('matched_at')->nullable();
            $table->timestamp('pickup_scheduled_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            
            // Environmental metrics (calculated)
            $table->decimal('carbon_footprint', 10, 2)->nullable()->comment('in kg CO2');
            $table->string('material_composition')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('user_id');
            $table->index('status');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};

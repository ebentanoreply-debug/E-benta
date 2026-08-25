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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            
            // Offer details
            $table->decimal('bid_amount', 10, 2);
            $table->enum('proposed_method', ['repair', 'harvest', 'refine', 'dispose'])->comment('repair=Repair for resale, harvest=Component recovery, refine=Material extraction');
            $table->text('notes')->nullable();
            
            // Pickup information
            $table->datetime('proposed_pickup_date');
            $table->text('pickup_location')->nullable();
            
            // Status: pending, accepted, rejected, cancelled, completed
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled', 'completed'])->default('pending');
            
            $table->timestamp('responded_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('listing_id');
            $table->index('buyer_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};

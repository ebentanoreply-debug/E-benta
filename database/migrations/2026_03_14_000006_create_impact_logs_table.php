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
        Schema::create('impact_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            
            // Device information
            $table->string('device_category');
            $table->decimal('device_weight', 5, 2)->comment('in kg');
            
            // Processing outcome
            $table->enum('processing_method', ['repair', 'harvest', 'refine', 'dispose'])->comment('How the device was processed');
            
            // Environmental impact metrics
            $table->decimal('co2_saved', 10, 2)->comment('in kg CO2');
            $table->decimal('landfill_diverted_weight', 10, 2)->comment('in kg');
            $table->decimal('materials_recovered_weight', 10, 2)->nullable()->comment('in kg');
            
            // Detailed material recovery
            $table->decimal('gold_recovered', 5, 4)->nullable()->comment('in kg');
            $table->decimal('copper_recovered', 5, 2)->nullable()->comment('in kg');
            $table->decimal('plastic_recovered', 5, 2)->nullable()->comment('in kg');
            $table->decimal('aluminum_recovered', 5, 2)->nullable()->comment('in kg');
            $table->decimal('rare_earth_recovered', 5, 4)->nullable()->comment('in kg');
            
            // Certification
            $table->string('certificate_path')->nullable();
            $table->string('certificate_token')->nullable()->unique(); // For certificate verification
            
            // Status
            $table->enum('status', ['pending', 'verified', 'certified'])->default('pending');
            
            $table->timestamp('certified_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('listing_id');
            $table->index('seller_id');
            $table->index('buyer_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impact_logs');
    }
};

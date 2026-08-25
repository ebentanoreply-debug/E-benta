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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            
            // Reporter information
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            
            // Polymorphic relationship for reporting listings, offers, or users
            $table->string('reportable_type'); // 'App\Models\Listing', 'App\Models\Offer', 'App\Models\User'
            $table->unsignedBigInteger('reportable_id');
            
            // Report details
            $table->enum('reason', [
                'inappropriate_content',
                'scam_fraud',
                'offensive_language',
                'harassment_abuse',
                'spam',
                'false_information',
                'fake_listing',
                'broken_item_misrepresentation',
                'seller_unresponsive',
                'suspicious_behavior',
                'other'
            ]);
            
            $table->text('description')->nullable();
            
            // Report status
            $table->enum('status', [
                'pending',
                'under_review',
                'resolved',
                'dismissed'
            ])->default('pending')->index();
            
            // Admin information
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->foreign('reviewed_by')->references('id')->on('users')->nullableOnDelete();
            
            $table->text('admin_notes')->nullable();
            
            $table->timestamp('reviewed_at')->nullable();
            
            // Action taken
            $table->enum('action_taken', [
                'none',
                'warning_sent',
                'content_removed',
                'user_suspended',
                'user_banned',
                'listing_removed'
            ])->default('none')->nullable();
            
            // Metadata
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes for common queries
            $table->index(['user_id', 'created_at']);
            $table->index(['status', 'created_at']);
            $table->index(['reportable_type', 'reportable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

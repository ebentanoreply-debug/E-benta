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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reviewer_id'); // User leaving the review
            $table->unsignedBigInteger('reviewee_id'); // User being reviewed
            $table->unsignedBigInteger('offer_id'); // Reference to the completed transaction
            $table->integer('rating'); // 1-5 stars
            $table->string('title'); // Review title
            $table->text('comment')->nullable(); // Review comment
            $table->enum('review_type', ['buyer', 'seller']); // Is reviewer a buyer or seller?
            $table->json('attributes')->nullable(); // JSON for detailed ratings (communication, professionalism, etc.)
            $table->boolean('is_verified')->default(false); // Verified purchase
            $table->timestamps();
            
            // Indexes
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->index('reviewer_id');
            $table->index('reviewee_id');
            $table->index('offer_id');
            $table->index('rating');
            $table->index('created_at');
            
            // Unique constraint: one review per reviewer per offer
            $table->unique(['reviewer_id', 'offer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

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
        Schema::create('device_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. 'Laptop', 'Smartphone', 'Tablet'
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Font Awesome icon class
            $table->timestamps();
        });

        Schema::create('device_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. 'Apple', 'Samsung', 'Dell'
            $table->text('description')->nullable();
            $table->string('logo_url')->nullable();
            $table->timestamps();
        });

        Schema::create('device_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_type_id')->constrained('device_types')->onDelete('cascade');
            $table->foreignId('device_brand_id')->constrained('device_brands')->onDelete('cascade');
            $table->string('model_name')->unique(); // e.g. 'iPhone 13 Pro'
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_models');
        Schema::dropIfExists('device_brands');
        Schema::dropIfExists('device_types');
    }
};

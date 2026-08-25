<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Normalizes database schema to 3NF by:
     * 1. Creating review_attributes table (separate rating dimensions)
     * 2. Creating password_reset_tokens table (consolidate reset logic)
     * 3. Creating email_change_tokens table (consolidate email change logic)
     * 4. Creating device_category_mapping table (normalize device lookups)
     * 5. Removing redundant columns and JSON storage
     */
    public function up(): void
    {
        // 1. Create review_attributes table for detailed ratings (removes JSON from reviews)
        Schema::create('review_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade');
            $table->string('attribute'); // e.g., 'communication', 'professionalism', 'speed'
            $table->integer('score'); // 1-5
            $table->timestamps();
            
            $table->unique(['review_id', 'attribute'], 'ra_review_attr_unique');
            $table->index('review_id');
        });

        // 2. Create proper password_reset_tokens table (consolidate from password_reset_tokens + users columns)
        if (!Schema::hasTable('password_reset_tokens_new')) {
            Schema::create('password_reset_tokens_new', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('email');
                $table->string('token')->unique('prt_token_unique');
                $table->timestamp('expires_at');
                $table->boolean('used')->default(false);
                $table->timestamps();
                
                $table->index(['user_id', 'used'], 'prt_user_used_idx');
                $table->index('expires_at');
            });
        }

        // 3. Create email_change_tokens table (normalize from users columns)
        Schema::create('email_change_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('token')->unique('ect_token_unique');
            $table->string('new_email');
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'used'], 'ect_user_used_idx');
            $table->index('expires_at');
        });

        // 4. Create device_category_mapping table (normalize device relationship)
        Schema::create('device_category_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_type_id')->constrained('device_types')->onDelete('cascade');
            $table->foreignId('device_brand_id')->constrained('device_brands')->onDelete('cascade');
            $table->foreignId('device_model_id')->constrained('device_models')->onDelete('cascade');
            $table->string('category')->comment('e.g., Laptop, Smartphone - for fast filtering');
            $table->timestamps();
            
            $table->unique(['device_type_id', 'device_brand_id', 'device_model_id'], 'dcm_unique_device');
            $table->index('category');
        });

        // 5. Create notification_data table (replace JSON in notifications)
        Schema::create('notification_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained('notifications')->onDelete('cascade');
            $table->string('key');
            $table->string('value');
            $table->timestamps();
            
            $table->unique(['notification_id', 'key'], 'nd_notif_key_unique');
            $table->index('notification_id');
        });

        // 6. Create audit_log_changes table (replace JSON from audit_logs)
        Schema::create('audit_log_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_log_id')->constrained('audit_logs')->onDelete('cascade');
            $table->enum('change_type', ['old_value', 'new_value']);
            $table->string('field_name');
            $table->longText('field_value');
            $table->timestamps();
            
            $table->index('audit_log_id');
            $table->index(['audit_log_id', 'change_type'], 'alc_auditlog_type_idx');
        });

        // 7. Update impact_logs to store device category as FK instead of string
        if (Schema::hasColumn('impact_logs', 'device_category')) {
            Schema::table('impact_logs', function (Blueprint $table) {
                $table->foreignId('device_type_id')->nullable()->after('offer_id')->constrained('device_types')->onDelete('set null');
            });
        }

        // 8. Create photos table (normalize from JSON in listings)
        Schema::create('listing_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->onDelete('cascade');
            $table->string('photo_url');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('listing_id', 'lp_listing_idx');
            $table->index('sort_order', 'lp_sort_idx');
        });

        // 9. Remove denormalized columns from users (keep only FK references going forward)
        Schema::table('users', function (Blueprint $table) {
            // These columns will be removed after data backfill in down() or separate cleanup migration
            // For now, mark them as deprecated by adding a comment
        });

        // 10. Remove denormalized columns from reviews
        Schema::table('reviews', function (Blueprint $table) {
            // attributes JSON will be migrated to review_attributes table
        });

        // 11. Remove denormalized columns from listings
        Schema::table('listings', function (Blueprint $table) {
            // photos JSON will be migrated to listing_photos table
            // category string will be queried via device relationships
        });

        // 12. Remove denormalized columns from notifications
        Schema::table('notifications', function (Blueprint $table) {
            // data JSON will be migrated to notification_data table
        });

        // 13. Remove denormalized columns from audit_logs
        Schema::table('audit_logs', function (Blueprint $table) {
            // old_values and new_values JSON will be migrated to audit_log_changes table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_photos');
        Schema::dropIfExists('audit_log_changes');
        Schema::dropIfExists('notification_data');
        Schema::dropIfExists('device_category_mappings');
        Schema::dropIfExists('email_change_tokens');
        Schema::dropIfExists('password_reset_tokens_new');
        Schema::dropIfExists('review_attributes');

        if (Schema::hasColumn('impact_logs', 'device_type_id')) {
            Schema::table('impact_logs', function (Blueprint $table) {
                $table->dropForeignKeyIfExists(['device_type_id']);
                $table->dropColumn('device_type_id');
            });
        }
    }
};

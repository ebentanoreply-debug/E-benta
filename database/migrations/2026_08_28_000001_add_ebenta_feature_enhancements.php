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
        // 1. Update users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'warning_count')) {
                $table->unsignedSmallInteger('warning_count')->default(0)->after('is_banned');
            }
            if (!Schema::hasColumn('users', 'suspended_until')) {
                $table->timestamp('suspended_until')->nullable()->after('warning_count');
            }
            if (!Schema::hasColumn('users', 'id_type')) {
                $table->string('id_type', 100)->nullable()->after('suspended_until');
            }
            if (!Schema::hasColumn('users', 'id_number')) {
                $table->string('id_number', 100)->nullable()->after('id_type');
            }
            if (!Schema::hasColumn('users', 'id_photo_url')) {
                $table->string('id_photo_url', 500)->nullable()->after('id_number');
            }
            if (!Schema::hasColumn('users', 'id_selfie_url')) {
                $table->string('id_selfie_url', 500)->nullable()->after('id_photo_url');
            }
            if (!Schema::hasColumn('users', 'id_verification_status')) {
                $table->string('id_verification_status', 50)->default('unsubmitted')->after('id_selfie_url');
            }
            if (!Schema::hasColumn('users', 'id_rejection_reason')) {
                $table->text('id_rejection_reason')->nullable()->after('id_verification_status');
            }
            if (!Schema::hasColumn('users', 'id_submitted_at')) {
                $table->timestamp('id_submitted_at')->nullable()->after('id_rejection_reason');
            }
        });

        // 2. Update listings table
        Schema::table('listings', function (Blueprint $table) {
            if (!Schema::hasColumn('listings', 'listing_type')) {
                $table->string('listing_type', 50)->default('single')->after('user_id'); // 'single' or 'bulk_lot'
            }
            if (!Schema::hasColumn('listings', 'lot_item_count')) {
                $table->unsignedInteger('lot_item_count')->nullable()->after('listing_type');
            }
            if (!Schema::hasColumn('listings', 'handover_preference')) {
                $table->string('handover_preference', 50)->default('both')->after('intended_action'); // 'pickup_only', 'meetup_only', 'both'
            }
        });

        // 3. Update offers table
        Schema::table('offers', function (Blueprint $table) {
            if (!Schema::hasColumn('offers', 'cancellation_reason')) {
                $table->text('cancellation_reason')->nullable()->after('status');
            }
            if (!Schema::hasColumn('offers', 'handover_method')) {
                $table->string('handover_method', 50)->default('pickup')->after('proposed_method'); // 'pickup' or 'meetup'
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'warning_count',
                'suspended_until',
                'id_type',
                'id_number',
                'id_photo_url',
                'id_selfie_url',
                'id_verification_status',
                'id_rejection_reason',
                'id_submitted_at',
            ]);
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn([
                'listing_type',
                'lot_item_count',
                'handover_preference',
            ]);
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn([
                'cancellation_reason',
                'handover_method',
            ]);
        });
    }
};

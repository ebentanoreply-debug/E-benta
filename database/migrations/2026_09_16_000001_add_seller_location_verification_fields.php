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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'id_back_photo_url')) {
                $table->string('id_back_photo_url', 500)->nullable()->after('id_photo_url');
            }
            if (!Schema::hasColumn('users', 'proof_of_address_url')) {
                $table->string('proof_of_address_url', 500)->nullable()->after('id_selfie_url');
            }
            if (!Schema::hasColumn('users', 'proof_of_address_type')) {
                $table->string('proof_of_address_type', 100)->nullable()->after('proof_of_address_url');
            }
            if (!Schema::hasColumn('users', 'address_line_1')) {
                $table->string('address_line_1', 255)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'barangay')) {
                $table->string('barangay', 100)->nullable()->after('address_line_1');
            }
            if (!Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code', 20)->nullable()->after('address_province');
            }
            if (!Schema::hasColumn('users', 'location_notes')) {
                $table->text('location_notes')->nullable()->after('postal_code');
            }
            if (!Schema::hasColumn('users', 'location_verified_at')) {
                $table->timestamp('location_verified_at')->nullable()->after('id_submitted_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'id_back_photo_url',
                'proof_of_address_url',
                'proof_of_address_type',
                'address_line_1',
                'barangay',
                'postal_code',
                'location_notes',
                'location_verified_at',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

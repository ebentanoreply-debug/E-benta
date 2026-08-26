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
            // Location fields
            $table->string('address_city', 100)->nullable()->after('phone');
            $table->string('address_province', 100)->nullable()->after('address_city');

            // Payment preferences
            $table->string('gcash_number', 20)->nullable()->after('address_province');
            $table->string('bank_name', 100)->nullable()->after('gcash_number');
            $table->string('bank_account_number', 50)->nullable()->after('bank_name');

            // Seller preferences
            $table->string('preferred_action', 20)->nullable()->default('sell')->after('bank_account_number');

            // Granular notification preferences
            $table->boolean('notify_new_offer')->default(true)->after('preferred_action');
            $table->boolean('notify_transaction_complete')->default(true)->after('notify_new_offer');
            $table->boolean('notify_new_message')->default(true)->after('notify_transaction_complete');
            $table->boolean('notify_admin_updates')->default(false)->after('notify_new_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'address_city',
                'address_province',
                'gcash_number',
                'bank_name',
                'bank_account_number',
                'preferred_action',
                'notify_new_offer',
                'notify_transaction_complete',
                'notify_new_message',
                'notify_admin_updates',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add email change verification columns
            $table->string('email_change_token')->nullable()->after('email');
            $table->string('email_change_new_email')->nullable()->after('email_change_token');
            $table->timestamp('email_change_expires_at')->nullable()->after('email_change_new_email');
            $table->index('email_change_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email_change_token', 'email_change_new_email', 'email_change_expires_at']);
        });
    }
};

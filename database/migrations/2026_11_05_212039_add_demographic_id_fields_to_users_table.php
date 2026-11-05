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
            $table->string('birth_date', 50)->nullable()->after('id_number');
            $table->string('birth_place', 150)->nullable()->after('birth_date');
            $table->string('gender', 20)->nullable()->after('birth_place');
            $table->string('marital_status', 30)->nullable()->after('gender');
            $table->string('blood_type', 10)->nullable()->after('marital_status');
            $table->string('id_card_serial', 100)->nullable()->after('blood_type');
            $table->text('id_raw_qr_data')->nullable()->after('id_card_serial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'birth_date',
                'birth_place',
                'gender',
                'marital_status',
                'blood_type',
                'id_card_serial',
                'id_raw_qr_data',
            ]);
        });
    }
};

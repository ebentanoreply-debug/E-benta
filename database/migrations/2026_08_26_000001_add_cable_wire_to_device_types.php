<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert Cables & Wires to device_types if not already present
        $existing = DB::table('device_types')->where('name', 'Cables & Wires')->orWhere('name', 'Cable / Wire')->first();
        if (!$existing) {
            DB::table('device_types')->insert([
                'name' => 'Cables & Wires',
                'icon' => 'fa-plug',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('device_types')->where('name', 'Cables & Wires')->orWhere('name', 'Cable / Wire')->delete();
    }
};

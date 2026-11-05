<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updates JIMBOY MELICAN (User #390002) id_number to match his original PhilSys Card Number: 3592-5085-7612-9581
     */
    public function up(): void
    {
        DB::table('users')->where('id', 390002)->update([
            'id_number' => '3592-5085-7612-9581',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('id', 390002)->update([
            'id_number' => '7051-1331-2787-2982',
        ]);
    }
};


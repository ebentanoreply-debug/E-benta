<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updates all occurrences of 'Dalandan' barangay to official San Carlos City barangay 'Agdao'.
     */
    public function up(): void
    {
        // 1. Update users barangay
        DB::table('users')
            ->where('barangay', 'like', '%Dalandan%')
            ->update([
                'barangay' => 'Agdao',
            ]);

        // 2. Update users address lines if any mention Dalandan
        DB::statement("
            UPDATE users 
            SET address_line_1 = REPLACE(address_line_1, 'Dalandan', 'Agdao') 
            WHERE address_line_1 LIKE '%Dalandan%'
        ");

        // 3. Update addresses table
        DB::statement("
            UPDATE addresses 
            SET address_line_1 = REPLACE(address_line_1, 'Dalandan', 'Agdao') 
            WHERE address_line_1 LIKE '%Dalandan%'
        ");

        DB::statement("
            UPDATE addresses 
            SET address_line_2 = REPLACE(address_line_2, 'Dalandan', 'Agdao') 
            WHERE address_line_2 LIKE '%Dalandan%'
        ");

        // 4. Update listings pickup address
        DB::statement("
            UPDATE listings 
            SET pickup_address = REPLACE(pickup_address, 'Dalandan', 'Agdao') 
            WHERE pickup_address LIKE '%Dalandan%'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Historical normalization
    }
};


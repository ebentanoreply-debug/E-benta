<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updates Jerwin Lomibao's location to Barangay Baldog.
     */
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            $user = DB::table('users')->where('email', 'lomibaojerwin@gmail.com')->first();
            if ($user) {
                DB::table('users')->where('id', $user->id)->update([
                    'barangay' => 'Baldog',
                    'address_line_1' => 'Purok 2, Baldog',
                    'address_city' => 'San Carlos City',
                    'address_province' => 'Pangasinan',
                    'postal_code' => '2420',
                ]);

                if (Schema::hasTable('addresses')) {
                    $hasLine2 = Schema::hasColumn('addresses', 'address_line_2');
                    $addrData = [
                        'address_line_1' => 'Purok 2, Baldog',
                        'city' => 'San Carlos City',
                        'postal_code' => '2420',
                    ];
                    if ($hasLine2) {
                        $addrData['address_line_2'] = 'Baldog';
                    }
                    if (Schema::hasColumn('addresses', 'state')) {
                        $addrData['state'] = 'Pangasinan';
                    }

                    DB::table('addresses')->where('user_id', $user->id)->update($addrData);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversible if needed
    }
};

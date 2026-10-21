<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Removes all Purok, Sitio, and related road/proper prefixes from user addresses,
     * so that addresses in rural barangays display only their barangay.
     */
    public function up(): void
    {
        // 1. Clear address_line_1 in users table for any address containing Purok, Sitio, Proper, or local Road/Highway
        DB::table('users')
            ->where(function ($q) {
                $q->where('address_line_1', 'LIKE', '%Purok%')
                  ->orWhere('address_line_1', 'LIKE', '%Sitio%')
                  ->orWhere('address_line_1', 'LIKE', '%Proper%')
                  ->orWhere('address_line_1', 'LIKE', '%Road%')
                  ->orWhere('address_line_1', 'LIKE', '%Highway%');
            })
            ->update([
                'address_line_1' => null,
            ]);

        // 2. In addresses table, replace any Purok/Sitio/Proper/Road address_line_1 with the Barangay name
        if (Schema::hasTable('addresses')) {
            $userAddresses = DB::table('addresses')
                ->where(function ($q) {
                    $q->where('address_line_1', 'LIKE', '%Purok%')
                      ->orWhere('address_line_1', 'LIKE', '%Sitio%')
                      ->orWhere('address_line_1', 'LIKE', '%Proper%')
                      ->orWhere('address_line_1', 'LIKE', '%Road%')
                      ->orWhere('address_line_1', 'LIKE', '%Highway%');
                })
                ->get();

            foreach ($userAddresses as $addr) {
                $user = DB::table('users')->where('id', $addr->user_id)->first();
                $barangay = $user->barangay ?? '';
                $brgyLabel = str_starts_with(trim($barangay), 'Brgy.') ? $barangay : 'Brgy. ' . $barangay;

                DB::table('addresses')->where('id', $addr->id)->update([
                    'address_line_1' => $brgyLabel ?: 'San Carlos City',
                    'address_line_2' => null,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op
    }
};

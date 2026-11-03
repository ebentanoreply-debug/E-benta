<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Removes fake street names (e.g., Roxas Blvd, Aurora Blvd) from rural barangays,
     * ensuring rural users display clean, accurate official barangay addresses
     * (e.g., 'Brgy. Gamata, San Carlos City, Pangasinan 2420'), while preserving
     * authentic street names for Poblacion (town center) barangays.
     */
    public function up(): void
    {
        $poblacionBarangays = [
            'Rizal',
            'Brgy. Rizal',
            'Mabini',
            'Brgy. Mabini',
            'Palaris',
            'Brgy. Palaris',
            'Bugallon-Posadas',
            'Brgy. Bugallon-Posadas',
            'Bugallon',
            'Posadas',
            'Lucban',
            'Brgy. Lucban',
            'Padilla',
            'Brgy. Padilla',
            'Bonifacio',
            'Brgy. Bonifacio',
        ];

        // 1. Correct mismatched streets for Poblacion users
        DB::table('users')->where('email', 'aguilar.karen57@hotmail.com')->update(['address_line_1' => null]);
        DB::table('users')->where('barangay', 'like', '%Rizal%')->where('address_line_1', 'like', '%Roxas%')->update(['address_line_1' => '45 Rizal Avenue']);
        DB::table('users')->where('barangay', 'like', '%Bugallon%')->where('address_line_1', 'like', '%Bonifacio%')->update(['address_line_1' => '18 Posadas Street']);
        DB::table('users')->where('barangay', 'like', '%Padilla%')->where('address_line_1', 'like', '%Zamora%')->update(['address_line_1' => '24 Montemayor Street']);
        DB::table('users')->where('barangay', 'like', '%Palaris%')->where('address_line_1', 'like', '%Gomez%')->update(['address_line_1' => '28 Palaris Street']);

        // 2. Clear fake streets across all rural/non-Poblacion barangays in users table
        $ruralUsers = DB::table('users')->get()->filter(function ($user) use ($poblacionBarangays) {
            $rawBrgy = trim($user->barangay ?? '');
            return !in_array($rawBrgy, $poblacionBarangays, true);
        });

        foreach ($ruralUsers as $u) {
            DB::table('users')->where('id', $u->id)->update([
                'address_line_1' => null,
            ]);
        }

        // 3. Standardize addresses table for all rural users to official 'Brgy. [Name]'
        if (Schema::hasTable('addresses')) {
            $allAddresses = DB::table('addresses')->get();

            foreach ($allAddresses as $addr) {
                $user = DB::table('users')->where('id', $addr->user_id)->first();
                if (!$user) {
                    continue;
                }

                $rawBrgy = trim($user->barangay ?? '');
                $isPoblacion = in_array($rawBrgy, $poblacionBarangays, true);
                $brgyLabel = str_starts_with($rawBrgy, 'Brgy.') ? $rawBrgy : ($rawBrgy ? 'Brgy. ' . $rawBrgy : 'San Carlos City');

                if ($isPoblacion && $user->address_line_1) {
                    DB::table('addresses')->where('id', $addr->id)->update([
                        'address_line_1' => $user->address_line_1,
                        'address_line_2' => $brgyLabel,
                    ]);
                } else {
                    DB::table('addresses')->where('id', $addr->id)->update([
                        'address_line_1' => $brgyLabel,
                        'address_line_2' => null,
                    ]);
                }
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

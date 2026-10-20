<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updates Kris Aquino to Brgy. Bonifacio and customizes buyer locations.
     */
    public function up(): void
    {
        $buyers = [
            'krisaquino817@gmail.com' => [
                'role' => 'buyer',
                'address_line_1' => 'Malong Street',
                'barangay' => 'Bonifacio',
                'address_city' => 'San Carlos City',
                'address_province' => 'Pangasinan',
                'postal_code' => '2420',
            ],
            'Abeaustria@gmail.com' => [
                'role' => 'buyer',
                'address_line_1' => 'Purok 1, San Juan',
                'barangay' => 'San Juan',
                'address_city' => 'San Carlos City',
                'address_province' => 'Pangasinan',
                'postal_code' => '2420',
            ],
            'lomibaojerwin@gmail.com' => [
                'role' => 'buyer',
                'address_line_1' => 'Purok 2, San Juan',
                'barangay' => 'San Juan',
                'address_city' => 'San Carlos City',
                'address_province' => 'Pangasinan',
                'postal_code' => '2420',
            ],
            'jimmybeltran@gmail.com' => [
                'role' => 'buyer',
                'address_line_1' => 'Sitio Agtas',
                'barangay' => 'San Juan',
                'address_city' => 'San Carlos City',
                'address_province' => 'Pangasinan',
                'postal_code' => '2420',
            ],
            'benignogarcia23@gmail.com' => [
                'role' => 'buyer',
                'address_line_1' => 'Purok 1, Doyong',
                'barangay' => 'Doyong',
                'address_city' => 'San Carlos City',
                'address_province' => 'Pangasinan',
                'postal_code' => '2420',
            ],
            'Benignogarcia@gmail.com' => [
                'role' => 'buyer',
                'address_line_1' => 'Purok 1, Doyong',
                'barangay' => 'Doyong',
                'address_city' => 'San Carlos City',
                'address_province' => 'Pangasinan',
                'postal_code' => '2420',
            ],
        ];

        foreach ($buyers as $email => $data) {
            DB::table('users')->where('email', $email)->update($data);

            $user = DB::table('users')->where('email', $email)->first();
            if ($user && DB::getSchemaBuilder()->hasTable('addresses')) {
                DB::table('addresses')->where('user_id', $user->id)->update([
                    'address_line_1' => $data['address_line_1'],
                    'address_line_2' => 'Brgy. ' . $data['barangay'],
                    'city' => $data['address_city'],
                    'state' => $data['address_province'],
                    'postal_code' => $data['postal_code'],
                ]);
            }
        }

        // Also clean up any lingering store names
        DB::table('users')
            ->whereNotNull('business_name')
            ->update(['business_name' => null, 'business_description' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op
    }
};

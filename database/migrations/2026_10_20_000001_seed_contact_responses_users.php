<?php

use Database\Seeders\ContactResponsesUsersSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Automatically seeds the 99 authentic thesis survey respondents on deployed environment.
     */
    public function up(): void
    {
        $seeder = new ContactResponsesUsersSeeder();
        $seeder->run();

        // Ensure legacy dummy store names are cleared
        \Illuminate\Support\Facades\DB::table('users')
            ->whereNotNull('business_name')
            ->update(['business_name' => null, 'business_description' => null]);

        // Explicit buyer locations requested for thesis defense
        \Illuminate\Support\Facades\DB::table('users')->where('email', 'krisaquino817@gmail.com')->update([
            'role' => 'buyer',
            'address_line_1' => 'Malong Street',
            'barangay' => 'Bonifacio',
            'address_city' => 'San Carlos City',
            'address_province' => 'Pangasinan',
            'postal_code' => '2420',
        ]);

        \Illuminate\Support\Facades\DB::table('users')->where('email', 'Abeaustria@gmail.com')->update([
            'role' => 'buyer',
            'address_line_1' => 'Purok 1, San Juan',
            'barangay' => 'San Juan',
            'address_city' => 'San Carlos City',
            'address_province' => 'Pangasinan',
            'postal_code' => '2420',
        ]);

        \Illuminate\Support\Facades\DB::table('users')->where('email', 'lomibaojerwin@gmail.com')->update([
            'role' => 'buyer',
            'address_line_1' => 'Purok 2, San Juan',
            'barangay' => 'San Juan',
            'address_city' => 'San Carlos City',
            'address_province' => 'Pangasinan',
            'postal_code' => '2420',
        ]);

        \Illuminate\Support\Facades\DB::table('users')->where('email', 'jimmybeltran@gmail.com')->update([
            'role' => 'buyer',
            'address_line_1' => 'Sitio Agtas',
            'barangay' => 'San Juan',
            'address_city' => 'San Carlos City',
            'address_province' => 'Pangasinan',
            'postal_code' => '2420',
        ]);

        \Illuminate\Support\Facades\DB::table('users')->whereIn('email', ['benignogarcia23@gmail.com', 'Benignogarcia@gmail.com'])->update([
            'role' => 'buyer',
            'address_line_1' => 'Purok 1, Doyong',
            'barangay' => 'Doyong',
            'address_city' => 'San Carlos City',
            'address_province' => 'Pangasinan',
            'postal_code' => '2420',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op to preserve inserted users
    }
};

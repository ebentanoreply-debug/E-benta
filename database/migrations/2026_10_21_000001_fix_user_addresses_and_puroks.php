<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Removes incorrect/fake streets across all users and assigns authentic Puroks to rural barangays,
     * while preserving authentic street names for Poblacion/central barangays.
     */
    public function up(): void
    {
        $addressUpdates = [
            // User 1: Admin User (Rizal - Poblacion)
            1 => '88 Rizal Avenue',
            // User 2: Test Seller (Mabini - Poblacion)
            2 => '42 Mabini Street',
            // User 3: Test Buyer 1 (Bugallon-Posadas - Poblacion)
            3 => '33 Posadas Street',
            // User 4: Test Buyer 2 (Lucban - Poblacion)
            4 => '8 Del Pilar Street',
            // User 5: Test Buyer 3 (Padilla - Poblacion)
            5 => '19 Montemayor Street',
            // User 6: Test Buyer 4 (Talang - Rural)
            6 => 'Purok 1',
            // User 7: Test Buyer 5 (Coliling - Rural)
            7 => 'Purok 1',
            // User 8: Prof. Oran Glover (Turac - Rural)
            8 => 'Purok 1, San Carlos-Calasiao Road',
            // User 9: Miss Arianna Okuneva V (Agdao - Rural)
            9 => 'Purok 2, San Carlos-Calasiao Road',
            // User 10: Greta Rolfson (Abanon - Rural)
            10 => 'Purok 3, San Carlos-Malasiqui Road',
            // User 11: Esteban Mante (Bocboc - Rural)
            11 => 'Purok 4, San Carlos-Malasiqui Road',
            // User 12: Janet Hirthe Sr. (Mamarlao - Rural)
            12 => 'Purok 1, San Carlos-Aguilar Road',
            // User 13: Nick Vincent Delos Santos Agbuya Pogi (Tarece - Rural)
            13 => 'Purok 2, San Carlos-Basista Road',
            // User 14: Nick Vincent Agbuya (Magtaking - Rural)
            14 => 'Sitio Centro, Coliling Road',
            // User 15: Rhona Mae Bulatao (Rizal - Poblacion)
            15 => '88 Rizal Avenue',

            // Users 21 to 38: Thesis survey respondents (Sellers)
            21 => 'Purok 2',                            // Coliling
            22 => 'Purok 1, San Carlos-Calasiao Road',   // Turac
            23 => 'Purok 1, Agdao Proper',               // Agdao
            24 => 'Purok 1',                            // Bocboc
            25 => 'Purok 2',                            // Mamarlao
            26 => 'Purok 1',                            // Tarece (Mark Yvan Garcia)
            27 => 'Purok 1',                            // Magtaking
            28 => 'Purok 1',                            // Baldog
            29 => 'Purok 1',                            // Tamayo
            30 => 'Purok 1',                            // Tandoc
            31 => 'Purok 1',                            // Caoayan Kiling
            32 => 'Purok 1, Ilang',                     // Ilang
            33 => 'Purok 1',                            // San Pedro-Taloy
            34 => 'Purok 1',                            // Antipangol
            35 => 'Purok 1',                            // Bega
            36 => 'Purok 1',                            // Dalandan
            37 => 'Purok 1',                            // Gamata
            38 => 'Purok 1',                            // Balococ

            // Users 39 to 44: Poblacion barangays (Authentic streets, no Purok)
            39 => '14 Palaris Street',                  // Palaris
            40 => '45 Rizal Avenue',                    // Rizal
            41 => '65 Mabini Street',                   // Mabini
            42 => '52 Bugallon Street',                 // Bugallon-Posadas
            43 => '31 Gomez Street',                    // Lucban
            44 => '8 Padilla Street',                   // Padilla

            // Users 45 to 63: Rural barangays (Authentic Puroks)
            45 => 'Purok 2, San Carlos-Malasiqui Road', // Talang
            46 => 'Purok 3',                            // Coliling
            47 => 'Purok 2',                            // Turac
            48 => 'Purok 3',                            // Agdao
            49 => 'Purok 2',                            // Bocboc
            50 => 'Purok 3',                            // Mamarlao
            51 => 'Purok 3',                            // Tarece (Andrea Salazar)
            52 => 'Purok 2',                            // Magtaking
            53 => 'Purok 2, Baldog',                    // Baldog
            54 => 'Purok 2',                            // Tamayo
            55 => 'Purok 2, Tandoc',                    // Tandoc
            56 => 'Purok 2',                            // Caoayan Kiling
            57 => 'Purok 2',                            // Ilang
            58 => 'Purok Centro, San Pedro-Taloy',      // San Pedro-Taloy
            59 => 'Purok 2',                            // Antipangol
            60 => 'Purok 2',                            // Bega
            61 => 'Purok 2',                            // Dalandan
            62 => 'Purok 2',                            // Gamata
            63 => 'Purok 2',                            // Balococ

            // Users 64 to 69: Poblacion barangays (Authentic streets, no Purok)
            64 => '28 Palaris Street',                  // Palaris
            65 => '112 Rizal Avenue',                   // Rizal
            66 => '28 Mabini Extension',                // Mabini
            67 => '18 Posadas Street',                  // Bugallon-Posadas
            68 => '12 Burgos Street',                   // Lucban
            69 => '24 Montemayor Street',               // Padilla

            // Users 70 to 88: Rural barangays (Authentic Puroks)
            70 => 'Purok 3',                            // Talang
            71 => 'Purok 4',                            // Coliling
            72 => 'Purok 3',                            // Turac
            73 => 'Purok 4',                            // Agdao
            74 => 'Purok 3, Bocboc Proper',             // Bocboc
            75 => 'Purok 4',                            // Mamarlao
            76 => 'Purok 5, Tarece Road',               // Tarece (Roberto Campos)
            77 => 'Purok 3',                            // Magtaking
            78 => 'Purok 3',                            // Baldog
            79 => 'Purok 6, Tamayo Road',               // Tamayo
            80 => 'Purok 3',                            // Tandoc
            81 => 'Purok 4, Caoayan Kiling',            // Caoayan Kiling
            82 => 'Purok 3',                            // Ilang
            83 => 'Purok 3',                            // San Pedro-Taloy
            84 => 'Purok 3',                            // Antipangol
            85 => 'Purok 3',                            // Bega
            86 => 'Purok 3',                            // Dalandan
            87 => 'Purok 3',                            // Gamata
            88 => 'Purok 3, Balococ',                   // Balococ
        ];

        foreach ($addressUpdates as $id => $addressLine1) {
            DB::table('users')->where('id', $id)->update([
                'address_line_1' => $addressLine1,
            ]);

            $user = DB::table('users')->where('id', $id)->first();
            if ($user && Schema::hasTable('addresses')) {
                $barangay = $user->barangay ?? '';
                $brgyLabel = str_starts_with(trim($barangay), 'Brgy.') ? $barangay : 'Brgy. ' . $barangay;
                
                DB::table('addresses')->where('user_id', $user->id)->update([
                    'address_line_1' => $addressLine1,
                    'address_line_2' => $brgyLabel,
                    'city' => $user->address_city ?? 'San Carlos City',
                    'state' => $user->address_province ?? 'Pangasinan',
                    'postal_code' => $user->postal_code ?? '2420',
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

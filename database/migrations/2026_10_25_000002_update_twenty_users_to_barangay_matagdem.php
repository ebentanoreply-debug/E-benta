<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updates the barangay of 20 users to 'Barangay matagdem'.
     */
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        // Specific set of 20 authentic respondent users to set to Barangay matagdem
        $preferredEmails = [
            'vincentagbuya67@gmail.com',
            'christianbautista@gmail.com',
            'marygracedelacruz@gmail.com',
            'kyleramos17@gmail.com',
            'miashielagraceuson@gmail.com',
            'darlyngarcia711@gmail.com',
            'daisygeegarcia21@gmail.com',
            'markyvangarcia@gmail.com',
            'munozantonette5@gmail.com',
            'dg3946922@gmail.com',
            'jhomaribeltran423@gmail.com',
            'jensenvincejavier@gmail.com',
            'markrejierosario12@gmail.com',
            'marklhemuel50@gmail.com',
            'mclestersoriano43@gmail.com',
            'carinojoseph2489@gmail.com',
            'shinjay.rak@gmail.com',
            'michellecarino4@gmail.com',
            'johnmichaelsantos@gmail.com',
            'joshuareyes23@gmail.com',
        ];

        // 1. Gather existing IDs from the preferred email list
        $targetUserIds = DB::table('users')
            ->whereIn('email', $preferredEmails)
            ->pluck('id')
            ->toArray();

        // 2. If fewer than 20 found, dynamically select more users to ensure exactly 20 users
        if (count($targetUserIds) < 20) {
            $needed = 20 - count($targetUserIds);
            $protectedEmails = [
                'admin@test.com',
                'seller@test.com',
                'jimmybeltran@gmail.com',
                'lomibaojerwin@gmail.com',
                'benignogarcia23@gmail.com',
                'Benignogarcia@gmail.com',
                'krisaquino817@gmail.com',
                'Abeaustria@gmail.com',
            ];

            $additionalIds = DB::table('users')
                ->whereNotIn('id', $targetUserIds)
                ->whereNotIn('email', $protectedEmails)
                ->where('role', '!=', 'admin')
                ->orderBy('id', 'asc')
                ->limit($needed)
                ->pluck('id')
                ->toArray();

            $targetUserIds = array_merge($targetUserIds, $additionalIds);
        }

        // Ensure we cap at exactly 20 users
        $targetUserIds = array_slice($targetUserIds, 0, 20);

        if (empty($targetUserIds)) {
            return;
        }

        // 3. Update the 20 users in users table
        foreach ($targetUserIds as $index => $userId) {
            $purokNumber = ($index % 7) + 1;
            DB::table('users')->where('id', $userId)->update([
                'barangay' => 'Barangay matagdem',
                'address_line_1' => "Purok {$purokNumber}, Matagdem Road",
                'address_city' => 'San Carlos City',
                'address_province' => 'Pangasinan',
                'postal_code' => '2420',
            ]);

            // Update user's listings pickup address if exists
            if (Schema::hasTable('listings')) {
                DB::table('listings')->where('user_id', $userId)->update([
                    'pickup_address' => 'Barangay matagdem, San Carlos City, Pangasinan 2420',
                ]);
            }

            // Update addresses table if linked
            if (Schema::hasTable('addresses')) {
                $addrData = [
                    'address_line_1' => "Purok {$purokNumber}, Matagdem Road",
                    'city' => 'San Carlos City',
                    'postal_code' => '2420',
                ];
                if (Schema::hasColumn('addresses', 'address_line_2')) {
                    $addrData['address_line_2'] = 'Barangay matagdem';
                }
                if (Schema::hasColumn('addresses', 'state')) {
                    $addrData['state'] = 'Pangasinan';
                }
                if (Schema::hasColumn('addresses', 'barangay')) {
                    $addrData['barangay'] = 'Barangay matagdem';
                }
                DB::table('addresses')->where('user_id', $userId)->update($addrData);
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

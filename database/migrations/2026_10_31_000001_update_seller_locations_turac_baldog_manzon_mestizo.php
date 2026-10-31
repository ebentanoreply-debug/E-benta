<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updates seller locations for Mia Shiela Grace Uson, Vincent Agbuya,
     * Mark Rejie Rosario, Mark Lhemuel Ramos, and Jensen Vince Javier.
     */
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        $updates = [
            'miashielagraceuson@gmail.com' => [
                'barangay' => 'Turac',
                'address_line_1' => 'Purok 3, Turac',
            ],
            'vincentagbuya67@gmail.com' => [
                'barangay' => 'Turac',
                'address_line_1' => 'Purok 2, Turac',
            ],
            'markrejierosario12@gmail.com' => [
                'barangay' => 'Baldog',
                'address_line_1' => 'Purok 4, Baldog',
            ],
            'marklhemuel50@gmail.com' => [
                'barangay' => 'Manzon',
                'address_line_1' => 'Purok 1, Manzon',
            ],
            'jensenvincejavier@gmail.com' => [
                'barangay' => 'Mestizo',
                'address_line_1' => 'Purok 2, Mestizo',
            ],
        ];

        foreach ($updates as $email => $data) {
            $user = DB::table('users')->where('email', $email)->first();
            if ($user) {
                DB::table('users')->where('id', $user->id)->update([
                    'barangay' => $data['barangay'],
                    'address_line_1' => $data['address_line_1'],
                ]);

                if (Schema::hasTable('addresses')) {
                    DB::table('addresses')->where('user_id', $user->id)->update([
                        'address_line_1' => $data['address_line_1'],
                        'address_line_2' => 'Brgy. ' . $data['barangay'],
                    ]);
                }

                if (Schema::hasTable('listings')) {
                    DB::table('listings')->where('user_id', $user->id)->update([
                        'pickup_address' => 'Brgy. ' . $data['barangay'] . ', San Carlos City, Pangasinan 2420',
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
        // No-op
    }
};

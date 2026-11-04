<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Reassigns 1 product listing to each of the 25 specified users,
     * taking products from other users while preserving protected users.
     */
    public function up(): void
    {
        // 23 candidate listings mapped to the 23 users who don't have listings yet
        // (Abraham Delos Reyes has #420006, Jeslyn Muñoz has #420007)
        $reassignedMap = [
            'jaymarkpayopay23@gmail.com' => 330007,
            'ariesaustria24@gmail.com' => 330010,
            'jovenmenor18@gmail.com' => 330012,
            'justinerosario07@gmail.com' => 330013,
            'arielserafica21@gmail.com' => 330014,
            'triciamaerosariol2@gmail.com' => 390004,
            'danicafajardo16@gmail.com' => 390005,
            'anthonysorio09@gmail.com' => 390006,
            'christiangonzales@gmail.com' => 390007,
            'alexanderbonggot@gmail.com' => 390008,
            'christianbeltran11@gmail.com' => 390009,
            'maritessaustria17@gmail.com' => 390010,
            'stevenhermogeno08@gmail.com' => 390011,
            'angelinehermogeno14@gmail.com' => 390012,
            'kevinbeltran23@gmail.com' => 390013,
            'janrexrovillos06@gmail.com' => 390014,
            'rexpascual19@gmail.com' => 390017,
            'jayannlomboy10@gmail.com' => 390018,
            'macmactigno26@gmail.com' => 390019,
            'johnmarkesteban03@gmail.com' => 390020,
            'renzbeltran19@gmail.com' => 390021,
            'zyrellmenor14@gmail.com' => 390022,
            'gabrielpioquinto05@gmail.com' => 390023,
        ];

        foreach ($reassignedMap as $email => $listingId) {
            $user = DB::table('users')->where('email', $email)->first();
            if (!$user) {
                continue;
            }

            // Update listing owner and pickup address to match user location
            DB::table('listings')->where('id', $listingId)->update([
                'user_id' => $user->id,
                'pickup_address' => 'Brgy. San Juan, San Carlos City, Pangasinan 2420',
            ]);

            // Update corresponding audit log
            DB::table('audit_logs')
                ->where('model_type', 'Listing')
                ->where('model_id', $listingId)
                ->where('action', 'listing_created')
                ->update([
                    'user_id' => $user->id,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversal not required for historical inventory assignment
    }
};


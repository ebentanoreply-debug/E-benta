<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ---------------------------------------------------------------------
        // 1. UPDATE 25 SPECIFIED USERS TO OCTOBER 13, 2026
        // ---------------------------------------------------------------------
        $targetEmails = [
            'jaymarkpayopay23@gmail.com',
            'ariesaustria24@gmail.com',
            'jovenmenor18@gmail.com',
            'justinerosario07@gmail.com',
            'arielserafica21@gmail.com',
            'triciamaerosariol2@gmail.com',
            'danicafajardo16@gmail.com',
            'anthonysorio09@gmail.com',
            'abrahamdeslosreyes@gmail.com',
            'jeslynmunoz15@gmail.com',
            'christiangonzales@gmail.com',
            'alexanderbonggot@gmail.com',
            'christianbeltran11@gmail.com',
            'maritessaustria17@gmail.com',
            'stevenhermogeno08@gmail.com',
            'angelinehermogeno14@gmail.com',
            'kevinbeltran23@gmail.com',
            'janrexrovillos06@gmail.com',
            'rexpascual19@gmail.com',
            'jayannlomboy10@gmail.com',
            'macmactigno26@gmail.com',
            'johnmarkesteban03@gmail.com',
            'renzbeltran19@gmail.com',
            'zyrellmenor14@gmail.com',
            'gabrielpioquinto05@gmail.com',
        ];

        // Base registration time starts at 09:15 AM on October 13, 2026
        $baseDate = Carbon::create(2026, 10, 13, 9, 15, 0);

        foreach ($targetEmails as $index => $email) {
            $user = DB::table('users')->where('email', $email)->first();
            if (!$user) {
                continue;
            }

            // Distribute registration naturally across daytime: +16 minutes per user + seconds
            $regTime = (clone $baseDate)->addMinutes($index * 16)->addSeconds(($user->id % 7) * 45);

            $emailVerifiedAt = (clone $regTime)->addMinutes(3);
            $idSubmittedAt = $user->id_submitted_at ? (clone $regTime)->addMinutes(8) : null;
            $locationVerifiedAt = ($user->location_verified_at || $user->is_verified) ? (clone $regTime)->addMinutes(14) : null;
            $updatedAt = (clone $regTime)->addMinutes(15);

            DB::table('users')->where('id', $user->id)->update([
                'created_at' => $regTime->format('Y-m-d H:i:s'),
                'updated_at' => $updatedAt->format('Y-m-d H:i:s'),
                'email_verified_at' => $emailVerifiedAt ? $emailVerifiedAt->format('Y-m-d H:i:s') : null,
                'id_submitted_at' => $idSubmittedAt ? $idSubmittedAt->format('Y-m-d H:i:s') : null,
                'location_verified_at' => $locationVerifiedAt ? $locationVerifiedAt->format('Y-m-d H:i:s') : null,
            ]);

            // Update registration and verification audit logs
            DB::table('audit_logs')
                ->where('user_id', $user->id)
                ->where('action', 'register')
                ->update([
                    'created_at' => $regTime->format('Y-m-d H:i:s'),
                    'updated_at' => $regTime->format('Y-m-d H:i:s'),
                ]);

            DB::table('audit_logs')
                ->where('user_id', $user->id)
                ->where('action', 'email_verified')
                ->update([
                    'created_at' => $emailVerifiedAt->format('Y-m-d H:i:s'),
                    'updated_at' => $emailVerifiedAt->format('Y-m-d H:i:s'),
                ]);

            DB::table('audit_logs')
                ->where('user_id', $user->id)
                ->where('action', 'user_login')
                ->where('created_at', '<', '2026-10-25 00:00:00')
                ->update([
                    'created_at' => (clone $regTime)->addMinutes(4)->format('Y-m-d H:i:s'),
                    'updated_at' => (clone $regTime)->addMinutes(4)->format('Y-m-d H:i:s'),
                ]);

            if ($locationVerifiedAt) {
                DB::table('audit_logs')
                    ->where('user_id', $user->id)
                    ->whereIn('action', ['user_verified', 'kyc_verified'])
                    ->update([
                        'created_at' => $locationVerifiedAt->format('Y-m-d H:i:s'),
                        'updated_at' => $locationVerifiedAt->format('Y-m-d H:i:s'),
                    ]);
            }
        }

        // ---------------------------------------------------------------------
        // 2. CONVERT AM CASH TRANSACTIONS & COMMISSIONS TO PM
        // ---------------------------------------------------------------------
        // Mapping of transactions to their PM equivalents:
        $transactions = [
            // Ledger #90006 (Offer #360001 - Apple iPhone 13 Pro)
            // Oct 14, 2026 12:45 AM -> Oct 14, 2026 12:45 PM
            [
                'commission_id' => 90006,
                'offer_id' => 360001,
                'listing_id' => 360001,
                'pickup_time' => '2026-10-14 12:30:00',
                'completed_time' => '2026-10-14 12:45:00',
                'impact_cert_time' => '2026-10-14 13:05:00',
                'listing_proc_time' => '2026-10-14 14:30:00',
            ],
            // Ledger #120002 (Offer #360005 - Samsung Galaxy Tab S6 Lite)
            // Oct 14, 2026 02:35 AM -> Oct 14, 2026 02:35 PM
            [
                'commission_id' => 120002,
                'offer_id' => 360005,
                'listing_id' => 360005,
                'pickup_time' => '2026-10-14 14:20:00',
                'completed_time' => '2026-10-14 14:35:00',
                'impact_cert_time' => '2026-10-14 14:55:00',
                'listing_proc_time' => '2026-10-14 16:20:00',
            ],
            // Ledger #90007 (Offer #360002 - Apple iPad 9th Gen)
            // Oct 15, 2026 01:00 AM -> Oct 15, 2026 01:00 PM
            [
                'commission_id' => 90007,
                'offer_id' => 360002,
                'listing_id' => 360002,
                'pickup_time' => '2026-10-15 12:45:00',
                'completed_time' => '2026-10-15 13:00:00',
                'impact_cert_time' => '2026-10-15 13:20:00',
                'listing_proc_time' => '2026-10-15 14:45:00',
            ],
            // Ledger #90008 (Offer #360003 - Samsung Galaxy S22)
            // Oct 16, 2026 01:30 AM -> Oct 16, 2026 01:30 PM
            [
                'commission_id' => 90008,
                'offer_id' => 360003,
                'listing_id' => 360003,
                'pickup_time' => '2026-10-16 13:15:00',
                'completed_time' => '2026-10-16 13:30:00',
                'impact_cert_time' => '2026-10-16 13:50:00',
                'listing_proc_time' => '2026-10-16 15:15:00',
            ],
            // Ledger #120001 (Offer #360004 - iPad Pro 12.9")
            // Oct 17, 2026 02:00 AM -> Oct 17, 2026 02:00 PM
            [
                'commission_id' => 120001,
                'offer_id' => 360004,
                'listing_id' => 360004,
                'pickup_time' => '2026-10-17 13:45:00',
                'completed_time' => '2026-10-17 14:00:00',
                'impact_cert_time' => '2026-10-17 14:20:00',
                'listing_proc_time' => '2026-10-17 15:45:00',
            ],
        ];

        foreach ($transactions as $tx) {
            // 1. Update Commission record
            DB::table('commissions')->where('id', $tx['commission_id'])->update([
                'collected_at' => $tx['completed_time'],
                'created_at' => $tx['completed_time'],
                'updated_at' => $tx['completed_time'],
            ]);

            // 2. Update Offer record
            DB::table('offers')->where('id', $tx['offer_id'])->update([
                'cash_received_at' => $tx['completed_time'],
                'proposed_pickup_date' => $tx['pickup_time'],
                'updated_at' => $tx['completed_time'],
            ]);

            // 3. Update Listing tracking timestamps
            DB::table('listings')->where('id', $tx['listing_id'])->update([
                'pickup_scheduled_at' => $tx['pickup_time'],
                'picked_up_at' => $tx['pickup_time'],
                'delivered_at' => $tx['completed_time'],
                'processed_at' => $tx['listing_proc_time'],
            ]);

            // 4. Update Impact Logs
            DB::table('impact_logs')->where('offer_id', $tx['offer_id'])->update([
                'created_at' => $tx['completed_time'],
                'certified_at' => $tx['impact_cert_time'],
                'updated_at' => $tx['impact_cert_time'],
            ]);

            // 5. Update Audit Logs for transaction completed
            DB::table('audit_logs')
                ->where('model_type', 'Offer')
                ->where('model_id', $tx['offer_id'])
                ->where('action', 'transaction_completed')
                ->update([
                    'created_at' => $tx['completed_time'],
                    'updated_at' => $tx['completed_time'],
                ]);

            // 6. Update Audit Logs for item picked up
            DB::table('audit_logs')
                ->where('model_type', 'Listing')
                ->where('model_id', $tx['listing_id'])
                ->where('action', 'item_picked_up')
                ->update([
                    'created_at' => $tx['pickup_time'],
                    'updated_at' => $tx['pickup_time'],
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Historical data normalization
    }
};


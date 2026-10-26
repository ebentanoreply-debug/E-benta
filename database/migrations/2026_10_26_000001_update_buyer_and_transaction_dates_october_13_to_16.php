<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updates buyer registration dates and separates transaction/offer dates
     * so completed transactions and offers don't share identical dates.
     * Specifically sets Jimmy Beltran and Abe Austria to October 13, 2026,
     * Jerwin Lomibao to Oct 14, Benigno Garcia to Oct 15, and Kris Aquino to Oct 16.
     */
    public function up(): void
    {
        // 1. UPDATE BUYER USER ACCOUNTS REGISTRATION TIMESTAMPS
        $userTimestamps = [
            'rons02naadat@gmail.com' => '2026-10-12 08:30:00',
            '23sc4203_ms@psu.edu.ph' => '2026-10-12 11:15:00',
            'jimmybeltran@gmail.com' => '2026-10-13 08:30:00',
            'Abeaustria@gmail.com' => '2026-10-13 09:15:00',
            'lomibaojerwin@gmail.com' => '2026-10-14 09:00:00',
            'benignogarcia23@gmail.com' => '2026-10-15 09:00:00',
            'Benignogarcia@gmail.com' => '2026-10-15 09:00:00',
            'krisaquino817@gmail.com' => '2026-10-16 09:00:00',
        ];

        foreach ($userTimestamps as $email => $createdTime) {
            $user = DB::table('users')->where('email', $email)->first();
            if (!$user) {
                continue;
            }

            $cTime = Carbon::parse($createdTime);
            $emailVerifiedTime = (clone $cTime)->addMinutes(3)->toDateTimeString();
            $idSubmittedTime = (clone $cTime)->addMinutes(8)->toDateTimeString();
            $locationVerifiedTime = (clone $cTime)->addMinutes(14)->toDateTimeString();
            $updatedTime = (clone $cTime)->addMinutes(15)->toDateTimeString();

            DB::table('users')->where('id', $user->id)->update([
                'created_at' => $createdTime,
                'email_verified_at' => $user->email_verified_at ? $emailVerifiedTime : null,
                'id_submitted_at' => $user->id_submitted_at ? $idSubmittedTime : null,
                'location_verified_at' => $user->location_verified_at ? $locationVerifiedTime : null,
                'updated_at' => $updatedTime,
            ]);

            // Update user audit logs if present
            if (Schema::hasTable('audit_logs')) {
                DB::table('audit_logs')
                    ->where('user_id', $user->id)
                    ->where('action', 'register')
                    ->update([
                        'created_at' => $createdTime,
                        'updated_at' => $createdTime,
                    ]);

                DB::table('audit_logs')
                    ->where('user_id', $user->id)
                    ->where('action', 'email_verified')
                    ->update([
                        'created_at' => $emailVerifiedTime,
                        'updated_at' => $emailVerifiedTime,
                    ]);
            }
        }

        // 2. SPREAD OFFERS, TRANSACTIONS, LISTINGS & IMPACT LOGS ACROSS DIFFERENT DATES
        $schedules = [
            'jimmybeltran@gmail.com' => [
                'day' => '2026-10-13',
                'listing_time' => '2026-10-13 09:00:00',
                'offer_time' => '2026-10-13 10:44:00',
                'accepted_time' => '2026-10-13 11:14:00',
                'pickup_time' => '2026-10-13 16:30:00',
                'completed_time' => '2026-10-13 16:45:00',
            ],
            'Abeaustria@gmail.com' => [
                'day' => '2026-10-13',
                'listing_time' => '2026-10-13 10:15:00',
                'offer_time' => '2026-10-13 15:50:00',
                'accepted_time' => '2026-10-13 16:30:00',
                'pickup_time' => '2026-10-13 18:20:00',
                'completed_time' => null,
            ],
            'lomibaojerwin@gmail.com' => [
                'day' => '2026-10-14',
                'listing_time' => '2026-10-14 09:30:00',
                'offer_time' => '2026-10-14 11:25:00',
                'accepted_time' => '2026-10-14 12:10:00',
                'pickup_time' => '2026-10-14 16:45:00',
                'completed_time' => '2026-10-14 17:00:00',
            ],
            'benignogarcia23@gmail.com' => [
                'day' => '2026-10-15',
                'listing_time' => '2026-10-15 09:30:00',
                'offer_time' => '2026-10-15 13:40:00',
                'accepted_time' => '2026-10-15 14:20:00',
                'pickup_time' => '2026-10-15 17:15:00',
                'completed_time' => '2026-10-15 17:30:00',
            ],
            'krisaquino817@gmail.com' => [
                'day' => '2026-10-16',
                'listing_time' => '2026-10-16 10:00:00',
                'offer_time' => '2026-10-16 14:15:00',
                'accepted_time' => '2026-10-16 14:55:00',
                'pickup_time' => '2026-10-16 17:45:00',
                'completed_time' => null,
            ],
        ];

        foreach ($schedules as $emailKey => $sched) {
            $buyer = DB::table('users')->where('email', 'like', "%{$emailKey}%")->first();
            if (!$buyer) {
                continue;
            }

            $offer = DB::table('offers')->where('buyer_id', $buyer->id)->first();
            if (!$offer) {
                continue;
            }

            // Update Offer timestamps
            DB::table('offers')->where('id', $offer->id)->update([
                'created_at' => $sched['offer_time'],
                'responded_at' => $sched['accepted_time'],
                'cash_received_at' => $sched['completed_time'] ? $sched['completed_time'] : null,
                'proposed_pickup_date' => $sched['pickup_time'],
                'updated_at' => $sched['completed_time'] ?? $sched['accepted_time'],
            ]);

            // Update Listing timestamps
            DB::table('listings')->where('id', $offer->listing_id)->update([
                'created_at' => $sched['listing_time'],
                'matched_at' => $sched['accepted_time'],
                'pickup_scheduled_at' => $sched['pickup_time'],
                'picked_up_at' => $sched['completed_time'] ? $sched['pickup_time'] : null,
                'delivered_at' => $sched['completed_time'] ? $sched['completed_time'] : null,
                'processed_at' => $sched['completed_time'] ? Carbon::parse($sched['pickup_time'])->addHours(2)->toDateTimeString() : null,
                'updated_at' => $sched['completed_time'] ?? $sched['accepted_time'],
            ]);

            // Update Listing Photos if present
            if (Schema::hasTable('listing_photos')) {
                DB::table('listing_photos')->where('listing_id', $offer->listing_id)->update([
                    'created_at' => $sched['listing_time'],
                    'updated_at' => $sched['listing_time'],
                ]);
            }

            // Update Impact Logs
            if (Schema::hasTable('impact_logs')) {
                if ($sched['completed_time']) {
                    DB::table('impact_logs')->where('offer_id', $offer->id)->update([
                        'created_at' => $sched['completed_time'],
                        'updated_at' => $sched['completed_time'],
                        'certified_at' => Carbon::parse($sched['completed_time'])->addMinutes(20)->toDateTimeString(),
                    ]);
                }
            }

            // Update Commissions
            if (Schema::hasTable('commissions')) {
                if ($sched['completed_time']) {
                    DB::table('commissions')->where('offer_id', $offer->id)->update([
                        'collected_at' => $sched['completed_time'],
                        'created_at' => $sched['completed_time'],
                        'updated_at' => $sched['completed_time'],
                    ]);
                }
            }

            // Update Messages
            if (Schema::hasTable('messages')) {
                $messages = DB::table('messages')->where('offer_id', $offer->id)->orderBy('id')->get();
                $msgBase = Carbon::parse($sched['offer_time']);
                foreach ($messages as $mIdx => $msg) {
                    $mTime = (clone $msgBase)->addMinutes(($mIdx + 1) * 8)->toDateTimeString();
                    DB::table('messages')->where('id', $msg->id)->update([
                        'created_at' => $mTime,
                        'updated_at' => $mTime,
                        'read_at' => Carbon::parse($mTime)->addMinute()->toDateTimeString(),
                    ]);
                }
            }

            // Update Notifications
            if (Schema::hasTable('notifications')) {
                DB::table('notifications')
                    ->where('type', 'offer_received')
                    ->where(function ($q) use ($offer) {
                        $q->where('data->offer_id', $offer->id)
                          ->orWhere('data', 'like', '%"offer_id":' . $offer->id . '%')
                          ->orWhere('data', 'like', '%"offer_id": "' . $offer->id . '"%');
                    })
                    ->update([
                        'created_at' => $sched['offer_time'],
                        'updated_at' => $sched['offer_time'],
                    ]);

                DB::table('notifications')
                    ->where('type', 'offer_accepted')
                    ->where(function ($q) use ($offer) {
                        $q->where('data->offer_id', $offer->id)
                          ->orWhere('data', 'like', '%"offer_id":' . $offer->id . '%')
                          ->orWhere('data', 'like', '%"offer_id": "' . $offer->id . '"%');
                    })
                    ->update([
                        'created_at' => $sched['accepted_time'],
                        'updated_at' => $sched['accepted_time'],
                    ]);

                if ($sched['completed_time']) {
                    DB::table('notifications')
                        ->where('type', 'transaction_completed')
                        ->where(function ($q) use ($offer) {
                            $q->where('data->offer_id', $offer->id)
                              ->orWhere('data', 'like', '%"offer_id":' . $offer->id . '%')
                              ->orWhere('data', 'like', '%"offer_id": "' . $offer->id . '"%');
                        })
                        ->update([
                            'created_at' => $sched['completed_time'],
                            'updated_at' => $sched['completed_time'],
                        ]);
                }
            }

            // Update Audit Logs for this offer and listing
            if (Schema::hasTable('audit_logs')) {
                DB::table('audit_logs')
                    ->where('model_type', 'Offer')
                    ->where('model_id', $offer->id)
                    ->where('action', 'offer_created')
                    ->update([
                        'created_at' => $sched['offer_time'],
                        'updated_at' => $sched['offer_time'],
                    ]);

                DB::table('audit_logs')
                    ->where('model_type', 'Offer')
                    ->where('model_id', $offer->id)
                    ->where('action', 'offer_accepted')
                    ->update([
                        'created_at' => $sched['accepted_time'],
                        'updated_at' => $sched['accepted_time'],
                    ]);

                if ($sched['completed_time']) {
                    DB::table('audit_logs')
                        ->where('model_type', 'Listing')
                        ->where('model_id', $offer->listing_id)
                        ->where('action', 'item_picked_up')
                        ->update([
                            'created_at' => $sched['pickup_time'],
                            'updated_at' => $sched['pickup_time'],
                        ]);

                    DB::table('audit_logs')
                        ->where('model_type', 'Offer')
                        ->where('model_id', $offer->id)
                        ->where('action', 'transaction_completed')
                        ->update([
                            'created_at' => $sched['completed_time'],
                            'updated_at' => $sched['completed_time'],
                        ]);
                }

                DB::table('audit_logs')
                    ->where('model_type', 'Listing')
                    ->where('model_id', $offer->listing_id)
                    ->where('action', 'listing_created')
                    ->update([
                        'created_at' => $sched['listing_time'],
                        'updated_at' => $sched['listing_time'],
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

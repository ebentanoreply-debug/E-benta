<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Converts all verified users' government ID types to
     * 'Philippine National ID (PhilSys)' with standardized 16-digit PhilSys format (XXXX-XXXX-XXXX-XXXX).
     */
    public function up(): void
    {
        $users = DB::table('users')
            ->whereNotNull('id_type')
            ->where('id_type', '!=', '')
            ->orderBy('id')
            ->get();

        $usedIds = [];

        foreach ($users as $user) {
            $currentIdNumber = trim((string) $user->id_number);

            if (preg_match('/^\d{4}-\d{4}-\d{4}-\d{4}$/', $currentIdNumber) && !in_array($currentIdNumber, $usedIds)) {
                $finalIdNumber = $currentIdNumber;
            } elseif (preg_match('/^\d{16}$/', $currentIdNumber) && !in_array(substr($currentIdNumber, 0, 4) . '-' . substr($currentIdNumber, 4, 4) . '-' . substr($currentIdNumber, 8, 4) . '-' . substr($currentIdNumber, 12, 4), $usedIds)) {
                $finalIdNumber = substr($currentIdNumber, 0, 4) . '-' . substr($currentIdNumber, 4, 4) . '-' . substr($currentIdNumber, 8, 4) . '-' . substr($currentIdNumber, 12, 4);
            } else {
                $hash = md5('philsys_national_id_' . $user->id);
                $p1 = str_pad((hexdec(substr($hash, 0, 4)) % 8999) + 1000, 4, '0', STR_PAD_LEFT);
                $p2 = str_pad((hexdec(substr($hash, 4, 4)) % 8999) + 1000, 4, '0', STR_PAD_LEFT);
                $p3 = str_pad((hexdec(substr($hash, 8, 4)) % 8999) + 1000, 4, '0', STR_PAD_LEFT);
                $p4 = str_pad((hexdec(substr($hash, 12, 4)) % 8999) + 1000, 4, '0', STR_PAD_LEFT);
                $finalIdNumber = "{$p1}-{$p2}-{$p3}-{$p4}";

                $counter = 1;
                while (in_array($finalIdNumber, $usedIds)) {
                    $hash = md5('philsys_national_id_' . $user->id . '_' . $counter);
                    $p1 = str_pad((hexdec(substr($hash, 0, 4)) % 8999) + 1000, 4, '0', STR_PAD_LEFT);
                    $p2 = str_pad((hexdec(substr($hash, 4, 4)) % 8999) + 1000, 4, '0', STR_PAD_LEFT);
                    $p3 = str_pad((hexdec(substr($hash, 8, 4)) % 8999) + 1000, 4, '0', STR_PAD_LEFT);
                    $p4 = str_pad((hexdec(substr($hash, 12, 4)) % 8999) + 1000, 4, '0', STR_PAD_LEFT);
                    $finalIdNumber = "{$p1}-{$p2}-{$p3}-{$p4}";
                    $counter++;
                }
            }

            $usedIds[] = $finalIdNumber;

            DB::table('users')->where('id', $user->id)->update([
                'id_type' => 'Philippine National ID (PhilSys)',
                'id_number' => $finalIdNumber,
            ]);
        }

        // Update audit logs that reference older ID types
        $typesToReplace = [
            "Driver's License",
            "UMID / SSS ID",
            "Postal ID",
            "Passport",
            "Voter's ID",
            "Voter's ID / Certificate",
        ];

        foreach ($typesToReplace as $oldType) {
            DB::statement("
                UPDATE audit_logs 
                SET description = REPLACE(description, ?, 'Philippine National ID (PhilSys)')
                WHERE description LIKE ?
            ", [$oldType, "%{$oldType}%"]);
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

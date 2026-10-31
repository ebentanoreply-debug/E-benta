<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Simplifies bulk lot titles by removing parentheses.
     */
    public function up(): void
    {
        if (!Schema::hasTable('listings')) {
            return;
        }

        $renames = [
            'Bulk Lot: 10x Assorted Android Phones (Repair & Scrap)' => 'Bulk Lot: 10x Assorted Android Phones',
            'Bulk Lot: 5x Defective School Tablets (Parts & Salvage)' => 'Bulk Lot: 5x Defective School Tablets',
            'Bulk Lot: 8x Old Smartphones (Samsung & Xiaomi Lot)' => 'Bulk Lot: 8x Old Smartphones',
            'Bulk Lot: 6x Mixed Tablets & Smartphones (E-Waste Recycler Lot)' => 'Bulk Lot: 6x Mixed Tablets & Smartphones',
            'Bulk Lot: 12x Broken Touchscreen Phones (Salvage PCB Lot)' => 'Bulk Lot: 12x Broken Touchscreen Phones',
        ];

        foreach ($renames as $old => $new) {
            DB::table('listings')->where('device_details', $old)->update(['device_details' => $new]);

            if (Schema::hasTable('audit_logs')) {
                $logs = DB::table('audit_logs')->where('description', 'like', "%{$old}%")->get();
                foreach ($logs as $log) {
                    $updatedDesc = str_replace($old, $new, $log->description);
                    DB::table('audit_logs')->where('id', $log->id)->update(['description' => $updatedDesc]);
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


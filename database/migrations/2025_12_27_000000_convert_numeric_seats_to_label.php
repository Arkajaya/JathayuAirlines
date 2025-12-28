<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Convert numeric seat identifiers to labelled format (1A,1B,...)
        $perRow = 4; // must match seatmap generation logic
        $letters = ['A','B','C','D'];

        $bookings = DB::table('bookings')->whereNotNull('seats')->get(['id','seats']);
        foreach ($bookings as $b) {
            $seats = json_decode($b->seats, true);
            if (!is_array($seats)) continue;
            $new = [];
            foreach ($seats as $s) {
                // if already labelled (contains letter) keep
                if (!is_numeric($s)) {
                    $new[] = $s;
                    continue;
                }
                $num = (int)$s;
                if ($num <= 0) { $new[] = (string)$s; continue; }
                $row = (int) ceil($num / $perRow);
                $pos = ($num - 1) % $perRow;
                $letter = $letters[$pos] ?? chr(65 + $pos);
                $new[] = $row . $letter;
            }

            DB::table('bookings')->where('id', $b->id)->update(['seats' => json_encode($new)]);
        }
    }

    public function down()
    {
        // no automatic down conversion
    }
};

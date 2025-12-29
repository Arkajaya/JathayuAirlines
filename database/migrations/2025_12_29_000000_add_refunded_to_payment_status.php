<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            // Modify enum to include 'refunded'
            DB::statement("ALTER TABLE `bookings` MODIFY `payment_status` ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending'");
        } elseif ($driver === 'pgsql') {
            // Drop old check and add a new one including 'refunded'
            DB::statement("ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_payment_status_check");
            DB::statement("ALTER TABLE bookings ADD CONSTRAINT bookings_payment_status_check CHECK (payment_status IN ('pending','paid','failed','refunded'))");
        } else {
            // fallback: try to alter column via raw SQL generically
            DB::statement("ALTER TABLE bookings ALTER COLUMN payment_status TYPE text");
        }
    }

    public function down()
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `bookings` MODIFY `payment_status` ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending'");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_payment_status_check");
            DB::statement("ALTER TABLE bookings ADD CONSTRAINT bookings_payment_status_check CHECK (payment_status IN ('pending','paid','failed'))");
        } else {
            // no-op
        }
    }
};

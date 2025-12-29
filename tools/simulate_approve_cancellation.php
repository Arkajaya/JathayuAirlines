<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cancellation;
use App\Models\Booking;

// pick a pending cancellation
$c = Cancellation::where('status', 'pending')->first();
if (! $c) {
    echo "No pending cancellation found\n";
    exit(0);
}

echo "Before: booking_id={$c->booking_id}\n";
$booking = $c->booking()->first();
if ($booking) {
    echo "Booking seats: "; var_export($booking->seats); echo "\n";
    echo "Service booked_seats: " . ($booking->service->booked_seats ?? 'N/A') . "\n";
}

$c->status = 'approved';
$c->save();

// reload
$booking = $c->booking()->first();
if ($booking) {
    echo "After: booking status={$booking->status}, payment_status={$booking->payment_status}\n";
    echo "Booking seats: "; var_export($booking->seats); echo "\n";
    echo "Service booked_seats: " . ($booking->service->booked_seats ?? 'N/A') . "\n";
}

echo "Cancellation updated.\n";

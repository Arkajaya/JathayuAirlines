<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Booking;

// pick an existing user and service
$user = User::first();
$service = Service::where('is_active', true)->first();
if (! $user || ! $service) {
    echo "No user or service available.\n";
    exit(1);
}

Auth::loginUsingId($user->id);

// build request data
$data = [
    'service_id' => $service->id,
    'passenger_details' => [['name' => 'Sim Test', 'phone' => '08123456789']],
    'seats' => [],
    'special_request' => 'sim test',
];

$request = Request::create('/bookings', 'POST', $data);

$before = Booking::where('service_id', $service->id)->count();

$controller = new App\Http\Controllers\BookingController();

try {
    // first call
    $res1 = $controller->store($request);
    // second immediate call
    $res2 = $controller->store($request);
} catch (\Exception $e) {
    echo "Exception during store: " . $e->getMessage() . "\n";
}

$after = Booking::where('service_id', $service->id)->count();

echo "Bookings before: $before\n";
echo "Bookings after: $after\n";

<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use Carbon\Carbon;

$total = Service::where('is_active', 1)->count();
$upcomingOrNull = Service::where('is_active',1)
    ->where(function($q){
        $q->where('departure_time', '>', Carbon::now())
          ->orWhereNull('departure_time');
    })->count();

echo "Active services total: $total\n";
echo "Upcoming or null departure services: $upcomingOrNull\n";
$list = Service::where('is_active',1)->orderBy('departure_time','asc')->get();
foreach($list as $s){
    echo "- [{$s->id}] {$s->departure_city} -> {$s->arrival_city} | departure_time: ".($s->departure_time? $s->departure_time->toDateTimeString() : 'NULL')." | active: {$s->is_active}\n";
}

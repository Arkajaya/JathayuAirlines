<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$u = App\Models\User::where('email','staff@jathayu.com')->first();
if (! $u) {
    echo "USER_NOT_FOUND\n";
    exit(0);
}
$output = [
    'id' => $u->id,
    'roles' => method_exists($u, 'getRoleNames') ? $u->getRoleNames()->toArray() : [],
    'isAdmin' => method_exists($u, 'isAdmin') ? $u->isAdmin() : null,
];
echo json_encode($output, JSON_PRETTY_PRINT) . "\n";
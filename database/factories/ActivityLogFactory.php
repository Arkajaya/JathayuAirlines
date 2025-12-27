<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ActivityLog;

class ActivityLogFactory extends Factory
{
    protected $model = ActivityLog::class;

    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            'user_id' => null,
            'action' => $faker->randomElement(['login', 'logout', 'create_booking', 'cancel_booking', 'update_profile']),
            'description' => $faker->sentence(10),
            'ip_address' => $faker->ipv4(),
            'user_agent' => $faker->userAgent(),
            'properties' => null,
        ];
    }
}

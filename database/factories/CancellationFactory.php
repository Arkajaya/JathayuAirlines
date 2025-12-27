<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cancellation;

class CancellationFactory extends Factory
{
    protected $model = Cancellation::class;

    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            'booking_id' => null,
            'user_id' => null,
            'reason' => $faker->sentence(10),
            'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
            'admin_note' => $faker->optional()->sentence(),
            'refund_amount' => $faker->optional(0.6)->randomFloat(2, 0, 1000000),
        ];
    }
}

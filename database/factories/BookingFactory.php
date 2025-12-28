<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $faker = fake('id_ID');
        $passengerCount = $faker->numberBetween(1, 5);
        $passengers = [];
        for ($i = 0; $i < $passengerCount; $i++) {
            $passengers[] = [
                'name' => $faker->name(),
                'birth_date' => $faker->date('Y-m-d', '-18 years'),
                'passport' => strtoupper($faker->bothify('??######')),
            ];
        }

        $paymentMethods = ['credit_card', 'bank_transfer', 'e-wallet'];

        return [
            // foreign keys will be assigned by seeder when needed
            'user_id' => null,
            'service_id' => null,
            'passenger_count' => $passengerCount,
            'passenger_details' => $passengers,
            'total_price' => 0,
            'status' => $faker->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'payment_method' => $faker->randomElement($paymentMethods),
            'payment_status' => $faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'special_request' => $faker->optional()->sentence(),
            'is_checkin' => $faker->boolean(20),
        ];
    }
}

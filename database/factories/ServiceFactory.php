<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $classes = ['economy', 'business', 'first'];
        $faker = $this->faker;
        $capacity = $faker->numberBetween(100, 300);
        $booked = $faker->numberBetween(0, $capacity);

        $departure = $faker->dateTimeBetween('now', '+30 days');
        $duration = $faker->numberBetween(60, 600);
        $arrival = (clone $departure)->modify("+{$duration} minutes");

        return [
            'flight_number' => strtoupper($faker->bothify('JA###')) . $faker->randomLetter(),
            'airline_name' => $faker->company() . ' Airlines',
            'departure_city' => $faker->city(),
            'arrival_city' => $faker->city(),
            'departure_time' => $departure,
            'arrival_time' => $arrival,
            'duration' => $duration,
            'capacity' => $capacity,
            'booked_seats' => $booked,
            'price' => $faker->numberBetween(300000, 3000000),
            'class' => $faker->randomElement($classes),
            'description' => $faker->sentence(8),
            'is_active' => $faker->boolean(90),
        ];
    }
}

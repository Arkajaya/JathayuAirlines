<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Cancellation;
use App\Models\ActivityLog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles (using Spatie Permission fields)
        $roles = [
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['name' => 'Staff', 'guard_name' => 'web'],
            ['name' => 'User', 'guard_name' => 'web'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Hendra Admin',
            'email' => 'admin@jathayu.com',
            'password' => bcrypt('password123'),
            'role_id' => 1,
            'email_verified_at' => now(),
        ]);

        $staff = User::create([
            'name' => 'Neonardo Staff',
            'email' => 'staff@jathayu.com',
            'password' => bcrypt('password123'),
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);

        // Assign Spatie roles to created users to keep role checks consistent
        try {
            $admin->assignRole('Admin');
        } catch (\Exception $e) {
            // ignore if roles not configured
        }

        try {
            $staff->assignRole('Staff');
        } catch (\Exception $e) {
            // ignore if roles not configured
        }

        // // Create additional users
        // User::factory(50)->create();

        // // Create services (flights)
        // Service::factory(20)->create();

        // // Create blogs using factory
        // Blog::factory(10)->create();

        // // Create bookings: attach to existing users and services and compute total_price
        // $users = User::all();
        // $services = Service::all();

        // $bookings = Booking::factory(150)->make()->each(function ($booking) use ($users, $services) {
        //     $booking->user_id = $users->random()->id;
        //     $service = $services->random();
        //     $booking->service_id = $service->id;
        //     $booking->total_price = $service->price * $booking->passenger_count;
        //     $booking->save();
        // });

        // // Create cancellations for some bookings
        // $bookings = Booking::inRandomOrder()->take(20)->get();
        // foreach ($bookings as $b) {
        //     Cancellation::factory()->create([
        //         'booking_id' => $b->id,
        //         'user_id' => $b->user_id,
        //     ]);
        // }

        // // Activity logs
        // ActivityLog::factory(200)->make()->each(function ($log) use ($users) {
        //     $log->user_id = $users->random()->id;
        //     $log->save();
        // });
    }
}
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

        // Create additional regular users
        $additionalUsers = User::factory(30)->create()->each(function ($u) {
            $u->role_id = 3; // regular user role_id
            $u->save();
            try { $u->assignRole('User'); } catch (\Exception $e) { }
        });

        // Create services (flights)
        Service::factory(20)->create();

        // Create blogs using factory, set featured_image to Unsplash random images (travel themed)
        for ($i = 1; $i <= 12; $i++) {
            $blog = Blog::factory()->make();
            // Use Unsplash random image with a signature to vary images
            $blog->featured_image = 'https://source.unsplash.com/random/1200x800?travel,airplane&sig=' . $i;
            $blog->save();
        }

    }
}
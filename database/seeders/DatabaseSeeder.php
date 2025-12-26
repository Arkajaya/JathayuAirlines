<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Service;
use App\Models\Blog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $roles = [
            ['name' => 'Admin', 'description' => 'Administrator dengan akses penuh'],
            ['name' => 'Staff', 'description' => 'Staff operasional'],
            ['name' => 'User', 'description' => 'Pengguna biasa'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Create admin user
        User::create([
            'name' => 'Admin Jathayu',
            'email' => 'admin@jathayu.com',
            'password' => bcrypt('password123'),
            'role_id' => 1,
            'email_verified_at' => now(),
        ]);

        // Create sample flights
        $flights = [
            [
                'flight_number' => 'JA701',
                'airline_name' => 'Jathayu Airlines',
                'departure_city' => 'Jakarta (CGK)',
                'arrival_city' => 'Denpasar (DPS)',
                'departure_time' => now()->addDays(1)->setTime(8, 0),
                'arrival_time' => now()->addDays(1)->setTime(10, 30),
                'duration' => 150,
                'capacity' => 180,
                'price' => 1250000,
                'class' => 'economy',
                'description' => 'Penerbangan langsung ke Bali',
            ],
            [
                'flight_number' => 'JA702',
                'airline_name' => 'Jathayu Airlines',
                'departure_city' => 'Jakarta (CGK)',
                'arrival_city' => 'Surabaya (SUB)',
                'departure_time' => now()->addDays(2)->setTime(14, 0),
                'arrival_time' => now()->addDays(2)->setTime(15, 30),
                'duration' => 90,
                'capacity' => 160,
                'price' => 850000,
                'class' => 'business',
                'description' => 'Penerbangan bisnis dengan fasilitas lengkap',
            ],
        ];

        foreach ($flights as $flight) {
            Service::create($flight);
        }

        // Create sample blogs
        $blogs = [
            [
                'title' => 'Tips Traveling Nyaman dengan Jathayu Airlines',
                'slug' => 'tips-traveling-nyaman',
                'excerpt' => 'Pelajari cara membuat perjalanan Anda lebih nyaman dengan tips dari kami',
                'content' => '<p>Traveling dengan pesawat bisa menjadi pengalaman yang menyenangkan jika Anda mempersiapkannya dengan baik. Berikut adalah beberapa tips untuk membuat perjalanan Anda lebih nyaman:</p>
                <ul>
                    <li>Check-in online 24 jam sebelum keberangkatan</li>
                    <li>Datang ke bandara minimal 2 jam sebelum keberangkatan</li>
                    <li>Bawa barang bawaan yang sesuai dengan ketentuan</li>
                    <li>Gunakan fasilitas lounge jika tersedia</li>
                </ul>',
                'author' => 'Tim Jathayu',
                'is_published' => true,
            ],
            [
                'title' => 'Destinasi Populer 2024 dengan Jathayu',
                'slug' => 'destinasi-populer-2024',
                'excerpt' => 'Temukan destinasi terpopuler tahun ini yang bisa Anda kunjungi',
                'content' => '<p>Tahun 2024 membawa banyak destinasi menarik yang bisa Anda jelajahi dengan Jathayu Airlines:</p>
                <ol>
                    <li><strong>Bali</strong> - Pulau Dewata dengan pantai eksotis</li>
                    <li><strong>Yogyakarta</strong> - Kota budaya dan sejarah</li>
                    <li><strong>Labuan Bajo</strong> - Gerbang menuju Komodo</li>
                    <li><strong>Raja Ampat</strong> - Surga penyelam dunia</li>
                </ol>',
                'author' => 'Tim Marketing',
                'is_published' => true,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}
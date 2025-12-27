<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blog;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        $faker = fake('id_ID');
        $title = $faker->sentence(6);

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title) . '-' . $faker->unique()->numberBetween(1, 9999),
            'excerpt' => $faker->sentence(12),
            'content' => '<p>' . implode('</p><p>', $faker->paragraphs(3)) . '</p>',
            'author' => $faker->name(),
            'featured_image' => null,
            'views' => $faker->numberBetween(0, 2000),
            'is_published' => $faker->boolean(80),
        ];
    }
}

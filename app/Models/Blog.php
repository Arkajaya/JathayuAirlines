<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'author', 'featured_image', 'views', 'is_published'];

    protected $casts = [
        'is_published' => 'boolean',
        'views' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Blog $blog) {
            if (empty($blog->slug) && ! empty($blog->title)) {
                $blog->slug = static::generateUniqueSlug($blog->title);
            }
        });

        static::updating(function (Blog $blog) {
            if (empty($blog->slug) && ! empty($blog->title)) {
                $blog->slug = static::generateUniqueSlug($blog->title, $blog->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $exceptId = null): string
    {
        $base = Str::slug($title) ?: Str::slug(substr($title, 0, 50));
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)
            ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
            ->exists()) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
<?php

namespace App\Models;

use App\Casts\JsonUnicode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'featured_image_alt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'tags',
        'blog_highlights',
        'contact_info',
        'is_published',
        'is_external',
        'external_url',
        'published_at',
        'category_id'
    ];

    protected $casts = [
        'tags' => JsonUnicode::class,
        'blog_highlights' => JsonUnicode::class,
        'is_published' => 'boolean',
        'is_external' => 'boolean',
        'published_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    /**
     * Ensure tags always returns an array regardless of storage format.
     */
    public function getTagsAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    /**
     * Get the gallery images for the blog.
     */
    public function images()
    {
        return $this->hasMany(BlogImage::class)->orderBy('sort_order');
    }

    /**
     * Get the primary gallery image for the blog.
     */
    public function primaryImage()
    {
        return $this->hasOne(BlogImage::class)->where('is_primary', true);
    }

    /**
     * Get the category that owns the blog.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}

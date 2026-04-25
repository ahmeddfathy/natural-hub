<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'image_alt',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($field) {
            if (empty($field->slug)) {
                $baseSlug = self::generateArabicSlug($field->name);
                $slug = $baseSlug;
                $count = 1;

                while (self::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $field->slug = $slug;
            }
        });
    }

    protected static function generateArabicSlug(string $text): string
    {
        $slug = trim($text);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('/[^\x{0600}-\x{06FF}a-zA-Z0-9\-_]/u', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);

        return trim($slug, '-');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_field');
    }

}

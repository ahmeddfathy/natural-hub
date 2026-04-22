<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VideoCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
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

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $baseSlug = Str::slug($category->name);
                $slug = $baseSlug;
                $count = 1;

                while (self::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $category->slug = $slug;
            }
        });
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('name');
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'video_category_field');
    }

    public function getFullNameAttribute(): string
    {
        if (!$this->parent) {
            return $this->name;
        }

        return $this->parent->full_name . ' > ' . $this->name;
    }

    public function getProjectTypeLabelAttribute(): string
    {
        return $this->full_name;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'image',
        'image_alt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'project_type',
        'is_featured',
        'is_external',
        'external_url',
        'field_id',
        'portfolio_category_id',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_external' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = Str::slug($portfolio->title);
            }
        });
    }

    /**
     * Get the category for the portfolio.
     */
    public function category()
    {
        return $this->belongsTo(PortfolioCategory::class, 'portfolio_category_id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function videos()
    {
        return $this->hasMany(PortfolioVideo::class)->orderBy('sort_order');
    }

    public function getResolvedProjectTypeAttribute(): ?string
    {
        return $this->category?->project_type_label ?? $this->project_type;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // category_type options
    const CATEGORY_HAIR   = 'Hair';
    const CATEGORY_SKIN   = 'Skin';
    const CATEGORY_LASHES = 'Lashes';
    const CATEGORY_SHOP   = 'Shop';

    protected $fillable = [
        'title',
        'category_type',
        'description',
        'image',
        'image_alt',
        'features',
        'icon',
        'price_label',
        'price_min',
        'price_max',
        'duration_minutes',
        'branch_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features'  => 'array',
        'is_active' => 'boolean',
    ];

    // ─── Relations ──────────────────────────────────────────────────────────

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    // ─── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category_type', $category);
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    /** e.g. "٦٠٠ — ٨٠٠ ج" or from price_label */
    public function getDisplayPriceAttribute(): string
    {
        if ($this->price_label) {
            return $this->price_label;
        }

        if ($this->price_min && $this->price_max) {
            return "{$this->price_min} — {$this->price_max} ج";
        }

        return $this->price_min ? "{$this->price_min} ج" : 'تواصلي معنا';
    }

    public static function categoryLabels(): array
    {
        return [
            self::CATEGORY_HAIR   => 'علاجات الشعر',
            self::CATEGORY_SKIN   => 'العناية بالبشرة',
            self::CATEGORY_LASHES => 'الرموش والحواجب',
            self::CATEGORY_SHOP   => 'المتجر',
        ];
    }
}

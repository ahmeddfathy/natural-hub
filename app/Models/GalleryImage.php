<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'url', 'alt', 'caption',
        'category', 'is_before_after',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_before_after' => 'boolean',
        'is_active'       => 'boolean',
    ];

    // ─── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeBeforeAfter($query)
    {
        return $query->where('is_before_after', true);
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    public function getFullUrlAttribute(): string
    {
        return asset('storage/' . $this->url);
    }

    public static function categories(): array
    {
        return ['Hair' => 'شعر', 'Skin' => 'بشرة', 'Lashes' => 'رموش', 'General' => 'عام'];
    }
}

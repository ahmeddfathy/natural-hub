<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'image',
        'price', 'size_label', 'bundle_id',
        'in_stock', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'in_stock'  => 'boolean',
        'is_active' => 'boolean',
    ];

    public function bundle()
    {
        return $this->belongsTo(ShopBundle::class, 'bundle_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('assets/images/2jpeg.jpeg');
    }

    /** WhatsApp order link */
    public function getOrderLinkAttribute(): string
    {
        $msg = urlencode("أريد طلب: {$this->name} ({$this->size_label}) - {$this->price} ج.م");
        return "https://wa.me/201001234567?text={$msg}";
    }
}

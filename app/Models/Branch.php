<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'city', 'phone', 'whatsapp',
        'google_maps_url', 'iframe_url',
        'opens_at', 'closes_at',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opens_at'  => 'datetime:H:i',
        'closes_at' => 'datetime:H:i',
    ];

    // ─── Relations ──────────────────────────────────────────────────────────

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // ─── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    /** e.g. "10:00 ص — 10:00 م" */
    public function getWorkingHoursAttribute(): string
    {
        return $this->opens_at . ' — ' . $this->closes_at;
    }

    /** WhatsApp deep-link */
    public function getWhatsappLinkAttribute(): string
    {
        $number = preg_replace('/\D/', '', $this->whatsapp ?? $this->phone ?? '');
        return "https://wa.me/{$number}";
    }
}

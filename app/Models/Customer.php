<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'notes',
        'total_visits', 'last_visit_at',
    ];

    protected $casts = [
        'last_visit_at' => 'datetime',
    ];

    // ─── Relations ──────────────────────────────────────────────────────────

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function completedBookings()
    {
        return $this->hasMany(Booking::class)->where('status', 'completed');
    }

    // ─── Scopes ─────────────────────────────────────────────────────────────

    public function scopeByPhone($query, string $phone)
    {
        return $query->where('phone', $phone);
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    /**
     * Find or create a customer by phone number.
     * Used in BookingController for zero-friction experience.
     */
    public static function findOrCreateByPhone(string $phone, string $name): self
    {
        return static::firstOrCreate(
            ['phone' => $phone],
            ['name'  => $name]
        );
    }

    /** Increment visit counter and set last_visit timestamp */
    public function recordVisit(): void
    {
        $this->increment('total_visits');
        $this->update(['last_visit_at' => now()]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'branch_id', 'specialty',
        'phone', 'avatar', 'status', 'sort_order',
    ];

    protected $casts = [];

    // ─── Relations ──────────────────────────────────────────────────────────

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ─── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForBranch($query, int $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    /** Total completed bookings count — used in performance reports */
    public function getCompletedBookingsCountAttribute(): int
    {
        return $this->bookings()->where('status', 'completed')->count();
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('assets/images/logo/logo.jpeg');
    }
}

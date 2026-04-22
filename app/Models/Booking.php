<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'service_id', 'branch_id', 'staff_id',
        'appointment_at', 'duration_minutes', 'notes',
        'status', 'source',
        'cancellation_reason', 'cancelled_at',
    ];

    protected $casts = [
        'appointment_at' => 'datetime',
        'cancelled_at'   => 'datetime',
    ];

    // ─── Constants ──────────────────────────────────────────────────────────

    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const SOURCE_WEBSITE = 'website';
    const SOURCE_MANUAL  = 'manual';

    // ─── Relations ──────────────────────────────────────────────────────────

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    // ─── Scopes ─────────────────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('appointment_at', today());
    }

    public function scopeForBranch($query, int $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    // ─── Status helpers ─────────────────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function confirm(): void
    {
        $this->update(['status' => self::STATUS_CONFIRMED]);
    }

    public function complete(): void
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
        $this->customer->recordVisit();
    }

    public function cancel(string $reason = ''): void
    {
        $this->update([
            'status'              => self::STATUS_CANCELLED,
            'cancellation_reason' => $reason,
            'cancelled_at'        => now(),
        ]);
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING   => 'قيد الانتظار',
            self::STATUS_CONFIRMED => 'مؤكد',
            self::STATUS_COMPLETED => 'مكتمل',
            self::STATUS_CANCELLED => 'ملغي',
            default                => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING   => 'warning',
            self::STATUS_CONFIRMED => 'info',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_CANCELLED => 'danger',
            default                => 'secondary',
        };
    }
}

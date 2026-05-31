<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'user_id', 'paket_id', 'kode_booking', 'tanggal_acara', 'jam_acara',
    'nama_acara', 'alamat', 'latitude', 'longitude', 'catatan',
    'status', 'total_harga', 'biaya_transport',
])]
class Booking extends Model
{
    protected function casts(): array
    {
        return [
            'tanggal_acara' => 'date',
            'total_harga' => 'decimal:2',
            'biaya_transport' => 'decimal:2',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    // ── Auto-generate booking code ────────────────

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->kode_booking)) {
                $booking->kode_booking = 'SGT-' . strtoupper(uniqid());
            }
        });
    }

    // ── Status Helpers ────────────────────────────

    public function canTransitionTo(string $targetStatus): bool
    {
        if ($this->status === $targetStatus) {
            return false;
        }

        $statusOrder = [
            'pending' => 1,
            'confirmed' => 2,
            'dp_paid' => 3,
            'paid' => 4,
            'ongoing' => 5,
            'completed' => 6,
            'cancelled' => 7,
        ];

        $currentOrder = $statusOrder[$this->status] ?? 0;
        $targetOrder = $statusOrder[$targetStatus] ?? 0;

        // Cancelled is a terminal state (cannot transition out of cancelled)
        if ($this->status === 'cancelled') {
            return false;
        }

        // Completed is a terminal state (cannot transition out of completed)
        if ($this->status === 'completed') {
            return false;
        }

        // Cannot transition to a status that has a lower order (previous status)
        if ($targetOrder < $currentOrder) {
            return false;
        }

        // Ongoing cannot transition to cancelled (it's already in progress)
        if ($this->status === 'ongoing' && $targetStatus === 'cancelled') {
            return false;
        }

        return true;
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return in_array($this->status, ['confirmed', 'dp_paid', 'paid', 'ongoing', 'completed']);
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'dp_paid' => 'DP Dibayar',
            'paid' => 'Lunas',
            'ongoing' => 'Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'dp_paid' => 'indigo',
            'paid' => 'green',
            'ongoing' => 'purple',
            'completed' => 'emerald',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    // ── Relationships ─────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    public function testimonial(): HasOne
    {
        return $this->hasOne(Testimonial::class);
    }
}

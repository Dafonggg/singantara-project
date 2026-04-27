<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'booking_id', 'jenis', 'metode', 'jumlah', 'bukti_transfer',
    'status', 'catatan_admin', 'verified_at',
])]
class Payment extends Model
{
    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}

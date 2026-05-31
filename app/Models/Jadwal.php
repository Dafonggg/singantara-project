<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['booking_id', 'karyawan_id', 'peran', 'status_hadir', 'catatan'])]
class Jadwal extends Model
{
    public function getStatusHadirLabelAttribute(): string
    {
        return match ($this->status_hadir) {
            'belum' => 'Menunggu Konfirmasi',
            'hadir' => 'Bersedia',
            'tidak_hadir' => 'Tidak Bersedia',
            default => ucfirst($this->status_hadir),
        };
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }
}

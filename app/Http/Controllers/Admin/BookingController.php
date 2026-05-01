<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'paket']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_booking', 'like', "%{$request->search}%")
                  ->orWhere('nama_acara', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
            });
        }

        $bookings = $query->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'paket', 'payments', 'jadwals.karyawan']);

        // Exclude already-assigned karyawans from dropdown
        $assignedIds = $booking->jadwals->pluck('karyawan_id');
        $karyawans = User::where('role', 'karyawan')
            ->where('status', 'active')
            ->whereNotIn('id', $assignedIds)
            ->get();

        return view('admin.bookings.show', compact('booking', 'karyawans'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,dp_paid,paid,ongoing,completed,cancelled']);

        $booking->update(['status' => $request->status]);

        return back()->with('success', "Status booking diubah menjadi: {$booking->status_label}");
    }

    public function assignKaryawan(Request $request, Booking $booking)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:users,id',
            'peran' => 'nullable|string|max:100',
        ]);

        // Prevent assigning the same employee twice
        $existing = Jadwal::where('booking_id', $booking->id)
            ->where('karyawan_id', $request->karyawan_id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'Karyawan ini sudah ditugaskan ke booking ini.');
        }

        Jadwal::create([
            'booking_id' => $booking->id,
            'karyawan_id' => $request->karyawan_id,
            'peran' => $request->peran ?? 'Pemain',
        ]);

        return back()->with('success', 'Karyawan berhasil ditugaskan.');
    }

    public function removeKaryawan(Jadwal $jadwal)
    {
        $jadwal->delete();

        return back()->with('success', 'Karyawan berhasil dihapus dari jadwal.');
    }
}

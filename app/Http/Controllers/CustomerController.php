<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Paket;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Customer dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $bookings = $user->bookings()->with('paket')->latest()->take(5)->get();
        $totalBookings = $user->bookings()->count();
        $activeBookings = $user->bookings()->whereNotIn('status', ['completed', 'cancelled'])->count();

        return view('customer.dashboard', compact('bookings', 'totalBookings', 'activeBookings'));
    }

    /**
     * Show booking creation form.
     */
    public function createBooking()
    {
        $pakets = Paket::active()->get();

        return view('customer.booking.create', compact('pakets'));
    }

    /**
     * Check date availability (AJAX).
     */
    public function checkAvailability(Request $request)
    {
        $request->validate(['tanggal' => 'required|date']);

        $date = $request->tanggal;
        $bookingsOnDate = Booking::where('tanggal_acara', $date)
            ->whereNotIn('status', ['cancelled'])
            ->count();

        // Max 3 bookings per day
        $available = $bookingsOnDate < 3;

        return response()->json([
            'available' => $available,
            'count' => $bookingsOnDate,
            'message' => $available
                ? "Tanggal tersedia! ({$bookingsOnDate}/3 booking)"
                : 'Tanggal sudah penuh (3/3 booking)',
        ]);
    }

    /**
     * Store new booking.
     */
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'tanggal_acara' => 'required|date|after:today',
            'jam_acara' => 'required',
            'nama_acara' => 'required|string|max:255',
            'alamat' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $paket = Paket::findOrFail($validated['paket_id']);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'paket_id' => $paket->id,
            'tanggal_acara' => $validated['tanggal_acara'],
            'jam_acara' => $validated['jam_acara'],
            'nama_acara' => $validated['nama_acara'],
            'alamat' => $validated['alamat'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'pending',
            'total_harga' => $paket->harga,
            'biaya_transport' => 0,
        ]);

        return redirect()->route('customer.booking.show', $booking)
            ->with('success', 'Booking berhasil dibuat! Silakan tunggu konfirmasi dari admin.');
    }

    /**
     * Show booking detail.
     */
    public function showBooking(Booking $booking)
    {
        // Ensure user can only see their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['paket', 'payments', 'jadwals.karyawan']);

        return view('customer.booking.show', compact('booking'));
    }

    /**
     * Show booking history.
     */
    public function bookingHistory()
    {
        $bookings = Auth::user()->bookings()
            ->with('paket')
            ->latest()
            ->paginate(10);

        return view('customer.booking.history', compact('bookings'));
    }

    /**
     * Upload payment proof.
     */
    public function uploadPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'jenis' => 'required|in:dp,pelunasan',
            'jumlah' => 'required|numeric|min:1',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('bukti_transfer')->store('payments', 'public');

        Payment::create([
            'booking_id' => $booking->id,
            'jenis' => $validated['jenis'],
            'metode' => 'transfer',
            'jumlah' => $validated['jumlah'],
            'bukti_transfer' => $path,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }
}

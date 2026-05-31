<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Paket;
use App\Models\Payment;
use App\Models\Testimonial;
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

        // Completed bookings that don't have a testimonial yet
        $completedBookingsWithoutTestimonial = $user->bookings()
            ->with('paket')
            ->where('status', 'completed')
            ->whereDoesntHave('testimonial')
            ->get();

        // User's existing testimonials
        $myTestimonials = $user->testimonials()
            ->with('booking.paket')
            ->latest()
            ->get();

        return view('customer.dashboard', compact(
            'bookings',
            'totalBookings',
            'activeBookings',
            'completedBookingsWithoutTestimonial',
            'myTestimonials'
        ));
    }

    /**
     * Store testimonial for a completed booking.
     */
    public function storeTestimonial(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', 'Testimoni hanya bisa diberikan untuk booking yang sudah selesai.');
        }

        // Prevent duplicate
        if ($booking->testimonial) {
            return back()->with('error', 'Anda sudah memberikan testimoni untuk booking ini.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'deskripsi' => 'required|string|max:1000',
        ]);

        Testimonial::create([
            'user_id' => Auth::id(),
            'booking_id' => $booking->id,
            'rating' => $validated['rating'],
            'deskripsi' => $validated['deskripsi'],
            'is_approved' => false,
        ]);

        return back()->with('success', 'Terima kasih! Testimoni Anda berhasil dikirim dan menunggu persetujuan admin.');
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

        // Max 1 booking per day
        $available = $bookingsOnDate < 1;

        return response()->json([
            'available' => $available,
            'count' => $bookingsOnDate,
            'message' => $available
                ? 'Tanggal tersedia!'
                : 'Tanggal sudah dibooking oleh pelanggan lain.',
        ]);
    }

    /**
     * Get all booked dates (for disabling in calendar picker).
     */
    public function getBookedDates()
    {
        $bookedDates = Booking::whereNotIn('status', ['cancelled'])
            ->where('tanggal_acara', '>=', now()->toDateString())
            ->pluck('tanggal_acara')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->values();

        return response()->json(['booked_dates' => $bookedDates]);
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
            'jalan_gedung' => 'required|string|max:255',
            'detail_lainnya' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Server-side: enforce max 1 booking per day
        $existingBooking = Booking::where('tanggal_acara', $validated['tanggal_acara'])
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($existingBooking) {
            return back()->withErrors(['tanggal_acara' => 'Tanggal sudah dibooking oleh pelanggan lain.'])->withInput();
        }

        $paket = Paket::findOrFail($validated['paket_id']);

        // Concatenate address details
        $alamatLengkap = $validated['jalan_gedung'];
        if (!empty($validated['detail_lainnya'])) {
            $alamatLengkap .= ' (' . $validated['detail_lainnya'] . ')';
        }
        $alamatLengkap .= ', ' . $validated['alamat'];

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'paket_id' => $paket->id,
            'tanggal_acara' => $validated['tanggal_acara'],
            'jam_acara' => $validated['jam_acara'],
            'nama_acara' => $validated['nama_acara'],
            'alamat' => $alamatLengkap,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'confirmed',
            'total_harga' => $paket->harga,
            'biaya_transport' => 0,
        ]);

        return redirect()->route('customer.booking.show', $booking)
            ->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran DP atau Pelunasan.');
    }

    /**
     * Show booking detail.
     */
    public function showBooking(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['paket', 'payments' => function ($q) {
            $q->latest();
        }]);

        $bankAccounts = \App\Models\BankAccount::active()->get();

        return view('customer.booking.show', compact('booking', 'bankAccounts'));
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

        // Only allow payment upload for confirmed bookings
        $allowedStatuses = ['confirmed', 'dp_paid', 'paid', 'ongoing'];
        if (!in_array($booking->status, $allowedStatuses)) {
            return back()->with('error', 'Pembayaran hanya bisa dilakukan setelah booking dikonfirmasi oleh admin.');
        }

        // Prevent double payment: check if there's already a pending payment
        $hasPendingPayment = $booking->payments()->where('status', 'pending')->exists();
        if ($hasPendingPayment) {
            return back()->with('error', 'Anda masih memiliki pembayaran yang menunggu verifikasi. Silakan tunggu hingga admin memverifikasi.');
        }

        $request->validate([
            'jenis' => 'required|in:dp,pelunasan',
        ]);

        $totalPaid = $booking->payments()->where('status', 'verified')->sum('jumlah');
        $remainingBalance = $booking->total_harga - $totalPaid;
        $jenis = $request->input('jenis');
        $maxAmount = $jenis === 'dp' ? ($booking->total_harga * 0.5) : $remainingBalance;

        $validated = $request->validate([
            'jenis' => 'required|in:dp,pelunasan',
            'jumlah' => 'required|numeric|min:10000|max:' . $maxAmount,
            'metode' => 'required|exists:bank_accounts,kode_bank',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png,webp,heic,heif|max:5120',
        ], [
            'jumlah.max' => 'Jumlah pembayaran tidak boleh melebihi ' . ($jenis === 'dp' ? 'DP (50%) yaitu Rp ' . number_format($booking->total_harga * 0.5, 0, ',', '.') : 'sisa tagihan yaitu Rp ' . number_format($remainingBalance, 0, ',', '.')),
        ]);

        // Prevent duplicate DP: check if DP already verified or booking status indicates DP is paid
        if ($validated['jenis'] === 'dp') {
            $dpVerified = $booking->payments()->where('jenis', 'dp')->where('status', 'verified')->exists()
                          || in_array($booking->status, ['dp_paid', 'paid', 'ongoing', 'completed']);
            if ($dpVerified) {
                return back()->with('error', 'DP sudah dibayar.');
            }
        }

        // Prevent duplicate pelunasan: check if pelunasan already verified or booking status is paid or higher
        if ($validated['jenis'] === 'pelunasan') {
            $pelunasanVerified = $booking->payments()->where('jenis', 'pelunasan')->where('status', 'verified')->exists()
                                 || in_array($booking->status, ['paid', 'ongoing', 'completed']);
            if ($pelunasanVerified) {
                return back()->with('error', 'Pelunasan sudah dibayar.');
            }
            // Pelunasan can only be done after DP is verified or booking status is dp_paid or higher
            $dpVerified = $booking->payments()->where('jenis', 'dp')->where('status', 'verified')->exists()
                          || in_array($booking->status, ['dp_paid', 'paid', 'ongoing', 'completed']);
            if (!$dpVerified) {
                return back()->with('error', 'DP harus diverifikasi terlebih dahulu sebelum melakukan pelunasan.');
            }
        }

        $path = $request->file('bukti_transfer')->store('payments', 'public');

        Payment::create([
            'booking_id' => $booking->id,
            'jenis' => $validated['jenis'],
            'metode' => $validated['metode'],
            'jumlah' => $validated['jumlah'],
            'bukti_transfer' => $path,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('booking.user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'action' => 'required|in:verify,reject',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        if ($request->action === 'verify') {
            $payment->update([
                'status' => 'verified',
                'catatan_admin' => $request->catatan_admin,
                'verified_at' => now(),
            ]);

            // Update booking status based on payment type
            $booking = $payment->booking;
            if ($payment->jenis === 'dp') {
                $booking->update(['status' => 'dp_paid']);
            } else {
                $booking->update(['status' => 'paid']);
            }

            return back()->with('success', 'Pembayaran berhasil diverifikasi.');
        }

        $payment->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Pembayaran ditolak.');
    }
}

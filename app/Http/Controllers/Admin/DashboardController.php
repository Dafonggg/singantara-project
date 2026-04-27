<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'active_bookings' => Booking::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'total_revenue' => Payment::where('status', 'verified')->sum('jumlah'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_customers' => User::where('role', 'pelanggan')->count(),
            'total_karyawan' => User::where('role', 'karyawan')->count(),
        ];

        $recentBookings = Booking::with(['user', 'paket'])
            ->latest()
            ->take(5)
            ->get();

        $pendingPayments = Payment::with('booking.user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyRevenue[] = [
                'month' => $date->translatedFormat('M Y'),
                'total' => Payment::where('status', 'verified')
                    ->whereYear('verified_at', $date->year)
                    ->whereMonth('verified_at', $date->month)
                    ->sum('jumlah'),
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentBookings', 'pendingPayments', 'monthlyRevenue'));
    }
}

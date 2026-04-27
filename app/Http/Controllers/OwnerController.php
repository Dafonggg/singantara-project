<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'total_revenue' => Payment::where('status', 'verified')->sum('jumlah'),
            'total_customers' => User::where('role', 'pelanggan')->count(),
        ];

        $recentBookings = Booking::with(['user', 'paket'])
            ->latest()
            ->take(10)
            ->get();

        // Monthly revenue for chart
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

        return view('owner.dashboard', compact('stats', 'recentBookings', 'monthlyRevenue'));
    }
}

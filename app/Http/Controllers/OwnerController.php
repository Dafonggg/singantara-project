<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

    /**
     * Revenue report with date range filter.
     */
    public function report(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;

        $query = Payment::with(['booking.user', 'booking.paket'])
            ->where('status', 'verified');

        if ($dariTanggal) {
            $query->whereDate('verified_at', '>=', $dariTanggal);
        }

        if ($sampaiTanggal) {
            $query->whereDate('verified_at', '<=', $sampaiTanggal);
        }

        $payments = $query->latest('verified_at')->get();

        $summary = [
            'total_pendapatan' => $payments->sum('jumlah'),
            'jumlah_transaksi' => $payments->count(),
            'total_dp' => $payments->where('jenis', 'dp')->sum('jumlah'),
            'total_pelunasan' => $payments->where('jenis', 'pelunasan')->sum('jumlah'),
        ];

        return view('owner.report', compact('payments', 'summary', 'dariTanggal', 'sampaiTanggal'));
    }

    /**
     * Export revenue report as PDF.
     */
    public function exportReport(Request $request)
    {
        $dariTanggal = $request->dari_tanggal;
        $sampaiTanggal = $request->sampai_tanggal;

        $query = Payment::with(['booking.user', 'booking.paket'])
            ->where('status', 'verified');

        if ($dariTanggal) {
            $query->whereDate('verified_at', '>=', $dariTanggal);
        }

        if ($sampaiTanggal) {
            $query->whereDate('verified_at', '<=', $sampaiTanggal);
        }

        $payments = $query->latest('verified_at')->get();

        $summary = [
            'total_pendapatan' => $payments->sum('jumlah'),
            'jumlah_transaksi' => $payments->count(),
            'total_dp' => $payments->where('jenis', 'dp')->sum('jumlah'),
            'total_pelunasan' => $payments->where('jenis', 'pelunasan')->sum('jumlah'),
        ];

        $filename = 'laporan_pendapatan_' . ($dariTanggal ?? 'all') . '_' . ($sampaiTanggal ?? 'all') . '.pdf';

        $pdf = Pdf::loadView('owner.report-pdf', compact('payments', 'summary', 'dariTanggal', 'sampaiTanggal'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}

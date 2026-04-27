<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $upcomingJadwals = $user->jadwals()
            ->with('booking.paket')
            ->whereHas('booking', fn($q) => $q->where('tanggal_acara', '>=', now()->toDateString())
                ->whereNotIn('status', ['cancelled', 'completed']))
            ->latest()
            ->take(5)
            ->get();

        $totalAssignments = $user->jadwals()->count();
        $upcomingCount = $user->jadwals()
            ->whereHas('booking', fn($q) => $q->where('tanggal_acara', '>=', now()->toDateString())
                ->whereNotIn('status', ['cancelled', 'completed']))
            ->count();

        return view('karyawan.dashboard', compact('upcomingJadwals', 'totalAssignments', 'upcomingCount'));
    }

    public function jadwal()
    {
        $jadwals = Auth::user()->jadwals()
            ->with('booking.paket', 'booking.user')
            ->latest()
            ->paginate(10);

        return view('karyawan.jadwal.index', compact('jadwals'));
    }

    public function showJadwal(Jadwal $jadwal)
    {
        if ($jadwal->karyawan_id !== Auth::id()) {
            abort(403);
        }

        $jadwal->load('booking.paket', 'booking.user');

        return view('karyawan.jadwal.show', compact('jadwal'));
    }

    public function updateKehadiran(Request $request, Jadwal $jadwal)
    {
        if ($jadwal->karyawan_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['status_hadir' => 'required|in:hadir,tidak_hadir']);

        $jadwal->update(['status_hadir' => $request->status_hadir]);

        return back()->with('success', 'Status kehadiran berhasil diupdate.');
    }
}

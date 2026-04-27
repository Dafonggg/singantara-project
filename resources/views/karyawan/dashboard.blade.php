<x-layout title="Dashboard Karyawan">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold">Dashboard Karyawan 👷</h1>
                <p class="text-dark-400 mt-1">Halo, {{ auth()->user()->name }}!</p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">📋</div>
                    <div class="text-2xl font-bold">{{ $totalAssignments }}</div>
                    <div class="text-sm text-dark-400 mt-1">Total Penugasan</div>
                </div>
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">⏳</div>
                    <div class="text-2xl font-bold">{{ $upcomingCount }}</div>
                    <div class="text-sm text-dark-400 mt-1">Jadwal Mendatang</div>
                </div>
            </div>

            <div class="flex gap-3 mb-6">
                <a href="{{ route('karyawan.jadwal.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-primary-500 hover:text-primary-400 transition-all">📅 Lihat Semua Jadwal</a>
            </div>

            {{-- Upcoming Assignments --}}
            <div class="glass rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-dark-700"><h2 class="font-bold">Jadwal Mendatang</h2></div>
                @if($upcomingJadwals->count() > 0)
                    <div class="divide-y divide-dark-800">
                        @foreach($upcomingJadwals as $jadwal)
                            <a href="{{ route('karyawan.jadwal.show', $jadwal) }}" class="flex items-center justify-between p-5 hover:bg-white/5 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-lg">🎪</div>
                                    <div>
                                        <div class="font-semibold group-hover:text-primary-400">{{ $jadwal->booking->nama_acara }}</div>
                                        <div class="text-sm text-dark-500">{{ $jadwal->booking->paket->nama }} · {{ $jadwal->peran ?? 'Pemain' }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium">{{ $jadwal->booking->tanggal_acara->format('d/m/Y') }}</div>
                                    <div class="text-xs text-dark-500">{{ $jadwal->booking->jam_acara }}</div>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $jadwal->status_hadir === 'hadir' ? 'bg-green-500/10 text-green-400' : ($jadwal->status_hadir === 'tidak_hadir' ? 'bg-red-500/10 text-red-400' : 'bg-gray-500/10 text-gray-400') }}">{{ $jadwal->status_hadir_label }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="text-5xl mb-4">📭</div>
                        <p class="text-dark-400">Belum ada jadwal mendatang</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

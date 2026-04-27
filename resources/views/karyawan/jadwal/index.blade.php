<x-layout title="Jadwal Saya">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('karyawan.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400">← Dashboard</a>
            <h1 class="text-2xl font-bold mt-2 mb-6">Jadwal Saya</h1>

            <div class="glass rounded-2xl overflow-hidden">
                @if($jadwals->count() > 0)
                    <div class="divide-y divide-dark-800">
                        @foreach($jadwals as $jadwal)
                            <a href="{{ route('karyawan.jadwal.show', $jadwal) }}" class="flex items-center justify-between p-5 hover:bg-white/5 transition-colors group">
                                <div>
                                    <div class="font-semibold group-hover:text-primary-400">{{ $jadwal->booking->nama_acara }}</div>
                                    <div class="text-sm text-dark-500">{{ $jadwal->booking->user->name }} · {{ $jadwal->booking->paket->nama }}</div>
                                    <div class="text-xs text-dark-500 mt-1">Peran: {{ $jadwal->peran ?? 'Pemain' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium">{{ $jadwal->booking->tanggal_acara->format('d/m/Y') }}</div>
                                    <div class="text-xs text-dark-500">{{ $jadwal->booking->jam_acara }}</div>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $jadwal->status_hadir === 'hadir' ? 'bg-green-500/10 text-green-400' : ($jadwal->status_hadir === 'tidak_hadir' ? 'bg-red-500/10 text-red-400' : 'bg-gray-500/10 text-gray-400') }}">{{ $jadwal->status_hadir_label }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="p-4 border-t border-dark-800">{{ $jadwals->links() }}</div>
                @else
                    <div class="p-12 text-center text-dark-400">Belum ada jadwal</div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

<x-layout title="Detail Jadwal">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('karyawan.jadwal.index') }}" class="text-sm text-dark-400 hover:text-primary-400">← Jadwal Saya</a>

            <div class="glass rounded-2xl p-6 mt-4 mb-6">
                <h1 class="text-xl font-bold mb-4">{{ $jadwal->booking->nama_acara }}</h1>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-dark-400">Pelanggan:</span> {{ $jadwal->booking->user->name }}</div>
                    <div><span class="text-dark-400">Paket:</span> {{ $jadwal->booking->paket->nama }}</div>
                    <div><span class="text-dark-400">Tanggal:</span> {{ $jadwal->booking->tanggal_acara->format('d/m/Y') }}</div>
                    <div><span class="text-dark-400">Jam:</span> {{ $jadwal->booking->jam_acara }}</div>
                    <div><span class="text-dark-400">Peran:</span> {{ $jadwal->peran ?? 'Pemain' }}</div>
                    <div><span class="text-dark-400">Status:</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $jadwal->status_hadir === 'hadir' ? 'bg-green-500/10 text-green-400' : ($jadwal->status_hadir === 'tidak_hadir' ? 'bg-red-500/10 text-red-400' : 'bg-gray-500/10 text-gray-400') }}">{{ $jadwal->status_hadir_label }}</span>
                    </div>
                </div>
                <div class="mt-4 text-sm"><span class="text-dark-400">Alamat:</span> {{ $jadwal->booking->alamat }}</div>
            </div>

            {{-- Map --}}
            @if($jadwal->booking->latitude && $jadwal->booking->longitude)
                <div class="glass rounded-2xl p-6 mb-6">
                    <h2 class="font-bold mb-3">📍 Lokasi Acara</h2>
                    <div id="karyawan-map" style="height: 250px; border-radius: 0.75rem; z-index: 1;" class="border border-dark-700"></div>
                    <a href="https://www.google.com/maps?q={{ $jadwal->booking->latitude }},{{ $jadwal->booking->longitude }}" target="_blank" class="inline-block mt-3 text-sm text-primary-400 hover:text-primary-300">🗺️ Buka di Google Maps →</a>
                </div>
            @endif

            {{-- Update Kehadiran --}}
            @if($jadwal->status_hadir === 'belum')
                <div class="glass rounded-2xl p-6">
                    <h2 class="font-bold mb-4">Konfirmasi Kehadiran</h2>
                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('karyawan.jadwal.kehadiran', $jadwal) }}" class="flex-1">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status_hadir" value="hadir">
                            <button class="w-full py-3 rounded-xl text-sm font-bold bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500/20 transition-all">✅ Hadir</button>
                        </form>
                        <form method="POST" action="{{ route('karyawan.jadwal.kehadiran', $jadwal) }}" class="flex-1">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status_hadir" value="tidak_hadir">
                            <button class="w-full py-3 rounded-xl text-sm font-bold bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 transition-all">❌ Tidak Hadir</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($jadwal->booking->latitude && $jadwal->booking->longitude)
        <x-slot:scripts>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const map = L.map('karyawan-map').setView([{{ $jadwal->booking->latitude }}, {{ $jadwal->booking->longitude }}], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OSM' }).addTo(map);
                    L.marker([{{ $jadwal->booking->latitude }}, {{ $jadwal->booking->longitude }}]).addTo(map).bindPopup('{{ $jadwal->booking->nama_acara }}').openPopup();
                });
            </script>
        </x-slot:scripts>
    @endif
</x-layout>

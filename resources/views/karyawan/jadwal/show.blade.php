<x-layout title="Detail Jadwal">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('karyawan.jadwal.index') }}" class="text-sm text-dark-400 hover:text-primary-400">← Jadwal Saya</a>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="mt-4 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 flex items-center gap-3">
                    <x-heroicon-o-check-circle class="w-5 h-5 text-green-400 shrink-0" />
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-green-400/60 hover:text-green-400">&times;</button>
                </div>
            @endif
            @if(session('error') || $errors->any())
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)" class="mt-4 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center gap-3">
                    <x-heroicon-o-x-circle class="w-5 h-5 text-red-400 shrink-0" />
                    <span class="text-sm font-medium">
                        @if(session('error'))
                            {{ session('error') }}
                        @else
                            {{ $errors->first() }}
                        @endif
                    </span>
                    <button @click="show = false" class="ml-auto text-red-400/60 hover:text-red-400">&times;</button>
                </div>
            @endif

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
                
                @if($jadwal->status_hadir === 'tidak_hadir' && $jadwal->catatan)
                    <div class="mt-4 p-3 rounded-xl bg-red-500/5 border border-red-500/10 text-sm text-red-400">
                        <span class="font-bold">Catatan Penolakan:</span> {{ $jadwal->catatan }}
                    </div>
                @endif
            </div>

            {{-- Map --}}
            @if($jadwal->booking->latitude && $jadwal->booking->longitude)
                <div class="glass rounded-2xl p-6 mb-6">
                    <h2 class="font-bold mb-3 flex items-center gap-2">
                        <x-heroicon-o-map-pin class="w-5 h-5 text-primary-400" />
                        Lokasi Acara
                    </h2>
                    <div id="karyawan-map" style="height: 250px; border-radius: 0.75rem; z-index: 1;" class="border border-dark-700"></div>
                    <a href="https://www.google.com/maps?q={{ $jadwal->booking->latitude }},{{ $jadwal->booking->longitude }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-primary-400 hover:text-primary-300">
                        <x-heroicon-o-map class="w-4 h-4" /> Buka di Google Maps →
                    </a>
                </div>
            @endif

            {{-- Update Kesediaan --}}
            @if($jadwal->status_hadir === 'belum')
                <div x-data="{ status: '', showCatatan: false }" class="glass rounded-2xl p-6">
                    <h2 class="font-bold mb-2">Konfirmasi Kesediaan</h2>
                    <p class="text-xs text-dark-400 mb-4">Apakah Anda bersedia ditugaskan pada acara ini?</p>
                    
                    <div x-show="!showCatatan" class="flex gap-3">
                        <form method="POST" action="{{ route('karyawan.jadwal.kehadiran', $jadwal) }}" class="flex-1">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status_hadir" value="hadir">
                            <button type="submit" class="w-full py-3 rounded-xl text-sm font-bold bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500/20 transition-all flex items-center justify-center gap-2">
                                <x-heroicon-o-check-circle class="w-4 h-4 text-green-400" /> Ya, Bersedia
                            </button>
                        </form>
                        <button @click="showCatatan = true; status = 'tidak_hadir'" class="flex-1 py-3 rounded-xl text-sm font-bold bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 transition-all flex items-center justify-center gap-2">
                            <x-heroicon-o-x-circle class="w-4 h-4 text-red-400" /> Tidak Bersedia
                        </button>
                    </div>

                    <!-- Tidak Bersedia Form with Catatan -->
                    <div x-show="showCatatan" x-transition class="space-y-4" style="display: none;">
                        <form method="POST" action="{{ route('karyawan.jadwal.kehadiran', $jadwal) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status_hadir" value="tidak_hadir">
                            
                            <div>
                                <label class="block text-sm font-medium text-dark-300 mb-2">Alasan / Catatan Penolakan</label>
                                <textarea name="catatan" required rows="3" placeholder="Masukkan alasan Anda tidak bersedia hadir..." class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors resize-none"></textarea>
                            </div>

                            <div class="flex gap-3 mt-4">
                                <button type="button" @click="showCatatan = false; status = ''" class="flex-1 py-2.5 rounded-xl text-sm font-bold text-dark-300 border border-dark-700 hover:bg-white/5 transition-all">
                                    Batal
                                </button>
                                <button type="submit" class="flex-1 py-2.5 rounded-xl text-sm font-bold bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 transition-all">
                                    Kirim
                                </button>
                            </div>
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

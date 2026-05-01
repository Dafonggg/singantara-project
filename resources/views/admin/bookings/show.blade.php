<x-layout title="Detail Booking">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-dark-400 hover:text-primary-400">← Kelola Booking</a>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="mt-4 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 flex items-center gap-3">
                    <span class="text-lg">✅</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-green-400/60 hover:text-green-400">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)" class="mt-4 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center gap-3">
                    <span class="text-lg">❌</span>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto text-red-400/60 hover:text-red-400">&times;</button>
                </div>
            @endif

            <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Detail --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-xl font-bold">{{ $booking->nama_acara }}</h1>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-{{ $booking->status_color }}-500/10 text-{{ $booking->status_color }}-400">{{ $booking->status_label }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div><span class="text-dark-400">Kode:</span> <span class="font-mono">{{ $booking->kode_booking }}</span></div>
                            <div><span class="text-dark-400">Pelanggan:</span> {{ $booking->user->name }}</div>
                            <div><span class="text-dark-400">Email:</span> {{ $booking->user->email }}</div>
                            <div><span class="text-dark-400">Telepon:</span> {{ $booking->user->phone ?? '-' }}</div>
                            <div><span class="text-dark-400">Paket:</span> {{ $booking->paket->nama }}</div>
                            <div><span class="text-dark-400">Tanggal:</span> {{ $booking->tanggal_acara->format('d/m/Y') }}</div>
                            <div><span class="text-dark-400">Jam:</span> {{ $booking->jam_acara }}</div>
                            <div><span class="text-dark-400">Total:</span> <span class="font-bold text-primary-400">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span></div>
                        </div>
                        <div class="mt-4 text-sm"><span class="text-dark-400">Alamat:</span> {{ $booking->alamat }}</div>
                        @if($booking->catatan)<div class="mt-2 text-sm"><span class="text-dark-400">Catatan:</span> {{ $booking->catatan }}</div>@endif
                    </div>

                    {{-- Update Status --}}
                    <div class="glass rounded-2xl p-6">
                        <h2 class="font-bold mb-4">Update Status</h2>
                        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="flex gap-3">
                            @csrf @method('PATCH')
                            <select name="status" class="flex-1 px-4 py-2.5 rounded-xl bg-dark-800/50 border border-dark-700 text-white text-sm focus:outline-none focus:border-primary-500">
                                @foreach(['pending','confirmed','dp_paid','paid','ongoing','completed','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $booking->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold bg-primary-500 text-dark-950 hover:bg-primary-400 transition-all">Update</button>
                        </form>
                    </div>

                    {{-- Payments --}}
                    <div class="glass rounded-2xl p-6">
                        <h2 class="font-bold mb-4">Pembayaran</h2>
                        @forelse($booking->payments as $payment)
                            <div class="bg-dark-800/50 rounded-xl p-4 mb-3 flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-semibold">{{ ucfirst($payment->jenis) }} - Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</div>
                                    <div class="text-xs text-dark-500">{{ ucfirst(str_replace('_', ' ', $payment->metode)) }} · {{ $payment->created_at->format('d/m/Y H:i') }}</div>
                                    @if($payment->bukti_transfer)
                                        <a href="{{ asset('storage/' . $payment->bukti_transfer) }}" target="_blank" class="text-xs text-primary-400 hover:text-primary-300">Lihat Bukti →</a>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $payment->status === 'verified' ? 'bg-green-500/10 text-green-400' : ($payment->status === 'rejected' ? 'bg-red-500/10 text-red-400' : 'bg-yellow-500/10 text-yellow-400') }}">{{ $payment->status_label }}</span>
                                    @if($payment->status === 'pending')
                                        <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="flex gap-1">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="verify">
                                            <button type="submit" class="px-3 py-1 rounded-lg text-xs font-semibold bg-green-500/10 text-green-400 hover:bg-green-500/20">✓</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.payments.verify', $payment) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="px-3 py-1 rounded-lg text-xs font-semibold bg-red-500/10 text-red-400 hover:bg-red-500/20">✗</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-dark-400">Belum ada pembayaran.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Sidebar: Assign Karyawan --}}
                <div class="space-y-6">
                    <div class="glass rounded-2xl p-6">
                        <h2 class="font-bold mb-4">👷 Tim Karyawan</h2>
                        @foreach($booking->jadwals as $jadwal)
                            <div class="flex items-center justify-between bg-dark-800/50 rounded-xl p-3 mb-2">
                                <div>
                                    <div class="text-sm font-semibold">{{ $jadwal->karyawan->name }}</div>
                                    <div class="text-xs text-dark-500">{{ $jadwal->peran ?? 'Pemain' }}</div>
                                </div>
                                <form method="POST" action="{{ route('admin.jadwal.remove', $jadwal) }}">
                                    @csrf @method('DELETE')
                                    <button class="text-xs text-red-400 hover:text-red-300">Hapus</button>
                                </form>
                            </div>
                        @endforeach

                        {{-- Only show assign form if there are available karyawans --}}
                        @if($karyawans->count() > 0)
                            <form method="POST" action="{{ route('admin.bookings.assign', $booking) }}" class="mt-4 space-y-3">
                                @csrf
                                <select name="karyawan_id" required class="w-full px-3 py-2 rounded-xl bg-dark-800/50 border border-dark-700 text-white text-sm">
                                    <option value="">Pilih Karyawan</option>
                                    @foreach($karyawans as $k)
                                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="peran" placeholder="Peran (opsional)" class="w-full px-3 py-2 rounded-xl bg-dark-800/50 border border-dark-700 text-white text-sm">
                                <button type="submit" class="w-full py-2 rounded-xl text-sm font-bold bg-accent-500/10 text-accent-400 border border-accent-500/20 hover:bg-accent-500/20 transition-all">+ Tambah Karyawan</button>
                            </form>
                        @else
                            <div class="mt-4 p-3 rounded-xl bg-dark-800/50 text-xs text-dark-400 text-center">
                                Semua karyawan aktif sudah ditugaskan ke booking ini.
                            </div>
                        @endif
                    </div>

                    @if($booking->latitude && $booking->longitude)
                        <div class="glass rounded-2xl p-6">
                            <h2 class="font-bold mb-3">📍 Lokasi</h2>
                            <div id="admin-map" style="height: 200px; border-radius: 0.75rem; z-index: 1;" class="border border-dark-700"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($booking->latitude && $booking->longitude)
        <x-slot:scripts>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const map = L.map('admin-map').setView([{{ $booking->latitude }}, {{ $booking->longitude }}], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OSM' }).addTo(map);
                    L.marker([{{ $booking->latitude }}, {{ $booking->longitude }}]).addTo(map).bindPopup('{{ $booking->nama_acara }}').openPopup();
                });
            </script>
        </x-slot:scripts>
    @endif
</x-layout>

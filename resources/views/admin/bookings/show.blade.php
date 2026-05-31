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
                        <div class="flex flex-wrap items-center gap-3">
                            @php
                            $statusList = [
                                'pending' => [
                                    'label' => 'Pending',
                                    'icon' => '<svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>',
                                    'active' => 'bg-yellow-500 text-dark-950 shadow-lg shadow-yellow-500/20 border-transparent',
                                    'inactive' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20 hover:bg-yellow-500/20'
                                ],
                                'confirmed' => [
                                    'label' => 'Dikonfirmasi',
                                    'icon' => '<svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>',
                                    'active' => 'bg-blue-500 text-white shadow-lg shadow-blue-500/20 border-transparent',
                                    'inactive' => 'bg-blue-500/10 text-blue-400 border-blue-500/20 hover:bg-blue-500/20'
                                ],
                                'dp_paid' => [
                                    'label' => 'DP Dibayar',
                                    'icon' => '<svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>',
                                    'active' => 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/20 border-transparent',
                                    'inactive' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20 hover:bg-indigo-500/20'
                                ],
                                'paid' => [
                                    'label' => 'Lunas',
                                    'icon' => '<svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 0 1 1.5 1.5v12a1.5 1.5 0 0 1-1.5 1.5H3.75a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Zm13.5 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>',
                                    'active' => 'bg-green-500 text-white shadow-lg shadow-green-500/20 border-transparent',
                                    'inactive' => 'bg-green-500/10 text-green-400 border-green-500/20 hover:bg-green-500/20'
                                ],
                                'ongoing' => [
                                    'label' => 'Berlangsung',
                                    'icon' => '<svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>',
                                    'active' => 'bg-purple-500 text-white shadow-lg shadow-purple-500/20 border-transparent',
                                    'inactive' => 'bg-purple-500/10 text-purple-400 border-purple-500/20 hover:bg-purple-500/20'
                                ],
                                'completed' => [
                                    'label' => 'Selesai',
                                    'icon' => '<svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 21l-.813-5.096L3 15l5.096-.813L9 9l.813 5.096L15 15l-5.187.904ZM18 5.25L17.25 9l-.75-3.75L12.75 4.5l3.75-.75L17.25 0l.75 3.75 3.75.75-3.75.75Z" /></svg>',
                                    'active' => 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20 border-transparent',
                                    'inactive' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20 hover:bg-emerald-500/20'
                                ],
                                'cancelled' => [
                                    'label' => 'Batal',
                                    'icon' => '<svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>',
                                    'active' => 'bg-red-500 text-white shadow-lg shadow-red-500/20 border-transparent',
                                    'inactive' => 'bg-red-500/10 text-red-400 border-red-500/20 hover:bg-red-500/20'
                                ],
                            ];
                            @endphp

                            @foreach($statusList as $statusKey => $statusInfo)
                                @php
                                    $isCurrent = $booking->status === $statusKey;
                                    $canTransition = $booking->canTransitionTo($statusKey);
                                    $isDisabled = !$isCurrent && !$canTransition;
                                @endphp
                                <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="inline">
                                    @csrf 
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $statusKey }}">
                                    <button type="submit" 
                                        @disabled($isDisabled || $isCurrent)
                                        class="inline-flex items-center gap-2 rounded-xl font-bold transition-all duration-200 border 
                                        @if($isCurrent)
                                            {{ $statusInfo['active'] }} py-3.5 px-6 text-sm scale-110 shadow-xl z-10
                                        @elseif($canTransition)
                                            {{ $statusInfo['inactive'] }} py-2 px-3 text-xs opacity-75 hover:opacity-100
                                        @else
                                            bg-dark-800/30 text-dark-500 border-dark-700/30 py-2 px-3 text-xs opacity-40 cursor-not-allowed
                                        @endif">
                                        <span class="{{ $isCurrent ? 'w-5 h-5' : 'w-4 h-4' }} shrink-0">
                                            {!! $statusInfo['icon'] !!}
                                        </span>
                                        <span>{{ $statusInfo['label'] }}</span>
                                    </button>
                                </form>
                            @endforeach
                        </div>
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
                            <div class="bg-dark-800/50 rounded-xl p-4 mb-2">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-semibold">{{ $jadwal->karyawan->name }}</div>
                                        <div class="text-xs text-dark-400 mt-0.5">{{ $jadwal->peran ?? 'Pemain' }}</div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $jadwal->status_hadir === 'hadir' ? 'bg-green-500/10 text-green-400' : ($jadwal->status_hadir === 'tidak_hadir' ? 'bg-red-500/10 text-red-400' : 'bg-gray-500/10 text-gray-400') }}">
                                            {{ $jadwal->status_hadir_label }}
                                        </span>
                                        <form method="POST" action="{{ route('admin.jadwal.remove', $jadwal) }}" onsubmit="return confirm('Hapus karyawan ini dari penugasan?')">
                                            @csrf @method('DELETE')
                                            <button class="text-xs text-red-400 hover:text-red-300">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                                @if($jadwal->status_hadir === 'tidak_hadir' && $jadwal->catatan)
                                    <div class="mt-2 text-xs text-red-400 bg-red-500/5 border border-red-500/10 rounded-lg p-2.5">
                                        <span class="font-medium">Alasan:</span> {{ $jadwal->catatan }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
 
                         {{-- Only show assign form if there are available karyawans --}}
                         @if($karyawans->count() > 0)
                             <form method="POST" action="{{ route('admin.bookings.assign', $booking) }}" class="mt-4 space-y-3">
                                 @csrf
                                 <select name="karyawan_id" required class="w-full px-3 py-2.5 rounded-xl bg-dark-800/50 border border-dark-700 text-white text-sm focus:outline-none focus:border-primary-500">
                                     <option value="">Pilih Karyawan</option>
                                     @foreach($karyawans as $k)
                                         <option value="{{ $k->id }}">{{ $k->name }} - {{ $k->peran ?? 'Pemain' }}</option>
                                     @endforeach
                                 </select>
                                 <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-bold bg-accent-500/10 text-accent-400 border border-accent-500/20 hover:bg-accent-500/20 transition-all">+ Tambah Karyawan</button>
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

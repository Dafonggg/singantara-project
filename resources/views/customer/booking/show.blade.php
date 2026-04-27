<x-layout title="Detail Booking">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('customer.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">← Kembali ke Dashboard</a>
            </div>

            {{-- Booking Header --}}
            <div class="glass rounded-2xl p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-xl sm:text-2xl font-bold">{{ $booking->nama_acara }}</h1>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @switch($booking->status_color)
                                    @case('yellow') bg-yellow-500/10 text-yellow-400 @break
                                    @case('blue') bg-blue-500/10 text-blue-400 @break
                                    @case('green') bg-green-500/10 text-green-400 @break
                                    @case('red') bg-red-500/10 text-red-400 @break
                                    @default bg-gray-500/10 text-gray-400
                                @endswitch
                            ">{{ $booking->status_label }}</span>
                        </div>
                        <p class="text-sm text-dark-400">{{ $booking->kode_booking }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-dark-400">Total Harga</div>
                        <div class="text-2xl font-bold text-gradient">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Booking Detail --}}
                <div class="glass rounded-2xl p-6 space-y-4">
                    <h2 class="font-bold text-lg mb-4">Detail Acara</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between"><span class="text-dark-400 text-sm">Paket</span><span class="text-sm font-medium">{{ $booking->paket->nama }}</span></div>
                        <div class="flex justify-between"><span class="text-dark-400 text-sm">Tanggal</span><span class="text-sm font-medium">{{ $booking->tanggal_acara->translatedFormat('l, d F Y') }}</span></div>
                        <div class="flex justify-between"><span class="text-dark-400 text-sm">Jam</span><span class="text-sm font-medium">{{ $booking->jam_acara }}</span></div>
                        <div class="flex justify-between"><span class="text-dark-400 text-sm">Alamat</span><span class="text-sm font-medium text-right max-w-[200px]">{{ $booking->alamat }}</span></div>
                        @if($booking->catatan)
                            <div class="flex justify-between"><span class="text-dark-400 text-sm">Catatan</span><span class="text-sm text-right max-w-[200px]">{{ $booking->catatan }}</span></div>
                        @endif
                    </div>

                    {{-- Map --}}
                    @if($booking->latitude && $booking->longitude)
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-dark-300 mb-2">Lokasi di Peta</h3>
                            <div id="detail-map" style="height: 200px; border-radius: 0.75rem; z-index: 1;" class="border border-dark-700"></div>
                        </div>
                    @endif
                </div>

                {{-- Payment Section --}}
                <div class="space-y-6">
                    {{-- Payment History --}}
                    <div class="glass rounded-2xl p-6">
                        <h2 class="font-bold text-lg mb-4">Riwayat Pembayaran</h2>
                        @if($booking->payments->count() > 0)
                            <div class="space-y-3">
                                @foreach($booking->payments as $payment)
                                    <div class="bg-dark-800/50 rounded-xl p-4">
                                        <div class="flex justify-between mb-2">
                                            <span class="text-sm font-semibold">{{ ucfirst($payment->jenis) }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded-full {{ $payment->status === 'verified' ? 'bg-green-500/10 text-green-400' : ($payment->status === 'rejected' ? 'bg-red-500/10 text-red-400' : 'bg-yellow-500/10 text-yellow-400') }}">
                                                {{ $payment->status_label }}
                                            </span>
                                        </div>
                                        <div class="text-lg font-bold">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</div>
                                        <div class="text-xs text-dark-500 mt-1">{{ $payment->created_at->translatedFormat('d M Y H:i') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-dark-400">Belum ada pembayaran.</p>
                        @endif
                    </div>

                    {{-- Upload Payment --}}
                    @if(in_array($booking->status, ['confirmed', 'dp_paid']))
                        <div class="glass rounded-2xl p-6">
                            <h2 class="font-bold text-lg mb-4">Upload Bukti Pembayaran</h2>
                            <form method="POST" action="{{ route('customer.booking.payment', $booking) }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-dark-300 mb-2">Jenis Pembayaran</label>
                                    <select name="jenis" class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                                        @if($booking->status === 'confirmed')
                                            <option value="dp">DP (50%)</option>
                                        @endif
                                        <option value="pelunasan">Pelunasan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-dark-300 mb-2">Jumlah (Rp)</label>
                                    <input type="number" name="jumlah" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors" placeholder="0">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-dark-300 mb-2">Bukti Transfer</label>
                                    <input type="file" name="bukti_transfer" accept="image/*" required class="w-full text-sm text-dark-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-500/10 file:text-primary-400 hover:file:bg-primary-500/20">
                                </div>
                                <button type="submit" class="w-full py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 transition-all">
                                    Upload Pembayaran
                                </button>
                            </form>
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
                    const map = L.map('detail-map').setView([{{ $booking->latitude }}, {{ $booking->longitude }}], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(map);
                    L.marker([{{ $booking->latitude }}, {{ $booking->longitude }}]).addTo(map)
                        .bindPopup('{{ $booking->nama_acara }}').openPopup();
                });
            </script>
        </x-slot:scripts>
    @endif
</x-layout>

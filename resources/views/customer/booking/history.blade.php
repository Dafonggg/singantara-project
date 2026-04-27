<x-layout title="Riwayat Booking">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('customer.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">← Dashboard</a>
                <h1 class="text-2xl sm:text-3xl font-bold mt-2">Riwayat Booking</h1>
            </div>

            <div class="glass rounded-2xl overflow-hidden">
                @if($bookings->count() > 0)
                    <div class="divide-y divide-dark-800">
                        @foreach($bookings as $booking)
                            <a href="{{ route('customer.booking.show', $booking) }}" class="flex items-center justify-between p-5 hover:bg-white/5 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-lg">🎪</div>
                                    <div>
                                        <div class="font-semibold group-hover:text-primary-400 transition-colors">{{ $booking->nama_acara }}</div>
                                        <div class="text-sm text-dark-500">{{ $booking->kode_booking }} · {{ $booking->paket->nama }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                        @switch($booking->status_color)
                                            @case('yellow') bg-yellow-500/10 text-yellow-400 @break
                                            @case('blue') bg-blue-500/10 text-blue-400 @break
                                            @case('green') bg-green-500/10 text-green-400 @break
                                            @case('red') bg-red-500/10 text-red-400 @break
                                            @default bg-gray-500/10 text-gray-400
                                        @endswitch
                                    ">{{ $booking->status_label }}</span>
                                    <div class="text-xs text-dark-500 mt-1">{{ $booking->tanggal_acara->translatedFormat('d M Y') }}</div>
                                    <div class="text-sm font-semibold text-primary-400 mt-0.5">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="p-4 border-t border-dark-800">
                        {{ $bookings->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="text-5xl mb-4">📭</div>
                        <p class="text-dark-400">Belum ada riwayat booking</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

<x-layout title="Dashboard">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome Header --}}
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold">Halo, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-dark-400 mt-1">Selamat datang di dashboard SIGANTARA</p>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="glass rounded-2xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-500/10 flex items-center justify-center text-2xl">📋</div>
                        <div>
                            <div class="text-2xl font-bold">{{ $totalBookings }}</div>
                            <div class="text-sm text-dark-400">Total Booking</div>
                        </div>
                    </div>
                </div>
                <div class="glass rounded-2xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-accent-500/10 flex items-center justify-center text-2xl">⏳</div>
                        <div>
                            <div class="text-2xl font-bold">{{ $activeBookings }}</div>
                            <div class="text-sm text-dark-400">Booking Aktif</div>
                        </div>
                    </div>
                </div>
                <div class="glass rounded-2xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-2xl">🦁</div>
                        <div>
                            <a href="{{ route('customer.booking.create') }}" class="text-primary-400 hover:text-primary-300 font-semibold text-lg">+ Booking Baru</a>
                            <div class="text-sm text-dark-400">Pesan Sekarang</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('customer.booking.create') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all shadow-lg shadow-primary-500/25">
                    🎉 Buat Booking Baru
                </a>
                <a href="{{ route('customer.booking.history') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-dark-500 hover:text-white transition-all">
                    📜 Riwayat Booking
                </a>
            </div>

            {{-- Recent Bookings --}}
            <div class="glass rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-dark-700">
                    <h2 class="text-lg font-bold">Booking Terbaru</h2>
                </div>

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
                                            @case('indigo') bg-indigo-500/10 text-indigo-400 @break
                                            @case('green') bg-green-500/10 text-green-400 @break
                                            @case('purple') bg-purple-500/10 text-purple-400 @break
                                            @case('emerald') bg-emerald-500/10 text-emerald-400 @break
                                            @case('red') bg-red-500/10 text-red-400 @break
                                            @default bg-gray-500/10 text-gray-400
                                        @endswitch
                                    ">{{ $booking->status_label }}</span>
                                    <div class="text-xs text-dark-500 mt-1">{{ $booking->tanggal_acara->translatedFormat('d M Y') }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="text-5xl mb-4">📭</div>
                        <p class="text-dark-400 mb-4">Belum ada booking</p>
                        <a href="{{ route('customer.booking.create') }}" class="inline-block px-6 py-2.5 rounded-xl text-sm font-semibold bg-primary-500/10 text-primary-400 border border-primary-500/20 hover:bg-primary-500/20 transition-all">
                            Buat Booking Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

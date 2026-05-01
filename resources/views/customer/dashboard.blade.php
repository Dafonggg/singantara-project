<x-layout title="Dashboard">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome Header --}}
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold flex items-center gap-2">Halo, {{ auth()->user()->name }}! <x-heroicon-o-hand-raised class="w-7 h-7 text-primary-400" /></h1>
                <p class="text-dark-400 mt-1">Selamat datang di dashboard SIGANTARA</p>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="glass rounded-2xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-500/10 flex items-center justify-center">
                            <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-primary-400" />
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $totalBookings }}</div>
                            <div class="text-sm text-dark-400">Total Booking</div>
                        </div>
                    </div>
                </div>
                <div class="glass rounded-2xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-accent-500/10 flex items-center justify-center">
                            <x-heroicon-o-clock class="w-6 h-6 text-accent-400" />
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $activeBookings }}</div>
                            <div class="text-sm text-dark-400">Booking Aktif</div>
                        </div>
                    </div>
                </div>
                <div class="glass rounded-2xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">
                            <x-heroicon-o-plus-circle class="w-6 h-6 text-blue-400" />
                        </div>
                        <div>
                            <a href="{{ route('customer.booking.create') }}" class="text-primary-400 hover:text-primary-300 font-semibold text-lg">+ Booking Baru</a>
                            <div class="text-sm text-dark-400">Pesan Sekarang</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('customer.booking.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all shadow-lg shadow-primary-500/25">
                    <x-heroicon-s-sparkles class="w-4 h-4" /> Buat Booking Baru
                </a>
                <a href="{{ route('customer.booking.history') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-dark-500 hover:text-white transition-all">
                    <x-heroicon-o-document-text class="w-4 h-4" /> Riwayat Booking
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
                                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center">
                                            <x-heroicon-o-ticket class="w-5 h-5 text-primary-400" />
                                        </div>
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
                            <x-heroicon-o-inbox class="w-12 h-12 text-dark-600 mx-auto mb-4" />
                            <p class="text-dark-400 mb-4">Belum ada booking</p>
                            <a href="{{ route('customer.booking.create') }}" class="inline-block px-6 py-2.5 rounded-xl text-sm font-semibold bg-primary-500/10 text-primary-400 border border-primary-500/20 hover:bg-primary-500/20 transition-all">
                                Buat Booking Pertama
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Berikan Testimoni --}}
                <div class="space-y-6">
                    @if($completedBookingsWithoutTestimonial->count() > 0)
                        <div class="glass rounded-2xl p-6">
                            <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                                <x-heroicon-o-chat-bubble-bottom-center-text class="w-5 h-5 text-primary-400" />
                                Berikan Testimoni
                            </h2>
                            <p class="text-sm text-dark-400 mb-5">Ceritakan pengalaman Anda untuk membantu pelanggan lain.</p>

                            @foreach($completedBookingsWithoutTestimonial as $completedBooking)
                                <div class="mb-4 last:mb-0" x-data="{ rating: 0, hoveredRating: 0, open: false }">
                                    <button @click="open = !open" class="w-full flex items-center justify-between p-4 rounded-xl bg-dark-800/50 border border-dark-700 hover:border-primary-500/30 transition-all text-left">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                                                <x-heroicon-s-check-circle class="w-4 h-4 text-emerald-400" />
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold">{{ $completedBooking->nama_acara }}</div>
                                                <div class="text-xs text-dark-500">{{ $completedBooking->tanggal_acara->translatedFormat('d M Y') }} · {{ $completedBooking->paket->nama }}</div>
                                            </div>
                                        </div>
                                        <x-heroicon-o-chevron-down class="w-4 h-4 text-dark-400 transition-transform" ::class="open ? 'rotate-180' : ''" />
                                    </button>

                                    <div x-show="open" x-transition x-cloak class="mt-3 p-4 rounded-xl bg-dark-800/30 border border-dark-700">
                                        <form method="POST" action="{{ route('customer.testimonial.store', $completedBooking) }}" class="space-y-4">
                                            @csrf
                                            {{-- Star Rating --}}
                                            <div>
                                                <label class="block text-sm font-medium text-dark-300 mb-2">Rating</label>
                                                <div class="flex items-center gap-1">
                                                    <template x-for="star in 5" :key="star">
                                                        <button type="button"
                                                            @click="rating = star"
                                                            @mouseenter="hoveredRating = star"
                                                            @mouseleave="hoveredRating = 0"
                                                            class="focus:outline-none transition-transform hover:scale-110">
                                                            <svg class="w-7 h-7 transition-colors" :class="star <= (hoveredRating || rating) ? 'text-primary-400' : 'text-dark-600'" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        </button>
                                                    </template>
                                                    <span class="ml-2 text-sm text-dark-400" x-text="rating > 0 ? rating + '/5' : ''"></span>
                                                </div>
                                                <input type="hidden" name="rating" x-model="rating">
                                            </div>

                                            {{-- Description --}}
                                            <div>
                                                <label class="block text-sm font-medium text-dark-300 mb-2">Ceritakan Pengalaman Anda</label>
                                                <textarea name="deskripsi" rows="3" required
                                                    class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 transition-colors resize-none text-sm"
                                                    placeholder="Bagaimana pengalaman Anda dengan layanan kami?"></textarea>
                                            </div>

                                            <button type="submit" :disabled="rating === 0"
                                                class="w-full py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 disabled:opacity-50 disabled:cursor-not-allowed hover:from-primary-400 hover:to-primary-500 transition-all">
                                                Kirim Testimoni
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- My Testimonials --}}
                    @if($myTestimonials->count() > 0)
                        <div class="glass rounded-2xl p-6">
                            <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                                <x-heroicon-o-star class="w-5 h-5 text-primary-400" />
                                Testimoni Saya
                            </h2>
                            <div class="space-y-3">
                                @foreach($myTestimonials as $testi)
                                    <div class="bg-dark-800/50 rounded-xl p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-1">
                                                @for($i = 0; $i < $testi->rating; $i++)
                                                    <x-heroicon-s-star class="w-3.5 h-3.5 text-primary-400" />
                                                @endfor
                                            </div>
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $testi->is_approved ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">
                                                {{ $testi->is_approved ? 'Ditampilkan' : 'Menunggu Review' }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-dark-300 italic">"{{ $testi->deskripsi }}"</p>
                                        <div class="text-xs text-dark-500 mt-2">{{ $testi->booking->nama_acara }} · {{ $testi->created_at->translatedFormat('d M Y') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>

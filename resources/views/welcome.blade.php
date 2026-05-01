<x-layout title="Beranda">
    {{-- Hero Section --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
        {{-- Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-dark-950 via-dark-900 to-dark-950"></div>
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 25% 50%, rgba(249,168,37,0.15) 0%, transparent 50%), radial-gradient(circle at 75% 50%, rgba(76,175,80,0.1) 0%, transparent 50%);"></div>

        {{-- Floating elements --}}
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-10 w-96 h-96 bg-accent-500/5 rounded-full blur-3xl animate-float" style="animation-delay: 3s;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase bg-primary-500/10 text-primary-400 border border-primary-500/20 mb-6">
                    <x-heroicon-s-sparkles class="w-4 h-4" /> Layanan Sisingaan Profesional
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black tracking-tight leading-tight mb-6">
                    Pesan <span class="text-gradient">Sisingaan</span><br>
                    <span class="text-dark-300">Mudah & Cepat</span>
                </h1>

                <p class="max-w-2xl mx-auto text-lg sm:text-xl text-dark-400 leading-relaxed mb-10">
                    SIGANTARA mempermudah Anda memesan jasa sisingaan untuk acara sunatan, pernikahan, dan event budaya. Pilih paket, tentukan lokasi, dan kami siap hadir!
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl text-base font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all shadow-xl shadow-primary-500/25 hover:shadow-primary-500/40 hover:-translate-y-0.5" id="hero-cta-book">
                        Pesan Sekarang
                    </a>
                    <a href="#paket" class="w-full sm:w-auto px-8 py-4 rounded-2xl text-base font-semibold text-dark-300 border border-dark-700 hover:border-dark-500 hover:text-white transition-all hover:-translate-y-0.5" id="hero-cta-packages">
                        Lihat Paket
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="mt-20 grid grid-cols-2 sm:grid-cols-4 gap-6 animate-slide-up" style="animation-delay: 0.3s;">
                <div class="glass rounded-2xl p-5 text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-gradient">500+</div>
                    <div class="text-xs text-dark-400 mt-1">Acara Sukses</div>
                </div>
                <div class="glass rounded-2xl p-5 text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-gradient">50+</div>
                    <div class="text-xs text-dark-400 mt-1">Pemain Profesional</div>
                </div>
                <div class="glass rounded-2xl p-5 text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-gradient">10+</div>
                    <div class="text-xs text-dark-400 mt-1">Tahun Pengalaman</div>
                </div>
                <div class="glass rounded-2xl p-5 text-center">
                    <div class="flex items-center justify-center gap-1 text-2xl sm:text-3xl font-bold text-gradient">4.9 <x-heroicon-s-star class="w-5 h-5 sm:w-6 sm:h-6 text-primary-400" /></div>
                    <div class="text-xs text-dark-400 mt-1">Rating Pelanggan</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Paket Section --}}
    <section id="paket" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase bg-primary-500/10 text-primary-400 border border-primary-500/20 mb-4">Paket Layanan</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold">
                    Pilih <span class="text-gradient">Paket</span> Terbaik
                </h2>
                <p class="mt-4 text-dark-400 max-w-xl mx-auto">Tersedia berbagai paket sisingaan untuk kebutuhan acara Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($pakets as $paket)
                    <div class="glass rounded-2xl overflow-hidden group hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        {{-- Image placeholder --}}
                        <div class="h-48 bg-gradient-to-br from-primary-600/20 to-accent-600/20 flex items-center justify-center">
                            <x-heroicon-s-trophy class="w-16 h-16 text-primary-400/60" />
                        </div>

                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-lg font-bold mb-2">{{ $paket->nama }}</h3>
                            <p class="text-sm text-dark-400 mb-4 flex-1">{{ $paket->deskripsi }}</p>

                            {{-- Daftar Isi Paket --}}
                            @if($paket->daftar_isi && count($paket->daftar_isi) > 0)
                                <div class="space-y-1.5 mb-4">
                                    @foreach($paket->daftar_isi as $item)
                                        <div class="flex items-center gap-2 text-sm text-dark-300">
                                            <x-heroicon-s-check-circle class="w-4 h-4 text-accent-400 shrink-0" />
                                            {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="space-y-2 mb-5">
                                <div class="flex items-center gap-2 text-sm text-dark-300">
                                    <x-heroicon-o-user-group class="w-4 h-4 text-primary-400" />
                                    {{ $paket->jumlah_pemain }} Pemain
                                </div>
                                <div class="flex items-center gap-2 text-sm text-dark-300">
                                    <x-heroicon-o-clock class="w-4 h-4 text-primary-400" />
                                    {{ $paket->durasi }}
                                </div>
                            </div>

                            <div class="flex items-end justify-between pt-4 border-t border-dark-700">
                                <div>
                                    <span class="text-xs text-dark-500">Mulai dari</span>
                                    <div class="text-xl font-bold text-gradient">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                                </div>
                                <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-primary-500/10 text-primary-400 border border-primary-500/20 hover:bg-primary-500/20 transition-all">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Cara Pesan Section --}}
    <section id="cara-pesan" class="py-24 bg-dark-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase bg-accent-500/10 text-accent-400 border border-accent-500/20 mb-4">Cara Pesan</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold">
                    Mudah & <span class="text-gradient">Cepat</span>
                </h2>
                <p class="mt-4 text-dark-400 max-w-xl mx-auto">Hanya beberapa langkah untuk mendapatkan layanan sisingaan terbaik</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $steps = [
                        ['icon' => 'pencil-square', 'title' => 'Daftar & Login', 'desc' => 'Buat akun gratis dan login ke sistem SIGANTARA'],
                        ['icon' => 'cube', 'title' => 'Pilih Paket', 'desc' => 'Pilih paket sisingaan sesuai kebutuhan acara Anda'],
                        ['icon' => 'map-pin', 'title' => 'Tentukan Lokasi', 'desc' => 'Pilih tanggal, jam, dan lokasi acara via peta GPS'],
                        ['icon' => 'check-badge', 'title' => 'Konfirmasi & Bayar', 'desc' => 'Admin akan mengkonfirmasi dan Anda upload bukti bayar'],
                    ];
                @endphp

                @foreach($steps as $i => $step)
                    <div class="relative text-center group">
                        <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-primary-500/10 to-accent-500/10 border border-primary-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                            @switch($step['icon'])
                                @case('pencil-square') <x-heroicon-o-pencil-square class="w-9 h-9 text-primary-400" /> @break
                                @case('cube') <x-heroicon-o-cube class="w-9 h-9 text-primary-400" /> @break
                                @case('map-pin') <x-heroicon-o-map-pin class="w-9 h-9 text-primary-400" /> @break
                                @case('check-badge') <x-heroicon-o-check-badge class="w-9 h-9 text-primary-400" /> @break
                            @endswitch
                        </div>
                        <span class="absolute -top-2 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-primary-500 text-dark-950 text-sm font-bold flex items-center justify-center shadow-lg">{{ $i + 1 }}</span>
                        <h3 class="text-lg font-bold mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-dark-400 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Galeri Section --}}
    <section id="galeri" class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase bg-primary-500/10 text-primary-400 border border-primary-500/20 mb-4">Galeri</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold">
                    Dokumentasi <span class="text-gradient">Acara</span>
                </h2>
                <p class="mt-4 text-dark-400 max-w-xl mx-auto">Momen-momen terbaik dari berbagai acara yang telah kami layani</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @if($galeris->count() > 0)
                    @foreach($galeris as $galeri)
                        <div class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer">
                            @if($galeri->gambar)
                                <img src="{{ Storage::url($galeri->gambar) }}" alt="{{ $galeri->judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-primary-600/20 to-accent-600/20 flex items-center justify-center">
                                    <x-heroicon-o-photo class="w-12 h-12 text-primary-400/40" />
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-950/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <div>
                                    <span class="text-sm font-semibold text-white">{{ $galeri->judul }}</span>
                                    @if($galeri->deskripsi)
                                        <p class="text-xs text-dark-300 mt-1">{{ Str::limit($galeri->deskripsi, 60) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fallback when no galeri entries --}}
                    @php
                        $galeriPlaceholders = [
                            ['title' => 'Sunatan Anak', 'icon' => 'sparkles'],
                            ['title' => 'Arak-arakan', 'icon' => 'musical-note'],
                            ['title' => 'Pencak Silat', 'icon' => 'fire'],
                            ['title' => 'Sisingaan Meriah', 'icon' => 'trophy'],
                            ['title' => 'Dekorasi Mewah', 'icon' => 'paint-brush'],
                            ['title' => 'Penari Profesional', 'icon' => 'user-group'],
                            ['title' => 'Musik Dogdog', 'icon' => 'speaker-wave'],
                            ['title' => 'Acara Budaya', 'icon' => 'building-library'],
                        ];
                    @endphp
                    @foreach($galeriPlaceholders as $item)
                        <div class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer">
                            <div class="absolute inset-0 bg-gradient-to-br from-primary-600/20 to-accent-600/20 flex items-center justify-center">
                                @switch($item['icon'])
                                    @case('sparkles') <x-heroicon-o-sparkles class="w-12 h-12 text-primary-400/50 group-hover:scale-125 transition-transform duration-300" /> @break
                                    @case('musical-note') <x-heroicon-o-musical-note class="w-12 h-12 text-primary-400/50 group-hover:scale-125 transition-transform duration-300" /> @break
                                    @case('fire') <x-heroicon-o-fire class="w-12 h-12 text-primary-400/50 group-hover:scale-125 transition-transform duration-300" /> @break
                                    @case('trophy') <x-heroicon-o-trophy class="w-12 h-12 text-primary-400/50 group-hover:scale-125 transition-transform duration-300" /> @break
                                    @case('paint-brush') <x-heroicon-o-paint-brush class="w-12 h-12 text-primary-400/50 group-hover:scale-125 transition-transform duration-300" /> @break
                                    @case('user-group') <x-heroicon-o-user-group class="w-12 h-12 text-primary-400/50 group-hover:scale-125 transition-transform duration-300" /> @break
                                    @case('speaker-wave') <x-heroicon-o-speaker-wave class="w-12 h-12 text-primary-400/50 group-hover:scale-125 transition-transform duration-300" /> @break
                                    @case('building-library') <x-heroicon-o-building-library class="w-12 h-12 text-primary-400/50 group-hover:scale-125 transition-transform duration-300" /> @break
                                @endswitch
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-950/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <span class="text-sm font-semibold text-white">{{ $item['title'] }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- Testimoni Section --}}
    <section class="py-24 bg-dark-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase bg-accent-500/10 text-accent-400 border border-accent-500/20 mb-4">Testimoni</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold">
                    Apa Kata <span class="text-gradient">Mereka</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if($testimonials->count() > 0)
                    @foreach($testimonials as $testi)
                        <div class="glass rounded-2xl p-6 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 0; $i < $testi->rating; $i++)
                                    <x-heroicon-s-star class="w-4 h-4 text-primary-400" />
                                @endfor
                                @for($i = $testi->rating; $i < 5; $i++)
                                    <x-heroicon-o-star class="w-4 h-4 text-dark-600" />
                                @endfor
                            </div>
                            <p class="text-dark-300 text-sm leading-relaxed mb-5 italic">"{{ $testi->deskripsi }}"</p>
                            <div class="flex items-center gap-3 border-t border-dark-700 pt-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-dark-950 font-bold text-sm">
                                    {{ strtoupper(substr($testi->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold">{{ $testi->user->name }}</div>
                                    <div class="text-xs text-dark-500">{{ $testi->booking->nama_acara }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fallback when no testimonials --}}
                    <div class="col-span-full text-center py-12">
                        <x-heroicon-o-chat-bubble-bottom-center-text class="w-16 h-16 text-dark-600 mx-auto mb-4" />
                        <p class="text-dark-400">Belum ada testimoni. Jadilah yang pertama memberikan ulasan!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="glass rounded-3xl p-10 sm:p-16 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-primary-500/5 to-accent-500/5"></div>
                <div class="relative">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        Siap Memesan <span class="text-gradient">Sisingaan?</span>
                    </h2>
                    <p class="text-dark-400 mb-8 max-w-lg mx-auto">Daftar sekarang dan pesan sisingaan untuk acara Anda. Tim kami siap memberikan pelayanan terbaik!</p>
                    <a href="{{ route('register') }}" class="inline-block px-10 py-4 rounded-2xl text-base font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all shadow-xl shadow-primary-500/25 hover:shadow-primary-500/40 hover:-translate-y-0.5">
                        Daftar Gratis Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-layout>

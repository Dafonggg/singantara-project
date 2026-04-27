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
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase bg-primary-500/10 text-primary-400 border border-primary-500/20 mb-6">
                    🎉 Layanan Sisingaan Profesional
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
                    <div class="text-2xl sm:text-3xl font-bold text-gradient">4.9⭐</div>
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
                            <div class="text-6xl">🦁</div>
                        </div>

                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-lg font-bold mb-2">{{ $paket->nama }}</h3>
                            <p class="text-sm text-dark-400 mb-4 flex-1">{{ $paket->deskripsi }}</p>

                            <div class="space-y-2 mb-5">
                                <div class="flex items-center gap-2 text-sm text-dark-300">
                                    <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $paket->jumlah_pemain }} Pemain
                                </div>
                                <div class="flex items-center gap-2 text-sm text-dark-300">
                                    <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                        ['icon' => '📝', 'title' => 'Daftar & Login', 'desc' => 'Buat akun gratis dan login ke sistem SIGANTARA'],
                        ['icon' => '📦', 'title' => 'Pilih Paket', 'desc' => 'Pilih paket sisingaan sesuai kebutuhan acara Anda'],
                        ['icon' => '📍', 'title' => 'Tentukan Lokasi', 'desc' => 'Pilih tanggal, jam, dan lokasi acara via peta GPS'],
                        ['icon' => '✅', 'title' => 'Konfirmasi & Bayar', 'desc' => 'Admin akan mengkonfirmasi dan Anda upload bukti bayar'],
                    ];
                @endphp

                @foreach($steps as $i => $step)
                    <div class="relative text-center group">
                        <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-primary-500/10 to-accent-500/10 border border-primary-500/10 flex items-center justify-center text-4xl group-hover:scale-110 transition-transform">
                            {{ $step['icon'] }}
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
                @php
                    $galeriPlaceholders = [
                        ['title' => 'Sunatan Anak', 'emoji' => '🎊'],
                        ['title' => 'Arak-arakan', 'emoji' => '🎵'],
                        ['title' => 'Pencak Silat', 'emoji' => '🥋'],
                        ['title' => 'Sisingaan Meriah', 'emoji' => '🦁'],
                        ['title' => 'Dekorasi Mewah', 'emoji' => '🎨'],
                        ['title' => 'Penari Profesional', 'emoji' => '💃'],
                        ['title' => 'Musik Dogdog', 'emoji' => '🥁'],
                        ['title' => 'Acara Budaya', 'emoji' => '🏮'],
                    ];
                @endphp
                @foreach($galeriPlaceholders as $item)
                    <div class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-600/20 to-accent-600/20 flex items-center justify-center">
                            <span class="text-5xl group-hover:scale-125 transition-transform duration-300">{{ $item['emoji'] }}</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-950/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <span class="text-sm font-semibold text-white">{{ $item['title'] }}</span>
                        </div>
                    </div>
                @endforeach
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
                @php
                    $testimonials = [
                        ['name' => 'Ibu Siti Aminah', 'event' => 'Sunatan Anak', 'text' => 'Pelayanan sangat memuaskan! Arak-arakan sisingaan nya meriah sekali, anak saya sangat senang. Recommended banget!', 'rating' => 5],
                        ['name' => 'Bapak Hendra', 'event' => 'Acara Sunatan', 'text' => 'Sudah 3 kali pakai jasa Alan Group, selalu puas. Pemainnya profesional dan tepat waktu. Harga juga bersahabat.', 'rating' => 5],
                        ['name' => 'Ibu Rina Wati', 'event' => 'Festival Budaya', 'text' => 'Tampil di acara festival kami, penampilannya sangat memukau. Dekorasi dan kostumnya bagus-bagus. Terima kasih!', 'rating' => 5],
                    ];
                @endphp

                @foreach($testimonials as $testi)
                    <div class="glass rounded-2xl p-6 hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center gap-1 mb-4">
                            @for($i = 0; $i < $testi['rating']; $i++)
                                <svg class="w-4 h-4 text-primary-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-dark-300 text-sm leading-relaxed mb-5 italic">"{{ $testi['text'] }}"</p>
                        <div class="flex items-center gap-3 border-t border-dark-700 pt-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-dark-950 font-bold text-sm">
                                {{ strtoupper(substr($testi['name'], 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold">{{ $testi['name'] }}</div>
                                <div class="text-xs text-dark-500">{{ $testi['event'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
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

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? 'SIGANTARA - Sistem Informasi Pemesanan Sisingaan Alan Group. Pesan jasa sisingaan online dengan mudah dan cepat.' }}">

    <title>{{ $title ?? 'SIGANTARA' }} - Pemesanan Sisingaan Online</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $head ?? '' }}
</head>
<body class="bg-dark-950 text-white font-sans antialiased min-h-screen flex flex-col">
    {{-- Navigation --}}
    <nav x-data="{ open: false }" class="fixed top-0 w-full z-50 glass transition-all duration-300" id="main-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center font-bold text-dark-950 text-lg transition-transform group-hover:scale-110">
                        S
                    </div>
                    <span class="text-xl font-bold tracking-tight">
                        <span class="text-gradient">SIGAN</span><span class="text-white">TARA</span>
                    </span>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5 transition-all">Beranda</a>
                    <a href="{{ route('home') }}#paket" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5 transition-all">Paket</a>
                    <a href="{{ route('home') }}#galeri" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5 transition-all">Galeri</a>
                    <a href="{{ route('home') }}#cara-pesan" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5 transition-all">Cara Pesan</a>

                    @auth
                        @php $dashboardRoute = match(auth()->user()->role) {
                            'admin' => 'admin.dashboard',
                            'owner' => 'owner.dashboard',
                            'karyawan' => 'karyawan.dashboard',
                            default => 'customer.dashboard',
                        }; @endphp
                        <a href="{{ route($dashboardRoute) }}" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5 transition-all">Dashboard</a>
                    @endauth
                </div>

                {{-- Auth Buttons --}}
                <div class="hidden lg:flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-dark-300 hover:text-white border border-dark-700 hover:border-dark-500 transition-all">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all shadow-lg shadow-primary-500/25 hover:shadow-primary-500/40">
                            Daftar
                        </a>
                    @else
                        <div x-data="{ profileOpen: false }" class="relative">
                            <button @click="profileOpen = !profileOpen" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-white/5 transition-all">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-dark-950 font-bold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-dark-300">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="profileOpen" @click.away="profileOpen = false" x-transition class="absolute right-0 mt-2 w-48 rounded-xl bg-dark-800 border border-dark-700 shadow-xl py-1">
                                <a href="{{ route($dashboardRoute) }}" class="block px-4 py-2 text-sm text-dark-300 hover:text-white hover:bg-white/5">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-dark-300 hover:text-white hover:bg-white/5">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                {{-- Mobile Menu Button --}}
                <button @click="open = !open" class="lg:hidden p-2 rounded-lg hover:bg-white/5 transition-all">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak class="lg:hidden pb-4 border-t border-dark-800 mt-2 pt-4">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5">Beranda</a>
                    <a href="{{ route('home') }}#paket" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5">Paket</a>
                    <a href="{{ route('home') }}#galeri" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5">Galeri</a>
                    <a href="{{ route('home') }}#cara-pesan" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5">Cara Pesan</a>
                    @auth
                        <a href="{{ route($dashboardRoute) }}" class="px-4 py-2 rounded-lg text-sm font-medium text-dark-300 hover:text-white hover:bg-white/5">Dashboard</a>
                    @endauth
                </div>
                <div class="flex flex-col gap-2 mt-4 px-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-center px-5 py-2.5 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700">Masuk</a>
                        <a href="{{ route('register') }}" class="text-center px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950">Daftar</a>
                    @else
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-center px-5 py-2.5 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success') || session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="fixed top-24 right-6 z-[60] max-w-sm">
            @if(session('success'))
                <div class="flex items-center gap-3 px-5 py-4 rounded-xl bg-accent-600/90 backdrop-blur-sm text-white shadow-xl">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                    <button @click="show = false" class="ml-auto"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 px-5 py-4 rounded-xl bg-red-600/90 backdrop-blur-sm text-white shadow-xl">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                    <button @click="show = false" class="ml-auto"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            @endif
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-dark-900/50 border-t border-dark-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center font-bold text-dark-950 text-lg">S</div>
                        <span class="text-xl font-bold"><span class="text-gradient">SIGAN</span><span>TARA</span></span>
                    </div>
                    <p class="text-dark-400 text-sm leading-relaxed">Sistem Informasi Pemesanan Sisingaan Alan Group. Layanan sisingaan profesional untuk acara sunatan, pernikahan, dan event budaya.</p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-sm font-semibold text-white mb-4 uppercase tracking-wider">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('home') }}#paket" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">Paket</a></li>
                        <li><a href="{{ route('home') }}#galeri" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">Galeri</a></li>
                        <li><a href="{{ route('login') }}" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">Login</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-sm font-semibold text-white mb-4 uppercase tracking-wider">Kontak</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-sm text-dark-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            0812-3456-7890
                        </li>
                        <li class="flex items-center gap-2 text-sm text-dark-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            info@sigantara.com
                        </li>
                        <li class="flex items-center gap-2 text-sm text-dark-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Subang, Jawa Barat
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-8 border-t border-dark-800 text-center">
                <p class="text-sm text-dark-500">&copy; {{ date('Y') }} SIGANTARA - Alan Group. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{ $scripts ?? '' }}
</body>
</html>

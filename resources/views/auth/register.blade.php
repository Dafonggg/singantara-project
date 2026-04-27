<x-layout title="Daftar">
    <section class="min-h-screen flex items-center justify-center py-24 px-4">
        <div class="w-full max-w-md">
            {{-- Header --}}
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center font-bold text-dark-950 text-xl">S</div>
                </a>
                <h1 class="text-3xl font-bold">Buat Akun Baru</h1>
                <p class="text-dark-400 mt-2">Daftar untuk memesan sisingaan</p>
            </div>

            {{-- Register Form --}}
            <div class="glass rounded-2xl p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-5" id="register-form">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-dark-300 mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors"
                            placeholder="Nama lengkap Anda">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-dark-300 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors"
                            placeholder="email@contoh.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-dark-300 mb-2">No. Telepon / WhatsApp</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors"
                            placeholder="081234567890">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label for="address" class="block text-sm font-medium text-dark-300 mb-2">Alamat <span class="text-dark-500">(opsional)</span></label>
                        <textarea id="address" name="address" rows="2"
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors resize-none"
                            placeholder="Alamat lengkap Anda">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-dark-300 mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-dark-300 mb-2">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors"
                            placeholder="Ulangi password">
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="register-button"
                        class="w-full py-3.5 rounded-xl text-base font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all shadow-lg shadow-primary-500/25 hover:shadow-primary-500/40">
                        Daftar Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-dark-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300 font-semibold transition-colors">Masuk</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layout>

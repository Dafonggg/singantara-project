<x-layout title="Tambah Admin">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-dark-400 hover:text-primary-400 transition-colors mb-6 inline-flex items-center gap-1">
                <x-heroicon-o-arrow-left class="w-4 h-4" /> Kembali ke Daftar Admin
            </a>

            <div class="glass rounded-2xl p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center">
                        <x-heroicon-o-user-plus class="w-5 h-5 text-primary-400" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Tambah Admin Baru</h1>
                        <p class="text-sm text-dark-400">Buat akun administrator baru untuk sistem.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"
                            placeholder="Masukkan nama lengkap">
                        @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"
                            placeholder="admin@example.com">
                        @error('email') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Password</label>
                        <input type="password" name="password" required minlength="8"
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"
                            placeholder="Minimal 8 karakter">
                        @error('password') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-dark-300 mb-2">No. Handphone (Opsional)</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"
                                placeholder="08xxxxxxxxxx">
                            @error('phone') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-dark-300 mb-2">Status Akun</label>
                            <select name="status" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Alamat (Opsional)</label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"
                            placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                        @error('address') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all shadow-lg shadow-primary-500/25 flex items-center justify-center gap-2">
                            <x-heroicon-o-check class="w-4 h-4" /> Simpan Akun Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

<x-layout title="Edit Karyawan">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.karyawan.index') }}" class="text-sm text-dark-400 hover:text-primary-400">← Kelola Karyawan</a>
            <h1 class="text-2xl font-bold mt-2 mb-6">Edit: {{ $karyawan->name }}</h1>
            <div class="glass rounded-2xl p-6">
                <form method="POST" action="{{ route('admin.karyawan.update', $karyawan) }}" class="space-y-5">
                    @csrf @method('PUT')
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Nama</label><input type="text" name="name" value="{{ old('name', $karyawan->name) }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"></div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Username</label><input type="text" name="username" value="{{ old('username', $karyawan->username) }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">@error('username')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Email</label><input type="email" name="email" value="{{ old('email', $karyawan->email) }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"></div>
                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Peran</label>
                        <input type="text" name="peran" value="{{ old('peran', $karyawan->peran) }}" placeholder="Contoh: Penopang Singa, Pemain Kendang" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                        @error('peran')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Telepon</label><input type="tel" name="phone" value="{{ old('phone', $karyawan->phone) }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"></div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Alamat</label><textarea name="address" rows="2" class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors resize-none">{{ old('address', $karyawan->address) }}</textarea></div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                            <option value="active" {{ $karyawan->status === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $karyawan->status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Password Baru <span class="text-dark-500">(kosongkan jika tidak ubah)</span></label><input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"></div>
                    <button type="submit" class="w-full py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 transition-all">Update Karyawan</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

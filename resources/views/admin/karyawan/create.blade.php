<x-layout title="Tambah Karyawan">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.karyawan.index') }}" class="text-sm text-dark-400 hover:text-primary-400">← Kelola Karyawan</a>
            <h1 class="text-2xl font-bold mt-2 mb-6">Tambah Karyawan</h1>
            <div class="glass rounded-2xl p-6">
                <form method="POST" action="{{ route('admin.karyawan.store') }}" class="space-y-5">
                    @csrf
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Nama</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">@error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Email</label><input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">@error('email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Telepon</label><input type="tel" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">@error('phone')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Alamat</label><textarea name="address" rows="2" class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors resize-none">{{ old('address') }}</textarea></div>
                    <div><label class="block text-sm font-medium text-dark-300 mb-2">Password</label><input type="password" name="password" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">@error('password')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                    <button type="submit" class="w-full py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 transition-all">Simpan Karyawan</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

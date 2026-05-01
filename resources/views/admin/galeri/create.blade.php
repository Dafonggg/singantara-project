<x-layout title="Tambah Dokumentasi">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.galeri.index') }}" class="text-sm text-dark-400 hover:text-primary-400">← Kelola Dokumentasi</a>
            <h1 class="text-2xl font-bold mt-2 mb-6">Tambah Dokumentasi Baru</h1>

            <div class="glass rounded-2xl p-6">
                <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Judul</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                        @error('judul')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Deskripsi <span class="text-dark-500">(opsional)</span></label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors resize-none">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Gambar <span class="text-red-400">*</span></label>
                        <input type="file" name="gambar" accept="image/*" required class="w-full text-sm text-dark-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-500/10 file:text-primary-400">
                        @error('gambar')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="w-full py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 transition-all">Simpan Dokumentasi</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

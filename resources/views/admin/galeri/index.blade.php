<x-layout title="Kelola Dokumentasi">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400">← Dashboard</a>
                    <h1 class="text-2xl font-bold mt-2">Kelola Dokumentasi Acara</h1>
                </div>
                <a href="{{ route('admin.galeri.create') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950">+ Tambah Dokumentasi</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($galeris as $galeri)
                    <div class="glass rounded-2xl overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-primary-600/20 to-accent-600/20 flex items-center justify-center">
                            @if($galeri->gambar)
                                <img src="{{ Storage::url($galeri->gambar) }}" alt="{{ $galeri->judul }}" class="w-full h-full object-cover">
                            @else
                                <x-heroicon-o-photo class="w-12 h-12 text-primary-400/40" />
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold mb-1">{{ $galeri->judul }}</h3>
                            @if($galeri->deskripsi)
                                <p class="text-sm text-dark-400 mb-3">{{ Str::limit($galeri->deskripsi, 80) }}</p>
                            @endif
                            <div class="flex gap-2">
                                <a href="{{ route('admin.galeri.edit', $galeri) }}" class="flex-1 text-center py-2 rounded-xl text-xs font-semibold bg-primary-500/10 text-primary-400 border border-primary-500/20 hover:bg-primary-500/20 transition-all">Edit</a>
                                <form method="POST" action="{{ route('admin.galeri.destroy', $galeri) }}" class="flex-1" onsubmit="return confirm('Hapus dokumentasi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="w-full py-2 rounded-xl text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 transition-all">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full glass rounded-2xl p-12 text-center">
                        <x-heroicon-o-photo class="w-12 h-12 text-dark-600 mx-auto mb-4" />
                        <p class="text-dark-400">Belum ada dokumentasi acara.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>

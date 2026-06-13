<x-layout title="Kelola Paket">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400">← Dashboard</a>
                    <h1 class="text-2xl font-bold mt-2">Kelola Paket</h1>
                </div>
                <a href="{{ route('admin.paket.create') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950">+ Tambah Paket</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pakets as $paket)
                    <div class="glass rounded-2xl overflow-hidden">
                        <div class="h-40 bg-gradient-to-br from-primary-600/20 to-accent-600/20 flex items-center justify-center overflow-hidden">
                            @if($paket->gambar)
                                <img src="{{ Storage::url($paket->gambar) }}" alt="{{ $paket->nama }}" class="w-full h-full object-cover">
                            @else
                                <x-heroicon-s-trophy class="w-12 h-12 text-primary-400/60" />
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-bold">{{ $paket->nama }}</h3>
                                <span class="px-2 py-0.5 rounded-full text-xs {{ $paket->is_active ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">{{ $paket->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                            <p class="text-sm text-dark-400 mb-3">{{ Str::limit($paket->deskripsi, 80) }}</p>
                            <div class="text-lg font-bold text-gradient mb-4">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.paket.edit', $paket) }}" class="flex-1 text-center py-2 rounded-xl text-xs font-semibold bg-primary-500/10 text-primary-400 border border-primary-500/20 hover:bg-primary-500/20 transition-all">Edit</a>
                                <form method="POST" action="{{ route('admin.paket.destroy', $paket) }}" class="flex-1" onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf @method('DELETE')
                                    <button class="w-full py-2 rounded-xl text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 transition-all">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>

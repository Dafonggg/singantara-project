<x-layout title="Edit Paket">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.paket.index') }}" class="text-sm text-dark-400 hover:text-primary-400">← Kelola Paket</a>
            <h1 class="text-2xl font-bold mt-2 mb-6">Edit Paket: {{ $paket->nama }}</h1>

            <div class="glass rounded-2xl p-6">
                <form method="POST" action="{{ route('admin.paket.update', $paket) }}" enctype="multipart/form-data" class="space-y-5"
                    x-data="{ items: {{ json_encode($paket->daftar_isi ?? ['']) }} }">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Nama Paket</label>
                        <input type="text" name="nama" value="{{ old('nama', $paket->nama) }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors resize-none">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-dark-300 mb-2">Harga (Rp)</label>
                            <input type="number" name="harga" value="{{ old('harga', $paket->harga) }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-dark-300 mb-2">Jumlah Pemain</label>
                            <input type="number" name="jumlah_pemain" value="{{ old('jumlah_pemain', $paket->jumlah_pemain) }}" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Durasi</label>
                        <input type="text" name="durasi" value="{{ old('durasi', $paket->durasi) }}" class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                    </div>

                    {{-- Daftar Isi Paket --}}
                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Daftar Isi Paket</label>
                        <p class="text-xs text-dark-500 mb-3">Tambahkan item yang termasuk dalam paket ini.</p>
                        <div class="space-y-2">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="flex items-center gap-2">
                                    <input type="text" :name="'daftar_isi[' + index + ']'" x-model="items[index]"
                                        placeholder="Contoh: 4 Sisingaan, Musik Dogdog"
                                        class="flex-1 px-4 py-2.5 rounded-xl bg-dark-800/50 border border-dark-700 text-white text-sm focus:outline-none focus:border-primary-500 transition-colors">
                                    <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1"
                                        class="p-2 rounded-lg text-red-400 hover:bg-red-500/10 transition-colors">
                                        <x-heroicon-o-x-mark class="w-4 h-4" />
                                    </button>
                                </div>
                            </template>
                        </div>
                        <button type="button" @click="items.push('')"
                            class="mt-2 inline-flex items-center gap-1.5 text-sm text-primary-400 hover:text-primary-300 transition-colors">
                            <x-heroicon-o-plus-circle class="w-4 h-4" /> Tambah Item
                        </button>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Gambar (kosongkan jika tidak ingin mengubah)</label>
                        @if($paket->gambar)
                            <div class="mb-3">
                                <img src="{{ Storage::url($paket->gambar) }}" alt="{{ $paket->nama }}" class="w-32 h-32 object-cover rounded-xl">
                            </div>
                        @endif
                        <input type="file" name="gambar" accept="image/*" class="w-full text-sm text-dark-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-500/10 file:text-primary-400">
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $paket->is_active ? 'checked' : '' }} class="w-4 h-4 rounded bg-dark-800 border-dark-600 text-primary-500 focus:ring-primary-500">
                        <span class="text-sm text-dark-300">Aktif</span>
                    </label>
                    <button type="submit" class="w-full py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 transition-all">Update Paket</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

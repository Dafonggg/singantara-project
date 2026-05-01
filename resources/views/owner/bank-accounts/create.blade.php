<x-layout title="Tambah Rekening Bank">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('owner.bank-accounts.index') }}" class="text-sm text-dark-400 hover:text-primary-400 mb-6 inline-block">← Kembali ke Daftar Rekening</a>

            <div class="glass rounded-2xl p-6 sm:p-8">
                <h1 class="text-2xl font-bold mb-6">Tambah Rekening Bank</h1>

                <form method="POST" action="{{ route('owner.bank-accounts.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Nama Bank</label>
                        <input type="text" name="nama_bank" value="{{ old('nama_bank') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"
                            placeholder="Contoh: Bank BCA">
                        @error('nama_bank') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Kode Bank (Untuk referensi sistem)</label>
                        <input type="text" name="kode_bank" value="{{ old('kode_bank') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"
                            placeholder="Contoh: bca, bri, mandiri">
                        @error('kode_bank') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Nomor Rekening</label>
                        <input type="text" name="nomor_rekening" value="{{ old('nomor_rekening') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"
                            placeholder="Contoh: 1234567890">
                        @error('nomor_rekening') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Atas Nama</label>
                        <input type="text" name="atas_nama" value="{{ old('atas_nama') }}" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors"
                            placeholder="Contoh: Alan Group Sisingaan">
                        @error('atas_nama') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-3 bg-dark-800/50 p-4 rounded-xl border border-dark-700">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-dark-600 text-primary-500 focus:ring-primary-500 focus:ring-offset-dark-900 bg-dark-700">
                        <label for="is_active" class="text-sm font-medium text-white">Status Aktif</label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all shadow-lg shadow-primary-500/25">
                            Simpan Rekening Bank
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

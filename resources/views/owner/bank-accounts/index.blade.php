<x-layout title="Kelola Rekening Bank">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
                <div>
                    <a href="{{ route('owner.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400">← Kembali ke Dashboard</a>
                    <h1 class="text-2xl font-bold mt-2">Kelola Rekening Bank</h1>
                    <p class="text-dark-400 text-sm">Atur rekening bank untuk tujuan transfer pembayaran pelanggan.</p>
                </div>
                <a href="{{ route('owner.bank-accounts.create') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-primary-500 text-dark-950 hover:bg-primary-400 transition-all shadow-lg shadow-primary-500/25">
                    + Tambah Rekening
                </a>
            </div>

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 flex items-center justify-between">
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="text-green-400/60 hover:text-green-400">&times;</button>
                </div>
            @endif

            <div class="glass rounded-2xl overflow-hidden">
                @if($banks->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-dark-800/50 border-b border-dark-700">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Nama Bank</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Kode</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">No. Rekening</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Atas Nama</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Status</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-dark-800">
                                @foreach($banks as $bank)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="px-6 py-4 font-medium">{{ $bank->nama_bank }}</td>
                                        <td class="px-6 py-4 text-dark-400 font-mono">{{ $bank->kode_bank }}</td>
                                        <td class="px-6 py-4 text-dark-400">{{ $bank->nomor_rekening }}</td>
                                        <td class="px-6 py-4 text-dark-400">{{ $bank->atas_nama }}</td>
                                        <td class="px-6 py-4">
                                            @if($bank->is_active)
                                                <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-green-500/10 text-green-400">Aktif</span>
                                            @else
                                                <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-red-500/10 text-red-400">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('owner.bank-accounts.edit', $bank) }}" class="p-2 rounded-lg text-blue-400 hover:bg-blue-500/10 transition-colors" title="Edit">
                                                    <x-heroicon-o-pencil-square class="w-4 h-4" />
                                                </a>
                                                <form method="POST" action="{{ route('owner.bank-accounts.destroy', $bank) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekening ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 rounded-lg text-red-400 hover:bg-red-500/10 transition-colors" title="Hapus">
                                                        <x-heroicon-o-trash class="w-4 h-4" />
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center text-dark-400">
                        <x-heroicon-o-credit-card class="w-12 h-12 text-dark-600 mx-auto mb-4" />
                        <p>Belum ada rekening bank yang ditambahkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

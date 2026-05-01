<x-layout title="Kelola Testimoni">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400">← Dashboard</a>
                <h1 class="text-2xl font-bold mt-2">Kelola Testimoni</h1>
                <p class="text-dark-400 text-sm mt-1">Setujui atau tolak testimoni dari pelanggan.</p>
            </div>

            <div class="glass rounded-2xl overflow-hidden">
                @if($testimonials->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-dark-800/50 border-b border-dark-700">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Pelanggan</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Acara</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Rating</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Testimoni</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Status</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-dark-800">
                                @foreach($testimonials as $testi)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="px-6 py-4 font-medium">{{ $testi->user->name }}</td>
                                        <td class="px-6 py-4 text-dark-400">{{ $testi->booking->nama_acara ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-0.5">
                                                @for($i = 0; $i < $testi->rating; $i++)
                                                    <x-heroicon-s-star class="w-3.5 h-3.5 text-primary-400" />
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-dark-300 max-w-xs truncate">{{ Str::limit($testi->deskripsi, 80) }}</td>
                                        <td class="px-6 py-4">
                                            @if($testi->is_approved)
                                                <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-green-500/10 text-green-400">Disetujui</span>
                                            @else
                                                <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-yellow-500/10 text-yellow-400">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <form method="POST" action="{{ route('admin.testimonials.toggle', $testi) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="p-2 rounded-lg transition-colors {{ $testi->is_approved ? 'text-yellow-400 hover:bg-yellow-500/10' : 'text-green-400 hover:bg-green-500/10' }}" title="{{ $testi->is_approved ? 'Batalkan Persetujuan' : 'Setujui' }}">
                                                        @if($testi->is_approved)
                                                            <x-heroicon-o-x-circle class="w-4 h-4" />
                                                        @else
                                                            <x-heroicon-o-check-circle class="w-4 h-4" />
                                                        @endif
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.testimonials.destroy', $testi) }}" onsubmit="return confirm('Hapus testimoni ini?')">
                                                    @csrf @method('DELETE')
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
                        <x-heroicon-o-chat-bubble-bottom-center-text class="w-12 h-12 text-dark-600 mx-auto mb-4" />
                        <p>Belum ada testimoni dari pelanggan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

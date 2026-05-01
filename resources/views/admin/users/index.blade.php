<x-layout title="Kelola Admin">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">← Kembali ke Dashboard</a>
                    <h1 class="text-2xl font-bold mt-2 flex items-center gap-2">
                        <x-heroicon-o-shield-check class="w-6 h-6 text-primary-400" /> Kelola Admin
                    </h1>
                    <p class="text-dark-400 text-sm">Manajemen akun administrator sistem.</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all shadow-lg shadow-primary-500/25">
                    <x-heroicon-o-plus class="w-4 h-4" /> Tambah Admin Baru
                </a>
            </div>

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 flex items-center justify-between">
                    <span class="text-sm font-medium flex items-center gap-2">
                        <x-heroicon-o-check-circle class="w-5 h-5" /> {{ session('success') }}
                    </span>
                    <button @click="show = false" class="text-green-400/60 hover:text-green-400">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-between">
                    <span class="text-sm font-medium flex items-center gap-2">
                        <x-heroicon-o-exclamation-circle class="w-5 h-5" /> {{ session('error') }}
                    </span>
                    <button @click="show = false" class="text-red-400/60 hover:text-red-400">&times;</button>
                </div>
            @endif

            <div class="glass rounded-2xl overflow-hidden">
                @if($users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-dark-800/50 border-b border-dark-700">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Nama</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Email</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">No. HP</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300">Status</th>
                                    <th class="px-6 py-4 font-semibold text-dark-300 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-dark-800">
                                @foreach($users as $user)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-primary-500/10 flex items-center justify-center">
                                                    <x-heroicon-o-user class="w-4 h-4 text-primary-400" />
                                                </div>
                                                <div>
                                                    <div class="font-medium">{{ $user->name }}</div>
                                                    @if($user->id === auth()->id())
                                                        <span class="text-xs text-primary-400">(Anda)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-dark-400">{{ $user->email }}</td>
                                        <td class="px-6 py-4 text-dark-400">{{ $user->phone ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            @if($user->status === 'active')
                                                <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-green-500/10 text-green-400">Aktif</span>
                                            @else
                                                <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-red-500/10 text-red-400">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 rounded-lg text-blue-400 hover:bg-blue-500/10 transition-colors" title="Edit">
                                                    <x-heroicon-o-pencil-square class="w-4 h-4" />
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 rounded-lg text-red-400 hover:bg-red-500/10 transition-colors" title="Hapus">
                                                            <x-heroicon-o-trash class="w-4 h-4" />
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center text-dark-400">
                        <x-heroicon-o-shield-check class="w-12 h-12 text-dark-600 mx-auto mb-4" />
                        <p>Belum ada akun admin yang ditambahkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

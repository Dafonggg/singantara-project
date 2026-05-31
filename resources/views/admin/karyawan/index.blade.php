<x-layout title="Kelola Karyawan">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400">← Dashboard</a>
                    <h1 class="text-2xl font-bold mt-2">Kelola Karyawan</h1>
                </div>
                <a href="{{ route('admin.karyawan.create') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950">+ Tambah Karyawan</a>
            </div>

            <div class="glass rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead><tr class="border-b border-dark-700">
                        <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Nama</th>
                        <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Peran</th>
                        <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Email</th>
                        <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Telepon</th>
                        <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Status</th>
                        <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Aksi</th>
                    </tr></thead>
                    <tbody class="divide-y divide-dark-800">
                        @foreach($karyawans as $k)
                            <tr class="hover:bg-white/5">
                                <td class="px-5 py-4 text-sm font-semibold">
                                    {{ $k->name }}
                                    <div class="text-xs text-dark-500 font-normal">&#64;{{ $k->username }}</div>
                                </td>
                                <td class="px-5 py-4 text-sm text-dark-300 font-medium">{{ $k->peran ?? '-' }}</td>
                                <td class="px-5 py-4 text-sm text-dark-400">{{ $k->email }}</td>
                                <td class="px-5 py-4 text-sm">{{ $k->phone ?? '-' }}</td>
                                <td class="px-5 py-4"><span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $k->status === 'active' ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">{{ ucfirst($k->status) }}</span></td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.karyawan.edit', $k) }}" class="p-1.5 rounded-lg text-primary-400 hover:text-primary-300 hover:bg-primary-400/10 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.karyawan.destroy', $k) }}" onsubmit="return confirm('Hapus karyawan?')">
                                            @csrf @method('DELETE')
                                            <button class="p-1.5 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-400/10 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>

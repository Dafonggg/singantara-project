<x-layout title="Kelola Booking">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400">← Dashboard</a>
                    <h1 class="text-2xl font-bold mt-2">Kelola Booking</h1>
                </div>
            </div>

            {{-- Filters --}}
            <form method="GET" class="flex flex-wrap gap-3 mb-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari booking..." class="px-4 py-2.5 rounded-xl bg-dark-800/50 border border-dark-700 text-white text-sm focus:outline-none focus:border-primary-500 transition-colors w-64">
                <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl bg-dark-800/50 border border-dark-700 text-white text-sm focus:outline-none focus:border-primary-500 transition-colors">
                    <option value="">Semua Status</option>
                    @foreach(['pending','confirmed','dp_paid','paid','ongoing','completed','cancelled'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-semibold bg-primary-500/10 text-primary-400 border border-primary-500/20 hover:bg-primary-500/20 transition-all">Cari</button>
            </form>

            {{-- Booking Table --}}
            <div class="glass rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-dark-700">
                                <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Kode</th>
                                <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Pelanggan</th>
                                <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Paket</th>
                                <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Tanggal</th>
                                <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Status</th>
                                <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-800">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-5 py-4 text-sm font-mono">{{ $booking->kode_booking }}</td>
                                    <td class="px-5 py-4 text-sm">{{ $booking->user->name }}</td>
                                    <td class="px-5 py-4 text-sm">{{ $booking->paket->nama }}</td>
                                    <td class="px-5 py-4 text-sm">{{ $booking->tanggal_acara->format('d/m/Y') }}</td>
                                    <td class="px-5 py-4">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                            {{ $booking->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400' : ($booking->status === 'cancelled' ? 'bg-red-500/10 text-red-400' : 'bg-green-500/10 text-green-400') }}
                                        ">{{ $booking->status_label }}</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-sm text-primary-400 hover:text-primary-300">Detail →</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12 text-dark-400">Tidak ada booking ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-dark-800">{{ $bookings->links() }}</div>
            </div>
        </div>
    </div>
</x-layout>

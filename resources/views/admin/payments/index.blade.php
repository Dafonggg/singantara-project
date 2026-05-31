<x-layout title="Verifikasi Pembayaran">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400">← Dashboard</a>
            <h1 class="text-2xl font-bold mt-2 mb-6">Verifikasi Pembayaran</h1>

            <div class="flex gap-3 mb-6">
                <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 rounded-xl text-sm {{ !request('status') ? 'bg-primary-500/10 text-primary-400 border-primary-500/20' : 'text-dark-400 border-dark-700' }} border transition-all">Semua</a>
                <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-sm {{ request('status') === 'pending' ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' : 'text-dark-400 border-dark-700' }} border transition-all">Pending</a>
                <a href="{{ route('admin.payments.index', ['status' => 'verified']) }}" class="px-4 py-2 rounded-xl text-sm {{ request('status') === 'verified' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'text-dark-400 border-dark-700' }} border transition-all">Verified</a>
            </div>

            <div class="glass rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead><tr class="border-b border-dark-700">
                            <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Pelanggan</th>
                            <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Booking</th>
                            <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Jenis</th>
                            <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Jumlah</th>
                            <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Status</th>
                            <th class="text-left text-xs font-semibold text-dark-400 uppercase px-5 py-4">Aksi</th>
                        </tr></thead>
                        <tbody class="divide-y divide-dark-800">
                            @forelse($payments as $payment)
                                <tr class="hover:bg-white/5">
                                    <td class="px-5 py-4 text-sm">{{ $payment->booking->user->name ?? '-' }}</td>
                                    <td class="px-5 py-4 text-sm font-mono">{{ $payment->booking->kode_booking }}</td>
                                    <td class="px-5 py-4 text-sm">{{ ucfirst($payment->jenis) }}</td>
                                    <td class="px-5 py-4 text-sm font-semibold">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-5 py-4">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $payment->status === 'verified' ? 'bg-green-500/10 text-green-400' : ($payment->status === 'rejected' ? 'bg-red-500/10 text-red-400' : 'bg-yellow-500/10 text-yellow-400') }}">{{ $payment->status_label }}</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-1">
                                            @if($payment->bukti_transfer)
                                                <a href="{{ asset('storage/' . $payment->bukti_transfer) }}" target="_blank" class="p-2 rounded-lg text-primary-400 hover:bg-primary-500/10 transition-colors" title="Lihat Bukti">
                                                    <x-heroicon-o-eye class="w-4 h-4" />
                                                </a>
                                            @endif
                                            @if($payment->status === 'pending')
                                                <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="action" value="verify">
                                                    <button type="submit" class="p-2 rounded-lg text-green-400 hover:bg-green-500/10 transition-colors" title="Verifikasi">
                                                        <x-heroicon-o-check-circle class="w-4 h-4" />
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="p-2 rounded-lg text-red-400 hover:bg-red-500/10 transition-colors" title="Tolak">
                                                        <x-heroicon-o-x-circle class="w-4 h-4" />
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-12 text-dark-400">Tidak ada pembayaran</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-dark-800">{{ $payments->links() }}</div>
            </div>
        </div>
    </div>
</x-layout>

<x-layout title="Laporan Pendapatan">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <a href="{{ route('owner.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">← Kembali ke Dashboard</a>
                    <h1 class="text-2xl sm:text-3xl font-bold mt-2">📊 Laporan Pendapatan</h1>
                    <p class="text-dark-400 mt-1">Filter data pembayaran berdasarkan periode</p>
                </div>
            </div>

            {{-- Filter --}}
            <div class="glass rounded-2xl p-6 mb-6">
                <form method="GET" action="{{ route('owner.report') }}" class="flex flex-col sm:flex-row items-end gap-4">
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-dark-300 mb-2">Dari Tanggal</label>
                        <input type="date" name="dari_tanggal" value="{{ $dariTanggal }}"
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-dark-300 mb-2">Sampai Tanggal</label>
                        <input type="date" name="sampai_tanggal" value="{{ $sampaiTanggal }}"
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="flex-1 sm:flex-none px-6 py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 transition-all">
                            🔍 Filter
                        </button>
                        <a href="{{ route('owner.report') }}" class="flex-1 sm:flex-none px-6 py-3 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-dark-500 transition-all text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">💰</div>
                    <div class="text-xl font-bold text-gradient">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</div>
                    <div class="text-sm text-dark-400 mt-1">Total Pendapatan</div>
                </div>
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">📋</div>
                    <div class="text-xl font-bold">{{ $summary['jumlah_transaksi'] }}</div>
                    <div class="text-sm text-dark-400 mt-1">Jumlah Transaksi</div>
                </div>
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">💵</div>
                    <div class="text-xl font-bold text-blue-400">Rp {{ number_format($summary['total_dp'], 0, ',', '.') }}</div>
                    <div class="text-sm text-dark-400 mt-1">Total DP</div>
                </div>
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">✅</div>
                    <div class="text-xl font-bold text-green-400">Rp {{ number_format($summary['total_pelunasan'], 0, ',', '.') }}</div>
                    <div class="text-sm text-dark-400 mt-1">Total Pelunasan</div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 mb-6">
                <a href="{{ route('owner.report.export', ['dari_tanggal' => $dariTanggal, 'sampai_tanggal' => $sampaiTanggal]) }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 transition-all">
                    <x-heroicon-o-document-arrow-down class="w-4 h-4" /> Export PDF
                </a>
            </div>

            {{-- Data Table --}}
            <div class="glass rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-dark-700 flex items-center justify-between">
                    <h2 class="font-bold">Data Pembayaran Terverifikasi</h2>
                    @if($dariTanggal && $sampaiTanggal)
                        <span class="text-xs text-dark-400">Periode: {{ \Carbon\Carbon::parse($dariTanggal)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($sampaiTanggal)->format('d/m/Y') }}</span>
                    @endif
                </div>

                @if($payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-dark-800">
                                    <th class="text-left px-5 py-3 text-dark-400 font-medium">Tanggal</th>
                                    <th class="text-left px-5 py-3 text-dark-400 font-medium">Kode Booking</th>
                                    <th class="text-left px-5 py-3 text-dark-400 font-medium">Pelanggan</th>
                                    <th class="text-left px-5 py-3 text-dark-400 font-medium">Paket</th>
                                    <th class="text-left px-5 py-3 text-dark-400 font-medium">Jenis</th>
                                    <th class="text-left px-5 py-3 text-dark-400 font-medium">Metode</th>
                                    <th class="text-right px-5 py-3 text-dark-400 font-medium">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-dark-800">
                                @foreach($payments as $payment)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="px-5 py-4 text-dark-300">{{ $payment->verified_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                        <td class="px-5 py-4 font-mono text-xs">{{ $payment->booking->kode_booking ?? '-' }}</td>
                                        <td class="px-5 py-4">{{ $payment->booking->user->name ?? '-' }}</td>
                                        <td class="px-5 py-4 text-dark-300">{{ $payment->booking->paket->nama ?? '-' }}</td>
                                        <td class="px-5 py-4">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $payment->jenis === 'dp' ? 'bg-blue-500/10 text-blue-400' : 'bg-green-500/10 text-green-400' }}">
                                                {{ ucfirst($payment->jenis) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-dark-300 text-xs">{{ ucfirst(str_replace('_', ' ', $payment->metode)) }}</td>
                                        <td class="px-5 py-4 text-right font-semibold text-primary-400">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-dark-700 bg-dark-800/30">
                                    <td colspan="6" class="px-5 py-4 font-bold text-right">Total:</td>
                                    <td class="px-5 py-4 text-right font-bold text-xl text-gradient">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="text-4xl mb-3">📭</div>
                        <p class="text-dark-400">Tidak ada data pembayaran untuk periode ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

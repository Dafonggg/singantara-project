<x-layout title="Admin Dashboard">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold">Dashboard Admin 🛡️</h1>
                <p class="text-dark-400 mt-1">Overview sistem SIGANTARA</p>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @php
                    $statCards = [
                        ['label' => 'Total Booking', 'value' => $stats['total_bookings'], 'icon' => '📋', 'color' => 'primary'],
                        ['label' => 'Pending', 'value' => $stats['pending_bookings'], 'icon' => '⏳', 'color' => 'yellow'],
                        ['label' => 'Pendapatan', 'value' => 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.'), 'icon' => '💰', 'color' => 'accent'],
                        ['label' => 'Pelanggan', 'value' => $stats['total_customers'], 'icon' => '👥', 'color' => 'blue'],
                    ];
                @endphp
                @foreach($statCards as $card)
                    <div class="glass rounded-2xl p-5">
                        <div class="text-2xl mb-2">{{ $card['icon'] }}</div>
                        <div class="text-2xl font-bold">{{ $card['value'] }}</div>
                        <div class="text-sm text-dark-400 mt-1">{{ $card['label'] }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Quick Nav --}}
            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-primary-500 hover:text-primary-400 transition-all">📋 Kelola Booking</a>
                <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-primary-500 hover:text-primary-400 transition-all">💳 Pembayaran ({{ $stats['pending_payments'] }})</a>
                <a href="{{ route('admin.paket.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-primary-500 hover:text-primary-400 transition-all">📦 Manage Paket</a>
                <a href="{{ route('admin.karyawan.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-primary-500 hover:text-primary-400 transition-all">👷 Karyawan ({{ $stats['total_karyawan'] }})</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Recent Bookings --}}
                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-dark-700 flex items-center justify-between">
                        <h2 class="font-bold">Booking Terbaru</h2>
                        <a href="{{ route('admin.bookings.index') }}" class="text-xs text-primary-400 hover:text-primary-300">Lihat Semua →</a>
                    </div>
                    <div class="divide-y divide-dark-800">
                        @foreach($recentBookings as $booking)
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="flex items-center justify-between p-4 hover:bg-white/5 transition-colors">
                                <div>
                                    <div class="text-sm font-semibold">{{ $booking->nama_acara }}</div>
                                    <div class="text-xs text-dark-500">{{ $booking->user->name }} · {{ $booking->kode_booking }}</div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                    {{ $booking->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400' : 'bg-green-500/10 text-green-400' }}
                                ">{{ $booking->status_label }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Pending Payments --}}
                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-dark-700 flex items-center justify-between">
                        <h2 class="font-bold">Menunggu Verifikasi Bayar</h2>
                        <a href="{{ route('admin.payments.index') }}" class="text-xs text-primary-400 hover:text-primary-300">Lihat Semua →</a>
                    </div>
                    @if($pendingPayments->count() > 0)
                        <div class="divide-y divide-dark-800">
                            @foreach($pendingPayments as $payment)
                                <div class="flex items-center justify-between p-4">
                                    <div>
                                        <div class="text-sm font-semibold">{{ $payment->booking->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-dark-500">{{ ucfirst($payment->jenis) }} · Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-500/10 text-yellow-400">Pending</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center text-dark-400 text-sm">Tidak ada pembayaran menunggu ✅</div>
                    @endif
                </div>
            </div>

            {{-- Revenue Chart --}}
            <div class="glass rounded-2xl p-6 mt-6">
                <h2 class="font-bold text-lg mb-4">📊 Pendapatan 6 Bulan Terakhir</h2>
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json(collect($monthlyRevenue)->pluck('month')),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: @json(collect($monthlyRevenue)->pluck('total')),
                        backgroundColor: 'rgba(249, 168, 37, 0.3)',
                        borderColor: 'rgba(249, 168, 37, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { labels: { color: '#9ca3af' } } },
                    scales: {
                        x: { ticks: { color: '#6b7280' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                        y: { ticks: { color: '#6b7280', callback: v => 'Rp ' + v.toLocaleString('id-ID') }, grid: { color: 'rgba(255,255,255,0.05)' } }
                    }
                }
            });
        </script>
    </x-slot:scripts>
</x-layout>

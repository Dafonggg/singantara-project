<x-layout title="Dashboard Owner">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold">Dashboard Pemilik 👑</h1>
                <p class="text-dark-400 mt-1">Overview bisnis SIGANTARA</p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">📋</div>
                    <div class="text-2xl font-bold">{{ $stats['total_bookings'] }}</div>
                    <div class="text-sm text-dark-400 mt-1">Total Booking</div>
                </div>
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">✅</div>
                    <div class="text-2xl font-bold">{{ $stats['completed_bookings'] }}</div>
                    <div class="text-sm text-dark-400 mt-1">Selesai</div>
                </div>
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">💰</div>
                    <div class="text-2xl font-bold text-gradient">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                    <div class="text-sm text-dark-400 mt-1">Total Pendapatan</div>
                </div>
                <div class="glass rounded-2xl p-5">
                    <div class="text-2xl mb-2">👥</div>
                    <div class="text-2xl font-bold">{{ $stats['total_customers'] }}</div>
                    <div class="text-sm text-dark-400 mt-1">Pelanggan</div>
                </div>
            </div>

            {{-- Revenue Chart --}}
            <div class="glass rounded-2xl p-6 mb-6">
                <h2 class="font-bold text-lg mb-4">📊 Pendapatan 6 Bulan Terakhir</h2>
                <canvas id="ownerChart" height="100"></canvas>
            </div>

            {{-- Recent Bookings --}}
            <div class="glass rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-dark-700"><h2 class="font-bold">Booking Terbaru</h2></div>
                <div class="divide-y divide-dark-800">
                    @foreach($recentBookings as $booking)
                        <div class="flex items-center justify-between p-4">
                            <div>
                                <div class="text-sm font-semibold">{{ $booking->nama_acara }}</div>
                                <div class="text-xs text-dark-500">{{ $booking->user->name }} · {{ $booking->paket->nama }} · {{ $booking->tanggal_acara->format('d/m/Y') }}</div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $booking->status === 'completed' ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">{{ $booking->status_label }}</span>
                                <div class="text-sm font-semibold text-primary-400 mt-1">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            new Chart(document.getElementById('ownerChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json(collect($monthlyRevenue)->pluck('month')),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: @json(collect($monthlyRevenue)->pluck('total')),
                        borderColor: 'rgba(249, 168, 37, 1)',
                        backgroundColor: 'rgba(249, 168, 37, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgba(249, 168, 37, 1)',
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

<x-layout title="Detail Booking">
    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('customer.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">← Kembali ke Dashboard</a>
            </div>

            {{-- Flash Messages (Bug 2: success/error notification) --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 flex items-center gap-3">
                    <span class="text-lg"><x-heroicon-o-check-circle class="w-5 h-5 text-green-400" /></span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-green-400/60 hover:text-green-400 transition-colors">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 6000)" class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center gap-3">
                    <span class="text-lg"><x-heroicon-o-x-circle class="w-5 h-5 text-red-400" /></span>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto text-red-400/60 hover:text-red-400 transition-colors">&times;</button>
                </div>
            @endif

            {{-- Booking Header --}}
            <div class="glass rounded-2xl p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-xl sm:text-2xl font-bold">{{ $booking->nama_acara }}</h1>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @switch($booking->status_color)
                                    @case('yellow') bg-yellow-500/10 text-yellow-400 @break
                                    @case('blue') bg-blue-500/10 text-blue-400 @break
                                    @case('green') bg-green-500/10 text-green-400 @break
                                    @case('red') bg-red-500/10 text-red-400 @break
                                    @default bg-gray-500/10 text-gray-400
                                @endswitch
                            ">{{ $booking->status_label }}</span>
                        </div>
                        <p class="text-sm text-dark-400">{{ $booking->kode_booking }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-dark-400">Total Harga</div>
                        <div class="text-2xl font-bold text-gradient">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Booking Detail --}}
                <div class="glass rounded-2xl p-6 space-y-4">
                    <h2 class="font-bold text-lg mb-4">Detail Acara</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between"><span class="text-dark-400 text-sm">Paket</span><span class="text-sm font-medium">{{ $booking->paket->nama }}</span></div>
                        <div class="flex justify-between"><span class="text-dark-400 text-sm">Tanggal</span><span class="text-sm font-medium">{{ $booking->tanggal_acara->translatedFormat('l, d F Y') }}</span></div>
                        <div class="flex justify-between"><span class="text-dark-400 text-sm">Jam</span><span class="text-sm font-medium">{{ $booking->jam_acara }}</span></div>
                        <div class="flex justify-between"><span class="text-dark-400 text-sm">Alamat</span><span class="text-sm font-medium text-right max-w-[200px]">{{ $booking->alamat }}</span></div>
                        @if($booking->catatan)
                            <div class="flex justify-between"><span class="text-dark-400 text-sm">Catatan</span><span class="text-sm text-right max-w-[200px]">{{ $booking->catatan }}</span></div>
                        @endif
                    </div>

                    {{-- Map --}}
                    @if($booking->latitude && $booking->longitude)
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-dark-300 mb-2">Lokasi di Peta</h3>
                            <div id="detail-map" style="height: 200px; border-radius: 0.75rem; z-index: 1;" class="border border-dark-700"></div>
                        </div>
                    @endif
                </div>

                {{-- Payment Section --}}
                <div class="space-y-6">
                    {{-- Payment History --}}
                    <div class="glass rounded-2xl p-6">
                        <h2 class="font-bold text-lg mb-4">Riwayat Pembayaran</h2>
                        @if($booking->payments->count() > 0)
                            <div class="space-y-3">
                                @foreach($booking->payments as $payment)
                                    <div class="bg-dark-800/50 rounded-xl p-4">
                                        <div class="flex justify-between mb-2">
                                            <span class="text-sm font-semibold">{{ ucfirst($payment->jenis) }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded-full {{ $payment->status === 'verified' ? 'bg-green-500/10 text-green-400' : ($payment->status === 'rejected' ? 'bg-red-500/10 text-red-400' : 'bg-yellow-500/10 text-yellow-400') }}">
                                                {{ $payment->status_label }}
                                            </span>
                                        </div>
                                        <div class="text-lg font-bold">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</div>
                                        <div class="text-xs text-dark-500 mt-1">{{ ucfirst(str_replace('_', ' ', $payment->metode)) }} · {{ $payment->created_at->translatedFormat('d M Y H:i') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-dark-400">Belum ada pembayaran.</p>
                        @endif
                    </div>

                    {{-- Upload Payment --}}
                    @php
                        $hasPendingPayment = $booking->payments->where('status', 'pending')->count() > 0;
                        $dpVerified = $booking->payments->where('jenis', 'dp')->where('status', 'verified')->count() > 0
                                      || in_array($booking->status, ['dp_paid', 'paid', 'ongoing', 'completed']);
                        $pelunasanVerified = $booking->payments->where('jenis', 'pelunasan')->where('status', 'verified')->count() > 0
                                             || in_array($booking->status, ['paid', 'ongoing', 'completed']);
                        $allowedStatuses = ['confirmed', 'dp_paid', 'paid', 'ongoing'];
                        $canUpload = in_array($booking->status, $allowedStatuses) && !$hasPendingPayment && !$pelunasanVerified;
                        $totalPaid = $booking->payments->where('status', 'verified')->sum('jumlah');
                        $remainingBalance = $booking->total_harga - $totalPaid;
                    @endphp

                    {{-- DP Hangus Warning Notice --}}
                    @if(!$pelunasanVerified && !in_array($booking->status, ['completed', 'cancelled']))
                        <div class="p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 flex items-start gap-3">
                            <span class="text-lg shrink-0 mt-0.5"><x-heroicon-o-exclamation-triangle class="w-5 h-5 text-yellow-400" /></span>
                            <div class="text-xs">
                                <span class="font-semibold block mb-0.5">Penting: Ketentuan Batas Pembayaran</span>
                                Harap lakukan pelunasan pembayaran sebelum tanggal acara ({{ $booking->tanggal_acara->translatedFormat('d F Y') }}). Jika pelunasan tidak diselesaikan hingga tanggal tersebut, maka booking dianggap batal dan DP yang telah dibayarkan akan hangus.
                            </div>
                        </div>
                    @endif

                    {{-- Status: Pending — Waiting for admin confirmation --}}
                    @if($booking->status === 'pending')
                        <div class="glass rounded-2xl p-6">
                            <div class="flex items-center gap-3 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20">
                                <span class="text-2xl"><x-heroicon-o-clipboard-document-list class="w-6 h-6 text-blue-400" /></span>
                                <div>
                                    <div class="text-sm font-semibold text-blue-400">Menunggu Konfirmasi Admin</div>
                                    <div class="text-xs text-dark-400 mt-0.5">Booking Anda sedang menunggu konfirmasi dari admin. Anda bisa melakukan pembayaran setelah booking dikonfirmasi.</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Status: Cancelled --}}
                    @if($booking->status === 'cancelled')
                        <div class="glass rounded-2xl p-6">
                            <div class="flex items-center gap-3 p-4 rounded-xl bg-red-500/10 border border-red-500/20">
                                <span class="text-2xl"><x-heroicon-o-x-circle class="w-6 h-6 text-red-400" /></span>
                                <div>
                                    <div class="text-sm font-semibold text-red-400">Booking Dibatalkan</div>
                                    <div class="text-xs text-dark-400 mt-0.5">Booking ini telah dibatalkan. Anda tidak dapat melakukan pembayaran.</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Has pending payment — waiting for verification --}}
                    @if($hasPendingPayment)
                        <div class="glass rounded-2xl p-6">
                            <div class="flex items-center gap-3 p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/20">
                                <span class="text-2xl"><x-heroicon-o-clock class="w-6 h-6 text-yellow-400" /></span>
                                <div>
                                    <div class="text-sm font-semibold text-yellow-400">Menunggu Verifikasi</div>
                                    <div class="text-xs text-dark-400 mt-0.5">Pembayaran Anda sedang diverifikasi oleh admin. Anda tidak dapat mengupload pembayaran baru sampai pembayaran sebelumnya diverifikasi.</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($canUpload)
                        <div class="glass rounded-2xl p-6">
                            <h2 class="font-bold text-lg mb-4">Upload Bukti Pembayaran</h2>

                            {{-- Bank Transfer Info --}}
                            <div class="mb-5 space-y-3">
                                <h3 class="text-sm font-medium text-dark-300 mb-2 flex items-center gap-1.5"><x-heroicon-o-credit-card class="w-4 h-4 text-primary-400" /> Rekening Tujuan Transfer</h3>
                                <div class="space-y-2">
                                    @foreach($bankAccounts as $bank)
                                    <div class="bg-dark-800/50 rounded-xl p-4 flex items-center justify-between" x-data>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-primary-600/20 rounded-lg flex items-center justify-center text-xs font-bold text-primary-400">
                                                {{ strtoupper(substr($bank->nama_bank, 0, 3)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold">{{ $bank->nama_bank }}</div>
                                                <div class="text-xs text-dark-400 font-mono">{{ $bank->nomor_rekening }}</div>
                                                <div class="text-xs text-dark-500">a.n. {{ $bank->atas_nama }}</div>
                                            </div>
                                        </div>
                                        <button type="button" @click="navigator.clipboard.writeText('{{ $bank->nomor_rekening }}'); $el.textContent = '✓ Copied'" class="text-xs text-primary-400 hover:text-primary-300 transition-colors px-3 py-1.5 rounded-lg bg-primary-500/10 hover:bg-primary-500/20">Copy</button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <form method="POST" action="{{ route('customer.booking.payment', $booking) }}" enctype="multipart/form-data" class="space-y-4"
                                x-data="{
                                    fileSelected: false,
                                    fileName: '',
                                    metode: '',
                                    jenis: '{{ !$dpVerified ? 'dp' : 'pelunasan' }}',
                                    jumlah: 0,
                                    totalHarga: {{ $booking->total_harga }},
                                    remainingBalance: {{ $remainingBalance }},
                                    get maxAmount() {
                                        return this.jenis === 'dp' ? (this.totalHarga * 0.5) : this.remainingBalance;
                                    },
                                    init() {
                                        this.updateAmount();
                                    },
                                    updateAmount() {
                                        this.jumlah = this.maxAmount;
                                    },
                                    handleInput(e) {
                                        let val = parseFloat(e.target.value);
                                        if (isNaN(val)) {
                                            this.jumlah = '';
                                            return;
                                        }
                                        if (val > this.maxAmount) {
                                            this.jumlah = this.maxAmount;
                                        } else if (val < 0) {
                                            this.jumlah = 0;
                                        } else {
                                            this.jumlah = val;
                                        }
                                    }
                                }">
                                @csrf

                                {{-- Validation Errors --}}
                                @if($errors->any())
                                    <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20">
                                        <div class="text-sm font-semibold text-red-400 mb-2 flex items-center gap-1.5"><x-heroicon-o-exclamation-triangle class="w-4 h-4" /> Terjadi kesalahan:</div>
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li class="text-xs text-red-400">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-dark-300 mb-2">Jenis Pembayaran</label>
                                    <select name="jenis" x-model="jenis" x-on:change="updateAmount()" class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                                        @if(!$dpVerified)
                                            <option value="dp">DP (50%)</option>
                                            <option value="pelunasan">Pelunasan</option>
                                        @endif
                                        @if($dpVerified)
                                            <option value="pelunasan">Pelunasan</option>
                                        @endif
                                    </select>
                                    @error('jenis') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-dark-300 mb-2">Metode Pembayaran</label>
                                    <select name="metode" x-model="metode" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors">
                                        <option value="">-- Pilih Bank Tujuan --</option>
                                        @foreach($bankAccounts as $bank)
                                            <option value="{{ $bank->kode_bank }}">Transfer {{ $bank->nama_bank }} ({{ $bank->nomor_rekening }})</option>
                                        @endforeach
                                    </select>
                                    @error('metode') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-dark-300 mb-2">Jumlah (Rp)</label>
                                    <input type="number" name="jumlah" x-model.number="jumlah" x-on:input="handleInput($event)" :max="maxAmount" required class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 transition-colors" placeholder="0">
                                    <p class="mt-1.5 text-xs text-dark-400" x-show="jenis === 'dp'">
                                        Batas maksimal DP (50%): <span class="text-primary-400 font-semibold">Rp <span x-text="new Intl.NumberFormat('id-ID').format(totalHarga * 0.5)"></span></span>
                                    </p>
                                    <p class="mt-1.5 text-xs text-dark-400" x-show="jenis === 'pelunasan'">
                                        Sisa tagihan yang harus dibayar: <span class="text-primary-400 font-semibold">Rp <span x-text="new Intl.NumberFormat('id-ID').format(remainingBalance)"></span></span>
                                    </p>
                                    @error('jumlah') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-dark-300 mb-2">Bukti Transfer <span class="text-red-400">*</span></label>
                                    <input type="file" name="bukti_transfer" accept="image/*" required
                                        x-on:change="fileSelected = $event.target.files.length > 0; fileName = $event.target.files.length > 0 ? $event.target.files[0].name : ''"
                                        class="w-full text-sm text-dark-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-500/10 file:text-primary-400 hover:file:bg-primary-500/20">
                                    {{-- File selected indicator --}}
                                    <div x-show="fileSelected" x-transition class="mt-2 flex items-center gap-2 text-xs text-accent-400">
                                        <svg class="w-4 h-4 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span x-text="fileName"></span>
                                    </div>
                                    <div x-show="!fileSelected || !metode" class="mt-2 text-xs text-dark-500 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span x-text="!metode ? 'Pilih metode pembayaran (rekening tujuan) terlebih dahulu' : 'Upload bukti transfer terlebih dahulu untuk mengaktifkan tombol'"></span>
                                    </div>
                                    @error('bukti_transfer') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <button type="submit" :disabled="!fileSelected || !metode"
                                    class="w-full py-3 rounded-xl text-sm font-bold transition-all"
                                    :class="fileSelected && metode
                                        ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 hover:from-primary-400 hover:to-primary-500 shadow-lg shadow-primary-500/25 cursor-pointer'
                                        : 'bg-dark-700 text-dark-500 cursor-not-allowed'">
                                    <span x-show="!fileSelected || !metode" class="inline-flex items-center gap-1">
                                        <x-heroicon-o-lock-closed class="w-4 h-4" />
                                        <span x-text="!metode ? 'Pilih Metode Pembayaran' : 'Upload Bukti Transfer Dulu'"></span>
                                    </span>
                                    <span x-show="fileSelected && metode" class="inline-flex items-center gap-1"><x-heroicon-o-check-badge class="w-4 h-4" /> Upload Pembayaran</span>
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($pelunasanVerified)
                        <div class="glass rounded-2xl p-6">
                            <div class="flex items-center gap-3 p-4 rounded-xl bg-green-500/10 border border-green-500/20">
                                <span class="text-2xl"><x-heroicon-s-sparkles class="w-6 h-6 text-green-400" /></span>
                                <div>
                                    <div class="text-sm font-semibold text-green-400">Pembayaran Lunas</div>
                                    <div class="text-xs text-dark-400 mt-0.5">Semua pembayaran telah terverifikasi. Terima kasih!</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($booking->latitude && $booking->longitude)
        <x-slot:scripts>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const map = L.map('detail-map').setView([{{ $booking->latitude }}, {{ $booking->longitude }}], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(map);
                    L.marker([{{ $booking->latitude }}, {{ $booking->longitude }}]).addTo(map)
                        .bindPopup('{{ $booking->nama_acara }}').openPopup();
                });
            </script>
        </x-slot:scripts>
    @endif
</x-layout>

<x-layout title="Buat Booking">
    <x-slot:head>
        <style>
            #map { height: 300px; border-radius: 1rem; z-index: 1; }
        </style>
    </x-slot:head>

    <div class="pt-24 pb-12 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('customer.dashboard') }}" class="text-sm text-dark-400 hover:text-primary-400 transition-colors">← Kembali ke Dashboard</a>
                <h1 class="text-2xl sm:text-3xl font-bold mt-2">Buat Booking Baru</h1>
                <p class="text-dark-400 mt-1">Isi form di bawah untuk memesan sisingaan</p>
            </div>

            <form method="POST" action="{{ route('customer.booking.store') }}" class="space-y-6" x-data="bookingForm()" id="booking-form">
                @csrf

                {{-- Step Indicator --}}
                <div class="flex items-center justify-between mb-8">
                    <template x-for="(stepName, index) in ['Tanggal', 'Paket', 'Lokasi', 'Detail']" :key="index">
                        <div class="flex items-center" :class="index < 3 ? 'flex-1' : ''">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold transition-all"
                                :class="step > index ? 'bg-primary-500 text-dark-950' : (step === index ? 'bg-primary-500/20 text-primary-400 ring-2 ring-primary-500' : 'bg-dark-800 text-dark-500')">
                                <span x-text="index + 1"></span>
                            </div>
                            <span class="ml-2 text-sm font-medium hidden sm:block" :class="step >= index ? 'text-white' : 'text-dark-500'" x-text="stepName"></span>
                            <div x-show="index < 3" class="flex-1 h-0.5 mx-3" :class="step > index ? 'bg-primary-500' : 'bg-dark-800'"></div>
                        </div>
                    </template>
                </div>

                {{-- Step 1: Tanggal --}}
                <div x-show="step === 0" x-transition class="glass rounded-2xl p-6 space-y-5">
                    <h2 class="text-lg font-bold flex items-center gap-2">📅 Pilih Tanggal & Jam</h2>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" x-model="form.tanggal_acara" @change="checkDate()"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors">
                        <div x-show="dateMessage" class="mt-2 text-sm" :class="dateAvailable ? 'text-accent-400' : 'text-red-400'" x-text="dateMessage"></div>
                        @error('tanggal_acara') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Jam Acara</label>
                        <input type="time" name="jam_acara" x-model="form.jam_acara" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors">
                        @error('jam_acara') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <button type="button" @click="nextStep()" :disabled="!form.tanggal_acara || !form.jam_acara || !dateAvailable"
                        class="w-full py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 disabled:opacity-50 disabled:cursor-not-allowed hover:from-primary-400 hover:to-primary-500 transition-all">
                        Lanjut Pilih Paket →
                    </button>
                </div>

                {{-- Step 2: Paket --}}
                <div x-show="step === 1" x-transition class="space-y-4">
                    <h2 class="text-lg font-bold flex items-center gap-2">📦 Pilih Paket</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($pakets as $paket)
                            <label class="glass rounded-2xl p-5 cursor-pointer group transition-all hover:-translate-y-1"
                                :class="form.paket_id == {{ $paket->id }} ? 'ring-2 ring-primary-500 bg-primary-500/5' : ''">
                                <input type="radio" name="paket_id" value="{{ $paket->id }}" x-model="form.paket_id" @change="form.total_harga = {{ $paket->harga }}" class="hidden">
                                <div class="text-3xl mb-3">🦁</div>
                                <h3 class="font-bold text-lg">{{ $paket->nama }}</h3>
                                <p class="text-sm text-dark-400 mt-1">{{ $paket->deskripsi }}</p>
                                <div class="mt-3 space-y-1">
                                    <div class="text-xs text-dark-500">👥 {{ $paket->jumlah_pemain }} Pemain · ⏰ {{ $paket->durasi }}</div>
                                </div>
                                <div class="mt-3 text-xl font-bold text-gradient">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="step--" class="flex-1 py-3 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-dark-500 transition-all">← Kembali</button>
                        <button type="button" @click="nextStep()" :disabled="!form.paket_id"
                            class="flex-1 py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            Lanjut Pilih Lokasi →
                        </button>
                    </div>
                </div>

                {{-- Step 3: Lokasi --}}
                <div x-show="step === 2" x-transition class="glass rounded-2xl p-6 space-y-5">
                    <h2 class="text-lg font-bold flex items-center gap-2">📍 Lokasi Acara</h2>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" x-model="form.alamat" rows="3" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors resize-none"
                            placeholder="Masukkan alamat lengkap acara"></textarea>
                        @error('alamat') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Pilih Lokasi di Peta <span class="text-dark-500">(klik pada peta)</span></label>
                        <div id="map" class="border border-dark-700"></div>
                        <input type="hidden" name="latitude" x-model="form.latitude">
                        <input type="hidden" name="longitude" x-model="form.longitude">
                        <div x-show="form.latitude" class="mt-2 text-xs text-dark-500">
                            📍 Koordinat: <span x-text="form.latitude"></span>, <span x-text="form.longitude"></span>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="step--" class="flex-1 py-3 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-dark-500 transition-all">← Kembali</button>
                        <button type="button" @click="nextStep()" :disabled="!form.alamat"
                            class="flex-1 py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            Lanjut Detail →
                        </button>
                    </div>
                </div>

                {{-- Step 4: Detail --}}
                <div x-show="step === 3" x-transition class="glass rounded-2xl p-6 space-y-5">
                    <h2 class="text-lg font-bold flex items-center gap-2">📝 Detail Acara</h2>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Nama Acara</label>
                        <input type="text" name="nama_acara" x-model="form.nama_acara" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors"
                            placeholder="Contoh: Sunatan Anak Pak Ahmad">
                        @error('nama_acara') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Catatan <span class="text-dark-500">(opsional)</span></label>
                        <textarea name="catatan" x-model="form.catatan" rows="3"
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors resize-none"
                            placeholder="Catatan khusus untuk acara Anda"></textarea>
                    </div>

                    {{-- Summary --}}
                    <div class="bg-dark-800/50 rounded-xl p-5 space-y-2 border border-dark-700">
                        <h3 class="font-semibold mb-3">Ringkasan Booking</h3>
                        <div class="flex justify-between text-sm"><span class="text-dark-400">Tanggal</span><span x-text="form.tanggal_acara"></span></div>
                        <div class="flex justify-between text-sm"><span class="text-dark-400">Jam</span><span x-text="form.jam_acara"></span></div>
                        <div class="flex justify-between text-sm"><span class="text-dark-400">Lokasi</span><span x-text="form.alamat ? form.alamat.substring(0,40) + '...' : '-'" class="text-right max-w-[200px] truncate"></span></div>
                        <div class="border-t border-dark-600 my-2"></div>
                        <div class="flex justify-between font-bold"><span>Total</span><span class="text-gradient" x-text="'Rp ' + Number(form.total_harga).toLocaleString('id-ID')"></span></div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="step--" class="flex-1 py-3 rounded-xl text-sm font-semibold text-dark-300 border border-dark-700 hover:border-dark-500 transition-all">← Kembali</button>
                        <button type="submit" :disabled="!form.nama_acara"
                            class="flex-1 py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-lg shadow-primary-500/25">
                            ✅ Submit Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-slot:scripts>
        <script>
            function bookingForm() {
                return {
                    step: 0,
                    dateAvailable: false,
                    dateMessage: '',
                    map: null,
                    marker: null,
                    form: {
                        tanggal_acara: '{{ old("tanggal_acara", "") }}',
                        jam_acara: '{{ old("jam_acara", "") }}',
                        paket_id: '{{ old("paket_id", "") }}',
                        alamat: '{{ old("alamat", "") }}',
                        latitude: '{{ old("latitude", "") }}',
                        longitude: '{{ old("longitude", "") }}',
                        nama_acara: '{{ old("nama_acara", "") }}',
                        catatan: '{{ old("catatan", "") }}',
                        total_harga: 0,
                    },

                    nextStep() {
                        this.step++;
                        if (this.step === 2) {
                            this.$nextTick(() => this.initMap());
                        }
                    },

                    async checkDate() {
                        if (!this.form.tanggal_acara) return;
                        try {
                            const res = await fetch('{{ route("api.check-availability") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                },
                                body: JSON.stringify({ tanggal: this.form.tanggal_acara })
                            });
                            const data = await res.json();
                            this.dateAvailable = data.available;
                            this.dateMessage = data.message;
                        } catch {
                            this.dateMessage = 'Gagal mengecek ketersediaan.';
                            this.dateAvailable = false;
                        }
                    },

                    initMap() {
                        if (this.map) return;
                        // Default: Subang, Jawa Barat
                        const lat = this.form.latitude || -6.5714;
                        const lng = this.form.longitude || 107.7601;

                        this.map = L.map('map').setView([lat, lng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap'
                        }).addTo(this.map);

                        if (this.form.latitude) {
                            this.marker = L.marker([lat, lng]).addTo(this.map);
                        }

                        this.map.on('click', (e) => {
                            this.form.latitude = e.latlng.lat.toFixed(8);
                            this.form.longitude = e.latlng.lng.toFixed(8);

                            if (this.marker) {
                                this.marker.setLatLng(e.latlng);
                            } else {
                                this.marker = L.marker(e.latlng).addTo(this.map);
                            }
                        });
                    }
                };
            }
        </script>
    </x-slot:scripts>
</x-layout>

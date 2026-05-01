<x-layout title="Buat Booking">
    <x-slot:head>
        {{-- Flatpickr --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>
            #map { height: 300px; border-radius: 1rem; z-index: 1; }

            /* ── Flatpickr Dark Theme for SIGANTARA ── */
            .flatpickr-calendar {
                background: #1a1a2e !important;
                border: 1px solid rgba(255,255,255,0.08) !important;
                border-radius: 1rem !important;
                box-shadow: 0 25px 50px -12px rgba(0,0,0,0.6) !important;
                font-family: 'Poppins', sans-serif !important;
                overflow: hidden;
            }
            .flatpickr-months {
                background: rgba(255,255,255,0.03);
                padding: 0.5rem 0;
            }
            .flatpickr-months .flatpickr-month {
                color: #fff !important;
                fill: #fff !important;
            }
            .flatpickr-current-month .flatpickr-monthDropdown-months,
            .flatpickr-current-month input.cur-year {
                color: #fff !important;
                font-weight: 600 !important;
            }
            .flatpickr-current-month .flatpickr-monthDropdown-months option {
                background: #1a1a2e !important;
                color: #fff !important;
            }
            .flatpickr-months .flatpickr-prev-month,
            .flatpickr-months .flatpickr-next-month {
                color: #fff !important;
                fill: #fff !important;
            }
            .flatpickr-months .flatpickr-prev-month:hover,
            .flatpickr-months .flatpickr-next-month:hover {
                color: #f5a623 !important;
                fill: #f5a623 !important;
            }
            span.flatpickr-weekday {
                color: rgba(255,255,255,0.4) !important;
                font-weight: 500 !important;
                font-size: 0.75rem !important;
            }
            .flatpickr-day {
                color: #e0e0e0 !important;
                border-radius: 0.5rem !important;
                font-weight: 500 !important;
                transition: all 0.2s ease !important;
            }
            .flatpickr-day:hover {
                background: rgba(245,166,35,0.15) !important;
                border-color: rgba(245,166,35,0.3) !important;
                color: #f5a623 !important;
            }
            .flatpickr-day.selected {
                background: linear-gradient(135deg, #f5a623, #e6951e) !important;
                border-color: #f5a623 !important;
                color: #1a1a2e !important;
                font-weight: 700 !important;
                box-shadow: 0 4px 15px rgba(245,166,35,0.35) !important;
            }
            .flatpickr-day.today {
                border-color: rgba(245,166,35,0.5) !important;
                color: #f5a623 !important;
            }
            .flatpickr-day.today:hover {
                background: rgba(245,166,35,0.15) !important;
            }
            .flatpickr-day.flatpickr-disabled,
            .flatpickr-day.flatpickr-disabled:hover {
                color: rgba(255,255,255,0.15) !important;
                background: rgba(255,0,0,0.06) !important;
                border-color: transparent !important;
                text-decoration: line-through !important;
                cursor: not-allowed !important;
            }
            .flatpickr-day.prevMonthDay,
            .flatpickr-day.nextMonthDay {
                color: rgba(255,255,255,0.15) !important;
            }
            .flatpickr-innerContainer {
                padding: 0.5rem;
            }

            /* Legend below the calendar */
            .date-legend {
                display: flex;
                gap: 1.25rem;
                margin-top: 0.75rem;
                font-size: 0.75rem;
                color: rgba(255,255,255,0.5);
            }
            .date-legend span {
                display: flex;
                align-items: center;
                gap: 0.35rem;
            }
            .date-legend .dot {
                width: 10px;
                height: 10px;
                border-radius: 3px;
                display: inline-block;
            }
            .dot-available { background: rgba(245,166,35,0.5); border: 1px solid rgba(245,166,35,0.8); }
            .dot-booked { background: rgba(255,0,0,0.15); border: 1px solid rgba(255,0,0,0.3); text-decoration: line-through; }
            .dot-past { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); }
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
                    <h2 class="text-lg font-bold flex items-center gap-2"><x-heroicon-o-calendar-days class="w-5 h-5 text-primary-400" /> Pilih Tanggal & Jam</h2>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Tanggal Acara</label>
                        <input type="text" id="tanggal-picker" name="tanggal_acara" x-ref="datePicker"
                            readonly required placeholder="Pilih tanggal..."
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors cursor-pointer">
                        <div x-show="dateMessage" class="mt-2 text-sm flex items-center gap-1.5" :class="dateAvailable ? 'text-accent-400' : 'text-red-400'">
                            <span x-text="dateAvailable ? '✓' : '✗'"></span>
                            <span x-text="dateMessage"></span>
                        </div>
                        <div class="date-legend">
                            <span><i class="dot dot-available"></i> Tersedia</span>
                            <span><i class="dot dot-booked" style="text-decoration: line-through;"></i> Sudah Dibooking</span>
                            <span><i class="dot dot-past"></i> Lewat</span>
                        </div>
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
                    <h2 class="text-lg font-bold flex items-center gap-2"><x-heroicon-o-cube class="w-5 h-5 text-primary-400" /> Pilih Paket</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($pakets as $paket)
                            <label class="glass rounded-2xl p-5 cursor-pointer group transition-all hover:-translate-y-1"
                                :class="form.paket_id == {{ $paket->id }} ? 'ring-2 ring-primary-500 bg-primary-500/5' : ''">
                                <input type="radio" name="paket_id" value="{{ $paket->id }}" x-model="form.paket_id" @change="form.total_harga = {{ $paket->harga }}" class="hidden">
                                <div class="text-3xl mb-3"><x-heroicon-s-trophy class="w-8 h-8 text-primary-400/60" /></div>
                                <h3 class="font-bold text-lg">{{ $paket->nama }}</h3>
                                <p class="text-sm text-dark-400 mt-1">{{ $paket->deskripsi }}</p>
                                <div class="mt-3 space-y-1">
                                    <div class="text-xs text-dark-500 flex items-center gap-2"><x-heroicon-o-user-group class="w-3.5 h-3.5" /> {{ $paket->jumlah_pemain }} Pemain · <x-heroicon-o-clock class="w-3.5 h-3.5" /> {{ $paket->durasi }}</div>
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
                    <h2 class="text-lg font-bold flex items-center gap-2"><x-heroicon-o-map-pin class="w-5 h-5 text-primary-400" /> Lokasi Acara</h2>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" x-model="form.alamat" rows="3" required
                            class="w-full px-4 py-3 rounded-xl bg-dark-800/50 border border-dark-700 text-white placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-colors resize-none"
                            placeholder="Masukkan alamat lengkap acara"></textarea>
                        @error('alamat') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-dark-300 mb-2">Pilih Lokasi di Peta</label>

                        {{-- Geolocation button --}}
                        <button type="button" @click="requestGeolocation()" class="mb-3 flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-accent-500/10 text-accent-400 border border-accent-500/20 hover:bg-accent-500/20 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span x-text="geoLoading ? 'Mencari lokasi...' : 'Gunakan Lokasi Saya'"></span>
                        </button>
                        <div x-show="geoError" class="mb-3 text-xs text-red-400" x-text="geoError"></div>

                        <div id="map" class="border border-dark-700"></div>
                        <input type="hidden" name="latitude" x-model="form.latitude">
                        <input type="hidden" name="longitude" x-model="form.longitude">
                        <div x-show="form.latitude" class="mt-2 text-xs text-dark-500">
                            <x-heroicon-o-map-pin class="w-3.5 h-3.5 text-dark-500 inline" /> Koordinat: <span x-text="form.latitude"></span>, <span x-text="form.longitude"></span>
                        </div>
                        <p class="mt-1 text-xs text-dark-500 flex items-center gap-1"><x-heroicon-o-light-bulb class="w-3.5 h-3.5" /> Ketik nama tempat di kolom search pada peta, atau klik langsung pada peta untuk memilih lokasi.</p>
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
                    <h2 class="text-lg font-bold flex items-center gap-2"><x-heroicon-o-pencil-square class="w-5 h-5 text-primary-400" /> Detail Acara</h2>

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
                            <span class="inline-flex items-center gap-1"><x-heroicon-o-check-badge class="w-4 h-4" /> Submit Booking</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-slot:scripts>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
        <script>
            function bookingForm() {
                return {
                    step: 0,
                    dateAvailable: false,
                    dateMessage: '',
                    datePicker: null,
                    bookedDates: [],
                    map: null,
                    marker: null,
                    geocoder: null,
                    geoLoading: false,
                    geoError: '',
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

                    async init() {
                        // Fetch booked dates from API then initialize Flatpickr
                        await this.fetchBookedDates();
                        this.$nextTick(() => this.initDatePicker());
                    },

                    async fetchBookedDates() {
                        try {
                            const res = await fetch('{{ route("api.booked-dates") }}');
                            const data = await res.json();
                            this.bookedDates = data.booked_dates || [];
                        } catch {
                            this.bookedDates = [];
                        }
                    },

                    initDatePicker() {
                        const self = this;
                        const tomorrow = new Date();
                        tomorrow.setDate(tomorrow.getDate() + 1);

                        this.datePicker = flatpickr(this.$refs.datePicker, {
                            locale: 'id',
                            dateFormat: 'Y-m-d',
                            minDate: tomorrow,
                            disable: this.bookedDates,
                            disableMobile: true,
                            inline: false,
                            defaultDate: this.form.tanggal_acara || null,
                            onChange(selectedDates, dateStr) {
                                self.form.tanggal_acara = dateStr;
                                self.dateAvailable = true;
                                self.dateMessage = 'Tanggal tersedia! ✓';
                            },
                            onDayCreate(dObj, dStr, fp, dayElem) {
                                const dateStr = dayElem.dateObj.toISOString().split('T')[0];
                                if (self.bookedDates.includes(dateStr)) {
                                    dayElem.setAttribute('title', 'Sudah dibooking');
                                }
                            }
                        });
                    },

                    nextStep() {
                        this.step++;
                        if (this.step === 2) {
                            this.$nextTick(() => this.initMap());
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

                        // Add geocoder search control
                        this.geocoder = L.Control.geocoder({
                            defaultMarkType: 'L.marker',
                            placeholder: 'Cari lokasi...',
                            errorMessage: 'Tidak ditemukan.',
                            showUniqueResult: true,
                            showResultIcons: false,
                            suggestMinLength: 3,
                            queryMinLength: 3,
                            collapsed: false,
                            geocoder: L.Control.Geocoder.nominatim({
                                geocodingQueryParams: {
                                    countrycodes: 'id',
                                    'accept-language': 'id'
                                }
                            })
                        }).on('markgeocode', (e) => {
                            const { center, name } = e.geocode;
                            this.setLocation(center.lat, center.lng, name);
                        }).addTo(this.map);

                        // Click on map to place marker + reverse geocode
                        this.map.on('click', (e) => {
                            this.form.latitude = e.latlng.lat.toFixed(8);
                            this.form.longitude = e.latlng.lng.toFixed(8);

                            if (this.marker) {
                                this.marker.setLatLng(e.latlng);
                            } else {
                                this.marker = L.marker(e.latlng).addTo(this.map);
                            }

                            // Reverse geocode to fill address
                            this.reverseGeocode(e.latlng.lat, e.latlng.lng);
                        });
                    },

                    setLocation(lat, lng, address) {
                        this.form.latitude = parseFloat(lat).toFixed(8);
                        this.form.longitude = parseFloat(lng).toFixed(8);

                        const latlng = L.latLng(lat, lng);
                        if (this.marker) {
                            this.marker.setLatLng(latlng);
                        } else {
                            this.marker = L.marker(latlng).addTo(this.map);
                        }
                        this.map.setView(latlng, 16);

                        if (address) {
                            this.form.alamat = address;
                        }
                    },

                    async reverseGeocode(lat, lng) {
                        try {
                            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=id`);
                            const data = await res.json();
                            if (data.display_name) {
                                this.form.alamat = data.display_name;
                            }
                        } catch {
                            // Silently fail reverse geocode
                        }
                    },

                    requestGeolocation() {
                        if (!navigator.geolocation) {
                            this.geoError = 'Browser Anda tidak mendukung geolocation.';
                            return;
                        }

                        this.geoLoading = true;
                        this.geoError = '';

                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const { latitude, longitude } = position.coords;
                                this.geoLoading = false;

                                // If map isn't initialized yet, initialize it
                                if (!this.map) {
                                    this.$nextTick(() => {
                                        this.initMap();
                                        this.$nextTick(() => {
                                            this.setLocation(latitude, longitude);
                                            this.reverseGeocode(latitude, longitude);
                                        });
                                    });
                                } else {
                                    this.setLocation(latitude, longitude);
                                    this.reverseGeocode(latitude, longitude);
                                }
                            },
                            (error) => {
                                this.geoLoading = false;
                                switch (error.code) {
                                    case error.PERMISSION_DENIED:
                                        this.geoError = 'Izin lokasi ditolak. Silakan aktifkan izin lokasi di pengaturan browser Anda.';
                                        break;
                                    case error.POSITION_UNAVAILABLE:
                                        this.geoError = 'Informasi lokasi tidak tersedia.';
                                        break;
                                    case error.TIMEOUT:
                                        this.geoError = 'Permintaan lokasi timeout. Silakan coba lagi.';
                                        break;
                                    default:
                                        this.geoError = 'Terjadi kesalahan saat mengambil lokasi.';
                                }
                            },
                            {
                                enableHighAccuracy: true,
                                timeout: 10000,
                                maximumAge: 0
                            }
                        );
                    }
                };
            }
        </script>
    </x-slot:scripts>
</x-layout>

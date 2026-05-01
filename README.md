# 🦁 SIGANTARA — Sistem Informasi Pemesanan Sisingaan Alan Group

<p align="center">
  <strong>Aplikasi web untuk pemesanan jasa kesenian Sisingaan secara online</strong><br>
  Dibangun dengan Laravel 13 · Tailwind CSS 4 · Vite · SQLite
</p>

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Arsitektur & Struktur Folder](#-arsitektur--struktur-folder)
- [Flow Sistem](#-flow-sistem)
  - [Flow Booking Pelanggan](#1-flow-booking-pelanggan)
  - [Flow Pembayaran](#2-flow-pembayaran)
  - [Flow Admin](#3-flow-admin)
  - [Flow Owner](#4-flow-owner)
  - [Flow Karyawan](#5-flow-karyawan)
- [Database Schema](#-database-schema)
- [Instalasi & Setup](#-instalasi--setup)
- [Akun Default](#-akun-default)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Screenshot](#-screenshot)

---

## 🎯 Tentang Proyek

**SIGANTARA** adalah platform berbasis web yang mendigitalisasi proses pemesanan jasa kesenian **Sisingaan** milik **Alan Group**. Sistem ini memungkinkan pelanggan untuk melakukan booking online, memilih paket, menentukan lokasi via peta interaktif (Leaflet.js), dan mengunggah bukti pembayaran — semuanya dikelola melalui dashboard berbasis role.

Sistem memiliki **4 peran (role) utama:**

| Role | Deskripsi |
|------|-----------|
| **Owner** | Pemilik usaha — melihat laporan, kelola rekening bank, kelola akun |
| **Admin** | Mengelola booking, verifikasi pembayaran, kelola paket, karyawan, galeri, testimoni, dan user |
| **Karyawan** | Melihat jadwal tugas dan menandai kehadiran |
| **Pelanggan** | Mendaftar, melakukan booking, upload pembayaran, dan memberi testimoni |

---

## ✨ Fitur Utama

### 🌐 Landing Page
- Hero section dengan galeri foto
- Daftar paket sisingaan
- Testimoni pelanggan (yang sudah disetujui admin)

### 👤 Pelanggan
- Registrasi & login
- Dashboard ringkasan booking
- Pemesanan booking online (pilih paket, tanggal, lokasi via peta Leaflet)
- Cek ketersediaan tanggal secara realtime
- Upload bukti pembayaran (DP & pelunasan)
- Riwayat booking
- Kirim testimoni setelah acara selesai

### 🛡️ Admin
- Dashboard dengan statistik (Chart.js)
- Kelola booking (konfirmasi, ubah status)
- Verifikasi pembayaran
- CRUD paket sisingaan
- CRUD karyawan
- CRUD galeri foto
- Moderasi testimoni (approve/reject)
- Assign karyawan ke jadwal booking
- CRUD akun admin

### 👑 Owner
- Dashboard ringkasan bisnis
- Laporan pendapatan & export PDF (DomPDF)
- Kelola rekening bank (untuk info transfer)
- Kelola akun karyawan & admin

### 👷 Karyawan
- Dashboard jadwal tugas
- Lihat detail acara & lokasi
- Update status kehadiran

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|-------|-----------|
| **Backend** | PHP 8.3+, Laravel 13 |
| **Frontend** | Blade Templates, Tailwind CSS 4, Alpine.js |
| **Build Tool** | Vite 8 |
| **Database** | SQLite (default) / MySQL |
| **Maps** | Leaflet.js + OpenStreetMap |
| **Icons** | Blade Heroicons |
| **PDF Export** | barryvdh/laravel-dompdf |
| **Charts** | Chart.js |
| **Auth** | Laravel built-in (custom AuthController) |
| **Middleware** | Custom RoleMiddleware |

---

## 📁 Arsitektur & Struktur Folder

Menggunakan arsitektur **MVC (Model-View-Controller)** bawaan Laravel:

```
sigantara/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                  # Controller khusus admin
│   │   │   │   ├── BookingController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── GaleriController.php
│   │   │   │   ├── KaryawanController.php
│   │   │   │   ├── PaketController.php
│   │   │   │   ├── PaymentController.php
│   │   │   │   ├── TestimonialController.php
│   │   │   │   └── UserController.php
│   │   │   ├── Owner/                  # Controller khusus owner
│   │   │   │   ├── BankAccountController.php
│   │   │   │   └── UserController.php
│   │   │   ├── AuthController.php      # Login, register, logout
│   │   │   ├── CustomerController.php  # Semua fitur pelanggan
│   │   │   ├── KaryawanController.php  # Jadwal & kehadiran
│   │   │   ├── LandingController.php   # Halaman utama publik
│   │   │   └── OwnerController.php     # Dashboard & laporan owner
│   │   └── Middleware/
│   │       └── RoleMiddleware.php      # Proteksi akses berdasarkan role
│   └── Models/
│       ├── BankAccount.php
│       ├── Booking.php
│       ├── Galeri.php
│       ├── Jadwal.php
│       ├── Paket.php
│       ├── Payment.php
│       ├── Testimonial.php
│       └── User.php
├── database/
│   ├── migrations/                     # Skema tabel database
│   └── seeders/
│       └── DatabaseSeeder.php          # Data awal (admin, owner, paket, dll)
├── resources/views/
│   ├── admin/                          # View halaman admin
│   ├── auth/                           # Login & register
│   ├── components/                     # Blade components (layout, dll)
│   ├── customer/                       # View halaman pelanggan
│   ├── karyawan/                       # View halaman karyawan
│   ├── owner/                          # View halaman owner
│   └── welcome.blade.php              # Landing page
├── routes/
│   └── web.php                         # Semua route aplikasi
└── ...
```

---

## 🔄 Flow Sistem

### 1. Flow Booking Pelanggan

```
┌──────────────┐
│  Landing Page│
└──────┬───────┘
       ▼
┌──────────────┐     ┌───────────────┐
│   Register   │────▶│     Login     │
└──────────────┘     └───────┬───────┘
                             ▼
                   ┌──────────────────┐
                   │    Dashboard     │
                   │   Pelanggan      │
                   └────────┬─────────┘
                            ▼
                   ┌──────────────────┐
                   │  Buat Booking    │
                   │                  │
                   │ 1. Pilih Paket   │
                   │ 2. Pilih Tanggal │◀── Cek ketersediaan (AJAX)
                   │ 3. Input Alamat  │
                   │ 4. Pilih Lokasi  │◀── Leaflet Map Picker
                   │ 5. Catatan       │
                   └────────┬─────────┘
                            ▼
                   ┌──────────────────┐
                   │  Status: PENDING │
                   │  Menunggu Admin  │
                   └────────┬─────────┘
                            ▼
              ┌─────────────────────────────┐
              │  Admin konfirmasi booking   │
              │  Status → CONFIRMED         │
              └─────────────┬───────────────┘
                            ▼
                   ┌──────────────────┐
                   │  Upload Bukti DP │
                   │  (Min. 50%)      │
                   └────────┬─────────┘
                            ▼
              ┌─────────────────────────────┐
              │  Admin verifikasi DP        │
              │  Status → DP_PAID           │
              └─────────────┬───────────────┘
                            ▼
                   ┌──────────────────┐
                   │  Acara Berjalan  │
                   │  Status: ONGOING │
                   └────────┬─────────┘
                            ▼
                   ┌──────────────────┐
                   │ Upload Pelunasan │
                   └────────┬─────────┘
                            ▼
              ┌─────────────────────────────┐
              │  Admin verifikasi pelunasan │
              │  Status → PAID             │
              └─────────────┬───────────────┘
                            ▼
                   ┌──────────────────┐
                   │  Status: SELESAI │
                   │  (COMPLETED)     │
                   └────────┬─────────┘
                            ▼
                   ┌──────────────────┐
                   │ Kirim Testimoni  │
                   └──────────────────┘
```

### 2. Flow Pembayaran

```
Pelanggan                        Admin
────────                        ─────
Upload bukti DP ──────────────▶ Verifikasi DP
  (jenis: dp)                    ├── ✅ Verified → status booking: dp_paid
  (status: pending)              └── ❌ Rejected
                                       ▼
Upload bukti Pelunasan ───────▶ Verifikasi Pelunasan
  (jenis: pelunasan)             ├── ✅ Verified → status booking: paid
  (status: pending)              └── ❌ Rejected
```

**Validasi pembayaran:**
- DP harus diverifikasi sebelum bisa upload pelunasan
- Tidak bisa upload ganda jika masih ada pembayaran pending
- Tidak bisa duplikat DP/pelunasan yang sudah verified

### 3. Flow Admin

```
┌──────────────────────────────────────────────────────────────┐
│                      ADMIN DASHBOARD                         │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  📊 Dashboard ── Statistik booking, pendapatan, chart        │
│                                                              │
│  📋 Booking ──── Lihat semua booking                         │
│        ├── Ubah status (pending → confirmed → ongoing → ... )│
│        └── Assign karyawan ke jadwal                         │
│                                                              │
│  💳 Payments ─── Verifikasi bukti pembayaran                 │
│        └── Approve / Reject                                  │
│                                                              │
│  📦 Paket ────── CRUD paket sisingaan                        │
│        └── Nama, deskripsi, harga, jumlah pemain, durasi     │
│                                                              │
│  👷 Karyawan ─── CRUD data karyawan                          │
│                                                              │
│  🖼️ Galeri ───── CRUD foto dokumentasi                       │
│                                                              │
│  ⭐ Testimoni ── Moderasi testimoni pelanggan                │
│        └── Approve / Reject / Hapus                          │
│                                                              │
│  👤 Users ────── CRUD akun admin                             │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

### 4. Flow Owner

```
┌──────────────────────────────────────────────────────────┐
│                     OWNER DASHBOARD                       │
├──────────────────────────────────────────────────────────┤
│                                                          │
│  📊 Dashboard ─── Ringkasan bisnis & statistik           │
│                                                          │
│  📈 Laporan ───── Laporan pendapatan                     │
│        └── Export ke PDF (DomPDF)                         │
│                                                          │
│  🏦 Rekening ──── CRUD rekening bank                     │
│        └── Nama bank, nomor rekening, atas nama          │
│                                                          │
│  👤 Users ────── CRUD akun karyawan & admin              │
│                                                          │
└──────────────────────────────────────────────────────────┘
```

### 5. Flow Karyawan

```
┌──────────────────────────────────────────────────────────┐
│                   KARYAWAN DASHBOARD                      │
├──────────────────────────────────────────────────────────┤
│                                                          │
│  📊 Dashboard ──── Ringkasan jadwal tugas                │
│                                                          │
│  📅 Jadwal ─────── Daftar jadwal acara yang di-assign    │
│        ├── Lihat detail acara                            │
│        ├── Lihat lokasi acara                            │
│        └── Update status kehadiran                       │
│                                                          │
└──────────────────────────────────────────────────────────┘
```

---

## 🗃️ Database Schema

```
┌──────────────┐       ┌──────────────┐       ┌──────────────┐
│    users     │       │    pakets    │       │   galeris    │
├──────────────┤       ├──────────────┤       ├──────────────┤
│ id           │       │ id           │       │ id           │
│ name         │       │ nama         │       │ judul        │
│ email        │       │ deskripsi    │       │ path         │
│ password     │       │ harga        │       │ deskripsi    │
│ role         │──┐    │ jumlah_pemain│       │ created_at   │
│ phone        │  │    │ durasi       │       └──────────────┘
│ address      │  │    │ daftar_isi   │
│ status       │  │    │ is_active    │
└──────────────┘  │    └──────┬───────┘
                  │           │
                  │    ┌──────┴───────┐      ┌───────────────┐
                  ├───▶│   bookings   │      │   payments    │
                  │    ├──────────────┤      ├───────────────┤
                  │    │ id           │◀─────│ id            │
                  │    │ user_id (FK) │      │ booking_id(FK)│
                  │    │ paket_id(FK) │      │ jenis         │
                  │    │ kode_booking │      │ metode        │
                  │    │ tanggal_acara│      │ jumlah        │
                  │    │ jam_acara    │      │ bukti_transfer│
                  │    │ nama_acara   │      │ status        │
                  │    │ alamat       │      └───────────────┘
                  │    │ latitude     │
                  │    │ longitude    │      ┌───────────────┐
                  │    │ catatan      │      │   jadwals     │
                  │    │ status       │◀─────├───────────────┤
                  │    │ total_harga  │      │ id            │
                  │    │ biaya_transp │      │ booking_id(FK)│
                  │    └──────┬───────┘      │ karyawan_id   │
                  │           │              │ status        │
                  │           │              └───────────────┘
                  │           ▼
                  │    ┌──────────────┐      ┌───────────────┐
                  ├───▶│ testimonials │      │ bank_accounts │
                       ├──────────────┤      ├───────────────┤
                       │ id           │      │ id            │
                       │ user_id (FK) │      │ nama_bank     │
                       │ booking_id   │      │ kode_bank     │
                       │ rating       │      │ nomor_rekening│
                       │ deskripsi    │      │ atas_nama     │
                       │ is_approved  │      │ is_active     │
                       └──────────────┘      └───────────────┘
```

### Status Booking

| Status | Label | Deskripsi |
|--------|-------|-----------|
| `pending` | Menunggu Konfirmasi | Booking baru dibuat pelanggan |
| `confirmed` | Dikonfirmasi | Admin sudah mengkonfirmasi |
| `dp_paid` | DP Dibayar | DP sudah diverifikasi |
| `paid` | Lunas | Pelunasan sudah diverifikasi |
| `ongoing` | Berlangsung | Acara sedang berlangsung |
| `completed` | Selesai | Acara sudah selesai |
| `cancelled` | Dibatalkan | Booking dibatalkan |

---

## 🚀 Instalasi & Setup

### Prasyarat

Pastikan sistem kamu sudah memiliki:

- **PHP** ≥ 8.3
- **Composer** ≥ 2.x
- **Node.js** ≥ 18.x & **npm**
- **SQLite** (bawaan) atau **MySQL** 8+
- Ekstensi PHP: `pdo_sqlite`, `mbstring`, `openssl`, `fileinfo`, `gd`

### Langkah Instalasi

#### 1. Clone Repository

```bash
git clone https://github.com/Dafonggg/singantara-project.git
cd singantara-project
```

#### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

#### 3. Konfigurasi Environment

```bash
# Salin file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Konfigurasi Database

**Opsi A: SQLite (Default — Tanpa setup tambahan)**

File `.env` sudah dikonfigurasi menggunakan SQLite secara default. Pastikan file database sudah ada:

```bash
touch database/database.sqlite
```

**Opsi B: MySQL**

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sigantara
DB_USERNAME=root
DB_PASSWORD=your_password
```

Lalu buat database:

```sql
CREATE DATABASE sigantara;
```

#### 5. Migrasi & Seed Database

```bash
# Jalankan migrasi untuk membuat tabel
php artisan migrate

# Jalankan seeder untuk data awal
php artisan db:seed
```

Atau jalankan sekaligus:

```bash
php artisan migrate --seed
```

#### 6. Setup Storage Link

```bash
php artisan storage:link
```

#### 7. Build Assets

```bash
# Untuk development
npm run dev

# Untuk production
npm run build
```

---

## 🔑 Akun Default

Setelah menjalankan `php artisan db:seed`, akun berikut akan tersedia:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@sigantara.com` | `password` |
| **Owner** | `owner@sigantara.com` | `password` |
| **Karyawan 1** | `karyawan1@sigantara.com` | `password` |
| **Karyawan 2** | `karyawan2@sigantara.com` | `password` |
| **Karyawan 3** | `karyawan3@sigantara.com` | `password` |
| **Karyawan 4** | `karyawan4@sigantara.com` | `password` |
| **Karyawan 5** | `karyawan5@sigantara.com` | `password` |
| **Pelanggan** | `pelanggan@sigantara.com` | `password` |

> ⚠️ **Penting:** Ganti semua password default sebelum deploy ke production!

---

## ▶️ Menjalankan Aplikasi

### Development (Cara Cepat)

Gunakan script `composer dev` yang menjalankan semua service sekaligus:

```bash
composer dev
```

Ini akan menjalankan secara paralel:
- 🌐 **Laravel Server** → `http://localhost:8000`
- 📋 **Queue Worker** → Memproses antrian job
- 📜 **Laravel Pail** → Log viewer realtime
- ⚡ **Vite Dev Server** → Hot reload assets

### Development (Manual)

Buka 2 terminal terpisah:

**Terminal 1 — Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 — Vite Dev Server:**
```bash
npm run dev
```

Akses aplikasi di: **http://localhost:8000**

---

## 📸 Screenshot

> _Screenshot aplikasi akan ditambahkan di sini._

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan **akademik / tugas akhir**.

---

<p align="center">
  Dibuat dengan ❤️ oleh <strong>Tim SIGANTARA</strong>
</p>

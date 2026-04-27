Saya sudah membaca dokumen Anda dan saya akan **mengembangkan Tech Spec yang lebih lengkap**, termasuk:

* Booking dengan **GPS / Map Location**
* Laravel **v13 (terbaru)**
* Database **SQL (MySQL/PostgreSQL)**
* Tailwind **versi terbaru**
* Alur sistem yang diperbaiki dan lebih realistis
* Tech stack tambahan profesional

Semua ini saya buat berdasarkan dokumen Anda + saya sempurnakan alurnya agar siap dibangun.

Berikut **TECH SPEC SISTEM SIGANTARA** 👇

---

# TECH SPEC SISTEM SIGANTARA

Sistem Informasi Pemesanan Sisingaan Alan Group

---

# 1. Overview Sistem

SIGANTARA adalah sistem berbasis web untuk **pemesanan jasa sisingaan secara online** yang memungkinkan:

* Pelanggan booking online
* Pilih tanggal tersedia
* Pilih paket
* Pilih lokasi via GPS / Map
* Pembayaran online
* Manajemen jadwal karyawan
* Laporan pendapatan

Berdasarkan dokumen, sistem memiliki 4 aktor utama:

* Admin
* Pemilik
* Karyawan
* Pelanggan 

---

# 2. Tech Stack

## Backend

* Laravel 13 (Latest)
* PHP 8.3+
* Laravel Breeze / Laravel Jetstream (Auth)
* Laravel Eloquent ORM
* Laravel Queue (Notifikasi)

---

## Frontend

* Tailwind CSS (Latest)
* Alpine JS
* Blade Template

Optional (Highly Recommended)

* Livewire (UI interaktif)
* Vite (Asset build)

---

## Database

Relational Database:

* MySQL 8+ (Recommended)
  atau
* PostgreSQL

---

## GPS & Map Integration

Untuk fitur lokasi pesta:

Gunakan:

* Google Maps API
  atau
* Leaflet JS (Gratis)

Saya rekomendasikan:

Leaflet + OpenStreetMap
(Gratis dan ringan)

---

# 3. Arsitektur Sistem

Menggunakan:

MVC Architecture

Laravel Structure:

* Model
* Controller
* Blade View
* Service Layer (optional)

---

# 4. Fitur Utama Sistem

Berdasarkan dokumen + pengembangan

## 4.1 Authentication

* Login
* Register
* Role Based Access

Role:

* Admin
* Owner
* Karyawan
* Pelanggan

(Dokumen halaman 5 fitur login & registrasi) 

---

# 5. Modul Sistem

# 5.1 Modul Pelanggan

### Fitur

* Register
* Login
* Dashboard
* Booking
* Pilih tanggal
* Pilih paket
* Pilih lokasi GPS
* Upload pembayaran
* Lihat status

---

# 5.2 Modul Booking (Paling Penting)

Flow Booking Baru

Pelanggan:

1. Pilih tanggal
2. Pilih paket
3. Pilih lokasi
4. Pilih GPS lokasi
5. Input detail acara
6. Submit

---

# 6. Fitur GPS Lokasi Pesta

Tambahkan pada form booking:

Field:

* Alamat manual
* Map Picker
* Latitude
* Longitude

Contoh UI

Map Interaktif

User:

* Klik map
* Sistem ambil koordinat
* Simpan ke database

Database:

booking table:

* latitude
* longitude
* alamat_lengkap

---

# 7. Flow Booking Sistem

Flow Lengkap

Pelanggan

Register
↓
Login
↓
Dashboard
↓
Pilih Jadwal
↓
Booking
↓
Pilih Paket
↓
Pilih Lokasi GPS
↓
Submit
↓
Menunggu Konfirmasi
↓
Pembayaran DP
↓
Admin Konfirmasi
↓
Jadwal Masuk Karyawan
↓
Acara berlangsung
↓
Pelunasan
↓
Selesai

---

# 8. Modul Admin

Admin dapat:

* Kelola Booking
* Kelola Pelanggan
* Kelola Karyawan
* Kelola Kalender
* Konfirmasi Pembayaran
* Generate Nota
* Laporan

(Sesuai halaman admin pada dokumen page 10-11) 

---

# 9. Modul Owner

Owner dapat:

* Lihat Dashboard
* Lihat Pendapatan
* Lihat Booking
* Lihat Statistik

(Dashboard owner page 8 dokumen) 

---

# 10. Modul Karyawan

Karyawan dapat:

* Lihat jadwal tugas
* Lihat lokasi GPS acara
* Lihat detail acara
* Update status hadir

(Dashboard karyawan page 8-9 dokumen) 

---

# 11. Database Design

Users Table

* id
* name
* email
* password
* role
* phone
* address

---

Bookings Table

* id
* user_id
* paket_id
* tanggal_acara
* jam_acara
* alamat
* latitude
* longitude
* status
* total_harga
* created_at

---

Payments Table

* id
* booking_id
* metode
* jumlah
* bukti_transfer
* status

---

Karyawan Table

* id
* nama
* role
* no_hp
* status

---

Jadwal Table

* id
* booking_id
* karyawan_id
* status

---

# 12. API Integration

Tambahan Tech Stack

Rekomendasi:

Google Maps API / Leaflet

Payment Gateway

Optional:

* Midtrans
* Xendit
* Duitku

Untuk:

* Transfer otomatis
* QRIS
* Ewallet

---

# 13. Notifikasi Sistem

Gunakan:

Laravel Notification

Notifikasi:

* Booking berhasil
* Pembayaran diterima
* Jadwal dibuat
* Reminder acara

Channel:

* Email
* WhatsApp (Optional)

---

# 14. UI / UX Design

Gunakan:

Tailwind UI

Konsep:

Modern clean

Landing Page:

* Hero Section
* Paket Sisingaan
* Booking Cepat
* Galeri
* Testimoni

---

# 15. Security

Gunakan:

* Laravel CSRF
* Role Permission
* Validation
* File upload security

---

# 16. Deployment

Server:

* VPS
* Shared hosting
* Cloud (Recommended)

Rekomendasi:

* DigitalOcean
* AWS
* VPS Niagahoster

---

# 17. Struktur Folder Laravel

app/

* Models
* Controllers
* Services

resources/

* views
* components

routes/

* web.php

---

# 18. Tambahan Fitur (Recommended)

Tambahkan:

Fitur Keren

* Kalender Booking realtime
* Estimasi jarak lokasi
* Biaya luar kota otomatis
* Google Calendar Sync
* Export laporan PDF

---

# 19. Estimasi Halaman Sistem

Berdasarkan dokumen + pengembangan

Halaman:

Landing Page
Login
Register
Dashboard Pelanggan
Booking
Jadwal Booking
Pembayaran
Dashboard Admin
Kelola Booking
Kelola Karyawan
Kelola Pelanggan
Kelola Kalender
Dashboard Owner
Dashboard Karyawan
Laporan
Nota

(Sesuai wireframe dokumen page 7-15) 

---

# 20. Final Tech Stack

Backend

* Laravel 13
* PHP 8.3

Frontend

* Tailwind CSS Latest
* Alpine JS
* Blade

Database

* MySQL

Map

* Leaflet / Google Maps

Optional

* Livewire
* Midtrans
* Queue

---

# 21. Kesimpulan Arsitektur

SIGANTARA akan menjadi:

* Modern
* Scalable
* Mobile Friendly
* Real-time Booking
* GPS Location Ready

---
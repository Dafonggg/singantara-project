<?php

namespace Database\Seeders;

use App\Models\Galeri;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Admin & Owner ─────────────────────────────
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sigantara.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Pemilik Alan Group',
            'email' => 'owner@sigantara.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567891',
            'status' => 'active',
        ]);

        // ── Sample Karyawan ───────────────────────────
        $karyawanNames = ['Ahmad Surya', 'Budi Santoso', 'Cecep Hidayat', 'Dedi Kurniawan', 'Eko Prasetyo'];
        foreach ($karyawanNames as $i => $name) {
            User::create([
                'name' => $name,
                'email' => 'karyawan' . ($i + 1) . '@sigantara.com',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'phone' => '08123456789' . ($i + 2),
                'status' => 'active',
            ]);
        }

        // ── Sample Pelanggan ──────────────────────────
        User::create([
            'name' => 'Pelanggan Demo',
            'email' => 'pelanggan@sigantara.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'phone' => '081234567899',
            'status' => 'active',
        ]);

        // ── Paket Sisingaan ───────────────────────────
        Paket::create([
            'nama' => 'Paket Hemat',
            'deskripsi' => 'Paket dasar sisingaan dengan 2 sisingaan dan 10 pemain. Cocok untuk acara sunatan sederhana.',
            'harga' => 3500000,
            'jumlah_pemain' => 10,
            'durasi' => '2-3 jam',
            'is_active' => true,
        ]);

        Paket::create([
            'nama' => 'Paket Standar',
            'deskripsi' => 'Paket lengkap dengan 4 sisingaan dan 20 pemain, termasuk musik dogdog dan pencak silat.',
            'harga' => 6500000,
            'jumlah_pemain' => 20,
            'durasi' => '3-4 jam',
            'is_active' => true,
        ]);

        Paket::create([
            'nama' => 'Paket Premium',
            'deskripsi' => 'Paket mewah dengan 6 sisingaan, 30 pemain, dekorasi, dan dokumentasi foto/video.',
            'harga' => 10000000,
            'jumlah_pemain' => 30,
            'durasi' => '4-5 jam',
            'is_active' => true,
        ]);

        Paket::create([
            'nama' => 'Paket Eksklusif',
            'deskripsi' => 'Paket terlengkap dengan 8 sisingaan, 40+ pemain, full dekorasi, dokumentasi, dan MC profesional.',
            'harga' => 15000000,
            'jumlah_pemain' => 40,
            'durasi' => '5-6 jam',
            'is_active' => true,
        ]);
    }
}

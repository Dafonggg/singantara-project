<?php

namespace Database\Seeders;

use App\Models\BankAccount;
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
            'username' => 'admin',
            'email' => 'admin@sigantara.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Pemilik Alan Group',
            'username' => 'owner',
            'email' => 'owner@sigantara.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567891',
            'status' => 'active',
        ]);

        // ── Sample Karyawan ───────────────────────────
        $karyawans = [
            [
                'name' => 'Ahmad Surya',
                'username' => 'ahmadsurya',
                'email' => 'ahmad.surya@sigantara.com',
                'peran' => 'Penopang Singa',
                'phone' => '081234567892',
            ],
            [
                'name' => 'Saiful Anwar',
                'username' => 'saifulanwar',
                'email' => 'saiful.anwar@sigantara.com',
                'peran' => 'Pemain Kendang',
                'phone' => '081234567893',
            ],
            [
                'name' => 'Tito',
                'username' => 'tito',
                'email' => 'tito@sigantara.com',
                'peran' => 'Pemain Terompet',
                'phone' => '081234567894',
            ],
            [
                'name' => 'Dffa',
                'username' => 'dffa',
                'email' => 'dffa@sigantara.com',
                'peran' => 'Pemain Gong',
                'phone' => '081234567895',
            ],
            [
                'name' => 'Safut',
                'username' => 'safut',
                'email' => 'safut@sigantara.com',
                'peran' => 'Pemandu Acara',
                'phone' => '081234567896',
            ],
        ];

        foreach ($karyawans as $k) {
            User::create([
                'name' => $k['name'],
                'username' => $k['username'],
                'email' => $k['email'],
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'peran' => $k['peran'],
                'phone' => $k['phone'],
                'status' => 'active',
            ]);
        }

        // ── Sample Pelanggan ──────────────────────────
        User::create([
            'name' => 'Pelanggan Demo',
            'username' => 'pelanggan',
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

        // ── Rekening Bank ─────────────────────────────
        BankAccount::create([
            'nama_bank' => 'Bank BCA',
            'kode_bank' => 'bca',
            'nomor_rekening' => '1234567890',
            'atas_nama' => 'Alan Group Sisingaan',
            'is_active' => true,
        ]);

        BankAccount::create([
            'nama_bank' => 'Bank BRI',
            'kode_bank' => 'bri',
            'nomor_rekening' => '098765432100',
            'atas_nama' => 'Alan Group Sisingaan',
            'is_active' => true,
        ]);

        BankAccount::create([
            'nama_bank' => 'Bank Mandiri',
            'kode_bank' => 'mandiri',
            'nomor_rekening' => '112233445566',
            'atas_nama' => 'Alan Group Sisingaan',
            'is_active' => true,
        ]);
    }
}

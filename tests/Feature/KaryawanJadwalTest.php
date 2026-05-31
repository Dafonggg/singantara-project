<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaryawanJadwalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_assign_karyawan_with_predefined_role()
    {
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $karyawan = User::create([
            'name' => 'Ahmad Surya',
            'username' => 'ahmadsurya',
            'email' => 'ahmad@test.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
            'peran' => 'Penopang Singa',
        ]);

        $customer = User::create([
            'name' => 'Customer',
            'username' => 'customer',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
        ]);

        $paket = Paket::create([
            'nama' => 'Paket A',
            'deskripsi' => 'Paket A',
            'harga' => 1000000,
            'jumlah_pemain' => 5,
            'durasi' => '2 jam',
        ]);

        $booking = Booking::create([
            'user_id' => $customer->id,
            'paket_id' => $paket->id,
            'nama_acara' => 'Acara Test',
            'tanggal_acara' => now()->addDays(2)->toDateString(),
            'jam_acara' => '08:00',
            'alamat' => 'Alamat Test',
            'total_harga' => 1000000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.bookings.assign', $booking), [
                'karyawan_id' => $karyawan->id,
            ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('jadwals', [
            'booking_id' => $booking->id,
            'karyawan_id' => $karyawan->id,
            'peran' => 'Penopang Singa',
        ]);
    }

    public function test_karyawan_can_confirm_willingness_without_catatan()
    {
        $karyawan = User::create([
            'name' => 'Ahmad Surya',
            'username' => 'ahmadsurya',
            'email' => 'ahmad@test.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
            'peran' => 'Penopang Singa',
        ]);

        $customer = User::create([
            'name' => 'Customer',
            'username' => 'customer',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
        ]);

        $paket = Paket::create([
            'nama' => 'Paket A',
            'deskripsi' => 'Paket A',
            'harga' => 1000000,
            'jumlah_pemain' => 5,
            'durasi' => '2 jam',
        ]);

        $booking = Booking::create([
            'user_id' => $customer->id,
            'paket_id' => $paket->id,
            'nama_acara' => 'Acara Test',
            'tanggal_acara' => now()->addDays(2)->toDateString(),
            'jam_acara' => '08:00',
            'alamat' => 'Alamat Test',
            'total_harga' => 1000000,
            'status' => 'pending',
        ]);

        $jadwal = Jadwal::create([
            'booking_id' => $booking->id,
            'karyawan_id' => $karyawan->id,
            'peran' => 'Penopang Singa',
            'status_hadir' => 'belum',
        ]);

        $response = $this->actingAs($karyawan)
            ->patch(route('karyawan.jadwal.kehadiran', $jadwal), [
                'status_hadir' => 'hadir',
            ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('jadwals', [
            'id' => $jadwal->id,
            'status_hadir' => 'hadir',
            'catatan' => null,
        ]);
    }

    public function test_karyawan_must_provide_catatan_when_declining()
    {
        $karyawan = User::create([
            'name' => 'Ahmad Surya',
            'username' => 'ahmadsurya',
            'email' => 'ahmad@test.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
            'peran' => 'Penopang Singa',
        ]);

        $customer = User::create([
            'name' => 'Customer',
            'username' => 'customer',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
        ]);

        $paket = Paket::create([
            'nama' => 'Paket A',
            'deskripsi' => 'Paket A',
            'harga' => 1000000,
            'jumlah_pemain' => 5,
            'durasi' => '2 jam',
        ]);

        $booking = Booking::create([
            'user_id' => $customer->id,
            'paket_id' => $paket->id,
            'nama_acara' => 'Acara Test',
            'tanggal_acara' => now()->addDays(2)->toDateString(),
            'jam_acara' => '08:00',
            'alamat' => 'Alamat Test',
            'total_harga' => 1000000,
            'status' => 'pending',
        ]);

        $jadwal = Jadwal::create([
            'booking_id' => $booking->id,
            'karyawan_id' => $karyawan->id,
            'peran' => 'Penopang Singa',
            'status_hadir' => 'belum',
        ]);

        // Attempt to decline WITHOUT catatan (should fail validation)
        $response = $this->actingAs($karyawan)
            ->patch(route('karyawan.jadwal.kehadiran', $jadwal), [
                'status_hadir' => 'tidak_hadir',
            ]);

        $response->assertSessionHasErrors('catatan');

        // Attempt to decline WITH catatan (should succeed)
        $response2 = $this->actingAs($karyawan)
            ->patch(route('karyawan.jadwal.kehadiran', $jadwal), [
                'status_hadir' => 'tidak_hadir',
                'catatan' => 'Sakit demam',
            ]);

        $response2->assertRedirect();
        
        $this->assertDatabaseHas('jadwals', [
            'id' => $jadwal->id,
            'status_hadir' => 'tidak_hadir',
            'catatan' => 'Sakit demam',
        ]);
    }
}

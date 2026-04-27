<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PaketController as AdminPaketController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use Illuminate\Support\Facades\Route;

// ── Public ────────────────────────────────────────
Route::get('/', LandingController::class)->name('home');

// ── Auth ──────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ── Customer (Pelanggan) ──────────────────────────
Route::middleware(['auth', 'role:pelanggan'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking/create', [CustomerController::class, 'createBooking'])->name('booking.create');
    Route::post('/booking', [CustomerController::class, 'storeBooking'])->name('booking.store');
    Route::get('/booking/history', [CustomerController::class, 'bookingHistory'])->name('booking.history');
    Route::get('/booking/{booking}', [CustomerController::class, 'showBooking'])->name('booking.show');
    Route::post('/booking/{booking}/payment', [CustomerController::class, 'uploadPayment'])->name('booking.payment');
});

// ── Admin ─────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Bookings
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
    Route::post('/bookings/{booking}/assign', [AdminBookingController::class, 'assignKaryawan'])->name('bookings.assign');
    Route::delete('/jadwal/{jadwal}', [AdminBookingController::class, 'removeKaryawan'])->name('jadwal.remove');

    // Payments
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::patch('/payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');

    // Paket
    Route::resource('paket', AdminPaketController::class);

    // Karyawan
    Route::resource('karyawan', AdminKaryawanController::class);
});

// ── Owner ─────────────────────────────────────────
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
});

// ── Karyawan ──────────────────────────────────────
Route::middleware(['auth', 'role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanController::class, 'dashboard'])->name('dashboard');
    Route::get('/jadwal', [KaryawanController::class, 'jadwal'])->name('jadwal.index');
    Route::get('/jadwal/{jadwal}', [KaryawanController::class, 'showJadwal'])->name('jadwal.show');
    Route::patch('/jadwal/{jadwal}/kehadiran', [KaryawanController::class, 'updateKehadiran'])->name('jadwal.kehadiran');
});

// ── API (Date Availability) ──────────────────────
Route::middleware('auth')->prefix('api')->group(function () {
    Route::post('/check-availability', [CustomerController::class, 'checkAvailability'])->name('api.check-availability');
});

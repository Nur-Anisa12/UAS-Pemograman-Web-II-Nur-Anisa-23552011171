<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TipeKamarController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ActivityLogController;

// ── Halaman utama → redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// ── Routes Auth (login, logout) — sudah dibuat otomatis Breeze
require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/user-profile',          [UserProfileController::class, 'index'])->name('user-profile.index');
    Route::post('/user-profile/update',  [UserProfileController::class, 'update'])->name('user-profile.update');
});

// ── Routes Admin (hanya role admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // nanti tambah routes CRUD di sini
    Route::resource('tipe-kamar', TipeKamarController::class);
    Route::resource('fasilitas', FasilitasController::class)
        ->parameters([
            'fasilitas' => 'fasilitas',
        ]);
    Route::resource('kamar', KamarController::class)
        ->parameters([
            'kamar' => 'kamar',
        ]);

    Route::resource('tamu', TamuController::class)
        ->parameters([
            'tamu' => 'tamu',
        ]);
    Route::resource('bookings', BookingController::class);
    Route::post('bookings/{booking}/confirm',   [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{booking}/check-in',  [BookingController::class, 'checkIn'])->name('bookings.check-in');
    Route::post('bookings/{booking}/check-out', [BookingController::class, 'checkOut'])->name('bookings.check-out');
    Route::post('bookings/{booking}/cancel',    [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::resource('users', UserController::class);
    Route::get('laporan',             [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('laporan/export-pdf',  [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('admin/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
});

// ── Routes Petugas (admin + petugas bisa akses)
Route::middleware(['auth'])->prefix('petugas')->name('petugas.')->group(function () {

    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');

    // Tamu
    Route::resource('tamu', TamuController::class)
        ->parameters(['tamu' => 'tamu']);

    // Booking
    Route::resource('bookings', BookingController::class);
    Route::post('bookings/{booking}/confirm',   [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{booking}/check-in',  [BookingController::class, 'checkIn'])->name('bookings.check-in');
    Route::post('bookings/{booking}/check-out', [BookingController::class, 'checkOut'])->name('bookings.check-out');
    Route::post('bookings/{booking}/cancel',    [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Check-In
    Route::get('check-in',            [CheckInController::class,  'index'])->name('checkin.index');
    Route::post('check-in/{id}', [CheckInController::class, 'process'])->name('checkin.process');

    // Check-Out
    Route::get('check-out',            [CheckOutController::class, 'index'])->name('checkout.index');
    Route::post('check-out/{id}',  [CheckOutController::class, 'process'])->name('checkout.process');
    Route::get('check-out/{id}/nota', [CheckOutController::class, 'nota'])->name('checkout.nota');
});

// Profile — bisa diakses semua role yang sudah login

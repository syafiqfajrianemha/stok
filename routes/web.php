<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\RoleCheck;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user', [RegisteredUserController::class, 'index'])->middleware(RoleCheck::class.':admin')->name('user.index');
    Route::get('/user/{id}', [RegisteredUserController::class, 'edit'])->middleware(RoleCheck::class.':admin')->name('user.edit');
    Route::patch('/user/{id}', [RegisteredUserController::class, 'update'])->middleware(RoleCheck::class.':admin')->name('user.update');
    Route::delete('/user/{id}', [RegisteredUserController::class, 'destroy'])->middleware(RoleCheck::class.':admin')->name('user.destroy');

    Route::resource('/barang', BarangController::class)->middleware(RoleCheck::class.':admin');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
    Route::post('/transaksi/simpan', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])->name('transaksi.struk');

    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
    Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
});

require __DIR__.'/auth.php';

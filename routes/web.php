<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ovo su rute za tvoj projekat. Sve rute su zaštićene middleware-ima koji 
| osiguravaju da su korisnici autentifikovani.
|
*/

// Početna stranica vodi na dashboard (zaštita preko middleware-a)
Route::middleware(['auth:sanctum', 'verified'])->get('/', [DashboardController::class, 'index'])->name('dashboard');

// Ruta za dashboard (kontroler DashboardController)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', config('jetstream.auth_session')])
    ->name('dashboard');

// Ruta za igre (GamesController)
Route::get('/games', [GamesController::class, 'index'])
    ->middleware(['auth']) // Dodaj middleware ako je pristup samo za ulogovane korisnike
    ->name('games');

Route::get('/games', [GamesController::class, 'index'])->middleware(['auth'])->name('games');

use App\Http\Controllers\AccountController;

Route::post('/add-money', [AccountController::class, 'addMoney'])->middleware('auth')->name('add.money');

use App\Http\Controllers\SlotMachineController;

// Ruta za prikaz stranice slot mašine
Route::get('/slot-machine', [SlotMachineController::class, 'index'])->name('slot.machine');

// Ruta za spin funkcionalnost
Route::post('/slot-machine/spin', [SlotMachineController::class, 'spin'])->name('slot.machine.spin');

// Ruta za Blackjack
Route::get('/blackjack', [GamesController::class, 'blackjack'])->name('games.blackjack');

// Ruta za Roulette
Route::get('/roulette', [GamesController::class, 'roulette'])->name('games.roulette');

use App\Http\Controllers\RouletteController;

Route::post('/roulette/play', [RouletteController::class, 'play'])->name('roulette.play');

use App\Http\Controllers\BlackjackController;
// Ruta za početak igre (pokreće igru)
Route::post('/blackjack/start', [BlackjackController::class, 'start'])->middleware('auth');

// Ruta za završetak igre (ako korisnik pobedi ili izgubi)
Route::post('/blackjack/end', [BlackjackController::class, 'end'])->middleware('auth');

use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
});

use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
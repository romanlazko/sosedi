<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Telegram\TelegramAdvertisementController;
use App\Http\Controllers\Telegram\TelegramChatController;
use App\Http\Controllers\Telegram\TelegramController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::name('admin.')->group(function () {
        Route::resource('telegram_bot', TelegramController::class);
        Route::resource('telegram_bot.chat', TelegramChatController::class);
        Route::resource('telegram_bot.advertisement', TelegramAdvertisementController::class);
        Route::resource('telegram_bot.message', MessageController::class);
    });
});

require __DIR__.'/auth.php';

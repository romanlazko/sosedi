<?php

use App\Bots\pozor_sosedi_bot\Http\Controllers\AnnouncementController;
use App\Bots\pozor_sosedi_bot\Http\Controllers\BaraholkaAnnouncementController;
use App\Bots\pozor_sosedi_bot\Http\Controllers\BaraholkaCategoryController;
use App\Bots\pozor_sosedi_bot\Http\Controllers\BaraholkaSubcategoryController;
use Illuminate\Support\Facades\Route;
use Romanlazko\Telegram\Http\Controllers\ChatController;
use Romanlazko\Telegram\Http\Controllers\GetContactController;
use Romanlazko\Telegram\Http\Controllers\MessageController;

Route::middleware(['web'])->name('admin.')->prefix('admin')->group(function () {
    Route::middleware(['web', 'auth'])->group(function () {
        Route::resource('telegram_bot.announcement', AnnouncementController::class);
        Route::resource('telegram_bot.category', BaraholkaCategoryController::class);
        Route::resource('telegram_bot.category.subcategory', BaraholkaSubcategoryController::class);
    });
});

<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'telegram:pozorbottestbot'])->name('pozorbottestbot.')->group(function () {
    Route::get('/page', function(){
        return view('pozorbottestbot::page');
    })->name('page');
});
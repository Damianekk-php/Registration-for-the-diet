<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\AccountController;

Route::middleware(['auth'])->group(function () {
    Route::get('/account/edit', [AccountController::class, 'showForm'])->name('account.edit');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');
});

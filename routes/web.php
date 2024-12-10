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
    Route::post('/account/survey', [AccountController::class, 'storeSurvey'])->name('account.survey.store');
    Route::post('/account/family/invite', [AccountController::class, 'inviteFamilyMember'])->name('account.family.invite');
    Route::delete('/account/family/{id}', [AccountController::class, 'destroyFamilyMember'])->name('family.destroy');
    Route::post('/allergens/save', [App\Http\Controllers\AccountController::class, 'saveAllergens'])->name('allergens.save');
    Route::post('/physical-activity', [AccountController::class, 'savePhysicalActivity'])->name('physicalActivity.save');
});

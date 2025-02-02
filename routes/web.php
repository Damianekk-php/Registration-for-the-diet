<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\AccountController::class, 'showForm'])->name('showForm');

use App\Http\Controllers\AccountController;

Route::middleware(['auth'])->group(function () {
    Route::get('/account/edit', [AccountController::class, 'showForm'])->name('account.edit');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::post('/account/survey', [AccountController::class, 'storeSurvey'])->name('account.survey.store');
    Route::post('/account/family/invite', [AccountController::class, 'inviteFamilyMember'])->name('account.family.invite');
    Route::delete('/account/family/{id}', [AccountController::class, 'destroyFamilyMember'])->name('family.destroy');
    Route::post('/allergens/save', [App\Http\Controllers\AccountController::class, 'saveAllergens'])->name('allergens.save');
    Route::post('/physical-activity', [AccountController::class, 'savePhysicalActivity'])->name('physicalActivity.save');
    Route::post('/settings/save', [AccountController::class, 'saveSettings'])->name('settings.save');
    Route::post('/settings/saveTheme', [AccountController::class, 'saveTheme'])->name('settings.saveTheme');
    Route::get('/allergens', [AccountController::class, 'getAllergens'])->name('allergens.get');
    Route::post('/settings/saveBackground', [AccountController::class, 'saveBackground'])->name('settings.saveBackground');
    Route::get('/members/{email}/details', [AccountController::class, 'detailsByEmail'])->name('members.detailsByEmail');



});
Route::get('/family/activate/{token}', [AccountController::class, 'activateFamilyMember'])->name('family.activate');
Route::post('/account/family/invite', [AccountController::class, 'inviteFamilyMember'])->name('account.family.invite');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
});

Route::get('/admin/users/pdf', [AdminController::class, 'downloadUsersPDF'])->name('admin.users.pdf');

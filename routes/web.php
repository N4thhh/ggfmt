<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MtController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountSetupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\PanelistController;


Route::get('/', function () {
    return view('welcome');

});

Route::resource('mt', MtController::class)->parameters([
    'mt' => 'managementTrainee',
])->middleware(['auth','role:admin,hr,coach,panelist']);

Route::resource('user', UserController::class)->middleware(['auth','role:admin,hr']);

Route::resource('coach', CoachController::class)->middleware(['auth','role:admin,hr']);

Route::resource('panelist', PanelistController::class)->middleware(['auth','role:admin,hr']);

Route::post('/user/{user}/send-invite', [UserController::class, 'sendInvite'])->name('user.sendInvite')->middleware(['auth','role:admin,hr']);
Route::post('/user/send-invite-all', [UserController::class, 'sendInviteAll'])->name('user.sendInviteAll')->middleware(['auth','role:admin,hr']);
Route::get('/setup-account/{token}', [AccountSetupController::class, 'showSetupForm'])->name('account-setup.showSetupForm');
Route::post('/setup-account/{token}', [AccountSetupController::class, 'store'])->name('account-setup.store');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
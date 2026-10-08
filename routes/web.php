<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MtController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountSetupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\PanelistController;
use App\Http\Controllers\ScoringController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');

});

Route::resource('mt', MtController::class)
    ->parameters(['mt' => 'managementTrainee'])
    ->only(['index'])
    ->middleware(['auth', 'role:admin,hr,panelist']);

Route::resource('mt', MtController::class)
    ->parameters(['mt' => 'managementTrainee'])
    ->only(['show'])
    ->middleware(['auth', 'role:admin,hr,coach,panelist']);

Route::resource('user', UserController::class)->middleware(['auth','role:admin,hr']);

Route::resource('coach', CoachController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'role:admin,hr']);

Route::resource('coach', CoachController::class)
    ->only(['show'])
    ->middleware(['auth', 'role:admin,hr,coach']);

Route::resource('panelist', PanelistController::class)->middleware(['auth','role:admin,hr']);

Route::post('/user/{user}/send-invite', [UserController::class, 'sendInvite'])->name('user.sendInvite')->middleware(['auth','role:admin,hr']);
Route::post('/user/send-invite-all', [UserController::class, 'sendInviteAll'])->name('user.sendInviteAll')->middleware(['auth','role:admin,hr']);
Route::get('/setup-account/{token}', [AccountSetupController::class, 'showSetupForm'])->name('account-setup.showSetupForm');
Route::post('/setup-account/{token}', [AccountSetupController::class, 'store'])->name('account-setup.store');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/assignments/{assignment}/score', [ScoringController::class, 'show'])->name('scoring.show')->middleware(['auth', 'role:panelist']);
Route::post('/assignments/{assignment}/score', [ScoringController::class, 'store'])->name('scoring.store')->middleware(['auth', 'role:panelist']);
Route::get('/scoring/{assignment}/admin', [ScoringController::class, 'adminShow'])
    ->name('scoring.adminShow');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'role:admin,hr']);

Route::patch('/mt/{managementTrainee}/status', [MtController::class, 'updateStatus'])->name('mt.updateStatus');
Route::post('/mt/{managementTrainee}/assign-coach', [MtController::class, 'assignCoach'])->name('mt.assignCoach');
Route::patch('/mt/{managementTrainee}', [MtController::class, 'update'])->name('mt.update');
Route::post('/assignment/{assignment}/assign-panelist', [MtController::class, 'assignPanelist'])->name('assignment.assignPanelist');
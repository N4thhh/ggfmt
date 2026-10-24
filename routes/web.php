<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/setup-account/{token}', [AccountSetupController::class, 'showSetupForm'])->name('account-setup.showSetupForm');
Route::post('/setup-account/{token}', [AccountSetupController::class, 'store'])->name('account-setup.store');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'role:admin,hr']);


Route::resource('mt', MtController::class)
    ->parameters(['mt' => 'managementTrainee'])
    ->only(['index'])
    ->middleware(['auth', 'role:admin,hr,panelist']);

// mt.show: dilihat admin/hr/coach/panelist -- role 'mt' TIDAK termasuk di sini,
// MT punya halaman sendiri (mt.dashboard) di bawah.
Route::resource('mt', MtController::class)
    ->parameters(['mt' => 'managementTrainee'])
    ->only(['show'])
    ->middleware(['auth', 'role:admin,hr,coach,panelist']);

Route::middleware(['auth', 'role:mt'])->group(function () {
    Route::get('/mt-dashboard', [MtController::class, 'dashboard'])->name('mt.dashboard');
    Route::post('/mt-dashboard/photo', [MtController::class, 'uploadPhoto'])->name('mt.uploadPhoto');
    Route::patch('/mt-dashboard/data', [MtController::class, 'updateOwnData'])->name('mt.updateOwnData');
    Route::post('/mt-dashboard/assignment/{assignment}/upload', [MtController::class, 'uploadAssignment'])->name('mt.uploadAssignment');
});

Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::patch('/mt/{managementTrainee}/status', [MtController::class, 'updateStatus'])->name('mt.updateStatus');
    Route::post('/mt/{managementTrainee}/assign-coach', [MtController::class, 'assignCoach'])->name('mt.assignCoach');
    Route::patch('/mt/{managementTrainee}', [MtController::class, 'update'])->name('mt.update');
    Route::post('/assignment/{assignment}/assign-panelist', [MtController::class, 'assignPanelist'])->name('assignment.assignPanelist');
    Route::get('/mts/search', [MtController::class, 'searchAjax'])->name('mts.searchAjax');
});

Route::resource('coach', CoachController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'role:admin,hr']);

Route::resource('coach', CoachController::class)
    ->only(['show'])
    ->middleware(['auth', 'role:admin,hr,coach']);

Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::post('/coach/{coach}/assign-mt', [CoachController::class, 'assignMt'])->name('coach.assignMt');
    Route::get('/coaches/search', [CoachController::class, 'searchAjax'])->name('coaches.searchAjax');
});

Route::resource('panelist', PanelistController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'role:admin,hr']);

Route::resource('panelist', PanelistController::class)
    ->only(['show'])
    ->middleware(['auth', 'role:admin,hr,panelist']);

Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::post('/panelist/{panelist}/assign-assignment', [PanelistController::class, 'assignAssignment'])->name('panelist.assignAssignment');
    Route::get('/panelists/search', [PanelistController::class, 'searchAjax'])->name('panelists.searchAjax');
    Route::get('/assignments/search', [PanelistController::class, 'searchAssignmentAjax'])->name('assignments.searchAjax');
});

Route::resource('user', UserController::class)
    ->middleware(['auth', 'role:admin,hr']);

Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::post('/user/{user}/send-invite', [UserController::class, 'sendInvite'])->name('user.sendInvite');
    Route::post('/user/send-invite-all', [UserController::class, 'sendInviteAll'])->name('user.sendInviteAll');
});

Route::middleware(['auth', 'role:admin,hr,panelist'])->group(function () {
    Route::get('/scoring/{assignment}', [ScoringController::class, 'adminShow'])->name('scoring.adminShow');
    Route::post('/scoring/{assignment}', [ScoringController::class, 'store'])->name('scoring.store');
});

Route::get('/force-logout', function (\Illuminate\Http\Request $request) {
    // 1. Keluarkan user dari sesi autentikasi
    Auth::logout();

    // 2. Hancurkan sesi yang saat ini berjalan
    $request->session()->invalidate();

    // 3. Buat ulang token CSRF demi keamanan
    $request->session()->regenerateToken();

    // 4. Arahkan kembali ke halaman login
    return redirect('/login');
});

Route::post('/coach-notes/{managementTrainee}', [CoachController::class, 'storeNote'])
    ->name('coach.storeNote')
    ->middleware(['auth', 'role:coach']);

Route::middleware(['auth', 'role:coach'])->group(function () {
    Route::post('/coach-notes/{managementTrainee}', [CoachController::class, 'storeNote'])->name('coach.storeNote');
    Route::patch('/coach-notes/{coachNote}', [CoachController::class, 'updateNote'])->name('coach.updateNote');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MtController;


Route::get('/', function () {
    return view('welcome');

});

Route::resource('mt', MtController::class)->parameters([
    'mt' => 'managementTrainee',
]);


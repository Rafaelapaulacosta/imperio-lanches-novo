<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LancheController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::resource('lanches', LancheController::class)->parameters([
    'lanches' => 'lanche'
]);


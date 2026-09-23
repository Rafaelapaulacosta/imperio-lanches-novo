<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LancheController;
use App\Http\Controllers\BairroController;
use App\Http\Controllers\RefrigeranteController;
use App\Http\Controllers\PedidoController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::resource('lanches', LancheController::class)->parameters([
    'lanches' => 'lanche'
]);

Route::resource('bairros', BairroController::class)->parameters([
    'bairros' => 'bairro'
]);

Route::resource('refrigerantes', RefrigeranteController::class)->parameters([
    'refrigerantes' => 'refrigerante'
]);

Route::resource('pedidos', PedidoController::class);

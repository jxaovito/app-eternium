<?php
use App\Modules\Financeiro\Controllers\Financeiro_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Financeiro\Controllers'], function () {
    Route::get('/financeiro', [Financeiro_controller::class, 'index'])->name('financeiro');
    Route::get('/financeiro/editar/{id}', [Financeiro_controller::class, 'editar'])->name('editar');
    Route::post('/financeiro/editar_salvar', [Financeiro_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/financeiro/novo', [Financeiro_controller::class, 'novo'])->name('novo');
    Route::post('/financeiro/novo_salvar', [Financeiro_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/financeiro/remover/{id}', [Financeiro_controller::class, 'remover'])->name('remover');
});
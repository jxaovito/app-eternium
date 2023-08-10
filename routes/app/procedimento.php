<?php
use App\Modules\Procedimento\Controllers\Procedimento_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Procedimento\Controllers'], function () {
    Route::get('/procedimento', [Procedimento_controller::class, 'index'])->name('procedimento');
    Route::get('/procedimento/editar/{id}', [Procedimento_controller::class, 'editar'])->name('editar');
    Route::post('/procedimento/editar_salvar', [Procedimento_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/procedimento/novo', [Procedimento_controller::class, 'novo'])->name('novo');
    Route::post('/procedimento/novo_salvar', [Procedimento_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/procedimento/remover/{id}', [Procedimento_controller::class, 'remover'])->name('remover');
});
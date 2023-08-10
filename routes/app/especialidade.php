<?php
use App\Modules\Especialidade\Controllers\Especialidade_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Especialidade\Controllers'], function () {
    Route::get('/especialidade', [Especialidade_controller::class, 'index'])->name('especialidade');
    Route::get('/especialidade/editar/{id}', [Especialidade_controller::class, 'editar'])->name('editar');
    Route::post('/especialidade/editar_salvar', [Especialidade_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/especialidade/novo', [Especialidade_controller::class, 'novo'])->name('novo');
    Route::post('/especialidade/novo_salvar', [Especialidade_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/especialidade/remover/{id}', [Especialidade_controller::class, 'remover'])->name('remover');
});
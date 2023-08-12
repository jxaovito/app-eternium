<?php
use App\Modules\Especialidade\Controllers\Especialidade_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Especialidade\Controllers'], function () {
    Route::get('/especialidade', [Especialidade_controller::class, 'index'])->name('especialidade');
    Route::get('/especialidade/editar/{id}', [Especialidade_controller::class, 'editar'])->name('editar');
    Route::post('/especialidade/editar_salvar/{id}', [Especialidade_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/especialidade/novo', [Especialidade_controller::class, 'novo'])->name('novo');
    Route::post('/especialidade/novo_salvar', [Especialidade_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/especialidade/remover/{id}', [Especialidade_controller::class, 'remover'])->name('remover');
    Route::get('/especialidade/desativar/{id}', [Especialidade_controller::class, 'desativar'])->name('desativar');
    Route::get('/especialidade/ativar/{id}', [Especialidade_controller::class, 'ativar'])->name('ativar');
    Route::post('/especialidade/filtrar', [Especialidade_controller::class, 'filtrar'])->name('filtrar');
    Route::get('/especialidade/limpar_filtro', [Especialidade_controller::class, 'limpar_filtro'])->name('limpar_filtro');
});
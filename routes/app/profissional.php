<?php
use App\Modules\Profissional\Controllers\Profissional_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Profissional\Controllers'], function () {
    Route::get('/profissional', [Profissional_controller::class, 'index'])->name('profissional');
    Route::get('/profissional/editar/{id}', [Profissional_controller::class, 'editar'])->name('editar');
    Route::post('/profissional/editar_salvar/{id}', [Profissional_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/profissional/novo', [Profissional_controller::class, 'novo'])->name('novo');
    Route::post('/profissional/novo_salvar', [Profissional_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/profissional/remover/{id}', [Profissional_controller::class, 'remover'])->name('remover');

    Route::get('/profissional/horario/{id}', [Profissional_controller::class, 'horario'])->name('horario');
    Route::post('/profissional/horario_salvar/{id}', [Profissional_controller::class, 'horario_salvar'])->name('horario_salvar');

    Route::get('/profissional/desativar/{id}', [Profissional_controller::class, 'desativar'])->name('desativar');
    Route::get('/profissional/ativar/{id}', [Profissional_controller::class, 'ativar'])->name('ativar');

    Route::post('/profissional/filtrar', [Profissional_controller::class, 'filtrar'])->name('filtrar');
    Route::get('/profissional/limpar_filtro', [Profissional_controller::class, 'limpar_filtro'])->name('limpar_filtro');

    Route::post('/profissional/get_especialidade_by_profissional_id', [Profissional_controller::class, 'get_especialidade_by_profissional_id'])->name('get_especialidade_by_profissional_id');
});
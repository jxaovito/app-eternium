<?php
use App\Modules\Paciente\Controllers\Paciente_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Paciente\Controllers'], function () {
    Route::get('/paciente', [Paciente_controller::class, 'index'])->name('paciente');

    Route::get('/paciente/editar/{id}', [Paciente_controller::class, 'editar'])->name('editar');
    Route::post('/paciente/editar_salvar/{id}', [Paciente_controller::class, 'editar_salvar'])->name('editar_salvar');

    Route::get('/paciente/novo', [Paciente_controller::class, 'novo'])->name('novo');
    Route::post('/paciente/novo_salvar', [Paciente_controller::class, 'novo_salvar'])->name('novo_salvar');

    Route::get('/paciente/remover/{id}', [Paciente_controller::class, 'remover'])->name('remover');

    Route::get('/paciente/visualizar/{id}', [Paciente_controller::class, 'visualizar'])->name('visualizar');

    Route::get('/paciente/desativar/{id}', [Paciente_controller::class, 'desativar'])->name('desativar');
    Route::get('/paciente/ativar/{id}', [Paciente_controller::class, 'ativar'])->name('ativar');

    Route::post('/paciente/filtrar', [Paciente_controller::class, 'filtrar'])->name('filtrar');
    Route::get('/paciente/limpar_filtro', [Paciente_controller::class, 'limpar_filtro'])->name('limpar_filtro');

    Route::post('/paciente/busca_paciente_by_nome', [Paciente_controller::class, 'busca_paciente_by_nome'])->name('busca_paciente_by_nome');
    Route::post('/paciente/busca_paciente_by_id', [Paciente_controller::class, 'busca_paciente_by_id'])->name('busca_paciente_by_id');
});
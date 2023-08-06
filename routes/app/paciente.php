<?php
use App\Modules\Paciente\Controllers\Paciente_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Paciente\Controllers'], function () {
    Route::get('/paciente', [Paciente_controller::class, 'index'])->name('paciente');
    Route::get('/paciente/editar/{id}', [Paciente_controller::class, 'editar'])->name('editar');
    Route::post('/paciente/editar_salvar', [Paciente_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/paciente/novo', [Paciente_controller::class, 'novo'])->name('novo');
    Route::post('/paciente/novo_salvar', [Paciente_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/paciente/remover/{id}', [Paciente_controller::class, 'remover'])->name('remover');
});
<?php
use App\Modules\Profissional\Controllers\Profissional_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Profissional\Controllers'], function () {
    Route::get('/profissional', [Profissional_controller::class, 'index'])->name('profissional');
    Route::get('/profissional/editar/{id}', [Profissional_controller::class, 'editar'])->name('editar');
    Route::post('/profissional/editar_salvar', [Profissional_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/profissional/novo', [Profissional_controller::class, 'novo'])->name('novo');
    Route::post('/profissional/novo_salvar', [Profissional_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/profissional/remover/{id}', [Profissional_controller::class, 'remover'])->name('remover');
});
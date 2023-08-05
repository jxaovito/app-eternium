<?php
use App\Modules\Permissao\Controllers\Permissao_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Permissao\Controllers'], function () {
    Route::get('/permissao', [Permissao_controller::class, 'index'])->name('permissao');
    Route::get('/permissao/editar/{id}', [Permissao_controller::class, 'editar'])->name('editar');
    Route::post('/permissao/salvar_edicao', [Permissao_controller::class, 'salvar_edicao'])->name('salvar_edicao');
    Route::get('/permissao/novo', [Permissao_controller::class, 'novo'])->name('novo');
});
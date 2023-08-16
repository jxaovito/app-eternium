<?php
use App\Modules\Permissao\Controllers\Permissao_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Permissao\Controllers'], function () {
    Route::get('/permissao', [Permissao_controller::class, 'index'])->name('permissao');
    Route::get('/permissao/editar/{id}', [Permissao_controller::class, 'editar'])->name('editar_permissao');
    Route::post('/permissao/editar_salvar', [Permissao_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/permissao/novo', [Permissao_controller::class, 'novo'])->name('novo');
    Route::post('/permissao/novo_salvar', [Permissao_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/permissao/remover/{id}', [Permissao_controller::class, 'remover'])->name('remover');
});
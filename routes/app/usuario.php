<?php
use App\Modules\Usuario\Controllers\Usuario_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Usuario\Controllers'], function () {
    Route::get('/usuario', [Usuario_controller::class, 'index'])->name('usuario');
    Route::get('/usuario/editar/{id}', [Usuario_controller::class, 'editar'])->name('editar');
    Route::post('/usuario/editar_salvar/{id}', [Usuario_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/usuario/novo', [Usuario_controller::class, 'novo'])->name('novo');
    Route::post('/usuario/novo_salvar', [Usuario_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/usuario/remover/{id}', [Usuario_controller::class, 'remover'])->name('remover');
    Route::get('/usuario/desativar/{id}', [Usuario_controller::class, 'desativar'])->name('desativar');
    Route::get('/usuario/ativar/{id}', [Usuario_controller::class, 'ativar'])->name('ativar');
    Route::post('/usuario/filtrar', [Usuario_controller::class, 'filtrar'])->name('filtrar');
    Route::get('/usuario/limpar_filtro', [Usuario_controller::class, 'limpar_filtro'])->name('limpar_filtro');
});
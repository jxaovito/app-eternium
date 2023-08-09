<?php
use App\Modules\Convenio\Controllers\Convenio_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Convenio\Controllers'], function () {
    Route::get('/convenio', [Convenio_controller::class, 'index'])->name('convenio');
    Route::get('/convenio/editar/{id}', [Convenio_controller::class, 'editar'])->name('editar');
    Route::post('/convenio/editar_salvar', [Convenio_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/convenio/novo', [Convenio_controller::class, 'novo'])->name('novo');
    Route::post('/convenio/novo_salvar', [Convenio_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/convenio/remover/{id}', [Convenio_controller::class, 'remover'])->name('remover');
});
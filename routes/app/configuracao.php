<?php
use App\Modules\Configuracao\Controllers\Configuracao_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Configuracao\Controllers'], function () {
    Route::get('/configuracao', [Configuracao_controller::class, 'index'])->name('configuracao');
    Route::post('/configuracao/salvar_dados', [Configuracao_controller::class, 'salvar_dados'])->name('salvar_dados');
    Route::post('/configuracao/salvar_sistema', [Configuracao_controller::class, 'salvar_sistema'])->name('salvar_sistema');
});
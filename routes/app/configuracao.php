<?php
use App\Modules\Configuracao\Controllers\Configuracao_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Configuracao\Controllers'], function () {
    Route::get('/configuracao', [Configuracao_controller::class, 'index'])->name('configuracao');
    Route::post('/configuracao/salvar_dados', [Configuracao_controller::class, 'salvar_dados'])->name('salvar_dados');
    Route::post('/configuracao/salvar_sistema', [Configuracao_controller::class, 'salvar_sistema'])->name('salvar_sistema');

    Route::get('/configuracao/agenda', [Configuracao_controller::class, 'agenda'])->name('configuracao_agenda');
    Route::post('/configuracao/agenda_salvar', [Configuracao_controller::class, 'agenda_salvar'])->name('configuracao_agenda_salvar');

    // API
    Route::post('/configuracao/menu', [Configuracao_controller::class, 'menu'])->name('menu');
});
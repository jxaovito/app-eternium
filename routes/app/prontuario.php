<?php
use App\Modules\Prontuario\Controllers\Prontuario_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Prontuario\Controllers'], function () {
    Route::get('/prontuario', [Prontuario_controller::class, 'index'])->name('prontuario');

    Route::get('/prontuario/atender/{paciente_id}/{agenda_id?}/{submenu?}', [Prontuario_controller::class, 'atender'])->name('atender');

    // API
});
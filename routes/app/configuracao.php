<?php
use App\Modules\Configuracao\Controllers\Configuracao_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Configuracao\Controllers'], function () {
    Route::get('/configuracao', [Configuracao_controller::class, 'index'])->name('configuracao');
});
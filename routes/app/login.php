<?php
use App\Modules\Login\Controllers\Login_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web'], 'namespace' => 'App\Modules\Login\Controllers'], function () {
    Route::get('/', [Login_controller::class, 'index']);
    Route::get('/login', [Login_controller::class, 'index']);
    Route::post('/auth', [Login_controller::class, 'auth']);
    Route::get('/logout', [Login_controller::class, 'logout']);

    Route::get('/permissao_negada', [Login_controller::class, 'permissao_negada']);
});
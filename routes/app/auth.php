<?php
use App\Modules\Auth\Controllers\Auth_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Auth\Controllers'], function () {
    Route::post('/auth', [Auth_controller::class, 'auth']);
});
<?php
use App\Modules\Agenda\Controllers\Agenda_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Agenda\Controllers'], function () {
    Route::get('/agenda/{id?}', [Agenda_controller::class, 'index'])->name('agenda');
});
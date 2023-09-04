<?php
use App\Modules\Agenda\Controllers\Agenda_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Agenda\Controllers'], function () {
    Route::get('/agenda/{id?}', [Agenda_controller::class, 'index'])->name('agenda');

    // API's
    Route::post('/agenda/criar_agendamento', [Agenda_controller::class, 'criar_agendamento'])->name('criar_agendamento');
    Route::post('/agenda/atualizar_agenda', [Agenda_controller::class, 'atualizar_agenda'])->name('atualizar_agenda');
    Route::post('/agenda/busca_agendamento', [Agenda_controller::class, 'busca_agendamento'])->name('busca_agendamento');
    
});
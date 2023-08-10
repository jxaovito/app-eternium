<?php
use App\Modules\Relatorio\Controllers\Relatorio_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Relatorio\Controllers'], function () {
    Route::get('/relatorio', [Relatorio_controller::class, 'index'])->name('relatorio');
    Route::get('/relatorio/editar/{id}', [Relatorio_controller::class, 'editar'])->name('editar');
    Route::post('/relatorio/editar_salvar', [Relatorio_controller::class, 'editar_salvar'])->name('editar_salvar');
    Route::get('/relatorio/novo', [Relatorio_controller::class, 'novo'])->name('novo');
    Route::post('/relatorio/novo_salvar', [Relatorio_controller::class, 'novo_salvar'])->name('novo_salvar');
    Route::get('/relatorio/remover/{id}', [Relatorio_controller::class, 'remover'])->name('remover');
});
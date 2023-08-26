<?php
use App\Modules\Tratamento\Controllers\Tratamento_controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dynamic.database'], 'namespace' => 'App\Modules\Tratamento\Controllers'], function () {
    Route::get('/tratamento', [Tratamento_controller::class, 'index'])->name('tratamento');
    
    Route::get('/tratamento/editar/{id}', [Tratamento_controller::class, 'editar'])->name('editar');
    Route::post('/tratamento/editar_salvar', [Tratamento_controller::class, 'editar_salvar'])->name('editar_salvar');
    
    Route::get('/tratamento/novo', [Tratamento_controller::class, 'novo'])->name('novo');
    Route::post('/tratamento/novo_salvar', [Tratamento_controller::class, 'novo_salvar'])->name('novo_salvar');

    Route::get('/tratamento/visualizar/{id}', [Tratamento_controller::class, 'visualizar'])->name('visualizar');

    Route::get('/tratamento/remover/{id}', [Tratamento_controller::class, 'remover'])->name('remover');

    Route::post('/tratamento/filtrar', [Tratamento_controller::class, 'filtrar'])->name('filtrar');
    Route::get('/tratamento/limpar_filtro', [Tratamento_controller::class, 'limpar_filtro'])->name('limpar_filtro');

    Route::post('/tratamento/get_subcategoria', [Tratamento_controller::class, 'get_subcategoria'])->name('get_subcategoria');
});
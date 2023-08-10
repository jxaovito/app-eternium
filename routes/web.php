<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
require __DIR__.'/../routes/app/login.php';
require __DIR__.'/../routes/app/auth.php';
require __DIR__.'/../routes/app/agenda.php';
require __DIR__.'/../routes/app/permissao.php';
require __DIR__.'/../routes/app/paciente.php';
require __DIR__.'/../routes/app/convenio.php';
require __DIR__.'/../routes/app/profissional.php';
require __DIR__.'/../routes/app/especialidade.php';
require __DIR__.'/../routes/app/procedimento.php';
require __DIR__.'/../routes/app/tratamento.php';
require __DIR__.'/../routes/app/financeiro.php';
require __DIR__.'/../routes/app/relatorio.php';

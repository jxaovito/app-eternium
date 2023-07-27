<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class DynamicDatabaseConnection
{
    public function handle($request, Closure $next)
    {
        // Verifica se a sessão está disponível
        if (Session::isStarted()) {
            // Recupere o nome do banco de dados do cliente armazenado na sessão
            $clientDatabase = 'eter_conexao'.(Session::get('conexao_id') ? Session::get('conexao_id') : session('conexao_id'));

        } else {
            // Se a sessão não estiver disponível, defina um valor padrão ou use a conexão padrão do Laravel
            // $clientDatabase = 'valor_padrao';
            $clientDatabase = env('DB_CON_DATABASE', 'forge');
        }

        // Configuração da conexão dinâmica com o banco de dados do cliente
        Config::set('database.connections.mysql_db', [
            'driver' => 'mysql',
            'host' => env('DB_CON_HOST', '127.0.0.1'),
            'port' => env('DB_CON_PORT', '3306'),
            'database' => $clientDatabase,
            'username' => env('DB_CON_USERNAME', 'forge'),
            'password' => env('DB_CON_PASSWORD', ''),
            'unix_socket' => env('DB_CON_SOCKET', ''),
        ]);

        // Use a conexão dinâmica para realizar consultas no banco de dados do cliente
        Config::set('database.default', 'mysql_db');

        return $next($request);
    }
}

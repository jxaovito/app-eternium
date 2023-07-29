<?php

namespace App\Modules\Auth\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Auth\Models\Auth_model;
use App\Modules\Auth\Models\Auth_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Auth_controller extends Controller {
    protected $Auth_model;
    protected $Auth_db_model;
    protected $class;

    public function __construct() {
        $this->Auth_model = new Auth_model();
        $this->Auth_db_model = new Auth_db_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function auth(Request $request) {
        $dados = $request->all();
        $email = $request->email;
        $password = $request->password;
        $password_crypto = password_hash($password, PASSWORD_BCRYPT);

        $usuario = $this->Auth_db_model->get_all_table('usuario', $email);

        if ($usuario && password_verify($password, $usuario['password'])) {
            if ($email == 'administrador@eternium.com.br') {
                if ($dados['con']) {
                    session(['conexao_id' => base64_decode($dados['con'])]);
                    session(['usuario_id' => $usuario['id']]);
                    session(['usuario_email' => $usuario['email']]);
                } else {
                    return redirect()->back()->with('error', 'Usuário administrador só pode ser acessado através do Gerenciador.');
                }
            } else {
                session(['conexao_id' => $usuario['conexao_id']]);
                session(['usuario_id' => $usuario['id']]);
                session(['usuario_email' => $usuario['email']]);
            }

            // Sessão criada, agora podemos configurar a conexão dinâmica
            // antes de executar o restante do código

            // Chama o middleware aqui
            $middleware = new \App\Http\Middleware\DynamicDatabaseConnection();
            $middleware->handle($request, function () use ($usuario) {
                $this->handleAuthenticatedUser($usuario);
            });

            // Remova o var_dump abaixo, pois a sessão já foi configurada
            $permissoes = $this->Auth_model->get_permissoes_usuario($usuario['id']);
            $permissoes_all = $this->Auth_model->get_permissoes();

            session(['permissoes' => $permissoes]);
            session(['permissoes_all' => $permissoes_all]);
    		session(['usuario_id' => $usuario['id']]);
    		session(['usuario_nome' => $usuario['nome']]);
            session(['usuario_email' => $usuario['email']]);

    		return redirect()->route('agenda');

        } else {
            return redirect()->back()->with('error', 'Usuário e/ou senha incorretos');
        }
    }

    // Crie uma função para lidar com o usuário autenticado
    private function handleAuthenticatedUser($usuario) {
        $permissoes = $this->Auth_model->get_permissoes_usuario($usuario['id']);
        $permissoes_all = $this->Auth_model->get_permissoes();

        session(['permissoes' => $permissoes]);
        session(['permissoes_all' => $permissoes_all]);
        session(['usuario_id' => $usuario['id']]);
        session(['usuario_nome' => $usuario['nome']]);
        session(['usuario_email' => $usuario['email']]);

        return redirect()->route('agenda');
    }

    // ... Outros métodos e código ...
}

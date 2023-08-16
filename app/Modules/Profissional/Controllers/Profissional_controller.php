<?php

namespace App\Modules\Profissional\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Profissional\Models\Profissional_model;
use App\Modules\Profissional\Models\Profissional_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Profissional_controller extends Controller{
	protected $Profissional_model;
    protected $Profissional_db_model;
    protected $class;

    public function __construct(){
        $this->Profissional_model = new Profissional_model();
        $this->Profissional_db_model = new Profissional_db_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Profissionais');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $usuarios = $this->Profissional_model->get_all_table('usuario');
        $qtd_usuario = $this->Profissional_model->get_all_table('configuracao', array('tipo' => 'sistema', 'variavel' => 'qtd_usuarios'));
        if((count($usuarios) -1) < $qtd_usuario[0]['valor']){
            $adicionar_usuarios = true;
        }else{
            $adicionar_usuarios = false;
        }

        $_dados['adicionar_usuarios'] = $adicionar_usuarios;
        $_dados['pagina'] = 'profissional';

        return view('profissional.index', $_dados);
    }

    public function novo(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Adicionar Profissional');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['especialidades'] = $this->Profissional_model->get_all_table('especialidade', array('deletado' => '0'));
        $_dados['pagina'] = 'profissional';

        return view('profissional.novo', $_dados);
    }

    public function novo_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'novo', 'Adicionar Profissional');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $registros = $this->Profissional_model->get_all();
        $qtd_usuario = $this->Profissional_model->get_all_table('configuracao', array('tipo' => 'sistema', 'variavel' => 'qtd_usuarios'));
        if((count($registros) -1) >= $qtd_usuario[0]['valor']){
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Você atingiu o limite contratado de usuários no sistema. Caso queira adicionar novos usuários, entre em contato com o suporte!']);

            return redirect()->route('profissional');
        }

        $imagem_nome = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imagem_nome = time() . md5(date('Y-m-d H:m:s:u')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clientes/'.session('conexao_id').'/usuario'), $imagem_nome);
        }

        $request = $request->all();

        // Insert no Banco gerenciador
        $dados = array(
            'email' => $request['email'],
            'password' => password_hash($request['senha'], PASSWORD_BCRYPT),
            'conexao_id' => session('conexao_id'),
        );
        $usuario_id = $this->Profissional_db_model->insert_dados('usuario', $dados);

        // Insert Banco conexao
        $dados = array(
            'id' => $usuario_id,
            'nome' => $request['nome'],
            'atualizar_senha' => (isset($request['solicitar_redefinicao']) ? $request['solicitar_redefinicao'] : null),
            'imagem' => $imagem_nome,
        );
        $id = $this->Profissional_model->insert_dados('usuario', $dados);

        // Insert usuário no nível de permissão
        $dados = array(
            'usuario_id' => $usuario_id,
            'auth_nivel_permissao_id' => $request['nivel_permissao'],
        );
        $id = $this->Profissional_model->insert_dados('usuario_has_nivel_permissao', $dados);

        /**
        ** Insert da Tabela e dados do Profissional
        **/
        $dados = array(
            'nome' => $request['nome'],
            'usuario_id' => $usuario_id,
        );
        $profissional_id = $this->Profissional_model->insert_dados('profissional', $dados);

        foreach($request['especialidade'] as $key => $esp){
            $dados = array(
                'especialidade_id' => $esp,
                'profissional_id' => $profissional_id
            );

            $this->Profissional_model->insert_dados('especialidade_has_profissional', $dados);
        }

        if($id){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Profissional cadastrado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao salvar o usuário. Entre em contato com o suporte.']);
        }
        return redirect()->route('profissional');
    }
}

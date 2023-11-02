<?php

namespace App\Modules\Usuario\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Usuario\Models\Usuario_model;
use App\Modules\Usuario\Models\Usuario_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Usuario_controller extends Controller{
	protected $Usuario_model;
    protected $Usuario_db_model;
    protected $class;

    public function __construct(){
        $this->Usuario_model = new Usuario_model();
        $this->Usuario_db_model = new Usuario_db_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Usuários');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $registros = $this->Usuario_model->get_all();
        $qtd_usuario = $this->Usuario_model->get_all_table('configuracao', array('tipo' => 'sistema', 'variavel' => 'qtd_usuarios'));
        if((count($registros) -1) >= $qtd_usuario[0]['valor']){
            $adicionar_usuarios = false;
        }else{
            $adicionar_usuarios = true;
        }
        
        $registros_db = $this->Usuario_db_model->get_all_table('usuario', array('conexao_id' => session('conexao_id')));

        foreach($registros as $key => $registro){
            foreach($registros_db as $key_db => $registro_db){
                if($registro['id'] == $registro_db['id'] && $registro['id'] != -1){
                    $registros[$key]['email'] = $registro_db['email'];
                }
            }
        }

        $_dados['registros'] = $registros;
        $_dados['adicionar_usuarios'] = $adicionar_usuarios;
        $_dados['pagina'] = 'usuario';
        $_dados['funcao'] = __FUNCTION__;

        return view('usuario.index', $_dados);
    }

    //Filtrar Usuário
    public function filtrar(Request $request){
        $request->all();
        session(['filtro_usuario_nome' => $request->usuario_nome]);

        return redirect()->route('usuario');
    }

    //Limpar Filtro
    public function limpar_filtro(){
        session()->forget('filtro_usuario_nome');
        return redirect()->route('usuario');
    }

    // Novo Usuário
    public function novo(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Adicionar Usuários');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $registros = $this->Usuario_model->get_all();
        $qtd_usuario = $this->Usuario_model->get_all_table('configuracao', array('tipo' => 'sistema', 'variavel' => 'qtd_usuarios'));
        if((count($registros) -1) >= $qtd_usuario[0]['valor']){
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Você atingiu o limite contratado de usuários no sistema. Caso queira adicionar novos usuários, entre em contato com o suporte!']);

            return redirect()->route('usuario');
        }

        $_dados['nivel_permissao'] = $this->Usuario_model->get_all_table('auth_nivel_permissao');

        $_dados['pagina'] = 'usuario';
        $_dados['funcao'] = __FUNCTION__;
        return view('usuario.novo', $_dados);
    }

    // Salvar Novo Usuário
    public function novo_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'novo', 'Adicionar Usuários');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $registros = $this->Usuario_model->get_all();
        $qtd_usuario = $this->Usuario_model->get_all_table('configuracao', array('tipo' => 'sistema', 'variavel' => 'qtd_usuarios'));
        if((count($registros) -1) >= $qtd_usuario[0]['valor']){
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Você atingiu o limite contratado de usuários no sistema. Caso queira adicionar novos usuários, entre em contato com o suporte!']);

            return redirect()->route('usuario');
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
        $usuario_id = $this->Usuario_db_model->insert_dados('usuario', $dados);

        // Insert Banco conexao
        $dados = array(
            'id' => $usuario_id,
            'nome' => $request['nome'],
            'atualizar_senha' => (isset($request['solicitar_redefinicao']) ? $request['solicitar_redefinicao'] : null),
            'imagem' => $imagem_nome,
        );
        $id = $this->Usuario_model->insert_dados('usuario', $dados);

        // Insert usuário no nível de permissão
        $dados = array(
            'usuario_id' => $usuario_id,
            'auth_nivel_permissao_id' => $request['nivel_permissao'],
        );
        $id = $this->Usuario_model->insert_dados('usuario_has_nivel_permissao', $dados);

        if($id){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Usuário cadastrado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao salvar o usuário. Entre em contato com o suporte.']);
        }
        return redirect()->route('usuario');
    }

    // Editar Usuário
    public function editar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Editar Usuário');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $_dados['usuario_db'] = $this->Usuario_db_model->get_all_table('usuario', array('id' => $id, 'conexao_id' => session('conexao_id')));
        if(!$_dados['usuario_db']){
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Não foi possível encontrar o usuário.']);

            return redirect()->route('usuario');
        }

        $_dados['usuario'] = $this->Usuario_model->get_all_table('usuario', array('id' => $id));
        $_dados['nivel_permissao_user'] = $this->Usuario_model->get_all_table('usuario_has_nivel_permissao', array('usuario_id' => $id));
        $_dados['nivel_permissao'] = $this->Usuario_model->get_all_table('auth_nivel_permissao');
        $_dados['pagina'] = 'usuario';
        $_dados['funcao'] = __FUNCTION__;

        return view('usuario.editar', $_dados);
    }

    // Salvar Edição de Usuário
    public function editar_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'editar', 'Editar Usuário');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $id = request()->route('id');
        $usuario = $this->Usuario_model->get_all_table('usuario', array('id' => $id));
        $usuario_nivel_permissao = $this->Usuario_model->get_all_table('usuario_has_nivel_permissao', array('usuario_id' => $id));
        $inset = 0;

        $dados = $request->all(); // Capturar todos os dados do request

        $imagem_nome = null;
        if($request->hasFile('image')){
            if(isset($dados['remover-imagem']) && $dados['remover-imagem']){
                unlink(public_path('clientes/'.session('conexao_id').'/usuario/'.$usuario[0]['imagem']));
            }

            $image = $request->file('image');
            $imagem_nome = time() . md5(date('Y-m-d H:m:s:u')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clientes/'.session('conexao_id').'/usuario'), $imagem_nome);

        }else if(isset($dados['remover-imagem']) && $dados['remover-imagem']){
            unlink(public_path('clientes/'.session('conexao_id').'/usuario/'.$usuario[0]['imagem']));

        }else{
            $imagem_nome = $usuario[0]['imagem'];
        }

        if($dados['senha']){
            if(!$dados['repetir_senha']){
                session(['tipo_mensagem' => 'danger']);
                session(['mensagem' => 'Preencha a confirmação de senha!']);

                return redirect()->route('usuario/editar/'.$id);
            }

            if($dados['senha'] != $dados['repetir_senha']){
                session(['tipo_mensagem' => 'danger']);
                session(['mensagem' => 'Senha de confirmação está diferente da senha informada.']);

                return redirect()->route('usuario');
            }

            $inset .= $this->Usuario_db_model->update_table('usuario', array('id' => $id, 'conexao_id' => session('conexao_id')), array('password' => password_hash($request['senha'], PASSWORD_BCRYPT)));
        }

        if($usuario_nivel_permissao[0]['auth_nivel_permissao_id'] != $dados['nivel_permissao']){
            $inset .= $this->Usuario_model->update_table('usuario_has_nivel_permissao', array('usuario_id' => $id), array('auth_nivel_permissao_id' => $dados['nivel_permissao']));
        }

        $dados = array(
            'nome' => $dados['nome'],
            'imagem' => $imagem_nome,
            'atualizar_senha' => (isset($dados['solicitar_redefinicao']) ? $dados['solicitar_redefinicao'] : null),
        );

        $inset .= $this->Usuario_model->update_table('usuario', array('id' => $id), $dados);

        if($inset){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Usuário atualizado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao atualizar o usuário. Entre em contato com o suporte!']);
        }
        
        return redirect()->route('usuario');
    }

    // Remover Usuário
    public function remover(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Remover Usuário');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        var_dump('expression');exit();
        // Criar validações para verificar se usuário não possui movimentações.
        $profissionais_especialidade = $this->Usuario_model->get_all_table('especialidade_has_profissional', array('especialidade_id' => $id));

        if($profissionais_especialidade){
            session(['tipo_mensagem' => 'warning']);
            session(['mensagem' => 'Não é possível remover a especialidade, pois existe movimentações ativas. Considere desativar esta especialidade.']);
        
        }else if($this->Usuario_model->delete_dados('especialidade', array('id' => $id))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Especialidade removida com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao remover o especialidade. Entre em contato com o suporte!']);
        }

        return redirect()->route('especialidade');
    }

    // Desativar Usuário
    public function desativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Desativar Usuário');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Usuario_model->update_table('usuario', array('id' => $id), array('deletado' => 1))){
            $this->Usuario_db_model->update_table('usuario', array('id' => $id, 'conexao_id' => session('conexao_id')), array('deletado' => 1));
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Usuário desativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao desativar o usuário. Entre em contato com o suporte!']);
        }

        return redirect()->route('usuario');
    }

    // Ativar Usuário
    public function ativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Ativar Usuário');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Usuario_model->update_table('usuario', array('id' => $id), array('deletado' => '0'))){
            $this->Usuario_db_model->update_table('usuario', array('id' => $id, 'conexao_id' => session('conexao_id')), array('deletado' => '0'));
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Usuário ativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao ativar o usuario. Entre em contato com o suporte!']);
        }

        return redirect()->route('usuario');
    }
}

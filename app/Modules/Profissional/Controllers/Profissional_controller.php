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

        $_dados['registros'] = $this->Profissional_model->get_all_profissional();
        $_dados['especialidades'] = $this->Profissional_model->get_all_table('especialidade', array('deletado' => '0'));
        $_dados['horarios_prof'] = $this->Profissional_model->get_all_table('profissional_horario');

        $_dados['adicionar_usuarios'] = $adicionar_usuarios;
        $_dados['pagina'] = 'profissional';

        return view('profissional.index', $_dados);
    }

    //Filtrar Profissional
    public function filtrar(Request $request){
        $request->all();
        session(['filtro_profissional_nome' => $request->nome]);
        session(['filtro_profissional_especialidade' => $request->especialidade]);

        return redirect()->route('profissional');
    }

    //Limpar Filtro
    public function limpar_filtro(){
        session()->forget('filtro_profissional_nome');
        session()->forget('filtro_profissional_especialidade');
        return redirect()->route('profissional');
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
            'telefone_principal' => $request['telefone_principal'],
            'telefone_secundario' => $request['telefone_secundario'],
            'cpf' => $request['cpf'],
            'cnpj' => $request['cnpj'],
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

    // Editar Profissional
    public function editar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Editar Profissional');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $_dados['registros'] = $this->Profissional_model->get_all_profissional($id);
        $_dados['especialidades'] = $this->Profissional_model->get_all_table('especialidade', array('deletado' => '0'));
        $_dados['usuario'] = $this->Profissional_db_model->get_all_table('usuario', array('id' => $_dados['registros'][0]['usuario_id']));
        $_dados['pagina'] = 'profissional';

        return view('profissional.editar', $_dados);
    }

    // Salvar Edição de Profissional
    public function editar_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'editar', 'Editar Profissional');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $id = request()->route('id');
        $registros = $this->Profissional_model->get_all_profissional($id);

        $imagem_nome = null;
        $dados = $request->all(); // Capturar todos os dados do request
        $update_senha = false;
        $update_imagem = false;

        if($dados['senha'] || $dados['repetir_senha']){
            if($dados['senha'] == $dados['repetir_senha']){
                $update_senha = $this->Profissional_db_model->update_table('usuario', array('id' => $id), array('password' => password_hash($request['senha'], PASSWORD_BCRYPT)));

            }else{
                session(['tipo_mensagem' => 'danger']);
                session(['mensagem' => 'As senhas informadas não coincidem.']);

                return redirect()->route('profissional');
            }
        }

        if($request->hasFile('image')){
            if(isset($dados['remover-imagem']) && $dados['remover-imagem']){
                unlink(public_path('clientes/'.session('conexao_id').'/usuario/'.$registros[0]['imagem']));
            }

            $image = $request->file('image');
            $imagem_nome = time() . md5(date('Y-m-d H:m:s:u')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clientes/'.session('conexao_id').'/usuario'), $imagem_nome);

            $update_imagem = $this->Profissional_model->update_table('usuario', array('id' => $id), array('imagem' => $imagem_nome));

        }else{
            if(isset($dados['remover-imagem'])){
                unlink(public_path('clientes/'.session('conexao_id').'/usuario/'.$registros[0]['imagem']));
                $update_imagem = $this->Profissional_model->update_table('usuario', array('id' => $id), array('imagem' => $imagem_nome));
            }
        }

        // Remover especialides para Reincerir
        $update_especialidade = false;
        $this->Profissional_model->delete_dados('especialidade_has_profissional', array('profissional_id' => $registros[0]['profissional_id']));
        foreach($dados['especialidade'] as $esp){
            $dados_esp = array(
                'especialidade_id' => $esp,
                'profissional_id' => $registros[0]['profissional_id']
            );

            $update_especialidade = $this->Profissional_model->insert_dados('especialidade_has_profissional', $dados_esp);
        }

        $update = array(
            'nome' => $dados['nome'],
            'telefone_principal' => $dados['telefone_principal'],
            'telefone_secundario' => $dados['telefone_secundario'],
            'cpf' => $dados['cpf'],
            'cnpj' => $dados['cnpj'],
        );

        if($this->Profissional_model->update_table('profissional', array('id' => $registros[0]['profissional_id']), $update) || $update_imagem || $update_senha || $update_especialidade){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Profissional atualizado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao atualizar o profissional. Entre em contato com o suporte!']);
        }
        
        return redirect()->route('profissional');
    }

    // Desativar Profissional
    public function desativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Desativar Profissional');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Profissional_model->update_table('usuario', array('id' => $id), array('deletado' => 1))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Profissional desativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao desativar o profissional. Entre em contato com o suporte!']);
        }

        return redirect()->route('profissional');
    }

    // Ativar Profissional
    public function ativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Ativar Profissional');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Profissional_model->update_table('usuario', array('id' => $id), array('deletado' => '0'))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Profissional ativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao ativar o profissional. Entre em contato com o suporte!']);
        }

        return redirect()->route('profissional');
    }

    // Horários do Profissional
    public function horario(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Configurar Horários do Profissional');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $_dados['registros'] = $this->Profissional_model->get_all_profissional($id);
        $_dados['horarios'] = $this->Profissional_model->get_all_table('profissional_horario', array('profissional_id' => $_dados['registros']['0']['profissional_id']));
        $_dados['id'] = $id;
        $_dados['pagina'] = 'profissional';
        return view('profissional.horario', $_dados);
    }

    // Salvar horários do profissional
    public function horario_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'horario', 'Configurar Horários do Profissional');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');
        $registros = $this->Profissional_model->get_all_profissional($id);
        $dados = $request->all();

        $this->Profissional_model->delete_dados('profissional_horario', array('profissional_id' => $registros[0]['profissional_id']));

        if(isset($dados['hora_inicio_segunda']) && $dados['hora_inicio_segunda']){
            foreach($dados['hora_inicio_segunda'] as $key => $segunda){
                $horarios = array(
                    'profissional_id' => $registros[0]['profissional_id'],
                    'hora_inicio' => $segunda,
                    'hora_fim' => $dados['hora_fim_segunda'][$key],
                    'dia_semana' => 'segunda',
                );

                $insert = $this->Profissional_model->insert_dados('profissional_horario', $horarios);
            }
        }

        if(isset($dados['hora_inicio_terca']) && $dados['hora_inicio_terca']){
            foreach($dados['hora_inicio_terca'] as $key => $terca){
                $horarios = array(
                    'profissional_id' => $registros[0]['profissional_id'],
                    'hora_inicio' => $terca,
                    'hora_fim' => $dados['hora_fim_terca'][$key],
                    'dia_semana' => 'terca',
                );

                $insert = $this->Profissional_model->insert_dados('profissional_horario', $horarios);
            }
        }

        if(isset($dados['hora_inicio_quarta']) && $dados['hora_inicio_quarta']){
            foreach($dados['hora_inicio_quarta'] as $key => $quarta){
                $horarios = array(
                    'profissional_id' => $registros[0]['profissional_id'],
                    'hora_inicio' => $quarta,
                    'hora_fim' => $dados['hora_fim_quarta'][$key],
                    'dia_semana' => 'quarta',
                );

                $insert = $this->Profissional_model->insert_dados('profissional_horario', $horarios);
            }
        }

        if(isset($dados['hora_inicio_quinta']) && $dados['hora_inicio_quinta']){
            foreach($dados['hora_inicio_quinta'] as $key => $quinta){
                $horarios = array(
                    'profissional_id' => $registros[0]['profissional_id'],
                    'hora_inicio' => $quinta,
                    'hora_fim' => $dados['hora_fim_quinta'][$key],
                    'dia_semana' => 'quinta',
                );

                $insert = $this->Profissional_model->insert_dados('profissional_horario', $horarios);
            }
        }

        if(isset($dados['hora_inicio_sexta']) && $dados['hora_inicio_sexta']){
            foreach($dados['hora_inicio_sexta'] as $key => $sexta){
                $horarios = array(
                    'profissional_id' => $registros[0]['profissional_id'],
                    'hora_inicio' => $sexta,
                    'hora_fim' => $dados['hora_fim_sexta'][$key],
                    'dia_semana' => 'sexta',
                );

                $insert = $this->Profissional_model->insert_dados('profissional_horario', $horarios);
            }
        }

        if(isset($dados['hora_inicio_sabado']) && $dados['hora_inicio_sabado']){
            foreach($dados['hora_inicio_sabado'] as $key => $sabado){
                $horarios = array(
                    'profissional_id' => $registros[0]['profissional_id'],
                    'hora_inicio' => $sabado,
                    'hora_fim' => $dados['hora_fim_sabado'][$key],
                    'dia_semana' => 'sabado',
                );

                $insert = $this->Profissional_model->insert_dados('profissional_horario', $horarios);
            }
        }

        if(isset($dados['hora_inicio_domingo']) && $dados['hora_inicio_domingo']){
            foreach($dados['hora_inicio_domingo'] as $key => $domingo){
                $horarios = array(
                    'profissional_id' => $registros[0]['profissional_id'],
                    'hora_inicio' => $domingo,
                    'hora_fim' => $dados['hora_fim_domingo'][$key],
                    'dia_semana' => 'domingo',
                );

                $insert = $this->Profissional_model->insert_dados('profissional_horario', $horarios);
            }
        }

        if($insert){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Horário configurado com sucesso!']);

            return redirect()->route('horario', ['id' => $id]);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao configurar Horário. Entre em contato com o suporte!']);

            return redirect()->route('horario', ['id' => $id]);
        }
    }
}

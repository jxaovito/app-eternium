<?php

namespace App\Modules\Paciente\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Paciente\Models\Paciente_model;
use App\Modules\Paciente\Models\Paciente_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Paciente_controller extends Controller{
	protected $Paciente_model;
    protected $class;

    public function __construct(){
        $this->Paciente_model = new Paciente_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Pacientes');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['registros'] = $this->Paciente_model->get_all_pacientes();
        $_dados['convenios'] = $this->Paciente_model->get_all_table('convenio', array('deletado' => '0'));

        $_dados['pagina'] = 'paciente';

        return view('paciente.index', $_dados);
    }

    //Filtrar Paciente
    public function filtrar(Request $request){
        $request->all();
        session(['filtro_paciente_nome' => $request->nome]);
        session(['filtro_paciente_telefone' => $request->telefone]);
        session(['filtro_paciente_convenio' => $request->convenio]);

        return redirect()->route('paciente');
    }

    //Limpar Filtro
    public function limpar_filtro(){
        session()->forget('filtro_paciente_nome');
        session()->forget('filtro_paciente_telefone');
        session()->forget('filtro_paciente_convenio');
        return redirect()->route('paciente');
    }

    public function novo(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Adicionar Pacientes');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['convenios'] = $this->Paciente_model->get_all_table('convenio', array('deletado' => '0'));
        $_dados['generos'] = $this->Paciente_model->get_all_table('genero');
        $_dados['pagina'] = 'paciente';

        return view('paciente.novo', $_dados);
    }

    public function novo_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'novo', 'Adicionar Pacientes');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $imagem_nome = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imagem_nome = time() . md5(date('Y-m-d H:m:s:u')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clientes/'.session('conexao_id').'/paciente'), $imagem_nome);
        }

        if($request['estado']){
            $estado = $this->Paciente_model->get_all_table('endereco_estado', array('sigla' => $request['estado']));
            if(!$estado){
                $estado_id = $this->Paciente_model->insert_dados('endereco_estado', array('sigla' => $request['estado']));
            }else{
                $estado_id = $estado[0]['id'];
            }
        }

        if($request['cidade']){
            $cidade = $this->Paciente_model->get_all_table('endereco_cidade', array('nome' => $request['cidade']));
            if(!$cidade){
                $cidade_id = $this->Paciente_model->insert_dados('endereco_cidade', array('nome' => $request['cidade'], 'endereco_estado_id' => $estado_id));
            }else{
                $cidade_id = $cidade[0]['id'];
            }
        }

        if($request['bairro']){
            $bairro = $this->Paciente_model->get_all_table('endereco_bairro', array('nome' => $request['bairro']));
            if(!$bairro){
                $bairro_id = $this->Paciente_model->insert_dados('endereco_bairro', array('nome' => $request['bairro'], 'endereco_cidade_id' => $cidade_id));
            }else{
                $bairro_id = $bairro[0]['id'];
            }
        }else{
            $bairro_id = null;
        }

        $dados = array(
            'nome' => $request['nome'],
            'data_nascimento' => ($request['data_nascimento'] ? data_para_db($request['data_nascimento']) : null),
            'genero_id' => $request['genero_id'],
            'imagem' => $imagem_nome,
            'email' => $request['email'],
            'telefone_principal' => $request['telefone_principal'],
            'telefone_secundario' => $request['telefone_secundario'],
            'cpf' => $request['cpf'],
            'cnpj' => $request['cnpj'],
            'nome_mae' => $request['nome_mae'],
            'nome_pai' => $request['nome_pai'],
            'nome_responsavel' => $request['nome_responsavel'],
            'observacoes' => $request['observacoes'],
            'convenio_id' => $request['convenio_id'],
            'matricula' => $request['matricula'],
            'data_vencimento_carteirinha' => ($request['data_vencimento_carteirinha'] ? data_para_db($request['data_vencimento_carteirinha']) : null),
            'cep' => $request['cep'],
            'rua' => $request['rua'],
            'endereco_bairro_id' => $bairro_id
        );

        $paciente_id = $this->Paciente_model->insert_dados('paciente', $dados);
        if($paciente_id){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Paciente cadastrado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao salvar o paciente. Entre em contato com o suporte.']);
        }
        return redirect()->route('paciente');
    }

    public function editar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Editar Pacientes');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $id = request()->route('id');
        $_dados['registro'] = $this->Paciente_model->get_all_pacientes($id)[0];
        $_dados['convenios'] = $this->Paciente_model->get_all_table('convenio', array('deletado' => '0'));
        $_dados['generos'] = $this->Paciente_model->get_all_table('genero');

        $_dados['pagina'] = 'paciente';
        return view('paciente.editar', $_dados);
    }

    public function editar_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'editar', 'Editar Pacientes');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $id = request()->route('id');
        $imagem_nome = $this->Paciente_model->get_all_table('paciente', array('id' => $id))[0]['imagem'];
        $dados = $request->all(); // Capturar todos os dados do request

        if($request->hasFile('image')){
            if(isset($dados['remover-imagem']) && $dados['remover-imagem']){
                unlink(public_path('clientes/'.session('conexao_id').'/paciente/'.$imagem_nome));
            }

            $image = $request->file('image');
            $imagem_nome = time() . md5(date('Y-m-d H:m:s:u')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clientes/'.session('conexao_id').'/paciente'), $imagem_nome);

        }else{
            if(isset($dados['remover-imagem'])){
                unlink(public_path('clientes/'.session('conexao_id').'/paciente/'.$imagem_nome));
                $imagem_nome = null;
            }
        }

        $request = $request->all(); // Capturar todos os dados do request

        if($request['estado']){
            $estado = $this->Paciente_model->get_all_table('endereco_estado', array('sigla' => $request['estado']));
            if(!$estado){
                $estado_id = $this->Paciente_model->insert_dados('endereco_estado', array('sigla' => $request['estado']));
            }else{
                $estado_id = $estado[0]['id'];
            }
        }

        if($request['cidade']){
            $cidade = $this->Paciente_model->get_all_table('endereco_cidade', array('nome' => $request['cidade']));
            if(!$cidade){
                $cidade_id = $this->Paciente_model->insert_dados('endereco_cidade', array('nome' => $request['cidade'], 'endereco_estado_id' => $estado_id));
            }else{
                $cidade_id = $cidade[0]['id'];
            }
        }

        if($request['bairro']){
            $bairro = $this->Paciente_model->get_all_table('endereco_bairro', array('nome' => $request['bairro']));
            if(!$bairro){
                $bairro_id = $this->Paciente_model->insert_dados('endereco_bairro', array('nome' => $request['bairro'], 'endereco_cidade_id' => $cidade_id));
            }else{
                $bairro_id = $bairro[0]['id'];
            }
        }else{
            $bairro_id = null;
        }

        $dados = array(
            'nome' => $request['nome'],
            'data_nascimento' => ($request['data_nascimento'] ? data_para_db($request['data_nascimento']) : null),
            'genero_id' => $request['genero_id'],
            'imagem' => $imagem_nome,
            'email' => $request['email'],
            'telefone_principal' => $request['telefone_principal'],
            'telefone_secundario' => $request['telefone_secundario'],
            'cpf' => $request['cpf'],
            'cnpj' => $request['cnpj'],
            'nome_mae' => $request['nome_mae'],
            'nome_pai' => $request['nome_pai'],
            'nome_responsavel' => $request['nome_responsavel'],
            'observacoes' => $request['observacoes'],
            'convenio_id' => $request['convenio_id'],
            'matricula' => $request['matricula'],
            'data_vencimento_carteirinha' => ($request['data_vencimento_carteirinha'] ? data_para_db($request['data_vencimento_carteirinha']) : ''),
            'cep' => $request['cep'],
            'rua' => $request['rua'],
            'endereco_bairro_id' => $bairro_id
        );

        if($this->Paciente_model->update_table('paciente', array('id' => $id), $dados)){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Paciente editado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro para editar o paciente. Entre em contato com o suporte.']);
        }

        return redirect()->route('paciente');
    }

    // Desativar Paciente
    public function desativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Desativar Paciente');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Paciente_model->update_table('paciente', array('id' => $id), array('deletado' => 1))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Paciente desativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao desativar o paciente. Entre em contato com o suporte!']);
        }

        return redirect()->route('paciente');
    }

    // Ativar Profissional
    public function ativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Ativar Paciente');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Paciente_model->update_table('paciente', array('id' => $id), array('deletado' => '0'))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Paciente ativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao ativar o paciente. Entre em contato com o suporte!']);
        }

        return redirect()->route('paciente');
    }

    public function visualizar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Visualizar Paciente');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $_dados['registro'] = $this->Paciente_model->get_all_pacientes($id)[0];

        $_dados['pagina'] = 'paciente';

        return view('paciente.visualizar', $_dados);
    }

    public function busca_paciente_by_nome(Request $request){
        $nome = $request->input('nome');

        $registros = $this->Paciente_model->get_all_pacientes(null, $nome);

        echo json_encode($registros);
    }

    public function busca_paciente_by_id(Request $request){
        $id = $request->input('id');
        $tratamento = $request->input('tratamento');

        $registros = $this->Paciente_model->get_all_pacientes($id)[0];

        if($tratamento){
            $registros['tratamento'] = $this->Paciente_model->get_all_tratamento_ativo($id);
        }

        echo json_encode($registros);
    }
}

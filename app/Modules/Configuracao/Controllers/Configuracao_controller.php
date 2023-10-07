<?php

namespace App\Modules\Configuracao\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Configuracao\Models\Configuracao_model;
use App\Modules\Configuracao\Models\Configuracao_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Configuracao_controller extends Controller{
	protected $Configuracao_model;
    protected $class;

    public function __construct(){
        $this->Configuracao_model = new Configuracao_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Configurações da Empresa');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['dados'] = $this->Configuracao_model->get_all_table('configuracao', array('tipo' => 'dados'));
        $_dados['dados'] = array_column($_dados['dados'], null, 'variavel');
        $_dados['sistema'] = $this->Configuracao_model->get_all_table('configuracao', array('tipo' => 'sistema'));
        $_dados['sistema'] = array_column($_dados['sistema'], null, 'variavel');
        $_dados['pagina'] = 'configuracao';

        return view('configuracao.index', $_dados);
    }

    public function salvar_dados(Request $request){
        $check_auth = checkAuthentication($this->class, 'index', 'Configurações da Empresa');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $imagem_nome = $this->Configuracao_model->get_all_table('configuracao', array('tipo' => 'dados', 'variavel' => 'logo'))[0]['valor'];
        if($request->hasFile('logo')){
            if($imagem_nome){
                unlink(public_path('clientes/'.session('conexao_id').'/img/'.$imagem_nome));
            }
            $image = $request->file('logo');
            $imagem_nome = time() . md5(date('Y-m-d H:m:s:u')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clientes/'.session('conexao_id').'/img'), $imagem_nome);
        }

        $request = $request->all();
        $dados = array();
        $dados[] = array('tipo' => 'dados', 'variavel' => 'nome_empresa', 'nome' => 'Nome da Empresa', 'valor' => $request['nome_empresa']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'cpf', 'nome' => 'CPF', 'valor' => $request['cpf']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'cnpj', 'nome' => 'CNPJ', 'valor' => $request['cnpj']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'numero_clinica1', 'nome' => 'Telefone 1 da Empressa', 'valor' => $request['numero_clinica1']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'numero_clinica2', 'nome' => 'Telefone 2 da Empresa', 'valor' => $request['numero_clinica2']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'numero_clinica3', 'nome' => 'Telefone 3 da Empresa', 'valor' => $request['numero_clinica3']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'nome_proprietario', 'nome' => 'Nome do Proprietário', 'valor' => $request['nome_proprietario']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'site', 'nome' => 'Site', 'valor' => $request['site']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'endereco', 'nome' => 'Endereço', 'valor' => $request['endereco']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'bairro', 'nome' => 'Bairro', 'valor' => $request['bairro']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'cidade', 'nome' => 'Cidade', 'valor' => $request['cidade']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'estado', 'nome' => 'Estado', 'valor' => $request['estado']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'logo', 'nome' => 'Logo', 'valor' => $imagem_nome);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'cor_logo', 'nome' => 'Cor Predominante da Logo', 'valor' => $request['cor_logo']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'cor_font', 'nome' => 'Cor para Fonte', 'valor' => $request['cor_font']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'cor_menu_topo', 'nome' => 'Cor de Fundo do Menu Superior', 'valor' => $request['cor_menu_topo']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'cor_entorno', 'nome' => 'Cor Entorno de Fundo do Menu Superior', 'valor' => $request['cor_entorno']);
        $dados[] = array('tipo' => 'dados', 'variavel' => 'cor_centro', 'nome' => 'Cor Centro de Fundo do Menu Superior', 'valor' => $request['cor_centro']);

        $this->Configuracao_model->delete_dados('configuracao', array('tipo' => 'dados'));
        foreach($dados as $key => $dado){
            $this->Configuracao_model->insert_dados('configuracao', $dado);
        }

        $config_dados = $this->Configuracao_model->get_all_table('configuracao', array('tipo' => 'dados'));
        session(['config_dados' => $config_dados]);

        session(['tipo_mensagem' => 'success']);
        session(['mensagem' => 'Configurações Atualizadas com sucesso!']);
        return redirect()->route('configuracao');
    }

    public function salvar_sistema(Request $request){
        $check_auth = checkAuthentication($this->class, 'index', 'Configurações da Empresa');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $request = $request->all();
        $dados = array();
        $dados[] = array('tipo' => 'sistema', 'variavel' => 'qtd_usuarios', 'nome' => 'Quantidade de Usuários', 'valor' => $request['qtd_usuarios']);
        $dados[] = array('tipo' => 'sistema', 'variavel' => 'publico_alvo', 'nome' => 'Nome do Público Álvo', 'valor' => $request['publico_alvo']);
        $dados[] = array('tipo' => 'sistema', 'variavel' => 'whatsapp_automatico', 'nome' => 'Lembrete de Whatsapp Autmático', 'valor' => $request['whatsapp_automatico']);

        $this->Configuracao_model->delete_dados('configuracao', array('tipo' => 'sistema'));
        foreach($dados as $key => $dado){
            $this->Configuracao_model->insert_dados('configuracao', $dado);
        }

        session(['tipo_mensagem' => 'success']);
        session(['mensagem' => 'Configurações Atualizadas com sucesso!']);
        return redirect()->route('configuracao');
    }

    public function agenda(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Configurações da Agenda');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['configuracoes_agenda'] = $this->Configuracao_model->get_all_table('agenda_configuracao', array());
        $_dados['whatsapp_automatico'] = $this->Configuracao_model->get_all_table('configuracao', array('variavel' => 'whatsapp_automatico'))[0]['valor'];
        $_dados['pagina'] = 'configuracao';

        return view('configuracao.configuracao_agenda', $_dados);
    }

    public function agenda_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'agenda', 'Configurações da Agenda');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $request = $request->all();
        unset($request['_token']);

        foreach($request as $identificador => $valor){
            $update = $this->Configuracao_model->update_table('agenda_configuracao', array('identificador' => $identificador), array('valor' => $valor));
        }

        if($update){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Configurações Atualizadas com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao Atualizar as configurações!']);
        }

        return redirect()->route('configuracao_agenda');
    }

    public function menu(Request $request){
        $tipo = $request->input('tipo');

        session(['menu' => $tipo]);
    }
}

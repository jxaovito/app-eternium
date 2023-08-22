<?php

namespace App\Modules\Especialidade\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Especialidade\Models\Especialidade_model;
use App\Modules\Especialidade\Models\Especialidade_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Especialidade_controller extends Controller{
	protected $Especialidade_model;
    protected $class;

    public function __construct(){
        $this->Especialidade_model = new Especialidade_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Especialidades');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['registros'] = $this->Especialidade_model->get_all();

        $_dados['pagina'] = 'especialidade';

        return view('especialidade.index', $_dados);
    }

    //Filtrar Especialidade
    public function filtrar(Request $request){
        $request->all();
        session(['filtro_especialidade_nome' => $request->especialidade_nome]);

        return redirect()->route('especialidade');
    }

    //Limpar Filtro
    public function limpar_filtro(){
        session()->forget('filtro_especialidade_nome');
        return redirect()->route('especialidade');
    }

    // Novo convênio
    public function novo(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Adicionar Especialidade');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'especialidade';
        return view('especialidade.novo', $_dados);
    }

    // Salvar Nova Especialidade
    public function novo_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'novo', 'Adicionar Especialidade');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $request = $request->all();
        $dados = array(
            'nome' => $request['nome'],
            'cor_fundo' => $request['cor_fundo'],
            'cor_fonte' => $request['cor_fonte'],
        );
        $id = $this->Especialidade_model->insert_dados('especialidade', $dados);

        if($id){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Especialidade cadastrada com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao salvar o especialidade. Entre em contato com o suporte.']);
        }
        return redirect()->route('especialidade');
    }

    // Editar Especialidade
    public function editar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Editar Especialidade');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $_dados['especialidade'] = $this->Especialidade_model->get_all_table('especialidade', array('id' => $id));
        $_dados['pagina'] = 'especialidade';

        return view('especialidade.editar', $_dados);
    }

    // Salvar Edição de Especialidade
    public function editar_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'editar', 'Editar Especialidade');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $id = request()->route('id');

        $imagem_nome = null;
        $dados = $request->all(); // Capturar todos os dados do request

        $dados = array(
            'nome' => $dados['nome'],
            'cor_fundo' => $dados['cor_fundo'],
            'cor_fonte' => $dados['cor_fonte'],
        );

        if($this->Especialidade_model->update_table('especialidade', array('id' => $id), $dados)){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Especialidade atualizado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao atualizar o especialidade. Entre em contato com o suporte!']);
        }
        
        return redirect()->route('especialidade');
    }

    // Remover Especialidade
    public function remover(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Remover Especialidade');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $profissionais_especialidade = $this->Especialidade_model->get_all_table('especialidade_has_profissional', array('especialidade_id' => $id));

        if($profissionais_especialidade){
            session(['tipo_mensagem' => 'warning']);
            session(['mensagem' => 'Não é possível remover a especialidade, pois existe movimentações ativas. Considere desativar esta especialidade.']);
        
        }else if($this->Especialidade_model->delete_dados('especialidade', array('id' => $id))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Especialidade removida com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao remover o especialidade. Entre em contato com o suporte!']);
        }

        return redirect()->route('especialidade');
    }

    // Desativar Especialidade
    public function desativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Desativar Especialidade');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Especialidade_model->update_table('especialidade', array('id' => $id), array('deletado' => 1))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Especialidade desativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao desativar o especialidade. Entre em contato com o suporte!']);
        }

        return redirect()->route('especialidade');
    }

    // Ativar Especialidade
    public function ativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Ativar Especialidade');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Especialidade_model->update_table('especialidade', array('id' => $id), array('deletado' => '0'))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Especialidade ativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao ativar o especialidade. Entre em contato com o suporte!']);
        }

        return redirect()->route('especialidade');
    }

    public function get_all_especialidade(){
        $registros = $this->Especialidade_model->get_all_table('especialidade', array('deletado' => '0'));

        echo json_encode($registros);
    }
}

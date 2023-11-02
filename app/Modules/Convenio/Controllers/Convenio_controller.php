<?php

namespace App\Modules\Convenio\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Convenio\Models\Convenio_model;
use App\Modules\Convenio\Models\Convenio_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Convenio_controller extends Controller{
	protected $Convenio_model;
    protected $class;

    public function __construct(){
        $this->Convenio_model = new Convenio_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Convenios');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['registros'] = $this->Convenio_model->get_all();

        $_dados['pagina'] = 'convenio';
        $_dados['funcao'] = __FUNCTION__;

        return view('convenio.index', $_dados);
    }

    //Filtrar Convenio
    public function filtrar(Request $request){
        $request->all();
        session(['filtro_convenio_nome' => $request->convenio_nome]);

        return redirect()->route('convenio');
    }

    //Limpar Filtro
    public function limpar_filtro(){
        session()->forget('filtro_convenio_nome');
        return redirect()->route('convenio');
    }

    // Novo convênio
    public function novo(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Adicionar Convênio');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'convenio';
        $_dados['funcao'] = __FUNCTION__;
        return view('convenio.novo', $_dados);
    }

    // Salvar Novo convênio
    public function novo_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'novo', 'Adicionar Convênio');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $imagem_nome = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imagem_nome = time() . md5(date('Y-m-d H:m:s:u')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clientes/'.session('conexao_id').'/convenio'), $imagem_nome);
        }

        $request = $request->all();
        $id = $this->Convenio_model->insert_dados('convenio', array('nome' => $request['nome'], 'cnpj' => $request['cnpj'], 'imagem' => $imagem_nome));

        if($id){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Convênio cadastrado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao salvar o convênio. Entre em contato com o suporte.']);
        }
        return redirect()->route('convenio');
    }

    // Editar Convênio
    public function editar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Editar Convênio');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $_dados['convenio'] = $this->Convenio_model->get_all_table('convenio', array('id' => $id));
        $_dados['pagina'] = 'convenio';
        $_dados['funcao'] = __FUNCTION__;

        return view('convenio.editar', $_dados);
    }

    // Salvar Edição de convênio
    public function editar_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'editar', 'Editar Convênio');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $id = request()->route('id');
        $convenio = $this->Convenio_model->get_all_table('convenio', array('id' => $id))[0];

        $imagem_nome = null;
        $dados = $request->all(); // Capturar todos os dados do request

        if($request->hasFile('image')){
            if(isset($dados['remover-imagem']) && $dados['remover-imagem']){
                unlink(public_path('clientes/'.session('conexao_id').'/convenio/'.$convenio['imagem']));
            }

            $image = $request->file('image');
            $imagem_nome = time() . md5(date('Y-m-d H:m:s:u')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('clientes/'.session('conexao_id').'/convenio'), $imagem_nome);

        }else{
            if(isset($dados['remover-imagem'])){
                unlink(public_path('clientes/'.session('conexao_id').'/convenio/'.$convenio['imagem']));
            }
        }

        if($this->Convenio_model->update_table('convenio', array('id' => $id), array('nome' => $dados['nome'], 'cnpj' => $dados['cnpj'], 'imagem' => $imagem_nome))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Convênio atualizado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao atualizar o convênio. Entre em contato com o suporte!']);
        }
        
        return redirect()->route('convenio');
    }

    // Remover convênio
    public function remover(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Remover Convênio');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');
        $convenio = $this->Convenio_model->get_all_table('convenio', array('id' => $id));

        if($this->Convenio_model->get_all_table('paciente', array('convenio_id' => $id))){
            session(['tipo_mensagem' => 'warning']);
            session(['mensagem' => 'Não é possível remover o convênio, pois existe movimentações ativas. Considere desativar este convênio.']);
        
        }else if($this->Convenio_model->delete_dados('convenio', array('id' => $id))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Convênio removido com sucesso!']);

            if($convenio[0]['imagem']){
                unlink(public_path('clientes/'.session('conexao_id').'/convenio/'.$convenio[0]['imagem']));
            }

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao remover o convênio. Entre em contato com o suporte!']);
        }

        return redirect()->route('convenio');
    }

    // Desativar Convênio
    public function desativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Desativar Convênio');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Convenio_model->update_table('convenio', array('id' => $id), array('deletado' => 1))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Convênio desativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao desativar o convênio. Entre em contato com o suporte!']);
        }

        return redirect()->route('convenio');
    }

    // Ativar Convênio
    public function ativar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Ativar Convênio');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        if($this->Convenio_model->update_table('convenio', array('id' => $id), array('deletado' => '0'))){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Convênio ativado com sucesso!']);

        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao ativar o convênio. Entre em contato com o suporte!']);
        }

        return redirect()->route('convenio');
    }
}
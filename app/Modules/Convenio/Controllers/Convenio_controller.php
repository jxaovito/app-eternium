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

        $_dados['registros'] = $this->Convenio_model->get_all_table('convenio', array('deletado' => '0'));

        $_dados['pagina'] = 'convenio';

        return view('convenio.index', $_dados);
    }

    public function novo(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Adicionar Convênio');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'convenio';
        return view('convenio.novo', $_dados);
    }

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

    public function editar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Editar Convênio');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $_dados['convenio'] = $this->Convenio_model->get_all_table('convenio', array('id' => $id));
        $_dados['pagina'] = 'convenio';

        return view('convenio.editar', $_dados);
    }

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
            if($dados['remover-imagem']){
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
}

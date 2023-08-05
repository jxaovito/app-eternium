<?php

namespace App\Modules\Permissao\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Permissao\Models\Permissao_model;
use App\Modules\Permissao\Models\Permissao_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Permissao_controller extends Controller{
	protected $Permissao_model;
    protected $Permissao_db_model;
    protected $class;

    public function __construct(){
        $this->Permissao_model = new Permissao_model();
        $this->Permissao_db_model = new Permissao_db_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Níveis de Permissões');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['nivel_permissao'] = $this->Permissao_model->get_all_table('auth_nivel_permissao');
        $_dados['pagina'] = 'permissoes';

        return view('permissao.index', $_dados);
    }

    public function novo(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Adicionar Nível de Permissão');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'permissoes';
        return view('permissao.novo', $_dados);
    }

    public function editar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Editar Níveis de Permissões');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $_dados['permissoes'] = $this->Permissao_model->get_permissoes($id);
        $_dados['nivel_permissao_id'] = $id;
        $_dados['nivel_permissao'] = $this->Permissao_model->get_all_table('auth_nivel_permissao', array('id' => $id));
        $_dados['pagina'] = 'permissoes';

        return view('permissao.editar', $_dados);
    }

    public function salvar_edicao(Request $request){
        $check_auth = checkAuthentication($this->class, 'editar', 'Editar Níveis de Permissões');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $request = $request->all(); // Capturar todos os dados do request
        $nivel_permissao_id = $request['nivel_permissao_id'];
        $this->Permissao_model->delete_dados('auth_modulo_has_nivel_permissao', array('auth_nivel_permissao_id' => $nivel_permissao_id));

        foreach($request as $key => $req){
            if($key != '_token' && $key != 'nivel_permissao_id'){
                $modulo = $key;
                foreach($req as $funcao => $val){
                    $modulo_db = $this->Permissao_model->get_all_table('auth_modulo', array('modulo' => $modulo, 'funcao' => $funcao));
                    $this->Permissao_model->insert_dados('auth_modulo_has_nivel_permissao', array('auth_nivel_permissao_id' => $nivel_permissao_id, 'auth_modulo_id' => $modulo_db[0]['id']));
                }
            }
        }

        session(['tipo_mensagem' => 'success']);
        session(['mensagem' => 'Nível de Permissão alterado com Sucesso! É necessário realizar logout para que as permissões sejam atualizadas.']);
        return redirect()->route('permissao');
    }
}

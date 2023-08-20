<?php

namespace App\Modules\Procedimento\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Procedimento\Models\Procedimento_model;
use App\Modules\Procedimento\Models\Procedimento_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Procedimento_controller extends Controller{
	protected $Procedimento_model;
    protected $class;

    public function __construct(){
        $this->Procedimento_model = new Procedimento_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Procedimentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['registros'] = $this->Procedimento_model->get_all();
        $_dados['pagina'] = 'procedimento';

        return view('procedimento.index', $_dados);
    }

    //Filtrar Convenio
    public function filtrar(Request $request){
        $request->all();
        session(['filtro_procedimento_nome' => $request->procedimento_nome]);

        return redirect()->route('procedimento');
    }

    //Limpar Filtro
    public function limpar_filtro(){
        session()->forget('filtro_procedimento_nome');
        return redirect()->route('procedimento');
    }

    public function editar(){
        $check_auth = checkAuthentication($this->class, 'index', 'Procedimentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $id = request()->route('id');
        $_dados['convenio'] = $this->Procedimento_model->get_all_table('convenio', array('id' => $id))[0];
        $_dados['procedimentos'] = $this->Procedimento_model->get_all_table('convenio_procedimento', array('convenio_id' => $id, 'deletado' => '0'));

        $_dados['pagina'] = 'procedimento';

        return view('procedimento.editar', $_dados);
    }
}

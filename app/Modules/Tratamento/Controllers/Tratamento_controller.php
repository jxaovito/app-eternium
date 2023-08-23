<?php

namespace App\Modules\Tratamento\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Tratamento\Models\Tratamento_model;
use App\Modules\Tratamento\Models\Tratamento_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Tratamento_controller extends Controller{
	protected $Tratamento_model;
    protected $class;

    public function __construct(){
        $this->Tratamento_model = new Tratamento_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Tratamentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'tratamento';

        return view('tratamento.index', $_dados);
    }

    public function novo(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Adicionar Tratamentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['convenios'] = $this->Tratamento_model->get_all_table('convenio', array('deletado' => '0'));
        $_dados['forma_pagamento'] = $this->Tratamento_model->get_all_table('fin_forma_pagamento', array('deletado' => '0'), 'nome');
        $_dados['parcelas_pagamento'] = $this->Tratamento_model->get_all_table('fin_parcelas_pagamento', null, 'parcela');
        $_dados['contas'] = $this->Tratamento_model->get_all_table('fin_conta', null, 'nome');
        $_dados['categorias'] = $this->Tratamento_model->get_all_table('fin_categoria', array('deletado' => '0'), 'nome');
        $_dados['especialidades'] = $this->Tratamento_model->get_all_table('especialidade', array('deletado' => '0'));
        $_dados['profissionais'] = $this->Tratamento_model->get_al_profissional();
        $_dados['pagina'] = 'tratamento';

        return view('tratamento.novo', $_dados);
    }
}

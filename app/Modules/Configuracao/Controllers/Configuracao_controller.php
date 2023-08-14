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

        $_dados['pagina'] = 'configuracao';

        return view('configuracao.index', $_dados);
    }
}

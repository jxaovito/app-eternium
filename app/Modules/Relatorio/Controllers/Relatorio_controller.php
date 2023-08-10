<?php

namespace App\Modules\Relatorio\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Relatorio\Models\Relatorio_model;
use App\Modules\Relatorio\Models\Relatorio_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Relatorio_controller extends Controller{
	protected $Relatorio_model;
    protected $class;

    public function __construct(){
        $this->Relatorio_model = new Relatorio_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Relatórios');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'relatorio';

        return view('relatorio.index', $_dados);
    }
}

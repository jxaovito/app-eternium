<?php

namespace App\Modules\Financeiro\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Financeiro\Models\Financeiro_model;
use App\Modules\Financeiro\Models\Financeiro_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Financeiro_controller extends Controller{
	protected $Financeiro_model;
    protected $class;

    public function __construct(){
        $this->Financeiro_model = new Financeiro_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Financeiro');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'financeiro';

        return view('financeiro.index', $_dados);
    }
}

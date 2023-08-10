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

        $_dados['pagina'] = 'especialidade';

        return view('especialidade.index', $_dados);
    }
}

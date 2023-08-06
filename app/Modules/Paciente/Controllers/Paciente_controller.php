<?php

namespace App\Modules\Paciente\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Paciente\Models\Paciente_model;
use App\Modules\Paciente\Models\Paciente_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Paciente_controller extends Controller{
	protected $Paciente_model;
    protected $class;

    public function __construct(){
        $this->Paciente_model = new Paciente_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Pacientes');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'paciente';

        return view('paciente.index', $_dados);
    }
}

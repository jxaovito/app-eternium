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

        $_dados['pagina'] = 'procedimento';

        return view('procedimento.index', $_dados);
    }
}

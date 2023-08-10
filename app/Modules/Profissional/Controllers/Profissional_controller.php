<?php

namespace App\Modules\Profissional\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Profissional\Models\Profissional_model;
use App\Modules\Profissional\Models\Profissional_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Profissional_controller extends Controller{
	protected $Profissional_model;
    protected $class;

    public function __construct(){
        $this->Profissional_model = new Profissional_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Profissionais');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'profissional';

        return view('profissional.index', $_dados);
    }
}

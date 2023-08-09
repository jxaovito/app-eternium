<?php

namespace App\Modules\Convenio\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Convenio\Models\Convenio_model;
use App\Modules\Convenio\Models\Convenio_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Convenio_controller extends Controller{
	protected $Convenio_model;
    protected $class;

    public function __construct(){
        $this->Convenio_model = new Convenio_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Convenios');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'convenio';

        return view('convenio.index', $_dados);
    }
}

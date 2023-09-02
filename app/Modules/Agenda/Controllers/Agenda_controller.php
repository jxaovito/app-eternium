<?php

namespace App\Modules\Agenda\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Agenda\Models\Agenda_model;
use App\Modules\Agenda\Models\Agenda_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Agenda_controller extends Controller{
	protected $Agenda_model;
    protected $Agenda_db_model;
    protected $class;

    public function __construct(){
        $this->Agenda_model = new Agenda_model();
        $this->Agenda_db_model = new Agenda_db_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Agenda');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $profissional_id = request()->route('id');
        $profissionais = $this->Agenda_model->get_profissionais();
        foreach($profissionais as $key => $prof){
            $profissionais[$key]['especialidade'] = $this->Agenda_model->get_especialidade_by_profissional_id($prof['id']);
        }
        $_dados['profissionais'] = $profissionais;
        $_dados['profissional_id'] = ($profissional_id ? $profissional_id : $profissionais[0]['id']);
        $_dados['especialidades'] = $this->Agenda_model->get_all_table('especialidade', array('deletado' => '0'));
        $_dados['convenios'] = $this->Agenda_model->get_all_table('convenio', array('deletado' => '0'));
        $_dados['pagina'] = 'agenda';

        return view('agenda.index', $_dados);
    }
}

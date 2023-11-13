<?php

namespace App\Modules\Prontuario\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Prontuario\Models\Prontuario_model;
use App\Modules\Prontuario\Models\Prontuario_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Prontuario_controller extends Controller{
	protected $Prontuario_model;
    protected $Prontuario_db_model;
    protected $class;

    public function __construct(){
        $this->Prontuario_model = new Prontuario_model();
        $this->Prontuario_db_model = new Prontuario_db_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Prontuarios');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['pagina'] = 'prontuario';
        $_dados['funcao'] = __FUNCTION__;

        return view('prontuario.index', $_dados);
    }

    public function atender($paciente_id, $agenda_id = 0, $submenu = 1){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Visualizar Prontuário');
        $check_auth_agenda = checkAuthentication('agenda', 'atender_agendamento', 'Atender Agendamento');
        if(!$check_auth && !$check_auth_agenda){return redirect('/');}else if($check_auth === 'sp' && $check_auth_agenda === 'sp'){return redirect('/permissao_negada');}

        $paciente = $this->Prontuario_model->get_table('paciente', array('id' => $paciente_id));

        if(!$paciente){
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Paciente não encontrado!']);
            return redirect()->route('prontuario');

        }else{
            $paciente['idade'] = (isset($registro['data_nascimento']) ? Carbon::parse($registro['data_nascimento'])->diffInYears(Carbon::now()) : 'Idade não cadastrada');
            $paciente['data_nascimento'] = (isset($registro['data_nascimento']) ? data($registro['data_nascimento']) : '');
        }

        $convenio = $this->Prontuario_model->get_table('convenio', array('id' => $paciente['convenio_id']));
        $agendamentos_realizados = $this->Prontuario_model->get_all_agendamentos($paciente_id);

        $agendamento = array();
        $tratamento = array();
        if($agenda_id){
            $agendamento = $this->Prontuario_model->get_agendamento($agenda_id)[0];
            $tratamento = $this->Prontuario_model->get_tratamento_visualizar($agendamento['tratamento_id']);

            if($tratamento){
                $tratamento = $tratamento[0];
                $tratamento['procedimentos'] = $this->Prontuario_model->get_procedimentos_tratamento($tratamento['tratamento_id']);
            }

        }else{
            $agendamento['id'] = null;
            $agendamento['sessoes_contratada'] = 1;
            $agendamento['sessoes_consumida'] = 1;
        }

        // Criação do Prontuário ou Get caso já tenha sido criado
        $prontuario = $this->Prontuario_model->get_table('prontuario', array('paciente_id' => $paciente_id, 'status' => null));
        if($prontuario){
            if(data_para_db(data($prontuario['data_hora'])) != date('Y-m-d')){
               $this->Prontuario_model->update_table('prontuario', array('id' => $prontuario['id']), array('data_hora' => date('Y-m-d H:i:s')));
               $prontuario['data_hora'] = date('Y-m-d H:i:s');
            }
        
        }else{
            $prontuario = array(
                'data_hora' => date('Y-m-d H:i:s'),
                'paciente_id' => $paciente_id,
                'profissional_id' => session('profissional_id'),
                'agenda_id' => ($agenda_id ? $agenda_id : null),
                'status' => null,
                'ip' => null,
            );

            $prontuario['id'] = $this->Prontuario_model->insert_dados('prontuario', $prontuario);
        }

        $historico_prontuarios = $this->Prontuario_model->get_prontuarios();

        $_dados['agenda_id'] = $agenda_id;
        $_dados['paciente_id'] = $paciente_id;
        $_dados['submenu'] = $submenu;
        $_dados['paciente'] = $paciente;
        $_dados['convenio'] = $convenio;
        $_dados['agendamento'] = $agendamento;
        $_dados['tratamento'] = $tratamento;
        $_dados['prontuario'] = $prontuario;
        $_dados['historico_prontuarios'] = $historico_prontuarios;
        $_dados['agendamentos_realizados'] = $agendamentos_realizados;
        $_dados['pagina'] = 'prontuario';
        $_dados['funcao'] = __FUNCTION__;

        return view('prontuario.atender', $_dados);
    }
}
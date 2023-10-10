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

        $_dados['visualizacao_agenda'] = $this->Agenda_model->get_all_table('agenda_configuracao', array('identificador' => 'visualizacao_agenda'))[0]['valor'];
        if($_dados['visualizacao_agenda'] == 'day'){
            $_dados['data_inicio_agenda'] = date('Y-m-d');
            $_dados['data_fim_agenda'] = date('Y-m-d');

        }else if($_dados['visualizacao_agenda'] == 'week'){
            $hoje = new \DateTime();
            $primeiro_dia_semana = 1;
            $dia_semana_atual = $hoje->format('w');
            $dias_para_inicio_semana = ($dia_semana_atual - $primeiro_dia_semana + 7) % 7;

            // Calcula a data de início da semana
            $inicio_semana = clone $hoje;
            $intervalo = new \DateInterval('P' . $dias_para_inicio_semana . 'D');
            $inicio_semana->sub($intervalo);

            // Calcula a data de fim da semana (7 dias após o início)
            $fim_semana = clone $inicio_semana;
            $intervalo = new \DateInterval('P6D');
            $fim_semana->add($intervalo);

            // Formata as datas no formato desejado (por exemplo, Y-m-d)
            $_dados['data_inicio_agenda'] = $inicio_semana->format('Y-m-d');
            $_dados['data_fim_agenda'] = $fim_semana->format('Y-m-d');

        }else if($_dados['visualizacao_agenda'] == 'month'){
            $hoje = new \DateTime();
            $primeiro_dia_semana = 1;
            $dia_semana_atual = $hoje->format('w');
            $dias_para_inicio_semana = ($dia_semana_atual - $primeiro_dia_semana + 7) % 7;

            // Calcula a data de início da semana
            $inicio_semana = clone $hoje;
            $intervalo = new \DateInterval('P' . $dias_para_inicio_semana . 'D');
            $inicio_semana->sub($intervalo);

            // Calcula a data de fim da semana (7 dias após o início)
            $fim_semana = clone $inicio_semana;
            $intervalo = new \DateInterval('P6D');
            $fim_semana->add($intervalo);

            // Calcula o primeiro dia do mês atual e ajusta para subtrair 7 dias
            $primeiro_dia_mes = clone $hoje;
            $primeiro_dia_mes->modify('first day of this month');
            $primeiro_dia_mes->sub(new \DateInterval('P7D'));
            $_dados['data_inicio_agenda'] = $primeiro_dia_mes->format('Y-m-d');

            // Calcula o último dia do mês atual e ajusta para adicionar 7 dias
            $ultimo_dia_mes = clone $hoje;
            $ultimo_dia_mes->modify('last day of this month');
            $ultimo_dia_mes->add(new \DateInterval('P7D'));

            $_dados['data_fim_agenda'] = $ultimo_dia_mes->format('Y-m-d');
            
        }

        /** ---- Configuraç~ode datas para pegar o MES ---- */
        // Define o início do mês corrente e subtrai 7 dias
        $data_atual = Carbon::now();
        $data_mes_inicio = $data_atual->startOfMonth()->subDays(7);

        // Define o último dia do mês corrente e soma 14 dias
        $data_atual = Carbon::now();
        $data_mes_fim = $data_atual->endOfMonth()->addDays(14);

        // Atribui os valores às variáveis
        $_dados['data_inicio_mes'] = $data_mes_inicio->toDateString();
        $_dados['data_fim_mes'] = $data_mes_fim->toDateString();
        /** ---- Configuraç~ode datas para pegar o MES ---- */

        /** ---- Configuraç~ode datas para pegar o SEMANA ---- */
        // Define o início do mês corrente e subtrai 7 dias
        $data_atual = Carbon::now();
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);

        // Atribui os valores às variáveis
        $_dados['data_inicio_semana'] = $data_atual->startOfWeek()->toDateString();
        $_dados['data_fim_semana'] = $data_atual->endOfWeek()->toDateString();
        /** ---- Configuraç~ode datas para pegar o SEMANA ---- */



        // Profissional da agenda atual
        $_dados['profissional_id'] = ($profissional_id ? $profissional_id : $profissionais[0]['id']);
        $_dados['profissional_nome'] = $this->Agenda_model->get_all_table('profissional', array('id' => $_dados['profissional_id']))[0]['nome'];

        // Permissões/Configurações
        $_dados['whatsapp_automatico'] = $this->Agenda_model->get_all_table('configuracao', array('variavel' => 'whatsapp_automatico'))[0]['valor'];
        $_dados['envio_lembrete_para_todos'] = $this->Agenda_model->get_all_table('agenda_configuracao', array('identificador' => 'envio_lembrete_para_todos'))[0]['valor'];

        $_dados['profissionais'] = $profissionais;
        $_dados['especialidades'] = $this->Agenda_model->get_all_table('especialidade', array('deletado' => '0'));
        $_dados['convenios'] = $this->Agenda_model->get_all_table('convenio', array('deletado' => '0'));

        // Opções para cadastro de Novo Tratamento
        $_dados['forma_pagamento'] = $this->Agenda_model->get_all_table('fin_forma_pagamento', array('deletado' => '0'), 'nome');
        $_dados['parcelas_pagamento'] = $this->Agenda_model->get_all_table('fin_parcelas_pagamento', null, 'parcela');
        $_dados['contas'] = $this->Agenda_model->get_all_table('fin_conta', null, 'nome');
        $_dados['categorias'] = $this->Agenda_model->get_all_table('fin_categoria', array('deletado' => '0'), 'nome');
        
        $_dados['pagina'] = 'agenda';

        return view('agenda.index', $_dados);
    }

    public function criar_agendamento(Request $request){
        $dados = $request->input('dados');
        $profissional_id = $request->input('profissional_id');

        $tratamento = $this->Agenda_model->get_all_table('tratamento', array('id' => $dados['tratamento_id']))[0];

        $data_inicio = date_format(date_create_from_format('d/m/Y', $dados['data_inicio']), 'Y-m-d');
        $data_fim = date_format(date_create_from_format('d/m/Y', $dados['data_fim']), 'Y-m-d');

        $dados_agendamento = array(
            'data_inicio' => $data_inicio,
            'data_fim' => $data_fim,
            'hora_inicio' => $dados['hora_inicio'].':00',
            'hora_fim' => $dados['hora_fim'].':00',
            'tratamento_id' => $dados['tratamento_id'],
            'agenda_tipo_agendamento_id' => $dados['tipo-agendamento'],
            'profissional_id' => $profissional_id,
            'sessao' => null,
            'observacoes' => $dados['observacoes'],
            'whatsapp' => (isset($dados['whatsapp']) && $dados['whatsapp'] ? $dados['whatsapp'] : null),
        );

        $agenda_id = $this->Agenda_model->insert_dados('agenda', $dados_agendamento);

        $this->reordenar_sessoes($dados['tratamento_id']);

        echo json_encode($agenda_id);
    }

    public function atualizar_agenda(Request $request){
        $data_inicio_agenda = $request->input('data_inicio_agenda');
        $data_fim_agenda = $request->input('data_fim_agenda');
        $profissional_id = $request->input('profissional_id');

        $agendamentos = $this->Agenda_model->get_agendamentos($data_inicio_agenda, $data_fim_agenda, $profissional_id);

        echo json_encode($agendamentos);
    }

    public function busca_agendamento(Request $request){
        $agenda_id = $request->input('agenda_id');

        $agendamento = $this->Agenda_model->get_agendamento($agenda_id);

        echo json_encode($agendamento);
    }

    // Remover Agendamento
    public function remover_agendamento(Request $request){
        $agenda_id = $request->input('agenda_id');
        $tratamento_id = $request->input('tratamento_id');

        $this->reordenar_sessoes($tratamento_id);

        $this->Agenda_model->delete_dados('agenda', array('id' => $agenda_id));

        echo json_encode(true);
    }

    private function reordenar_sessoes($tratamento_id){
        $agendamentos = $this->Agenda_model->get_agendamentos_reordenar($tratamento_id);

        if($agendamentos){
            $sessao = 1;
            foreach($agendamentos as $key => $agendamento){
                if($agendamento['sessoes_contratada'] < $sessao){
                    $this->Agenda_model->update_table('agenda', array('id' => $agendamento['id']), array('sessao' => null, 'reserva' => 's'));
                }else{
                    $this->Agenda_model->update_table('agenda', array('id' => $agendamento['id']), array('sessao' => $sessao, 'reserva' => null));
                }
                $sessao++;
            }
        }else{
            $this->Agenda_model->update_table('agenda', array('tratamento_id' => $tratamento_id), array('sessao' => 1, 'reserva' => null));
        }
    }

    // Atualizar Agendamento
    public function atualizar_agendamento(Request $request){
        $agenda_id = $request->input('agenda_id');
        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');
        $hora_inicio = $request->input('hora_inicio');
        $hora_fim = $request->input('hora_fim');
        $profissional = $request->input('profissional_id');
        $observacoes = $request->input('observacoes');

        $agendamento = $this->Agenda_model->get_all_table('agenda', array('id' => $agenda_id));

        $dados = array(
            'data_inicio' => ($data_inicio ? $data_inicio : $agendamento[0]['data_inicio']),
            'data_fim' => ($data_fim ? $data_fim : $agendamento[0]['data_fim']),
            'hora_inicio' => ($hora_inicio ? $hora_inicio : $agendamento[0]['hora_inicio']),
            'hora_fim' => ($hora_fim ? $hora_fim : $agendamento[0]['hora_fim']),
            'profissional_id' => ($profissional ? $profissional : $agendamento[0]['profissional_id']),
            'observacoes' => ($observacoes ? $observacoes : $agendamento[0]['observacoes']),
        );

        $this->Agenda_model->update_table('agenda', array('id' => $agenda_id), $dados);

        $this->reordenar_sessoes($agendamento[0]['tratamento_id']);

        echo json_encode(true);
    }
}

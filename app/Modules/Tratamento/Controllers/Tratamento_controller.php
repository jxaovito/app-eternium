<?php

namespace App\Modules\Tratamento\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Tratamento\Models\Tratamento_model;
use App\Modules\Tratamento\Models\Tratamento_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Tratamento_controller extends Controller{
	protected $Tratamento_model;
    protected $class;

    public function __construct(){
        $this->Tratamento_model = new Tratamento_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Tratamentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['registros'] = $this->Tratamento_model->get_all_tratamentos();
        $_dados['convenio'] = $this->Tratamento_model->get_all_table('convenio', array('deletado' => '0'));
        $_dados['profissional'] = $this->Tratamento_model->get_all_table('profissional');
        $_dados['especialidade'] = $this->Tratamento_model->get_all_table('especialidade', array('deletado' => '0'));
        $_dados['pagina'] = 'tratamento';

        return view('tratamento.index', $_dados);
    }

    //Filtrar Tratamento
    public function filtrar(Request $request){
        $request->all();
        session(['filtro_tratamento_paciente' => $request['paciente']]);
        session(['filtro_tratamento_profissional' => $request['profissional']]);
        session(['filtro_tratamento_convenio' => $request['convenio']]);
        session(['filtro_tratamento_especialidade' => $request['especialidade']]);

        return redirect()->route('tratamento');
    }

    //Limpar Filtro
    public function limpar_filtro(){
        session()->forget('filtro_tratamento_paciente');
        session()->forget('filtro_tratamento_profissional');
        session()->forget('filtro_tratamento_convenio');
        session()->forget('filtro_tratamento_especialidade');

        return redirect()->route('tratamento');
    }

    public function novo(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Adicionar Tratamentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['convenios'] = $this->Tratamento_model->get_all_table('convenio', array('deletado' => '0'));
        $_dados['forma_pagamento'] = $this->Tratamento_model->get_all_table('fin_forma_pagamento', array('deletado' => '0'), 'nome');
        $_dados['parcelas_pagamento'] = $this->Tratamento_model->get_all_table('fin_parcelas_pagamento', null, 'parcela');
        $_dados['contas'] = $this->Tratamento_model->get_all_table('fin_conta', null, 'nome');
        $_dados['categorias'] = $this->Tratamento_model->get_all_table('fin_categoria', array('deletado' => '0'), 'nome');
        $_dados['especialidades'] = $this->Tratamento_model->get_all_table('especialidade', array('deletado' => '0'));
        $_dados['profissionais'] = $this->Tratamento_model->get_al_profissional();
        $_dados['pagina'] = 'tratamento';

        return view('tratamento.novo', $_dados);
    }

    public function novo_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'novo', 'Adicionar Tratamentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $request = $request->all();
        $tipo_desconto = null;
        if($request['desconto_real']){
            $tipo_desconto = '0';

        }else if($request['desconto_porcentagem']){
            $tipo_desconto = '1';
        }

        $tratamento = array(
            'data_hora' => date('Y-m-d H:i:s'),
            'paciente_id' => $request['paciente_id'],
            'profissional_id' => $request['profissional'],
            'especialidade_id' => $request['especialidade'],
            'convenio_id' => $request['convenio'],
            'usuario_id' => session('usuario_id'),
            'sessoes_contratada' => $request['total_sessoes'],
            'sessoes_consumida' => 0,
            'observacoes' => $request['observacoes_tratamento'],
            'subtotal' => str_replace(',', '.', $request['subtotal']),
            'desconto_real' => str_replace(',', '.', $request['desconto_real']),
            'desconto_porcento' => str_replace(',', '.', $request['desconto_porcentagem']),
            'tipo_desconto' => $tipo_desconto,
            'total' => str_replace(',', '.', $request['total']),
            'fin_lancamento' => (isset($request['pagamentos']) ? 's' : null),
        );

        $tratamento_id = $this->Tratamento_model->insert_dados('tratamento', $tratamento);

        foreach($request['procedimento_id'] as $key => $procedimento_id){
            $tipo_desconto = null;
            if($request['tipo_desconto'][$key] == 'real'){
                $tipo_desconto = '0';

            }else{
                $tipo_desconto = '1';
            }

            $tratamento_has_procedimento = array(
                'tratamento_id' => $tratamento_id,
                'procedimento_id' => $request['procedimento_id'][$key],
                'sessoes_contratada' => $request['sessoes_procedimento'][$key],
                'sessoes_consumida' => 0,
                'subtotal' => str_replace(',', '.', $request['valor_procedimento'][$key]) * $request['sessoes_procedimento'][$key],
                'desconto_real' => ($tipo_desconto == '0' && $request['desconto_procedimento'][$key] ? str_replace(',', '.', $request['desconto_procedimento'][$key]) : null),
                'desconto_porcento' => ($tipo_desconto == '1' && $request['desconto_procedimento'][$key] ? str_replace(',', '.', $request['desconto_procedimento'][$key]) : null),
                'tipo_desconto' => $tipo_desconto,
                'total' => str_replace(',', '.', $request['total_procedimento'][$key]),
            );

            $tratamento_has_procedimento_id = $this->Tratamento_model->insert_dados('tratamento_has_procedimento', $tratamento_has_procedimento);
        }

        $perfil_criador_tratamento = $this->Tratamento_model->get_usuario_criador_tratamento(session('usuario_id'))[0]['nome'];

        $data_vencimento = ($request['data_vencimento'] ? date_format(date_create_from_format('d/m/Y', $request['data_vencimento']), 'Y-m-d') : null);

        if(isset($request['pagamentos']) && $request['pagamentos']){
            $fin_lacamento_financeiro = array(
                'data_hora' => date('Y-m-d H:i:s'),
                'data_vencimento' => $data_vencimento,
                'interessado_paciente_id' => $request['paciente_id'],
                'interessado_profissional_id' => null,
                'interessado_usuario_id' => null,
                'criado_por' => $perfil_criador_tratamento,
                'usuario_id' => session('usuario_id'),
                'tratamento_id' => $tratamento_id,
                'agenda_id' => null,
                'fin_forma_pagamento_id' => $request['forma_pagamento'],
                'fin_parcelas_pagamento_id' => $request['parcela_pagamento'],
                'fin_categoria_id' => $request['categoria'],
                'fin_subcategoria_id' => $request['subcategoria'],
                'fin_conta_id' => $request['conta'],
            );

            $fin_lancamento_financeiro_id = $this->Tratamento_model->insert_dados('fin_lacamento_financeiro', $fin_lacamento_financeiro);

            $nome_usuario_corrente = $this->Tratamento_model->get_all_table('usuario', array('id' => session('usuario_id')))[0]['nome'];

            $fin_lacamento_financeiro_log = array(
                'tipo' => 'insert',
                'data_hora_interacao' => date('Y-m-d H:i:s'),
                'usuario_id_interacao' => session('usuario_id'),
                'nome' => $nome_usuario_corrente,
                'fin_lancamento_financeiro_id' => $fin_lancamento_financeiro_id,
                'data_hora' => date('Y-m-d H:i:s'),
                'data_vencimento' => $data_vencimento,
                'interessado_paciente_id' => $request['paciente_id'],
                'interessado_profissional_id' => null,
                'interessado_usuario_id' => null,
                'criado_por' => $perfil_criador_tratamento,
                'usuario_id' => session('usuario_id'),
                'tratamento_id' => $tratamento_id,
                'agenda_id' => null,
                'fin_forma_pagamento_id' => $request['forma_pagamento'],
                'fin_parcelas_pagamento_id' => $request['parcela_pagamento'],
                'fin_categoria_id' => $request['categoria'],
                'fin_subcategoria_id' => $request['subcategoria'],
                'fin_conta_id' => $request['conta'],
            );

            $fin_lacamento_financeiro_log_id = $this->Tratamento_model->insert_dados('fin_lacamento_financeiro_log', $fin_lacamento_financeiro_log);

            $parcela = $this->Tratamento_model->get_all_table('fin_parcelas_pagamento', array('id' => $request['parcela_pagamento']))[0]['parcela'];
            $total_por_parcela = str_replace(',', '.', $request['total']) / (int) $parcela;

            for($i=0; $i < $parcela; $i++){
                if($i > 0){
                    $dataCarbon = Carbon::createFromFormat('Y-m-d', $data_vencimento);
                    $dataCarbon->addMonth(); // Incrementa 1 mês
                    $data_vencimento = $dataCarbon->format('Y-m-d');

                    $fin_lancamento_parcela = array(
                        'fin_lancamento_financeiro_id' => $fin_lancamento_financeiro_id,
                        'data_vencimento' => $data_vencimento,
                        'valor' => $total_por_parcela,
                        'valor_restante' => $total_por_parcela,
                        'quitado' => 'n',
                    );

                    $fin_lancamento_parcela_id = $this->Tratamento_model->insert_dados('fin_lancamento_parcela', $fin_lancamento_parcela);

                }else{
                    $fin_lancamento_parcela = array(
                        'fin_lancamento_financeiro_id' => $fin_lancamento_financeiro_id,
                        'data_vencimento' => date('Y-m-d'),
                        'valor' => $total_por_parcela,
                        'valor_restante' => '0.00',
                        'quitado' => 's',
                    );

                    $fin_lancamento_parcela_id = $this->Tratamento_model->insert_dados('fin_lancamento_parcela', $fin_lancamento_parcela);

                    $fin_lancamento_parcela_pagamento = array(
                        'fin_lancamento_parcela_id' => $fin_lancamento_parcela_id,
                        'data_pagamento' => date('Y-m-d'),
                        'subtotal' => $total_por_parcela,
                        'total' => $total_por_parcela,
                    );

                    $fin_lancamento_parcela_pagamento__id = $this->Tratamento_model->insert_dados('fin_lancamento_parcela_pagamento', $fin_lancamento_parcela_pagamento);
                }
            }
        }
        
        if($tratamento_id){
            if($request['origem'] == 'agenda'){
                $tratamento['status'] = true;
                $tratamento['profissional'] = $this->Tratamento_model->get_all_table('profissional', array('id' => $tratamento['profissional_id']))[0]['nome'];
                $tratamento['especialidade'] = $this->Tratamento_model->get_all_table('especialidade', array('id' => $tratamento['especialidade_id']))[0]['nome'];

                $tratamento['retorno'] = date('d/m/Y') . ' ' . $tratamento['profissional'] . '(' . $tratamento['especialidade'] . ')' . ' - ' . $tratamento['sessoes_consumida'] . '/' . $tratamento['sessoes_contratada'];
                $tratamento['tratamento_id'] = $tratamento_id;

                echo json_encode($tratamento);

            }else{
                session(['tipo_mensagem' => 'success']);
                session(['mensagem' => 'Tratamento cadastrado com sucesso!']);
            }

        }else{
            if($request['origem'] == 'agenda'){
                $tratamento['status'] = false;
                echo json_encode($tratamento);
            
            }else{
                session(['tipo_mensagem' => 'danger']);
                session(['mensagem' => 'Houve um erro ao cadsatrar o tratamento. Entre em contato com o suporte.']);
            }
        }

        if(!$request['origem']){
            return redirect()->route('tratamento');
        }
    }

    public function get_subcategoria(Request $request){
        $categoria_id = $request->input('categoria_id');

        $registros = $this->Tratamento_model->get_all_table('fin_subcategoria', array('fin_categoria_id' => $categoria_id, 'deletado' => '0'));

        echo json_encode($registros);
    }

    public function visualizar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Visualizar Tratamento');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $registros = $this->Tratamento_model->get_tratamento_visualizar($id);

        foreach($registros as $key => $registro){
            $registros[$key]['procedimentos'] = $this->Tratamento_model->get_procedimentos_tratamento($registro['tratamento_id']);
            $registros[$key]['parcelas'] = $this->Tratamento_model->get_all_table('fin_lancamento_parcela', array('fin_lancamento_financeiro_id' => $registro['fin_lancamento_financeiro_id']));
            $registros[$key]['idade'] = (isset($registro['data_nascimento']) ? Carbon::parse($registro['data_nascimento'])->diffInYears(Carbon::now()) : 'Idade não cadastrada');
            $registros[$key]['data_nascimento'] = (isset($registro['data_nascimento']) ? date_format(date_create_from_format('Y-m-d', $registro['data_nascimento']), 'd/m/Y') : '');
        }

        $_dados['registros'] = $registros;
        $_dados['pagina'] = 'tratamento';

        return view('tratamento.visualizar', $_dados);
    }

    public function editar(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Editar Tratamento');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}
        $id = request()->route('id');

        $_dados['convenios'] = $this->Tratamento_model->get_all_table('convenio', array('deletado' => '0'));
        $_dados['forma_pagamento'] = $this->Tratamento_model->get_all_table('fin_forma_pagamento', array('deletado' => '0'), 'nome');
        $_dados['parcelas_pagamento'] = $this->Tratamento_model->get_all_table('fin_parcelas_pagamento', null, 'parcela');
        $_dados['contas'] = $this->Tratamento_model->get_all_table('fin_conta', null, 'nome');
        $_dados['categorias'] = $this->Tratamento_model->get_all_table('fin_categoria', array('deletado' => '0'), 'nome');
        $_dados['especialidades'] = $this->Tratamento_model->get_all_table('especialidade', array('deletado' => '0'));
        $_dados['profissionais'] = $this->Tratamento_model->get_al_profissional();

        $registros = $this->Tratamento_model->get_tratamento_editar($id);
        foreach($registros as $key => $registro){
            $registros[$key]['procedimentos'] = $this->Tratamento_model->get_procedimentos_tratamento($registro['id']);
            $registros[$key]['parcelas'] = $this->Tratamento_model->get_all_table('fin_lancamento_parcela', array('fin_lancamento_financeiro_id' => $registro['fin_lancamento_financeiro_id']));
        }
        
        $_dados['registros'] = $registros;
        $_dados['pagina'] = 'tratamento';

        return view('tratamento.editar', $_dados);
    }
}

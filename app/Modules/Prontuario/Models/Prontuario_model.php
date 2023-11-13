<?php
namespace App\Modules\Prontuario\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Prontuario_model extends Model {
    protected $table = 'prontuario';
    protected $connection = 'mysql_db';

    function get_all_table($table, $where = null){
        $this->setTable($table);
    
        if($where){
            return $this->where($where)->get()->toArray();
        }
    
        return $this->get()->toArray();
    }

    function get_table($table, $where){
        $this->setTable($table);
    
        if($where){
            $return = $this->where($where)->get()->toArray();
            if($return){
                return $return[0];

            }else{
                return array();
            }

        }else{
            return array();
        }
    }

    function delete_dados($table, $where){
        $this->setTable($table);
        
        return $this->where($where)->delete();
    }

    function insert_dados($table, $dados){
        $this->setTable($table);
    
        return $this->insertGetId($dados);
    }

    function update_table($table, $where, $dados){
        $this->setTable($table);
    
        return DB::table($this->table)
        ->where($where)
        ->update($dados);;
    }

    function get_agendamento($agenda_id){
        return $this->setTable('agenda as a')
                    ->select('a.id', 'a.data_inicio', 'a.data_fim', 'a.hora_inicio', 'a.hora_fim', 'a.sessao', 'a.observacoes', 'a.whatsapp', 'a.reserva', 'ata.nome AS tipo_agendamento', 'pa.id as paciente_id', 'pa.nome AS paciente', 'pa.telefone_principal', 'co.nome AS convenio', 'pro.nome AS profissional', 'pro.id as profissional_id', 't.id as tratamento_id', 't.sessoes_contratada', 't.sessoes_consumida', 'es.nome as especialidade', 'es.cor_fundo as cor_fundo_esp', 'es.cor_fonte as cor_fonte_esp', DB::raw('GROUP_CONCAT(cp.nome SEPARATOR "[|]") AS procedimentos'), DB::raw('GROUP_CONCAT(cp.id SEPARATOR ",") AS id_procedimentos'), DB::raw('GROUP_CONCAT(thp.id SEPARATOR ",") AS tratamento_has_procedimento'), DB::raw('GROUP_CONCAT(thp.sessoes_contratada SEPARATOR ",") AS sessoes_contratada_proc'), DB::raw('GROUP_CONCAT(thp.sessoes_consumida SEPARATOR ",") AS sessoes_consumida_proc'))
                    ->join('agenda_tipo_agendamento as ata', function($join){
                        $join->on('ata.id', '=', 'a.agenda_tipo_agendamento_id');
                    })
                    ->join('tratamento as t', function($join){
                        $join->on('t.id', '=', 'a.tratamento_id');
                    })
                    ->join('paciente as pa', function($join){
                        $join->on('pa.id', '=', 't.paciente_id');
                    })
                    ->join('profissional as pro', function($join){
                        $join->on('pro.id', '=', 'a.profissional_id');
                    })
                    ->join('convenio as co', function($join){
                        $join->on('co.id', '=', 't.convenio_id');
                    })
                    ->leftJoin('tratamento_has_procedimento as thp', function($join){
                        $join->on('thp.tratamento_id', '=', 't.id');
                    })
                    ->leftJoin('convenio_procedimento as cp', function($join){
                        $join->on('cp.id', '=', 'thp.procedimento_id');
                    })
                    ->leftJoin('especialidade as es', function($join){
                        $join->on('es.id', '=', 't.especialidade_id');
                    })
                    ->where('a.id', '=', $agenda_id)
                    ->groupBy('t.id')
                    ->get()
                    ->toArray();
    }

    function get_tratamento_visualizar($tratamento_id){
        return $this->setTable('tratamento as t')
                    ->select('t.id as tratamento_id', 'pro.nome AS profissional', 'pa.nome AS paciente', 'pa.imagem AS imagem_paciente', 'pa.telefone_principal', 'pa.email', 'pa.data_nascimento', 'es.nome AS especialidade', 'es.cor_fundo AS cor_fundo_esp', 'es.cor_fonte AS cor_fonte_esp', 'co.nome AS convenio', 't.data_hora', 't.sessoes_contratada', 't.sessoes_consumida', 'pa.matricula', 't.observacoes', 't.subtotal', 't.desconto_real', 't.desconto_porcento', 't.total', 't.fin_lancamento', 'flf.data_vencimento', 'fc.nome AS categoria', 'fs.nome AS subcategoria', 'ffp.nome AS forma_pagamento', 'fct.nome AS conta', 'fpp.parcela', 'flf.id as fin_lancamento_financeiro_id')
                    ->leftJoin('profissional as pro', function($join){
                        $join->on('pro.id', '=', 't.profissional_id');
                    })
                    ->leftJoin('paciente as pa', function($join){
                        $join->on('pa.id', '=', 't.paciente_id');
                    })
                    ->leftJoin('especialidade as es', function($join){
                        $join->on('es.id', '=', 't.especialidade_id');
                    })
                    ->leftJoin('convenio as co', function($join){
                        $join->on('co.id', '=', 't.convenio_id');
                    })
                    ->leftJoin('fin_lacamento_financeiro as flf', function($join){
                        $join->on('flf.tratamento_id', '=', 't.id');
                    })
                    ->leftJoin('fin_categoria as fc', function($join){
                        $join->on('fc.id', '=', 'flf.fin_categoria_id');
                    })
                    ->leftJoin('fin_subcategoria as fs', function($join){
                        $join->on('fs.fin_categoria_id', '=', 'fc.id');
                    })
                    ->leftJoin('fin_forma_pagamento as ffp', function($join){
                        $join->on('ffp.id', '=', 'flf.fin_forma_pagamento_id');
                    })
                    ->leftJoin('fin_parcelas_pagamento as fpp', function($join){
                        $join->on('fpp.id', '=', 'flf.fin_parcelas_pagamento_id');
                    })
                    ->leftJoin('fin_conta as fct', function($join){
                        $join->on('fct.id', '=', 'flf.fin_conta_id');
                    })
                    ->where('t.id', '=', $tratamento_id)
                    ->get()
                    ->toArray();
    }

    function get_procedimentos_tratamento($tratamento_id){
        return $this->setTable('tratamento_has_procedimento as thp')
                    ->select('thp.procedimento_id', 'cp.nome as procedimento', 'cp.codigo', 'cp.valor as procedimento_valor', 'thp.sessoes_contratada', 'thp.sessoes_consumida', 'thp.subtotal', 'thp.desconto_real', 'thp.desconto_porcento', 'thp.tipo_desconto', 'thp.total', 'thp.tipo_desconto')
                    ->join('convenio_procedimento as cp', function($join){
                        $join->on('cp.id', '=', 'thp.procedimento_id');
                    })
                    ->where('thp.tratamento_id', '=', $tratamento_id)
                    ->get()
                    ->toArray();
    }

    function get_all_agendamentos($paciente_id){
        return $this->setTable('agenda as a')
                    ->leftJoin('tratamento as t', 't.id', '=', 'a.tratamento_id')
                    ->where('t.paciente_id', $paciente_id)
                    ->count();
    }

    function get_prontuarios(){
        return $this->setTable('prontuario as pron')
                    ->select('pron.*', 'pro.nome as profissional')
                    ->join('profissional as pro', 'pro.id', '=', 'pron.profissional_id')
                    ->orderBy('pron.data_hora', 'desc')
                    ->get()
                    ->toArray();
    }
}
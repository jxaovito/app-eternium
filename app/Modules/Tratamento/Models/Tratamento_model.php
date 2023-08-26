<?php
namespace App\Modules\Tratamento\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tratamento_model extends Model {
    protected $table = 'tratamento';
    protected $connection = 'mysql_db';

    function get_all_tratamentos(){
    	$query = $this->setTable('tratamento as t')
    				->select('t.id as tratamento_id', 'pro.nome as profissional', 'pa.nome as paciente', 'pa.imagem as imagem_paciente', 'es.nome as especialidade', 'es.cor_fundo as cor_fundo_especialidade', 'es.cor_fonte as cor_fonte_especialidade', 'co.nome as convenio', 't.data_hora', 't.sessoes_contratada', 't.sessoes_consumida', 'pa.matricula', 'pa.telefone_principal')
    				->join('profissional as pro', function($join){
    					$join->on('pro.id', '=', 't.profissional_id');
    				})
    				->join('paciente as pa', function($join){
    					$join->on('pa.id', '=', 't.paciente_id');
    				})
    				->join('especialidade as es', function($join){
    					$join->on('es.id', '=', 't.especialidade_id');
    				})
    				->join('convenio as co', function($join){
    					$join->on('co.id', '=', 't.convenio_id');
    				})
    				->orderBy('t.data_hora', 'desc');

		if(session('filtro_tratamento_paciente')){
			$query = $query->where('pa.nome', 'like', '%' . session('filtro_tratamento_paciente') . '%');
		}

		if(session('filtro_tratamento_profissional')){
			$query = $query->where('pro.id', '=', session('filtro_tratamento_profissional'));
		}

		if(session('filtro_tratamento_convenio')){
			$query = $query->where('co.id', '=', session('filtro_tratamento_convenio'));
		}

		if(session('filtro_tratamento_especialidade')){
			$query = $query->where('es.id', '=', session('filtro_tratamento_especialidade'));
		}

		return $query->paginate(20)->toArray();
    }

    function get_tratamento_visualizar($tratamento_id){
    	return $this->setTable('tratamento as t')
    				->select('t.id as tratamento_id', 'pro.nome AS profissional', 'pa.nome AS paciente', 'pa.imagem AS imagem_paciente', 'es.nome AS especialidade', 'es.cor_fundo AS cor_fundo_esp', 'es.cor_fonte AS cor_fonte_esp', 'co.nome AS convenio', 't.data_hora', 't.sessoes_contratada', 't.sessoes_consumida', 'pa.matricula', 't.observacoes', 't.subtotal', 't.desconto_real', 't.desconto_porcento', 't.total', 't.fin_lancamento', 'flf.data_vencimento', 'fc.nome AS categoria', 'fs.nome AS subcategoria', 'ffp.nome AS forma_pagamento', 'fct.nome AS conta', 'fpp.parcela', 'flf.id as fin_lancamento_financeiro_id')
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
    				->select('thp.sessoes_contratada', 'thp.sessoes_consumida', 'thp.subtotal', 'thp.desconto_real', 'thp.desconto_porcento', 'thp.tipo_desconto', 'thp.total', 'cp.nome as procedimento')
    				->join('convenio_procedimento as cp', function($join){
    					$join->on('cp.id', '=', 'thp.procedimento_id');
    				})
    				->where('thp.tratamento_id', '=', $tratamento_id)
    				->get()
    				->toArray();
    }

    function get_all_table($table, $where = null, $order_by = null){
		$this->setTable($table);
	
		if($where){
			if($order_by){
				return $this->where($where)->orderBy($order_by, 'ASC')->get()->toArray();
			}else{
				return $this->where($where)->get()->toArray();
			}

		}else{
			if($order_by){
				return $this->where($where)->orderBy($order_by, 'ASC')->get()->toArray();
			}
		}
	
		return $this->get()->toArray();
	}

	function get_usuario_criador_tratamento($usuario_id){
		return $this->setTable('usuario as u')
					->select('an.nome')
					->join('usuario_has_nivel_permissao as a', function($join){
						$join->on('a.usuario_id', '=', 'u.id');
					})
					->join('auth_nivel_permissao as an', function($join){
						$join->on('an.id', '=', 'a.auth_nivel_permissao_id');
					})
					->where('u.id', '=', $usuario_id)
					->get()
					->toArray();
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
        ->update($dados);
    }

    function get_al_profissional(){
    	return $this->setTable('profissional AS pr')
    				  ->select('pr.id as profissional_id', 'pr.nome as profissional')
    				  ->join('usuario AS u', function ($join) {
					        $join->on('u.id', '=', 'pr.usuario_id');
					    })
    				  ->where('u.deletado', '=', '0')
    				  ->orderBy('pr.nome', 'ASC')->get()->toArray();
    }
}

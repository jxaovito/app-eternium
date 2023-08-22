<?php
namespace App\Modules\Paciente\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Paciente_model extends Model {
    protected $table = 'paciente';
    protected $connection = 'mysql_db';

    function get_all_pacientes($id = null, $nome = null){
		$query = $this->setTable('paciente AS p')
					  ->select('p.id as paciente_id', 'p.*', 'co.nome as convenio', 'co.id as convenio_id', 'b.id as bairro_id', 'b.nome as bairro', 'c.id as cidade_id', 'c.nome as cidade', 'e.id as estado_id', 'e.sigla as estado', 'g.id as genero_id', 'g.nome as genero');

		if($id){
			$query = $query->where('p.id', '=', $id);
		}

	    if(session('filtro_paciente_nome') || $nome){
	    	$filtro = session('filtro_paciente_nome') ?? $nome;

        	$query = $query->where('p.nome', 'like', '%' . $filtro . '%');

	    }else{
	    	if(session('filtro_paciente_telefone')){
	    	    $filtro = session('filtro_paciente_telefone');
	    	    $query = $query->where('p.telefone_principal', 'like', '%' . $filtro . '%');
	    	}

	    	if(session('filtro_paciente_convenio')){
	    	    $filtro = session('filtro_paciente_convenio');
	    	    $query = $query->where('co.id', '=', $filtro);
	    	}
	    }

	    $query = $query->leftJoin('endereco_bairro AS b', function ($join) {
	        $join->on('b.id', '=', 'p.endereco_bairro_id');
	    })
	    ->leftJoin('endereco_cidade AS c', function ($join) {
	        $join->on('c.id', '=', 'b.endereco_cidade_id');
	    })
	    ->leftJoin('endereco_estado AS e', function ($join) {
	        $join->on('e.id', '=', 'c.endereco_estado_id');
	    })
	    ->leftJoin('convenio AS co', function ($join) {
	        $join->on('co.id', '=', 'p.convenio_id');
	    })
	    ->leftJoin('genero AS g', function ($join) {
	        $join->on('g.id', '=', 'p.genero_id');
	    })
	    ->orderBy('deletado', 'ASC')
	    ->orderBy('nome', 'ASC');

	    return $query->paginate(20);
    }

    function get_all_table($table, $where = null){
		$this->setTable($table);
	
		if($where){
			return $this->where($where)->get()->toArray();
		}
	
		return $this->get()->toArray();
	}

    function delete_dados($table, $where){
	    $this->setTable($table);
	    
	    return $this->where($where)->delete();
	}

    function insert_dados($table, $dados){
		$this->setTable($table);
    
    	return $this->insertGetId($dados);
	}

	public function update_table($table, $where, $dados){
        $this->setTable($table);
    
	    return DB::table($this->table)
        ->where($where)
        ->update($dados);;
    }
}

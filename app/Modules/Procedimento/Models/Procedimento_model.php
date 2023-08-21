<?php
namespace App\Modules\Procedimento\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Procedimento_model extends Model {
    protected $table = 'procedimento';
    protected $connection = 'mysql_db';

    function get_all(){
        $query = $this->setTable('convenio');

        if(session('filtro_procedimento_nome')){
            $filtro = session('filtro_procedimento_nome');
            $query = $query->where('convenio.nome', 'like', '%' . $filtro . '%');
        }

        $query = $query->leftJoin('convenio_procedimento as cp', 'cp.convenio_id', '=', 'convenio.id')
                       ->selectRaw('convenio.*, cp.id as procedimentos')
                       ->groupBy('convenio.id')
                       ->orderBy('deletado', 'ASC')
                       ->orderBy('nome', 'ASC');

        return $query->paginate(20);
    }

	function get_grupos_procedimentos(){
		$query = $this->setTable('convenio_procedimento');
		$query = $query->select('grupo_procedimento')
					   ->where('deletado', 0)
					   ->orderBy('grupo_procedimento', 'desc')
					   ->limit('1')->get()->toArray();

	  	return $query;

	}

    function get_all_table($table, $where = null){
		$this->setTable($table);

		if($table == 'convenio_procedimento'){
			return $this->where($where)->orderBy('codigo', 'asc')->get()->toArray();
		}
			
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

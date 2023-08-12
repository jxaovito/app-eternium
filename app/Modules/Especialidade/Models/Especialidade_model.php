<?php
namespace App\Modules\Especialidade\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Especialidade_model extends Model {
    protected $table = 'especialidade';
    protected $connection = 'mysql_db';

    function get_all(){
		$query = $this->setTable('especialidade');

		if(session('filtro_especialidade_nome')){
        	$filtro = session('filtro_especialidade_nome');
	        $query = $query->where('nome', 'like', '%' . $filtro . '%');
	    }

		$query = $query->orderBy('deletado', 'ASC')
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

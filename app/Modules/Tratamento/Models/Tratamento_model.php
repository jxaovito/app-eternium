<?php
namespace App\Modules\Tratamento\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tratamento_model extends Model {
    protected $table = 'tratamento';
    protected $connection = 'mysql_db';

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

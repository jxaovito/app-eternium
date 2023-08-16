<?php
namespace App\Modules\Profissional\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profissional_db_model extends Model {
    protected $table = 'usuario';
    protected $connection = 'mysql';
    public $timestamps = false;

    function get_all_table($table, $where = null){
		$this->setTable($table);
	
		if($where){
			return $this->where($where)->get()->toArray();
		}
	
		return $this->get()->toArray();
	}

	function insert_dados($table, $dados){
		$this->setTable($table);
    
    	return $this->insertGetId($dados);
	}

	function update_table($table, $where, $dados){
    	$this->setTable($table);
    
	    return $this->where($where)  // Usar o Query Builder do modelo configurado
	        ->update($dados);
	}
}

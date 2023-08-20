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
	        $query = $query->where('nome', 'like', '%' . $filtro . '%')
	        			   ->where('deletado', 0);
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
}

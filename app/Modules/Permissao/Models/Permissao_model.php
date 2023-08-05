<?php
namespace App\Modules\Permissao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permissao_model extends Model {
    protected $table = 'auth_modulo';
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

    function get_permissoes($id){
        $query = $this->selectRaw('auth_modulo.id, auth_modulo.funcao, auth_modulo.nome, auth_modulo.modulo, 
            (SELECT if(anp.id, TRUE, FALSE) AS STATUS
                FROM auth_modulo am1
                LEFT JOIN auth_modulo_has_nivel_permissao amnp1 ON amnp1.auth_modulo_id = am1.id
                LEFT JOIN auth_nivel_permissao anp1 ON anp1.id = amnp1.auth_nivel_permissao_id
                WHERE anp1.id = 1 AND am1.id = auth_modulo.id
            ) AS status')
            ->leftJoin('auth_modulo_has_nivel_permissao as amnp', 'amnp.auth_modulo_id', '=', 'auth_modulo.id')
            ->leftJoin('auth_nivel_permissao as anp', 'anp.id', '=', 'amnp.auth_nivel_permissao_id')
            ->orderBy('auth_modulo.modulo')
            ->get()->toArray();

        return $query;
    }
}

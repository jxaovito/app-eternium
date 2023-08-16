<?php
namespace App\Modules\Profissional\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profissional_model extends Model {
    protected $table = 'profissional';
    protected $connection = 'mysql_db';

    function get_all(){
		$query = $this->setTable('usuario AS u')
					  ->select('u.*', 'np.nome as nivel_permissao', 'np.id as nivel_permissao_id');

	    if(session('filtro_usuario_nome')){
	        $filtro = session('filtro_usuario_nome');
	        $query = $query->where('u.nome', 'like', '%' . $filtro . '%');
	    }

	    $query = $query->join('usuario_has_nivel_permissao AS unp', function ($join) {
	        $join->on('unp.usuario_id', '=', 'u.id');
	    })
	    ->join('auth_nivel_permissao AS np', function ($join) {
	        $join->on('np.id', '=', 'unp.auth_nivel_permissao_id');
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
}

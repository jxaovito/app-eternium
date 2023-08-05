<?php
namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auth_model extends Model {
    protected $table = 'usuario';
    protected $connection = 'mysql_db';
	protected $fillable = ['modulo', 'funcao', 'nome'];
	public $timestamps = false;

    function get_permissoes_usuario($usuario_id){
		$this->setTable('auth_modulo');
		return $this->join('auth_modulo_has_nivel_permissao as amnp', 'amnp.auth_modulo_id', '=', 'auth_modulo.id')
					->join('auth_nivel_permissao as anp', 'anp.id', '=', 'amnp.auth_nivel_permissao_id')
		            ->join('usuario_has_nivel_permissao as unp', 'unp.auth_nivel_permissao_id', '=', 'anp.id')
		            ->join('usuario as u', 'u.id', '=', 'unp.usuario_id')
		            ->where('u.id', $usuario_id)
		            ->select('auth_modulo.*')
		            ->get()->toArray();
	}


	function get_all_table($table, $where = array()){
		$this->setTable($table);
		
		if($where){
			return $this->select('*')->where($where)->get()->toArray();
		}else{
			return $this->select('*')->get()->toArray();
		}
	}

	function get_permissoes(){
		$this->setTable('auth_modulo');
		return $this->select('auth_modulo.*')
		            ->get()->toArray();
	}

	function insert_new_funcao($dados){
		$this->setTable('auth_modulo');
		return $this->create($dados)->id;
	}
}

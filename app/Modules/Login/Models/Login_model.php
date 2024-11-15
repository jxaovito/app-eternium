<?php
namespace App\Modules\Login\Models;

use Illuminate\Database\Eloquent\Model;

class Login_model extends Model{
	protected $table = 'usuario';

	public function get_all_table($table, $email){
		$this->setTable($table);
		return $this->where('email', $email)
					->first();
	}

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
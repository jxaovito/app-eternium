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

	function get_all_profissional($id = null){
	    $query = $this->newQuery()
	                  ->from('profissional AS p') 
	                  ->select('p.id as profissional_id', 'u.id as usuario_id', 'u.deletado', 'p.nome', 'p.telefone_principal', 'u.imagem', 'p.telefone_secundario', 'p.cpf', 'p.cnpj', 'u.atualizar_senha', DB::raw('GROUP_CONCAT(e.nome) as especialidade'), DB::raw('GROUP_CONCAT(e.cor_fundo) as cor_fundo_especialidade'), DB::raw('GROUP_CONCAT(e.cor_fonte) as cor_fonte_especialidade'), DB::raw('GROUP_CONCAT(e.id) as especialidade_id'));

        if(session('filtro_profissional_nome')){
        	$filtro = session('filtro_profissional_nome');
	        $query = $query->where('p.nome', 'like', '%' . $filtro . '%');
	    }

	    if(session('filtro_profissional_especialidade')){
        	$filtro = session('filtro_profissional_especialidade');
	        $query = $query->where('e.id', '=', $filtro);
	    }

	    if($id){
	    	$filtro = $id;
	        $query = $query->where('u.id', '=', $filtro);
	    }

	    $query = $query->join('usuario AS u', function ($join){
	        $join->on('u.id', '=', 'p.usuario_id');
	    })
	    ->leftJoin('especialidade_has_profissional AS ep', function ($join){
	        $join->on('ep.profissional_id', '=', 'p.id');
	    })
	    ->leftJoin('especialidade AS e', function ($join){
	        $join->on('e.id', '=', 'ep.especialidade_id');
	    })
	    ->groupBy('p.id', 'p.nome', 'p.telefone_principal', 'u.imagem')
	    ->orderBy('u.deletado', 'asc')
    	->orderBy('p.nome', 'asc');

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
